<?php

namespace TheJawker\Deployer\Notifications;

use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Messages\SlackMessage;

class PostDeploySlackMessage
{
    private $notification;

    public function __construct(PostDeployNotification $notification)
    {
        $this->notification = $notification;
    }

    public function construct()
    {
        $message = $this->initializeMessage();
        $message->level = $this->level();
        $message->attachments = $this->constructAttachments();

        return $message;
    }

    private function initializeMessage()
    {
        return (new SlackMessage())
            ->from('Deployer')
            ->to(config('deployer.slack-channel'))
            ->content(sprintf('Deployment on %s [%s]', config('app.name'), config('app.env')));
    }

    private function level()
    {
        $warnLevel = $this->notification->getDuration() > config('deployer.warn-after') ?
            'warning' : 'success';

        return $this->notification->log->isEmpty() ?
            $warnLevel : 'error';
    }

    private function constructAttachments()
    {
        return collect()
            ->put('duration', $this->getDurationAttachment())
            ->merge($this->convertLogToAttachments())
            ->toArray();
    }

    private function getDurationAttachment()
    {
        return (new SlackAttachment)
            ->title('Deployment took ' . $this->notification->getDuration() . ' seconds');
    }

    private function convertLogToAttachments()
    {
        return $this->notification->log->map(function ($log, $name) {
            return (new SlackAttachment)
                ->title(ucfirst($name) . ' has an issue')
                ->content($log);
        });
    }
}