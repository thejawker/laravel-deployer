<?php

namespace TheJawker\Deployer;

use Illuminate\Support\ServiceProvider;
use TheJawker\Deployer\Commands\DeployCommand;

class DeployerServiceProvider extends ServiceProvider
{
    /**
     * Bootstraps the Application Services.
     */
    public function boot()
    {

    }

    /**
     * Registers the Application Services.
     */
    public function register()
    {
        $this->app->bind('command.deploy', DeployCommand::class);
        $this->commands([
            'command.deploy'
        ]);
    }
}