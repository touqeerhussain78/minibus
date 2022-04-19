<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingEvents extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($quote, $operator)
    {
        $this->quote = $quote;
        $this->operator = $operator;
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
       // if($this->quote->booking['status'] == 0){
            $message = 'You have a new quotation request against trip #'.$this->quote->booking_id.' .';
        // }
        // else {
        //     $message = 'Your trip #'.$this->quote->booking_id.' has been accepted by the operator. Please proceed to pay for the trip to confirm it .';
        // }

        $data = [
            'greeting' => 'Dear '.$notifiable->name.'!',
            'line_1' => $message,
            'action' => 'View Bookings',
            'action_url' => url('/bookings'),
            'line_2' => 'Thank you for using Minibus!'
        ];
        return (new MailMessage)
                    ->from('info@minibus.com', 'Minibus')
                    ->subject('New Quotation Request')
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
            'title' => 'Trip Booked',
            'message' => 'You have a new quotation request against trip #'.$this->quote->booking_id.' .',
            'booking_id' => $this->quote->booking_id,
            'user_id' => $notifiable->id,
            'url' => url('/bookings'),
        ];
    }
}
