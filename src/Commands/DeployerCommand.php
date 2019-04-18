<?php

namespace TheJawker\Deployer\Commands;

use TheJawker\Deployer\DeployScriptGenerator;
use TheJawker\Deployer\ScriptInitializer;
use TheJawker\Deployer\ScriptLoader;
use TheJawker\Deployer\ScriptPostDeploy;

class DeployerCommand extends BaseCommand
{
    protected $signature = 'deployer';

    public function handle()
    {
        $scriptGenerator = new DeployScriptGenerator();
        $scriptGenerator->commands->push(new ScriptInitializer);
        $scriptGenerator->commands->push(
            (new ScriptLoader())
            ->loadConfigCommands('deployer.commands.set-up')
            ->loadConfigCommands('deployer.commands.deploy')
        );
        $scriptGenerator->commands->push(new ScriptPostDeploy);

        $scriptGenerator->store();
        return $scriptGenerator;
    }
}