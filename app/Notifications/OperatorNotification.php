<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OperatorNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $type)
    {
        $this->message = $message;
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if($this->type=='rate'){
            $subject = 'New Review';
            $action = 'Check your profile';
            $url = url('/operators');

        }else if($this->type=='approve'){
            $subject = 'Account Approval';
            $action = 'Login';
            $url = url('/login');

        }else if($this->type=='reject'){
            $subject = 'Account Rejected';
            $action = 'Contact Admin';
            $url = url('/contact-us');

        }
        
        $data = [
            'greeting' => 'Dear '.$notifiable->name.'!',
            'line_1' => $this->message,
            'action' => $action,
            'action_url' => $url,
            'line_2' => 'Thank you for using Minibus!'
        ];
        return (new MailMessage)
                    ->from('info@minibus.com', 'Minibus')
                    ->subject('Minibus - '.$subject)
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
        if($this->type=='rate'){
            $subject = 'New Review';
            $url = url('/operators');

        }else if($this->type=='approve'){
            $subject = 'Account Approval';
            $url = url('/login');

        }else if($this->type=='reject'){
            $subject = 'Account Rejected';
            $url = url('/contact-us');

        }

        return [
            'title' => 'Minibus - '.$subject,
            'message' => $this->message,
            'user_id' => $notifiable->id,
            'url' => $url,
        ];
    }
}
