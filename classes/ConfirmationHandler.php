<?php namespace Indikator\Newsletter\Classes;

use Backend;
use Mail;

class ConfirmationHandler
{
    public static function generateNewTokenForSubscriber($subscriber)
    {
        $subscriber->confirmation_hash = str_random('191');
        $subscriber->save();
    }

    public static function sendConfirmationEmailToSubscriber($subscriber)
    {
        self::generateNewTokenForSubscriber($subscriber);

        $confirmationLink = Backend::url('indikator/newsletter/subscribers/confirm', [
            'id'   => $subscriber->id,
            'hash' => $subscriber->confirmation_hash
        ]);

        Mail::send(new ConfirmationMail($subscriber, $confirmationLink));
    }
}
