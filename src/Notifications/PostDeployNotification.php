<?php

namespace TheJawker\Deployer\Notifications;

use Illuminate\Bus\Queueable;
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
    public $log;

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

    public function constructMessage()
    {
        return (new PostDeploySlackMessage($this))
            ->construct();
    }

    public function getDuration()
    {
        return round(microtime(true) - $this->microtime, 2);
    }
}