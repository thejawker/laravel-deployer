<?php

namespace TheJawker\Deployer\Commands;

class DeployCommand extends BaseCommand
{
    /**
     * The signature for the Command.
     *
     * @var string
     */
    protected $signature = 'deploy';

    /**
     * The description for the Command.
     *
     * @var string
     */
    protected $description = 'Starts deploying';

    /**
     * Runs the command.
     */
    public function handle()
    {
        $this->comment('Starting deployment...');
    }
}