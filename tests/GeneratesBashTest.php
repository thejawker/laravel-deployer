<?php

namespace TheJawker\Deployer\Test;

use Illuminate\Http\File;
use TheJawker\Deployer\DeployScriptGenerator;

class GeneratesBashTest extends TestCase
{
    /** @test */
    public function script_starts_with_valid_bash_exec()
    {
        $basScriptGenerator = new DeployScriptGenerator();
        $bash = $basScriptGenerator->asString();

        $this->assertEquals("#!/bin/bash", strtok($bash, "\n"));
    }
    
    /** @test */
    public function can_generate_a_bash_file()
    {
        $basScriptGenerator = new DeployScriptGenerator();

        /** @var File $file */
        $file = $basScriptGenerator->store();

        $this->assertNotEmpty($file);
        $this->assertTrue(str_contains("#!/bin/bash", $file->openFile()->fread(128)));
        $this->assertTrue(str_contains('deployer.sh', $file->getFilename()));
    }
    
    /** @test */
    public function uses_the_name_used_in_the_config()
    {
        config()->set('deployer.script-name', 'aaa.sh');
        $basScriptGenerator = new DeployScriptGenerator();

        $file = $basScriptGenerator->store();

        $this->assertTrue(str_contains('aaa.sh', $file->getFilename()));
    }
    
    /** @test */
    public function theres_a_default_script_name()
    {
        config()->set('deployer', null);
        $basScriptGenerator = new DeployScriptGenerator();

        $file = $basScriptGenerator->store();

        $this->assertTrue(str_contains('deployer.sh', $file->getFilename()));
    }
}