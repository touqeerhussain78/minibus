<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    protected $fillable = [
        'complain_category_id', 'booking_id', 'user_id', 'operator_id', 'comments', 'admin_remarks', 'status'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function operator()
    {
        return $this->hasOne(Operator::class, 'id', 'operator_id');
    }

    public function category()
    {
        return $this->hasOne(ComplainCategory::class, 'id', 'complain_category_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return date("d-m-Y", strtotime($value));
    }
}
