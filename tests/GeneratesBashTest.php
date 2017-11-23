<?php

namespace TheJawker\Deployer\Test;

use TheJawker\Deployer\DeployScriptGenerator;

class GeneratesBashTest extends TestCase
{
    /** @test */
    public function script_starts_with_valid_bash_exec()
    {
        $bash = DeployScriptGenerator::asString();

        $this->assertEquals("#!/bin/bash", strtok($bash, "\n"));
    }
    
    /** @test */
    public function setup_section_conforms_to_config()
    {

    }
}