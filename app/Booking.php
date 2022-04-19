<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id','no_of_passengers', 'type', 'pickup_date', 'pickup_time', 'pickup_lat', 'pickup_long', 'pickup_address', 'return_date', 'return_time', 'return_lat', 'return_long', 'return_address','dropoff_lat', 'dropoff_long', 'dropoff_address', 'is_return', 'trip_reason', 'hand_luggage', 'mid_luggage', 'large_luggage', 'additional_info', 'contact_name', 'contact_phone', 'contact_email', 'security_deposit', 'status', 'trip_end_date', 'is_refund', 'is_paid'
    ];

    public function user()
    {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }

    public function quotes()
    {
        return $this->hasMany('\App\QuoteBooking'); 
    }

    public function quote() {
        return $this->quotes()->where('status','=', 1);
    }

    public function specialInvites()
    {
        return $this->hasMany('\App\SpecialInvite'); 
    }

    public function getPickupDateAttribute($value)
    {
        return date("d-m-Y", strtotime($value));
    }

    public function getReturnDateAttribute($value)
    {
        return date("d-m-Y", strtotime($value));
    }
    
    public function getCreatedAtAttribute($value)
    {
        return date("d-m-Y", strtotime($value));
    }
}
