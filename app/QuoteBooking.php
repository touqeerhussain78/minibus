<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuoteBooking extends Model
{
    protected $fillable = [
        'operator_id','booking_id', 'amount', 'status'
    ];

    public function booking()
    {
        return $this->hasOne('\App\Booking', 'id', 'booking_id');
    }

    protected $with = ['operator'];

    
    public function operator()
    {
        return $this->hasOne('\App\Operator', 'id', 'operator_id'); 
    }

    public function getCreatedAtAttribute($value)
{
    return date("d-m-Y", strtotime($value));
}
}
