<?php

namespace TheJawker\Deployer\Test\ScriptRunner;

use Carbon\Carbon;
use TheJawker\Deployer\DeployScriptGenerator;
use TheJawker\Deployer\ScriptInitializer;
use TheJawker\Deployer\Test\TestCase;

class ScriptRunnerTest extends TestCase
{
    /** @test */
    public function the_script_can_be_run_on_the_command_line()
    {
        $generator = new DeployScriptGenerator();
        $generator->commands->push('echo Running Deployer...');
        $generator->store();

        $output = exec('bash ' . $generator->getFilePath());

        $this->assertTrue(str_contains('Running Deployer...', $output));
    }

    /** @test */
    public function can_run_artisan_commands()
    {
        $generator = new DeployScriptGenerator();

        $generator->commands->push('php -r "echo microtime(true);"');
        $generator->store();

        $output = exec('bash ' . $generator->getFilePath());

        $this->assertTrue(Carbon::createFromTimestamp((float) $output)->isPast());
    }

    /** @test */
    public function an_initializer_with_help_functions_can_be_injected_at_the_top()
    {
        $generator = new DeployScriptGenerator();

        $generator->commands->push(new ScriptInitializer);
        $generator->store();

        $output = exec('bash ' . $generator->getFilePath());

        $this->assertTrue(Carbon::createFromTimestamp((float) $output)->isPast());
    }
}