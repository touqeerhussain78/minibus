<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuotationEvents extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($quote)
    {
        $this->quote = $quote;
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
        if($this->quote->status == 0){
            $message = 'Your quotation request has been sent to trip #'.$this->quote->booking_id.'. You now have “'.$notifiable->quotations.'” quotations in your wallet .';
            
        }
        else if($this->quote->status == 1){
            $message = 'Your quotation request has been accepted for trip #'.$this->quote->booking_id.'.';
            
        }
        else{
            $message = 'Your quotation request has been declined for trip #'.$this->quote->booking_id.'.';
        }
        $data = [
            'greeting' => 'Dear '.$notifiable->name.'!',
            'line_1' => $message,
            'action' => 'View Sent Quotations',
            'action_url' => url('/operators/quotations/sent'),
            'line_2' => 'Thank you for using Minibus!'
        ];
        
        return (new MailMessage)
                    ->from('info@minibus.com', 'Minibus')
                    ->subject('Minibus - Trip Booking')
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
        if($this->quote->status == 0){
            $message = 'Your quotation request has been sent to trip #'.$this->quote->booking_id.'. You now have “'.$notifiable->quotations.'” quotations in your wallet .';
            
        }
        else if($this->quote->status == 1){
            $message = 'Your quotation request has been accepted for trip #'.$this->quote->booking_id.'.';
            
        }
        else{
            $message = 'Your quotation request has been declined for trip #'.$this->quote->booking_id.'.';
        }
        return [
            'title' => 'Minibus - Trip Booking',
            'message' => $message,
            'booking_id' => $this->quote->booking_id,
            'user_id' => $notifiable->id,
            'url' => url('/operators/quotations/sent'),
        ];
    }
}
