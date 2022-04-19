<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    protected $fillable = [
        'user_id', 'booking_quote_id', 'operator_id', 'booking_id', 'amount', 'stripe_charge_id', 'details'
    ];

    protected $hidden = ['details'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function booking()
    {
        return $this->hasOne(Booking::class, 'id', 'booking_id');
    }

    public function quote()
    {
        return $this->hasOne(QuoteBooking::class, 'id', 'booking_quote_id');
    }

    public function operator()
    {
        return $this->hasOne(Operator::class, 'id', 'operator_id');
    }

    public function getCreatedAtAttribute($value)
    {
        if(!empty($value)){
            return date("d-m-Y", strtotime($value));
        }else{
            return "";
        }
        
    }



}
