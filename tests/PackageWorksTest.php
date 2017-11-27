<?php

namespace TheJawker\Deployer\Test;

use Illuminate\Support\Facades\Artisan;

class PackageWorksTest extends TestCase
{
    /** @test */
    public function the_deployment_command_can_be_run()
    {
        Artisan::call('deployer');

        $this->assertTrue(true);
    }
}