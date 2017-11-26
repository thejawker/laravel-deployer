<?php

namespace TheJawker\Deployer\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class PostDeployNotification extends Notification
{
    use Queueable;

    /**
     * The microtime to calculate the duration.
     *
     * @var
     */
    private $microtime;

    /**
     * The Collection of errors.
     *
     * @var Collection
     */
    private $log;

    /**
     * Create a new notification instance.
     * @param float $microtime
     * @param Collection $log
     */
    public function __construct($microtime = null, $log)
    {
        $this->microtime = (float) $microtime;
        $this->log = $log;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        return $this->constructMessage();
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function getDuration()
    {
        return round(microtime(true) - $this->microtime, 2);
    }

    public function constructMessage()
    {
        $duration = $this->getDuration();

        $message = new SlackMessage();
        $message->level = $this->level();

        $message
            ->from('Deployer')
            ->to(config('deployer.slack-channel'))
            ->content(sprintf('Deployment on %s [%s]', config('app.name'), config('app.env')));
//            ->attachment(function ($attachment) use ($duration, $hasErrors) {
//                $attachment->title(sprintf("The process took %s seconds long.", $duration));
//            });

        return $message;
    }

    private function level()
    {
        $warnLevel = $this->getDuration() > config('deployer.warn-after') ?
            'warning' : 'success';

        return $this->log->isEmpty() ?
            $warnLevel : 'error';
    }
}