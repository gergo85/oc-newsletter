<?php

return [
    'plugin' => [
        'name' => 'Newsletter',
        'description' => 'Simple newsletter plugin.',
        'author' => 'Gergő Szabó'
    ],
    'menu' => [
        'newsletter' => 'Newsletter',
        'mails' => 'Mails',
        'subscribers' => 'Subscribers',
        'import' => 'Import',
        'export' => 'Export',
        'logs' => 'Logs',
        'settings' => 'Settings'
    ],
    'title' => [
        'mails' => 'mail',
        'subscribers' => 'subscriber',
        'statistics' => 'Statistics'
    ],
    'new' => [
        'mails' => 'New mail',
        'subscribers' => 'New subscriber'
    ],
    'stat' => [
        'mails' => 'Mail|Mails',
        'view' => 'View',
        'mail' => 'Sent',
        'loss' => 'Loss',
        'basic' => 'Basic',
        'emails' => 'Emails',
        'queued' => 'In queue',
        'send' => 'Send',
        'sent' => 'Sent',
        'viewed' => 'Viewed',
        'click' => 'Clicks',
        'clicked' => 'Clicked',
        'failed' => 'Failed',
        'log' => [
            'events' => 'Events',
            'summary' => 'Summary'
        ]
    ],
    'form' => [
        // General
        'id' => 'ID',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
        // Posts
        'title' => 'Title',
        'content' => 'Content',
        'status' => 'Status',
        'status_final' => 'Final',
        'status_draft' => 'Draft',
        'status_active' => 'Active',
        'status_inactive' => 'Inactive',
        'status_unsubscribed' => 'Unsubscribed',
        'status_pending' => 'Pending',
        'yes' => 'Yes',
        'no' => 'No',
        'view' => 'view',
        'last_send_at' => 'Last send at',
        'last_send' => 'Last send',
        'length' => 'Length',
        'clone_of' => 'Clone of',
        'mail_cloning' => 'Cloning mail :name',
        // Subscribers
        'name' => 'Name',
        'email' => 'E-mail',
        'comment' => 'Comment',
        'mail' => 'mail',
        'registered_at' => 'Registered date',
        'confirmed_at' => 'Confirmed date',
        'unsubscribed_at' => 'Unsubscribed date',
        'ip_address' => 'IP Address',
        'no_data' => 'No data',
        // Logs
        'mail' => 'Mail',
        'subscriber_name' => 'Subscriber name',
        'subscriber_email' => 'Subscriber email',
        'queued_at' => 'In queue',
        'send_at' => 'Sent',
        'viewed_at' => 'Viewed',
        'clicked_at' => 'Clicked',
        'logs_count' => 'Logs entries'
    ],
    'button' => [
        'activate' => 'Activate',
        'deactivate' => 'Hide',
        'active' => 'Active',
        'inactive' => 'Inactive',
        'import' => 'Import',
        'export' => 'Export',
        'unsubscribe' => 'Unsubscribe',
        'subscribe' => 'Subscription',
        'test' => 'Send test mail',
        'send' => 'Send newsletter',
        'send_confirmation' => 'Do you want to send the newsletter?',
        'resend' => 'Resend newsletter',
        'resend_confirmation' => 'Do you want to resend the newsletter?',
        'return' => 'Return'
    ],
    'flash' => [
        'activate' => 'Successfully activated those mails.',
        'deactivate' => 'Successfully deactivated those mails.',
        'draft' => 'Successfully modified those mails as draft.',
        'subscribe' => 'Successfully subscribed those users.',
        'unsubscribe' => 'Successfully unsubscribed those users.',
        'delete' => 'Do you want to delete this items?',
        'remove' => 'Successfully removed those items.',
        'newsletter_test_error' => 'An error occurred during sending the test newsletter.',
        'newsletter_send_success' => 'Newsletter was successfully send.',
        'newsletter_send_error' => 'An error occurred during sending the newsletter. Before resending again, take a look in the log to get more information about the current status!',
        'newsletter_resend_success' => 'Newsletter was successfully resend.',
        'newsletter_resend_error' => 'An error occurred during resending the newsletter. Before resending again, take a look in the log to get more information about the current status.',
        'subscriber_confirmation_token_invalid' => 'The confirmation link or token is invalid.',
        'subscriber_confirmation_token_expired' => 'Your confirmation link expired, please signup again.',
        'subscriber_confirmation' => 'You successfully confirmed your email address. You will receive upcoming newsletters.',
        'subscriber_already_confirmed' => 'Your account is already confirmed.',
        'mail_clone_confirm' => 'Do you want this clone this mail?'
    ],
    'backend_settings' => [
        'description' => 'Settings about sending newsletters and statistics view.',
        'main_section' => 'Settings about sending and handling newsletters',
        'click_tracking' => 'Track clicks',
        'click_tracking_comment' => 'Tracks when a person clicks on a link the newsletter.',
        'email_view_tracking' => 'Track newsletter views',
        'email_view_tracking_comment' => 'Tracks when a person looks at the newsletter.',
        'email_view_tracking_warning' => [
            'heading' => 'Be careful about using this feature',
            'subheading' => 'It is not allowed in every country!',
            'text' => 'When you use this function, you should be sure what you are doing! Make sure that you do not break any laws.'
        ],
        'newsletter_double_opt_in' => 'Newsletter registration confirmation',
        'newsletter_double_opt_in_comment' => 'Sends an email to the new subscriber which has to confirm his email address',
    ],
    'widget' => [
        'mails' => 'Newsletter - Mails',
        'newposts' => 'Newsletter - New mails',
        'subscribers' => 'Newsletter - Subscribers',
        'show_total' => 'Show total',
        'show_active' => 'Show active',
        'show_inactive' => 'Show inactive',
        'show_draft' => 'Show draft',
        'show_piece' => 'Number of mails',
        'show_date' => 'Show date',
        'show_rank' => 'Show rank',
        'show_unsub' => 'Show unsubscribed',
        'show_pending' => 'Show pending',
        'total' => 'Total'
    ],
    'component' => [
        'subscribe' => 'Subscriber form',
        'unsubscribe' => 'Unsubscribe form'
    ],
    'permission' => [
        'mails' => 'Manage mails',
        'subscribers' => 'Manage subscribers',
        'statistics' => 'View statistics',
        'import_export' => 'Import and Export',
        'settings' => 'Change settings',
        'logs' => 'Detailed views for logs'
    ],
    'messages' => [
        'unsubscribed' => 'We successfully unsubscribed you from our newsletter.',
        'not_subscribed' => 'Already subscribed to our newsletter.',
        'subscribed' => 'Thank you for your subscription to our newsletter!'
    ]
];
