<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PartnerVerifyEmailNotification extends VerifyEmail
{
    use Queueable;

    /** @var string */
    private $password;

    /** @var string */
    private $organizationName;
    /**
     * Create a new notification instance.
     */
    public function __construct($password, $organizationName)
    {
        $this->password = $password;
        $this->organizationName = $organizationName;
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
//dd($this->password, $notifiable);
//        dd($notifiable);
        return (new MailMessage)
//            ->subject(auth()->user()->partnerOrganization->organization_name . ' հրավիրել է ձեզ դառնալու փաստաթղթաշրջանառության թիմի անդամ') // Custom subject
            ->subject('Միացիր թիմին!'.env('APP_NAME')) // Custom subject
            ->line($this->organizationName.'-ն հրավիրել է ձեզ դառնալու թիմի անդամ: Ձեր մեկանգամյա գաղտնաբառն է ՝'.$this->password); // Custom message
//            ->action('Հաստատեք էլփոստի հասցեն', $this->verificationUrl($notifiable)); // Button text and URL
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
