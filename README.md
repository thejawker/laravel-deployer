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

## Publish Script
If you are happy with your config you can publish the bash script by running the following command:
```bash
$ php artisan deployer
```
This will create a `deployer.sh` bash file in the application root. Running this file will deploy and notify you of the status of the deployment.
```bash
bash ./deployer.sh # (or make it executable and just run it)
```

## Push to deploy?
Definitely possible, read up on the docs of your git provider (eg Bitbucket, GitHub). You just need to be able for the bash script to be run when you deploy (or other actions).

*Again, this is work in progress, so it probable will break all of the times*