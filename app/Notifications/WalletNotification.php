<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WalletNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($package=0, $type, $quote=0)
    {
        $this->package = $package;
        $this->type = $type;
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
        if($this->type=='operator'){
            $message = 'You have successfully purchased '.$this->package->quote.' quotations for £'.$this->package->amount.' .';
        }else{
            $message = 'Admin has send you '.$this->quote.' quotes in reward. Please check your wallet.';
        }
        
        $data = [
            'greeting' => 'Dear '.$notifiable->name.'!',
            'line_1' => $message,
            'action' => 'Check Your Wallet',
            'action_url' => url('/operators/wallet'),
            'line_2' => 'Thank you for using Minibus!'
        ];
        return (new MailMessage)
                    ->from('info@minibus.com', 'Minibus')
                    ->subject('Minibus - Wallet')
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
        if($this->type=='operator'){
            $message = 'You have successfully purchased '.$this->package->quote.' quotations for £'.$this->package->amount.' .';
        }else{
            $message = 'Admin has send you '.$this->quote.' quotes in reward. Please check your wallet.';
        }
        return [
            'title' => 'Minibus - Wallet',
            'message' => $message,
            'user_id' => $notifiable->id,
            'url' => url('/operators/wallet'),
        ];
    }
}
