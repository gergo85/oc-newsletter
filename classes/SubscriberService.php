<?php namespace Indikator\Newsletter\Classes;

use Indikator\Newsletter\Models\Settings;
use Db;

trait SubscriberService
{
    /**
     * Handles subscriber registration
     * either by registration in the frontend or by creating in the backend
     * 
     * @param $subscriber
     * @return void
     */
    public function onSubscriberRegister($subscriber)
    {
        if (!$subscriber->isActive()) {
            if (Settings::get('newsletter_double_opt_in', true)) {
                $subscriber->register();
                ConfirmationHandler::sendConfirmationEmailToSubscriber($subscriber);
            }
            else {
                $subscriber->activate();
            }
        }
    }
}
