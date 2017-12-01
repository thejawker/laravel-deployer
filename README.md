# Laravel Deployer
Makes deploying Laravel applications an absolute breeze! 💨💨💨💨 
This package will generate your deployment bash script and work with some nice notifications when things go wrong or right.

### 🚨 Work In Progress
Functional and all, but will take some time before it's fully done.

## Installation
You can install the package by running the following composer command:
```bash
$ composer require thejawker/laravel-deployer
``` 

If you are running Laravel 5.4 or lower you have to manually add the ServiceProvider.

Next up publish the vendor:
```bash
$ php artisan vendor:publish --tag=deployer-config
```

Then add your Slack Channel details and other deployment config to the `config/deployer.php` file.

## Config
The configuration is quite elaborate and heavily commented so it's easier to understand.

```php
# config/deployer.php

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
```

## Publish Script
If you are happy with your config you can publish the bash script by running the following command:
```bash
$ php artisan deployer
```
This will create a `deployer.sh` bash file in the application root. Running this file will deploy and notify you of the status of the deployment.
```bash
bash ./deployer.sh # (or make it executable and just run it)
```
**Note:** that you do have to run it in order to update the script. Also take care when you are `php artisan config:cache` since this will lock the config and not update the script.

## Push to deploy?
Definitely possible, read up on the docs of your git provider (eg Bitbucket, GitHub). You just need to be able for the bash script to be run when you deploy (or other actions).

*Again, this is work in progress, so it probable will break all of the times*