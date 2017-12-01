<?php

namespace TheJawker\Deployer\Test\Commands;

use TheJawker\Deployer\Commands\DeployerCommand;
use TheJawker\Deployer\Test\TestCase;

class DeployerCommandTest extends TestCase
{
    /** @test */
    public function deployer_can_be_run()
    {
        $deployerCommand = new DeployerCommand();

        $deployerCommand->handle();

        $this->assertTrue(true);
    }
}