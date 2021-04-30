<?php namespace Indikator\Newsletter\Classes;

use October\Rain\Mail\Mailable;
use App;
use File;

class ConfirmationMail extends Mailable
{
    public $subscriber;

    public $confirmationLink;

    public function __construct($subscriber, $confirmationLink)
    {
        $this->subscriber = $subscriber;
        $this->confirmationLink = $confirmationLink;
    }

    public function build()
    {
        return $this->view(
            'indikator.newsletter::mail.confirmation',
            [
                'subscriber'        => $this->subscriber,
                'confirmation_link' => $this->confirmationLink
            ]
        )->to($this->subscriber['email'], $this->subscriber['name']);
    }
}
