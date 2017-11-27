<?php

namespace TheJawker\Deployer\Test;

use TheJawker\Deployer\Notifications\PostDeployNotification;

class NotificationTest extends TestCase
{
    /** @test */
    public function a_duration_can_be_calculated()
    {
        $time = microtime(true) - 20;
        $log = collect();
        $notification = new PostDeployNotification($time, $log);

        $duration = $notification->getDuration();

        $this->assertEquals(20, $duration);
    }

    /** @test */
    public function a_slack_message_can_be_constructed()
    {
        $time = microtime(true) - 20;
        $log = collect();
        $notification = new PostDeployNotification($time, $log);

        $slackMessage = $notification->constructMessage();

        $this->assertEquals('Deployer', $slackMessage->username);
    }

    /** @test */
    public function the_message_is_by_default_success()
    {
        $time = microtime(true) - 20;
        $log = collect();
        $notification = new PostDeployNotification($time, $log);

        $slackMessage = $notification->constructMessage();

        $this->assertEquals('Deployer', $slackMessage->username);
        $this->assertEquals('success', $slackMessage->level);
    }

    /** @test */
    public function logs_are_attached_to_the_message()
    {
        $time = microtime(true) - 20;
        $log = collect([
            'git' => 'Something went wrong',
            'php' => 'Runtime error'
        ]);
        $notification = new PostDeployNotification($time, $log);

        $slackMessage = $notification->constructMessage();

        $this->assertEquals('Deployer', $slackMessage->username);
        $this->assertCount(3, $slackMessage->attachments);

        $this->assertEquals('Deployment took 20 seconds', $slackMessage->attachments[ 'duration' ]->title);
        $this->assertEquals('Git has an issue', $slackMessage->attachments[ 'git' ]->title);
        $this->assertEquals('Something went wrong', $slackMessage->attachments[ 'git' ]->content);
        $this->assertEquals('Php has an issue', $slackMessage->attachments[ 'php' ]->title);
        $this->assertEquals('Runtime error', $slackMessage->attachments[ 'php' ]->content);
    }

    /** @test */
    public function if_the_deployment_has_errors_it_will_be_an_error()
    {
        $time = microtime(true) - 20;
        $log = collect([
            'git' => 'things go wrong'
        ]);
        $notification = new PostDeployNotification($time, $log);

        $slackMessage = $notification->constructMessage();

        $this->assertEquals('Deployer', $slackMessage->username);
        $this->assertEquals('error', $slackMessage->level);
    }

    /** @test */
    public function a_longer_than_threshold_can_show_a_warning()
    {
        config()->set('deployer.warn-after', 20);
        $time = microtime(true) - 21;
        $log = collect();
        $notification = new PostDeployNotification($time, $log);

        $slackMessage = $notification->constructMessage();

        $this->assertEquals('Deployer', $slackMessage->username);
        $this->assertEquals('warning', $slackMessage->level);
    }

    /** @test */
    public function an_error_overrules_the_warning()
    {
        config()->set('deployer.warn-after', 20);
        $time = microtime(true) - 21;
        $log = collect(['git' => 'Some error']);
        $notification = new PostDeployNotification($time, $log);

        $slackMessage = $notification->constructMessage();

        $this->assertEquals('Deployer', $slackMessage->username);
        $this->assertEquals('error', $slackMessage->level);
    }

    /** @test */
    public function the_notification_is_sent_to_the_proper_channel()
    {
        config()->set('deployer.slack-channel', 'Random Channel');
        $time = microtime(true) - 21;
        $log = collect(['git' => 'Some error']);
        $notification = new PostDeployNotification($time, $log);

        $slackMessage = $notification->constructMessage();

        $this->assertEquals('Deployer', $slackMessage->username);
        $this->assertEquals('Random Channel', $slackMessage->channel);
    }

    /** @test */
    public function the_title_shows_the_environment_of_the_deployer()
    {
        config()->set('app.env', 'random-env');
        config()->set('app.name', 'random-app');
        $time = microtime(true) - 21;
        $log = collect(['git' => 'Some error']);
        $notification = new PostDeployNotification($time, $log);

        $slackMessage = $notification->constructMessage();

        $this->assertEquals('Deployer', $slackMessage->username);
        $this->assertEquals('Deployment on random-app [random-env]', $slackMessage->content);
    }
}