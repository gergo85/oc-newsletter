<?php namespace Indikator\Newsletter\Components;

use Cms\Classes\ComponentBase;
use Indikator\Newsletter\Classes\SubscriberService;
use Indikator\Newsletter\Models\Subscribers;
use Lang;
use App;
use Validator;
use ValidationException;
use Request;

class Subscribe extends ComponentBase
{
    use SubscriberService;

    public function componentDetails()
    {
        return [
            'name'        => 'indikator.newsletter::lang.component.subscribe',
            'description' => ''
        ];
    }

    public function onRun()
    {
        $this->page['text_messages'] = Lang::get('indikator.newsletter::lang.messages.subscribed');
        $this->page['text_name']     = Lang::get('indikator.newsletter::lang.form.name');
        $this->page['text_email']    = Lang::get('indikator.newsletter::lang.form.email');
        $this->page['text_button']   = Lang::get('indikator.newsletter::lang.button.subscribe');
    }

    public function onSubscription()
    {
        // Get data from form
        $data = post();

        // Validate input data
        $rules = [
            'name'  => 'required|between:2,64',
            'email' => 'required|email|between:8,64'
        ];

        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }

        // Get input data
        $name  = post('name');
        $email = post('email');

        // Looking for existing subscriber
        $subscriberResult = Subscribers::email($email);

        if ($subscriberResult->count() > 0) {
            $subscriber = $subscriberResult->first();
            // Update the name
            $subscriber->name = $name;
        }
        // Register new one
        else {
            $subscriber = Subscribers::create([
                'name'          => $name,
                'email'         => $email,
                'comment'       => '',
                'created'       => 2,
                'statistics'    => 0,
                'created_at'    => now(),
                'updated_at'    => now(),
                'registered_at' => now(),
                'registered_ip' => Request::ip(),
                'status'        => 3
            ]);
        }

        $this->onSubscriberRegister($subscriber);
    }
}
