<?php namespace Indikator\Newsletter\Classes;

use App;
use File;
use Mail;
use Queue;
use Log;
use BackendAuth;
use Db;
use Jenssegers\Date\Date;
use Illuminate\Support\Collection;
use System\Classes\PluginManager;
use Indikator\Newsletter\Models\Logs;
use Indikator\Newletters\Models\Mails;
use Indikator\Newsletter\Models\Subscribers;

class MailSender
{
    /**
     * @var Post
     */
    protected $news;

    /**
     * @var string of the used locale
     */
    protected $locale = false;

    /**
     * @var string replaced content
     */
    protected $replacedContent = null;

    /**
     * @var bool if the sending should be queued.
     */
    protected $queued;

    /**
     * MailSender constructor
     *
     * @param $news Posts should be send.
     * @param $queued boolean if the email sending should be queued
     */
    public function __construct($news, $queued = true)
    {
        $this->news = $news;

        $pluginManager = PluginManager::instance()->findByIdentifier('RainLab.Translate');
        if ($pluginManager && !$pluginManager->disabled) {
            $this->locale = true;
        }

        $this->queued = $queued;
    }

    /**
     * Sends a test newsletter to the current logged in backend user
     */
    public function sendTestNewsletter()
    {
        $receiver = BackendAuth::getUser();

        return $this->sendTest($receiver);
    }

    /**
     * Sends the newsletter to all active subscribers
     */
    public function SendMailsletter()
    {
        $result = $this->sendToActiveSubscribers();
        $this->news->last_send_at = new Date();
        $this->news->save();

        return $result;
    }

    /**
     * Resends the newsletter to all active subscribers
     */
    public function reSendMailsletter()
    {
        $result = $this->sendToActiveSubscribers();
        $this->news->last_send_at = new Date();
        $this->news->save();

        return $result;
    }

    /**
     * Sends the newsletter to all active subscribers
     */
    protected function sendToActiveSubscribers()
    {
        $activeSubscribers = Subscribers::where('status', 1);

        $activeSubscribers = $activeSubscribers->get();
        $results = true;

        foreach ($activeSubscribers as $receiver) {
            $results = $results && $this->send($receiver);
        }

        return $results;
    }

    /**
     * Prepare newsletter parameters for the template by the receiver.
     * It also replaces the content with absolute urls.
     *
     * @param $receiver
     * @return array
     */
    protected function prepareNewsletterParametersForReceiver($receiver)
    {
        // Locale
        if ($receiver->locale != '' && $this->locale) {
            if ($this->news->enable_newsletter_content) {
                $content = $this->news->lang($receiver->locale)->newsletter_content;
            }
            else {
                $content = $this->news->lang($receiver->locale)->content;
            }
        }
        else {
            if ($this->news->enable_newsletter_content) {
                $content = $this->news->newsletter_content;
            }
            else {
                $content = $this->news->content;
            }
        }

        // Replace
        if ($this->replacedContent === null) {
            // Replace all relative URL of images to absolute URL's
            $url = url('/');
            $this->replacedContent = preg_replace('/src="\/([^"]*)"/i', 'src="' . $url . '/$1"', $content);

            // Bugfix while displaying images in Microsoft Outlook
            // height/width must be set as img attribute and not as style
            $this->replacedContent = preg_replace('/<img (.+)?style="width: (.+)px; height: (.+)px;"/i', '<img $1 width="$2" height="$3"', $this->replacedContent);
            // With the new version of froala, only the width is set. 
            $this->replacedContent = preg_replace('/<img (.+)?style="width: (.+)px;"/i', '<img $1 width="$2"', $this->replacedContent);
        }

        // Parameters
        return [
            'name'      => isset($receiver->name) ? $receiver->name : trim($receiver->first_name.' '.$receiver->last_name),
            'email'     => $receiver->email,
            'title'     => $this->news->title,
            'subtitle'  => $this->news->subtitle,
            'summary'   => $this->news->introductory,
            'plaintext' => strip_tags($this->news->introductory),
            'content'   => $this->replacedContent,
            'image'     => $this->news->image
        ];
    }

    /**
     * Returns the template for a receiver
     *
     * @param $receiver
     * @return string
     */
    protected function getTemplateForReceiver($receiver)
    {
        // Template file
        return 'indikator.newsletter::mail.email';
    }

    /**
     * Sends a test message to the receiver that didn't get logged
     *
     * @param $receiver
     * @return bool
     */
    protected function sendTest($receiver)
    {
        $params   = $this->prepareNewsletterParametersForReceiver($receiver);
        $template = $this->getTemplateForReceiver($receiver);

        return SendMails::send($template, $params, $receiver, $this->news->title);
    }

    /**
     * Sends the news to a receiver
     *
     * @param $receiver object of the news with name and email attribute
     * @return boolean
     */
    protected function send($receiver)
    {
        $params   = $this->prepareNewsletterParametersForReceiver($receiver);
        $template = $this->getTemplateForReceiver($receiver);

        $logEntry = Logger::queued($this->news->id, $receiver->id);

        if ($this->queued) {
            $qId = Queue::push('\Indikator\Newsletter\Classes\SendMails', [
                'template' => $template,
                'params'   => $params,
                'receiver' => $receiver,
                'subject'  => $this->news->title,
                'log_id'   => $logEntry->id
            ], 'newsletter');

            if ($qId) {
                Logs::whereId($logEntry->id)->update(['job_id' => $qId]);
            }

            return true;
        }

        return SendMails::sendWithLogger($template, $params, $receiver, $this->news->title, $logEntry);
    }
}
