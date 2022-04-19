<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatuses extends Notification
{
    use Queueable;

   
    public function __construct($quote, $amount=0, $url=null)
    {
        $this->quote    = $quote;
        $this->amount   = $amount;
        $this->url      = $url;
        if($this->url   == null){
            $this->url  = '/bookings';
        }
        else{
            $this->url = '/bookings?type='.$this->url;
        }
    }

    
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

   
    public function toMail($notifiable)
    {
       
        if($this->quote->booking['status'] == 2){
           // $message = 'Your trip #'.$this->booking->id.' has been confirmed by the Operator “'.$this->quote->operator['name'].'”. . Security deposit is £'.$this->quote->booking['security_deposit'];
           $message = 'Congratulations! Operator verified your payment.';
        }
        else if($this->quote->booking['status'] == 3){
            $message = 'Operator “'.$this->quote->operator['name'].'” has marked your trip #'.$this->quote->booking_id.' as started.';
        }
        else if($this->quote->booking['status'] == 4){
            $message = 'Operator “'.$this->quote->operator['name'].'” has marked your trip #'.$this->quote->booking_id.' as completed.';
        }
        else if($this->quote->booking['status'] == 6){
            $message = 'Your trip #'.$this->quote->booking_id.' has been cancelled by operator.';
        }
        else {
            $message = 'You have paid security deposit amount £'.$this->amount.' for your trip #'.$this->quote->booking_id.' .';
        }
        $data = [
            'greeting' => 'Dear '.$notifiable->name.'!',
            'line_1' => $message,
            'action' => 'View Bookings',
            'action_url' => url($this->url),
            'line_2' => 'Thank you for using Minibus!'
        ];
        return (new MailMessage)
                    ->from('info@minibus.com', 'Minibus')
                    ->subject('Booking')
                    ->view('vendor.mail.default', compact('data'));
    }

   
    public function toArray($notifiable)
    {
        if($this->quote->booking['status'] == 2){
            $message = 'Congratulations! Operator verified your payment.';
        }
        else if($this->quote->booking['status'] == 3){
            $message = 'Operator “'.$this->quote->operator['name'].'” has marked your trip #'.$this->quote->booking_id.' as started.';
        }
        else if($this->quote->booking['status'] == 4){
            $message = 'Operator “'.$this->quote->operator['name'].'” has marked your trip #'.$this->quote->booking_id.' as completed.';
        }
        else if($this->quote->booking['status'] == 6){
            $message = 'Your trip #'.$this->quote->booking_id.' has been cancelled by operator.';
        }
        else {
            $message = 'You have paid security deposit amount £'.$this->amount.' for your trip #'.$this->quote->booking_id.' .';
        }
        return [
            'title' => 'Minibus - Booking',
            'message' => $message,
            'booking_id' => $this->quote->booking_id,
            'user_id' => $notifiable->id,
            'url' => url($this->url),
        ];
    }
}
