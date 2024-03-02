<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomVerifyEmailNotification extends VerifyEmail
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
//            ->subject(auth()->user()->partnerOrganization->organization_name . ' հրավիրել է ձեզ դառնալու փաստաթղթաշրջանառության թիմի անդամ') // Custom subject
            ->subject('Էլ. հասցեի հաստատում,'.env('APP_NAME')) // Custom subject
            ->line('Խնդրում ենք սեղմել ստորև նշված կոճակը՝ ձեր էլ.փոստի հասցեն հաստատելու համար:') // Custom message
            ->action('Հաստատեք էլփոստի հասցեն', $this->verificationUrl($notifiable)); // Button text and URL
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
