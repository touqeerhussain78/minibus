<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialInvite extends Model
{
    protected $fillable = [
        'user_id', 'operator_id','booking_id'
    ];

    public function booking()
    {
        return $this->hasOne('\App\Booking', 'id', 'booking_id');
    }
}
