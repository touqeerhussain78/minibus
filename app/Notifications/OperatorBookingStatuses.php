<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OperatorBookingStatuses extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($quote, $amount=0)
    {
        $this->quote = $quote;
        $this->amount = $amount;
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
        if($this->quote->booking['status'] == 1){
            $message = 'Your trip #'.$this->quote->booking_id.' has been confirmed. Security deposit is £'.$this->amount;
        }
        else if($this->quote->booking['status'] == 2 ){
            $message = 'Your trip #'.$this->quote->booking_id.' has been confirmed.';
        }
        else if($this->quote->booking['status'] == 3){
            $message = 'You have marked trip #'.$this->quote->booking_id.' as started.';
        }
        else if($this->quote->booking['status'] == 4){
            $message = 'You have marked trip #'.$this->quote->booking_id.' as completed.';
        }
        else if($this->quote->booking['status'] == 6){
            $message = 'Your trip #'.$this->quote->booking_id.' has been cancelled.';
        }
        else {
            $message = 'Your trip #'.$this->quote->booking_id.' has been confirmed. Security deposit is £'.$this->amount;
        }
        $data = [
            'greeting' => 'Dear '.$notifiable->name.'!',
            'line_1' => $message,
            'action' => 'View Bookings',
            'action_url' => url('/operators/quotations/accepted'),
            'line_2' => 'Thank you for using Minibus!'
        ];
        return (new MailMessage)
                    ->from('info@minibus.com', 'Minibus')
                    ->subject('Booking')
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
        if($this->quote->booking['status'] == 1 ){
            $message = 'Your trip #'.$this->quote->booking_id.' has been confirmed. Security deposit is £'.$this->amount;
        }
        else if($this->quote->booking['status'] == 2 ){
            $message = 'Your trip #'.$this->quote->booking_id.' has been confirmed.';
        }
        else if($this->quote->booking['status'] == 3){
            $message = 'You have marked trip #'.$this->quote->booking_id.' as started.';
        }
        else if($this->quote->booking['status'] == 4){
            $message = 'You have marked trip #'.$this->quote->booking_id.' as completed.';
        }
        else if($this->quote->booking['status'] == 6){
            $message = 'Your trip #'.$this->quote->booking_id.' has been cancelled.';
        }
        else {
            $message = 'Your trip #'.$this->quote->booking_id.' has been confirmed. Security deposit is £'.$this->amount;
        }
        return [
            'title' => 'Minibus - Booking',
            'message' => $message,
            'booking_id' => $this->quote->booking_id,
            'user_id' => $notifiable->id,
            'url' => url('/operators/quotations/accepted'),
        ];
    }
}
