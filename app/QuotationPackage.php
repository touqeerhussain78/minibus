<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationPackage extends Model
{
    protected $fillable = ['title', 'quote', 'amount', 'status'];

    public function operator_payment_log()
    {
        return $this->belongsTo('\App\OperatorPaymentLog');
    }
}
