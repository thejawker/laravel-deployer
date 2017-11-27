<?php

namespace TheJawker\Deployer\Test;

use Illuminate\Support\Facades\Notification;
use TheJawker\Deployer\Commands\PostDeployCommand;

class PostDeployCommandTest extends TestCase
{
    /** @test */
    public function can_parse_bash_array()
    {
        $microtime = microtime(true);
        $log = "not anything -hh=>==./testing.sh: line 6: not: command not found~@~@~git anything -hh=>==git: 'anything' is not a git command. See 'git --help'.~@~@~";

        $postDeploymentCommand = new PostDeployCommand($microtime, $log);

        $this->assertArraySubset([
            'not anything -hh' => './testing.sh: line 6: not: command not found',
            'git anything -hh' => "git: 'anything' is not a git command. See 'git --help'."
        ], $postDeploymentCommand->log->toArray());
    }

    /** @test */
    public function only_notifies_to_targeted_environments()
    {
        config()->set('deployer.env-level', ['cheese']);
        config()->set('app.env', 'cheese');
        Notification::fake();

        $postDeploymentCommand = new PostDeployCommand(microtime(true) - 20, collect());

        $this->assertTrue($postDeploymentCommand->handle());
    }

    /** @test */
    public function doesnt_send_to_other_environments()
    {
        config()->set('deployer.env-level', ['cheese']);
        config()->set('app.env', 'meat');

        Notification::fake();

        $postDeploymentCommand = new PostDeployCommand(microtime(true) - 20, collect());

        $this->assertFalse($postDeploymentCommand->handle());
    }

    /** @test */
    public function accepts_a_wildcard()
    {
        config()->set('deployer.env-level', ['*']);
        config()->set('app.env', 'meat');

        Notification::fake();

        $postDeploymentCommand = new PostDeployCommand(microtime(true) - 20, collect());

        $this->assertTrue($postDeploymentCommand->handle());
    }
}