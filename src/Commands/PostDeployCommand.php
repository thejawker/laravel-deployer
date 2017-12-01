<?php

namespace TheJawker\Deployer\Commands;

use Illuminate\Support\Facades\Notification;
use TheJawker\Deployer\Notifications\PostDeployNotification;

class PostDeployCommand extends BaseCommand
{
    /**
     * Constants for parsing.
     */
    const ARRAY_SEPARATOR = "~@~@~";
    const ARRAY_VALUE_SEPARATOR = "=>==";

    private $microtime;
    public $log;

    protected $signature = 'deployer:post-deploy
                            {timestamp : The starting time of the deployment script} 
                            {log? : The information log of the deployment}';

    public function setVariables($microtime = null, $log = null)
    {
        $this->microtime = $microtime ? $microtime : $this->argument('timestamp');
        $this->log = $log ? $this->parseLog($log) : $this->parseLog($this->argument('log'));
    }

    public function handle($microtime = null, $log = null)
    {
        $this->setVariables($microtime, $log);

        if (in_array(config('app.env'), config('deployer.env-level')) || in_array('*', config('deployer.env-level'))) {
            Notification::route('slack', config('deployer.slack-log.url'))
                ->notify(new PostDeployNotification($this->microtime, $this->log));
            return true;
        }

        return false;
    }

    private function parseLog($log)
    {
        return collect(explode(self::ARRAY_SEPARATOR, $log))->filter(function($line) {
            return count(explode(self::ARRAY_VALUE_SEPARATOR, $line, 2)) === 2;
        })->mapWithKeys(function ($line) {
            $output = explode(self::ARRAY_VALUE_SEPARATOR, $line, 2);
            return [$output[0] => $output[1]];
        });
    }
}