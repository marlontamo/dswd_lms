<?php

namespace App\Notifications\Frontend\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class UserNeedsConfirmation.
 */
class UserConfirmedEmail extends Notification
{
    use Queueable;

    /**
     * @var
     */
    protected $full_name;

    /**
     * UserNeedsConfirmation constructor.
     *
     * @param $confirmation_code
     */
    public function __construct($full_name)
    {
        $this->full_name = $full_name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $body = "Good Day Ma'am/Sir " . $this->full_name . ". Your account in DSWD CAR HITECH LXP has been confirmed. You can now login, enroll and access all the system's features. Click here to access the system.";
        return (new MailMessage())
            ->subject(app_name().': Your Account has been Confirmed.')
            ->line($body)
            ->action('HITECH LXP', url('/'))
            ->line(__('strings.emails.auth.thank_you_for_using_app'));
    }
}
