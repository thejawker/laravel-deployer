<?php

return [

    /*
    |--------------------------------------------------------------------------
    | The Name of the Deployment Script
    |--------------------------------------------------------------------------
    |
    */

    'script-name' => 'deployer.sh',

    /*
    |--------------------------------------------------------------------------
    | Notifications Settings
    |--------------------------------------------------------------------------
    |
    | These are your notification settings. For now we only support the
    | Slack platform to send Notifications.
    |
    */

    'slack-channel' => 'some-channel',
    'slack-url' => 'http://some-domain.xx',

    /*
    |--------------------------------------------------------------------------
    | Environment Notification Level
    |--------------------------------------------------------------------------
    |
    | You can add an array with the various levels where you like to
    | receive notifications. Adding just ['production'] will only
    | send notifications when deploying on the production env.
    |
    */

    'env-level' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Duration Warning Time Threshold
    |--------------------------------------------------------------------------
    |
    | If the deployment takes longer than this amount of time, the
    | message will be sent with a warning to the Slack Channel.
    |
    | Value is in seconds.
    |
    */

    'warn-after' => 20,

    /*
    |--------------------------------------------------------------------------
    | Commands
    |--------------------------------------------------------------------------
    |
    | Here you can define the commands you want to run. They run in
    | order of addition. They will be wrapped
    |
    */

    'commands' => [
        'initialize' => [

        ],

        'set-up' => [
            'php artisan down'
        ],


        'deploy' => [
            'git pull'
        ],

        'post-deploy' => [
            'php artisan up',
            'php artisan config:cache',
            'php artisan route:cache',
            'php artisan view:clear',
            'php artisan horizon:terminate'
        ]

        //...
    ]
];