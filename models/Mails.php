<?php namespace Indikator\Newsletter\Models;

use Model;
use BackendAuth;
use Carbon\Carbon;
use Cms\Classes\Page as CmsPage;
use Db;
use App;
use Str;
use Url;

class Mails extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    protected $table = 'indikator_newsletter_mails';

    public $rules = [
        'title'  => 'required',
        'status' => 'required|between:1,3|numeric'
    ];

    public $translatable = [
        'title',
        'content'
    ];

    protected $dates = [
        'published_at',
        'last_send_at'
    ];

    public static $allowedSorting = [
        'title asc',
        'title desc',
        'created_at asc',
        'created_at desc',
        'updated_at asc',
        'updated_at desc',
        'published_at asc',
        'published_at desc'
    ];

    public $belongsTo = [
        'category' => [
            'Indikator\Newsletter\Models\Categories',
            'order' => 'name'
        ]
    ];

    public $hasMany = [
        'logs' => [
            'Indikator\Newsletter\Models\Logs',
            'key' => 'mail_id'
        ],
        'logs_queued_count' => [
            'Indikator\Newsletter\Models\Logs',
            'key'   => 'mail_id',
            'scope' => 'isQueued',
            'count' => true
        ],
        'logs_send_count' => [
            'Indikator\Newsletter\Models\Logs',
            'key'   => 'mail_id',
            'scope' => 'isSend',
            'count' => true
        ],
        'logs_viewed_count' => [
            'Indikator\Newsletter\Models\Logs',
            'key'   => 'mail_id',
            'scope' => 'isViewed',
            'count' => true
        ],
        'logs_clicked_count' => [
            'Indikator\Newsletter\Models\Logs',
            'key'   => 'mail_id',
            'scope' => 'isClicked',
            'count' => true
        ],
        'logs_failed_count' => [
            'Indikator\Newsletter\Models\Logs',
            'key'   => 'mail_id',
            'scope' => 'isFailed',
            'count' => true
        ]
    ];

    public $preview = null;

    public function getSendAttribute() {
        return $this->last_send_at != null;
    }

    /**
     * List of administrators
     */
    public function getUserOptions()
    {
        $result = [0 => 'indikator.newsletter::lang.form.select_user'];
        $users = Db::table('backend_users')->orderBy('login', 'asc')->get()->all();

        foreach ($users as $user) {
            $name = trim($user->first_name.' '.$user->last_name);
            $name = ($name != '') ? ' ('.$name.')' : '';
            $result[$user->id] = $user->login.$name;
        }

        return $result;
    }

    /**
     * Check value of some fields
     */
    public function beforeSave()
    {
        if ($this->status == 1 && empty($this->published_at)) {
            $this->published_at = Carbon::now();
        }
    }

    /**
     * Keep the original send and last_send_at attribute because they are read only
     */
    public function beforeUpdate()
    {
        if (($lastSend = $this->getOriginal('last_send_at')) != null) {
            $this->last_send_at = $lastSend;
        }
    }

    // Next and previous post

    /**
     * Apply a constraint to the query to find the nearest sibling
     *
     * @param       $query
     * @param array $options
     */
    public function scopeApplySibling($query, $options = [])
    {
        if (!is_array($options)) {
            $options = ['direction' => $options];
        }

        extract(array_merge([
            'direction' => 'next',
            'attribute' => 'published_at'
        ], $options));

        $isPrevious = in_array($direction, ['previous', -1]);
        $directionOrder = $isPrevious ? 'desc' : 'asc';
        $directionOperator = $isPrevious ? '<' : '>';

        return $query
        ->where('id', '<>', $this->id)
        ->where($attribute, $directionOperator, $this->$attribute)
        ->orderBy($attribute, $directionOrder);
    }

    /**
     * Returns the next post, if available.
     *
     * @return self
     */
    public function next()
    {
        return self::isPublished()->applySibling()->first();
    }

    /**
     * Returns the previous post, if available.
     *
     * @return self
     */
    public function prev()
    {
        return self::isPublished()->applySibling(-1)->first();
    }

    public function scopeListFrontEnd($query, $options)
    {
        extract(array_merge([
            'page'     => 1,
            'perPage'  => 10,
            'sort'     => 'created_at',
            'search'   => '',
            'status'   => 1,
            'featured' => 0,
            'isTrans'  => false
        ], $options));

        $searchableFields = [
            'title',
            'content'
        ];

        if ($status) {
            $query->isPublished();
        }

        if ($featured != 0) {
            $query->isFeatured($featured);
        }

        if (!is_array($sort)) {
            $sort = [$sort];
        }

        foreach ($sort as $_sort) {
            if (in_array($_sort, array_keys(self::$allowedSorting))) {
                $parts = explode(' ', $_sort);

                if (count($parts) < 2) {
                    array_push($parts, 'desc');
                }

                list($sortField, $sortDirection) = $parts;

                $query->orderBy($sortField, $sortDirection);
            }
        }

        $search = trim($search);

        if (strlen($search)) {
            $query->searchWhere($search, $searchableFields);
        }

        if ($isTrans) {
            $current_locale = App::getLocale();
            $default_locale = Db::table('rainlab_translate_locales')->where('is_default', 1)->value('code');

            if ($current_locale != $default_locale) {
                $ids = Db::table('rainlab_translate_attributes')->where('model_type', 'Indikator\Newsletter\Models\Mails')->where('locale', $current_locale)->where('attribute_data', 'not like', '%"title":""%')->pluck('model_id');
                $query->whereIn('id', $ids);
            }
        }

        return $query->paginate($perPage, $page);
    }

    public function scopeIsPublished($query)
    {
        if (BackendAuth::check()) {
            $status = Settings::get('show_posts', false);

            if (!$status) {
                $status = [1, 3];
            }

            return $query->whereIn('status', $status);
        }

        return $query
            ->where('status', 1)
            ->whereNotNull('published_at')
            ->where('published_at', '<', Carbon::now())
        ;
    }

    public function scopeIsFeatured($query, $value = 1)
    {
        return $query->where('featured', $value);
    }

    public function duplicate($post)
    {
        $clone = new Posts();
        $clone->title = \Lang::get('indikator.newsletter::lang.form.clone_of').' '.$post->title;
        $clone->status = 3;
        $clone->image = $post->image;
        $clone->newsletter_content = $post->newsletter_content;

        $clone->save();

        \Event::fire('indikator.newsletter.mails.duplicate', [&$clone, $post]);

        return $clone;
    }
}
