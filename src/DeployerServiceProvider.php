<?php

namespace TheJawker\Deployer;

use Illuminate\Support\ServiceProvider;
use TheJawker\Deployer\Commands\DeployCommand;
use TheJawker\Deployer\Commands\DeployerCommand;
use TheJawker\Deployer\Commands\PostDeployCommand;

class DeployerServiceProvider extends ServiceProvider
{
    /**
     * Bootstraps the Application Services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/deployer.php' => config_path('deployer.php'),
        ], 'deployer-config');
    }

    /**
     * Registers the Application Services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/deployer.php', 'deployer');

        $this->app->bind('command.deployer', DeployerCommand::class);
        $this->app->bind('command.deployer.post-deploy', PostDeployCommand::class);
        $this->commands([
            'command.deployer',
            'command.deployer.post-deploy',
        ]);
    }
}