<?php

namespace TheJawker\Deployer\Commands;

use Illuminate\Support\Facades\Notification;
use TheJawker\Deployer\Notifications\PostDeployNotification;

class PostDeployCommand extends BaseCommand
{
    private $microtime;
    private $log;

    protected $signature = 'deployer:post-deploy
                            {timestamp : The starting time of the deployment script} 
                            {log? : The information log of the deployment}';
    /**
     * @var null
     */
    private $fakeUser;

    public function __construct($microtime, $log, $fakeUser = null)
    {
        $this->microtime = $microtime;
        $this->log = $log;
        $this->fakeUser = $fakeUser;
    }

    public function handle()
    {
        Notification::route('slack', config('deployer.slack-log.url'))
            ->notify(new PostDeployNotification($this->microtime, $this->log));
    }
}