<?php

use TheJawker\Deployer\BashCommands;

return [

    /*
    |--------------------------------------------------------------------------
    | The Name of the Deployment Script
    |--------------------------------------------------------------------------
    |
    */

    'script-name' => 'deploy.sh',

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
    | The various section of the Deployment Script
    |--------------------------------------------------------------------------
    |
    */

    'sections' => [

        /*
        |--------------------------------------------------------------------------
        | Set Up
        |--------------------------------------------------------------------------
        |
        | Here you can add bash commands to the set-up phase of the
        | deployer and some change config settings available.
        |
        */

        'set-up' => [
            'comment' => 'Prepares the deployment.',
            'commands' => [
//                BashCommands::SET_CURRENT_DIR,
//                BashCommands::ARTISAN_DOWN,
//                BashCommands::MIGRATE
            ]
        ],

        //...
    ]
];