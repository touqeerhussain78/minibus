<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SpecialInviteNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $booking_id)
    {
        $this->user = $user;
        $this->booking_id = $booking_id;
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
        $data = [
            'greeting' => 'Dear '.$notifiable->name.'!',
            'line_1' => 'You have received a special invite from "'.$this->user->name.'" for trip #'.$this->booking_id.'',
            'action' => 'View Special Invites',
            'action_url' => url('/operators/special-invites'),
            'line_2' => 'Thank you for using Minibus!'
        ];
        return (new MailMessage)
                    ->from('info@minibus.com', 'Minibus')
                    ->subject('Minibus - Special Invite')
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
            'title' => 'Minibus - Special Invite',
            'message' => 'You have received a special invite from "'.$this->user->name.'" for trip #'.$this->booking_id.'',
            'booking_id' => $this->booking_id,
            'user_id' => $notifiable->id,
            'url' => url('/operators/special-invites'),
        ];
    }
}
