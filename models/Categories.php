<?php namespace Indikator\Newsletter\Models;

use Model;

class Categories extends Model
{
    use \October\Rain\Database\Traits\Sluggable;
    use \October\Rain\Database\Traits\Sortable;
    use \October\Rain\Database\Traits\Validation;

    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    protected $table = 'indikator_newsletter_categories';

    public $rules = [
        'name'   => 'required',
        'slug'   => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'unique:indikator_newsletter_categories'],
        'status' => 'required|between:1,2|numeric',
        'hidden' => 'required|between:1,2|numeric'
    ];

    protected $slugs = [
        'slug' => 'name'
    ];

    public $belongsToMany = [
        'subscribers' => [
            'Indikator\Newsletter\Models\Subscribers',
            'table'    => 'indikator_newsletter_relations',
            'key'      => 'categories_id',
            'otherKey' => 'subscriber_id',
            'order'    => 'name'
        ]
    ];

    public $hasMany = [
        'mails' => [
            'Indikator\Newsletter\Models\Mails',
            'key' => 'category_id'
        ]
    ];

    public $translatable = [
        'name',
        ['slug', 'index' => true],
        'summary',
        'content'
    ];

    /**
     * Sets the "url" attribute with a URL to this object
     * @param string $pageName
     * @param \Cms\Classes\Controller $controller
     */
    public function setUrl($pageName, $controller)
    {
        $params = [
            'id'   => $this->id,
            'slug' => $this->slug
        ];

        return $this->url = $controller->pageUrl($pageName, $params);
    }
}
