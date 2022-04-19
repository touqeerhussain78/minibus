<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperatorRating extends Model
{
    protected $fillable = [
        'user_id', 'booking_id', 'operator_id', 'comments', 'rating', 'reply'
    ];

    protected $with = ['operator', 'user'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function operator()
    {
        return $this->hasOne(Operator::class, 'id', 'operator_id');
    }

}
