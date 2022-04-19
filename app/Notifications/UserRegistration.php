<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRegistration extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if($this->type=='operator'){
            $data = [
                'greeting' => 'Dear '.$notifiable->name.'!',
                'line_1' => 'Your account has been registered successfully. You will be notified after approval of your account.',
                'action' => 'Login',
                'action_url' => url('/login'),
                'line_2' => 'Thank you for using Minibus!'
            ];
    
        }else{
            $data = [
                'greeting' => 'Dear '.$notifiable->name.'!',
                'line_1' => 'Your account has been registered successfully. Welcome to Minibus.',
                'action' => 'Login',
                'action_url' => url('/login'),
                'line_2' => 'Thank you for using Minibus!'
            ];
    
        }
        
        return (new MailMessage)
            ->from('info@minibus.com', 'Minibus')
            ->subject('Account Registration')
            ->view('vendor.mail.default', compact('data'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
