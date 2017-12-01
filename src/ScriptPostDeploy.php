<?php

namespace TheJawker\Deployer;

class ScriptPostDeploy extends BaseBashCommand implements BashCommand
{

    /**
     * Is run before handled.
     *
     * @return void
     */
    public function run(): void
    {
        $this->newLine();
        $this->largeComment('Post Deploy Section');
        $this->loadConfigCommands('deployer.commands.post-deploy');

        $this->code('php artisan post-deploy ${TIMESTAMP} "${ERRORS}"');
    }
}