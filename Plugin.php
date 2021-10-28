<?php namespace Indikator\Newsletter;

use System\Classes\PluginBase;
use Backend;
use BackendAuth;
use Event;
use Db;
use Indikator\Newsletter\Models\Mails;
use Indikator\Newsletter\Models\Subscribers;
use Indikator\Newsletter\Models\Settings;
use Indikator\Newsletter\Controllers\Mails as MailsController;
use Indikator\Newsletter\Controllers\Subscribers as SubscribersController;
use Backend\Models\User;
use Config;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'indikator.newsletter::lang.plugin.name',
            'description' => 'indikator.newsletter::lang.plugin.description',
            'author'      => 'indikator.newsletter::lang.plugin.author',
            'icon'        => 'icon-envelope-o',
            'homepage'    => ''
        ];
    }

    public function registerNavigation()
    {
        return [
            'newsletter' => [
                'label'       => 'indikator.newsletter::lang.menu.newsletter',
                'url'         => Backend::url('indikator/newsletter/mails'),
                'icon'        => 'icon-envelope-o',
                'iconSvg'     => 'plugins/indikator/newsletter/assets/images/newsletter-icon.svg',
                'permissions' => ['indikator.newsletter.*'],
                'order'       => 820,

                'sideMenu' => [
                    'mails' => [
                        'label'       => 'indikator.newsletter::lang.menu.mails',
                        'url'         => Backend::url('indikator/newsletter/mails'),
                        'icon'        => 'icon-file-text',
                        'permissions' => ['indikator.newsletter.mails'],
                        'order'       => 100
                    ],
                    'categories' => [
                        'label'       => 'indikator.newsletter::lang.menu.categories',
                        'url'         => Backend::url('indikator/newsletter/categories'),
                        'icon'        => 'icon-tags',
                        'permissions' => ['indikator.newsletter.categories'],
                        'order'       => 200
                    ],
                    'subscribers' => [
                        'label'       => 'indikator.newsletter::lang.menu.subscribers',
                        'url'         => Backend::url('indikator/newsletter/subscribers'),
                        'icon'        => 'icon-user',
                        'permissions' => ['indikator.newsletter.subscribers'],
                        'order'       => 300
                    ],
                    'logs' => [
                        'label'       => 'indikator.newsletter::lang.menu.logs',
                        'url'         => Backend::url('indikator/newsletter/logs'),
                        'icon'        => 'icon-bar-chart',
                        'permissions' => ['indikator.newsletter.logs'],
                        'order'       => 400
                    ],
                    'settings' => [
                        'label'       => 'indikator.newsletter::lang.menu.settings',
                        'url'         => Backend::url('system/settings/update/indikator/newsletter/settings'),
                        'icon'        => 'icon-cogs',
                        'permissions' => ['indikator.newsletter.settings'],
                        'order'       => 500
                    ]
                ]
            ]
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'indikator.newsletter::lang.plugin.name',
                'description' => 'indikator.newsletter::lang.backend_settings.description',
                'category'    => 'system::lang.system.categories.cms',
                'icon'        => 'icon-envelope-o',
                'class'       => 'Indikator\Newsletter\Models\Settings',
                'order'       => 500,
                'keywords'    => 'newsletter email statistics',
                'permissions' => ['indikator.newsletter.settings']
            ]
        ];
    }

    public function registerReportWidgets()
    {
        return [
            'Indikator\Newsletter\ReportWidgets\Mails' => [
                'label'       => 'indikator.newsletter::lang.widget.mails',
                'context'     => 'dashboard',
                'permissions' => ['indikator.newsletter.mails']
            ],
            'Indikator\Newsletter\ReportWidgets\NewMails' => [
                'label'       => 'indikator.newsletter::lang.widget.newmails',
                'context    ' => 'dashboard',
                'permissions' => ['indikator.newsletter.mails']
            ],
            'Indikator\Newsletter\ReportWidgets\Subscribers' => [
                'label'       => 'indikator.newsletter::lang.widget.subscribers',
                'context'     => 'dashboard',
                'permissions' => ['indikator.newsletter.subscribers']
            ]
        ];
    }

    public function registerComponents()
    {
        return [
            'Indikator\Newsletter\Components\Categories'  => 'newsCategories',
            'Indikator\Newsletter\Components\Subscribe'   => 'newsSubscribe',
            'Indikator\Newsletter\Components\Unsubscribe' => 'newsUnsubscribe'
        ];
    }

    public function registerFormWidgets()
    {
        return [
            'Indikator\Newsletter\FormWidgets\MailInfo' => [
                'label' => 'MailInfo',
                'code'  => 'mailinfo'
            ],
            'Indikator\Newsletter\FormWidgets\CategoryInfo' => [
                'label' => 'CategoryInfo',
                'code'  => 'categoryinfo'
            ],
            'Indikator\Newsletter\FormWidgets\SubscriberInfo' => [
                'label' => 'SubscriberInfo',
                'code'  => 'subscriberinfo'
            ]
        ];
    }

    public function registerMailTemplates()
    {
        return [
            'indikator.newsletter::mail.email' => 'Email',
            'indikator.newsletter::mail.confirmation' => 'Confirmation'
        ];
    }

    public function registerPermissions()
    {
        return [
            'indikator.newsletter.mails' => [
                'tab'   => 'indikator.newsletter::lang.menu.newsletter',
                'label' => 'indikator.newsletter::lang.permission.mails',
                'order' => 100,
                'roles' => ['publisher']
            ],
            'indikator.newsletter.categories' => [
                'tab'   => 'indikator.newsletter::lang.menu.newsletter',
                'label' => 'indikator.newsletter::lang.permission.categories',
                'order' => 200,
                'roles' => ['publisher']
            ],
            'indikator.newsletter.subscribers' => [
                'tab'   => 'indikator.newsletter::lang.menu.newsletter',
                'label' => 'indikator.newsletter::lang.permission.subscribers',
                'order' => 200,
                'roles' => ['publisher']
            ],
            'indikator.newsletter.import_export' => [
                'tab'   => 'indikator.newsletter::lang.menu.newsletter',
                'label' => 'indikator.newsletter::lang.permission.import_export',
                'order' => 300,
                'roles' => ['publisher']
            ],
            'indikator.newsletter.logs' => [
                'tab'   => 'indikator.newsletter::lang.menu.newsletter',
                'label' => 'indikator.newsletter::lang.permission.logs',
                'order' => 400,
                'roles' => ['publisher']
            ],
            'indikator.newsletter.settings' => [
                'tab'   => 'indikator.newsletter::lang.menu.newsletter',
                'label' => 'indikator.newsletter::lang.permission.settings',
                'order' => 500,
                'roles' => ['publisher']
            ]
        ];
    }

    public function registerSchedule($schedule)
    {
        $memory = (int)Config::get('indikator.newsletter::memory_limit');
        $schedule->command('queue:work --daemon --queue=newsletter --memory=' . $memory)->everyMinute()->withoutOverlapping();
    }

    public function boot()
    {
        /*
         * Hide unused form fields
         */
        MailsController::extendFormFields(function($form, $model, $context)
        {
            if (!$model instanceof Mails) {
                return;
            }

            $settings = json_decode(Db::table('system_settings')->where('item', 'indikator_newsletter_settings')->value('value'));
        });

        SubscribersController::extendFormFields(function($form, $model, $context)
        {
            if (!$model instanceof Subscribers) {
                return;
            }

            $settings = json_decode(Db::table('system_settings')->where('item', 'indikator_newsletter_settings')->value('value'));
        });

        /*
         * Hide unused list columns
         */
        MailsController::extendListColumns(function($list, $model)
        {
            if (!$model instanceof Mails) {
                return;
            }

            $settings = json_decode(Db::table('system_settings')->where('item', 'indikator_newsletter_settings')->value('value'));
        });

        SubscribersController::extendListColumns(function($list, $model)
        {
            if (!$model instanceof Subscribers) {
                return;
            }

            $settings = json_decode(Db::table('system_settings')->where('item', 'indikator_newsletter_settings')->value('value'));

            if (Subscribers::where('comment', '!=', '')->count() == 0) {
                $list->removeColumn('comment');
            }
        });
    }
}
