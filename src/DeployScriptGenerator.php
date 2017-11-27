<?php

namespace TheJawker\Deployer;

use Illuminate\Http\File;
use Illuminate\Support\Collection;

class DeployScriptGenerator
{
    /**
     * @var Collection
     */
    public $commands;

    public function __construct()
    {
        $this->commands = collect([
            self::bashHeader()
        ]);
    }

    public function asString()
    {
        return $this->commands->reduce(function($carry, $command) {
            $string = $command instanceof BashCommand ? $command->handle() : $command;

            return $carry ? $carry . "\n" . $string : $string;
        });

        return $commands->implode(" \n");
    }

    private static function bashHeader()
    {
        return "#!/bin/bash";
    }

    public function store()
    {
        file_put_contents($this->getFilePath(), self::asString());

        return new File($this->getFilePath());
    }

    public function getFilePath()
    {
        return base_path(config('deployer.script-name', 'deployer.sh'));
    }

    public function loadConfig()
    {

    }
}