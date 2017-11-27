<?php

namespace TheJawker\Deployer;

use Illuminate\Support\ServiceProvider;
use TheJawker\Deployer\Commands\DeployCommand;
use TheJawker\Deployer\Commands\DeployerCommand;

class DeployerServiceProvider extends ServiceProvider
{
    /**
     * Bootstraps the Application Services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/deployer.php' => config_path('deployer.php'),
        ], 'config');
    }

    /**
     * Registers the Application Services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/deployer.php', 'deployer');

        $this->app->bind('command.deployer', DeployerCommand::class);
        $this->commands([
            'command.deployer'
        ]);
    }
}