<?php

namespace TheJawker\Deployer\Test\Commands;

use TheJawker\Deployer\ScriptInitializer;
use TheJawker\Deployer\Test\TestCase;

class ScriptInitializerTest extends TestCase
{
    /** @test */
    public function the_script_initializer_can_load_config_initializer_commands()
    {
        config()->set('deployer.commands.initialize', ['some-command']);
        $scriptInitializer = new ScriptInitializer();

        $scriptInitializer->loadConfigCommands('deployer.commands.initialize');

        $this->assertContains('some-command', $scriptInitializer->bash->first());
    }

    /** @test */
    public function commands_are_enclosed_in_the_run_command_bash_function()
    {
        config()->set('deployer.commands.initialize', ['some-command']);
        $scriptInitializer = new ScriptInitializer();

        $scriptInitializer->loadConfigCommands('deployer.commands.initialize');

        $this->assertEquals("run_command 'some-command'", $scriptInitializer->bash->first());
    }

    /** @test */
    public function commands_with_exclamation_mark_are_not_wrapped_in_run_command_bash_function()
    {
        config()->set('deployer.commands.initialize', ['!some-command']);
        $scriptInitializer = new ScriptInitializer();

        $scriptInitializer->loadConfigCommands('deployer.commands.initialize');

        $this->assertEquals("some-command", $scriptInitializer->bash->first());
    }
}