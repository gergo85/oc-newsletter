<?php namespace Indikator\Newsletter\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BackendAuth;
use App;
use File;
use Mail;
use Request;
use Indikator\Newsletter\Models\Mails as Item;
use Indikator\Newsletter\Classes\MailSender;
use Jenssegers\Date\Date;
use Carbon\Carbon;
use Flash;
use Lang;
use Redirect;

class Mails extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\ImportExportController::class
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $importExportConfig = 'config_import_export.yaml';

    public $requiredPermissions = ['indikator.newsletter.mails'];

    public $bodyClass = 'compact-container';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Indikator.Newsletter', 'newsletter', 'mails');
    }

    protected function getNewsByPathOrFail()
    {
        $uri = explode('/', Request::path());

        return Item::findOrFail(end($uri));
    }

    /**
     * Sends a test newsletter to the logged user.
     */
    public function onTest()
    {
        $news   = $this->getNewsByPathOrFail();
        $sender = new MailSender($news);

        if ($sender->sendTestNewsletter()) {
            Flash::success(trans('system::lang.mail_templates.test_success'));
        }
        else {
            Flash::error(trans('indikator.newsletter::lang.flash.newsletter_test_error'));
        }
    }

    /**
     * Sends a newsletter the first time if last_send_at is null.
     * Flash message will be attached.
     *
     * @return mixed
     */
    public function onSendMail()
    {
        $news = $this->getNewsByPathOrFail();

        if ($news->last_send_at === null) {
            $sender = new MailSender($news);

            if ($sender->SendMailsletter()) {
                Flash::success(trans('indikator.newsletter::lang.flash.newsletter_send_success'));
            }
            else {
                Flash::error(trans('indikator.newsletter::lang.flash.newsletter_send_error'));
            }
        }
        else {
            Flash::error(trans('indikator.newsletter::lang.flash.newsletter_send_error'));
        }

        return Redirect::refresh();
    }

    /**
     * Sends a newsletter again to the subscribers.
     * Returns a refresh with attached Flash message.
     *
     * @return mixed
     */
    public function onNewsResend()
    {
        $news   = $this->getNewsByPathOrFail();
        $sender = new MailSender($news);

        if ($sender->reSendMailsletter()) {
            Item::where('id', $news->id)->update(['last_send_at' => Date::now()]);

            Flash::success(trans('indikator.newsletter::lang.flash.newsletter_resend_success'));
        }
        else {
            Flash::error(trans('indikator.newsletter::lang.flash.newsletter_resend_error'));
        }

        return Redirect::refresh();
    }

    public function onActivate()
    {
        if ($this->isSelected()) {
            $this->changeStatus(post('checked'), 1);
            $this->setMessage('activate');
        }

        return $this->listRefresh();
    }

    public function onDeactivate()
    {
        if ($this->isSelected()) {
            $this->changeStatus(post('checked'), 2);
            $this->setMessage('deactivate');
        }

        return $this->listRefresh();
    }

    public function onDraft()
    {
        if ($this->isSelected()) {
            $this->changeStatus(post('checked'), 3);
            $this->setMessage('draft');
        }

        return $this->listRefresh();
    }

    public function onRemove()
    {
        if ($this->isSelected()) {
            foreach (post('checked') as $itemId) {
                if (!$item = Item::whereId($itemId)) {
                    continue;
                }

                $item->delete();
            }

            $this->setMessage('remove');
        }

        return $this->listRefresh();
    }

    /**
     * @return bool
     */
    private function isSelected()
    {
        return ($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds);
    }

    /**
     * @param $action
     */
    private function setMessage($action)
    {
        Flash::success(Lang::get('indikator.newsletter::lang.flash.'.$action));
    }

    /**
     * @param $mail
     * @param $id
     */
    private function changeStatus($mail, $id)
    {
        foreach ($mail as $itemId) {
            if (!$item = Item::where('status', '!=', $id)->whereId($itemId)) {
                continue;
            }

            if ($id == 1) {
                $update['status'] = 1;

                if (Item::whereId($itemId)->value('published_at') == null) {
                    $update['published_at'] = Carbon::now();
                }
            }
            else {
                $update = ['status' => $id];
            }

            $item->update($update);
        }
    }

    /**
     * @param $id
     */
    public function onCloneMail($id)
    {
        $mail    = Item::find($id);
        $newMail = $mail->duplicate($mail);
        $path    = Request::path();

        return Redirect::to(substr($path, 0, strrpos($path, '/', -1) + 1).$newMail->id);
    }

    public function onShowImage()
    {
        $this->vars['title'] = Item::where('image', post('image'))->value('title');
        $this->vars['image'] = '/storage/app/media'.post('image');

        return $this->makePartial('show_image');
    }

    public function onShowStat()
    {
        $this->vars['post'] = $mail = Item::whereId(post('id'))->first();
        $this->vars['last_send_at'] = ($mail->last_send_at) ? $mail->last_send_at : '<em>'.e(trans('indikator.newsletter::lang.form.no_data')).'</em>';
        $this->vars['published_at'] = ($mail->published_at) ? $mail->published_at : '<em>'.e(trans('indikator.newsletter::lang.form.no_data')).'</em>';

        return $this->makePartial('show_stat');
    }
}
