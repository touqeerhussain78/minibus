<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperatorPaymentLog extends Model
{
    protected $fillable = ['operator_id', 'quotation_package_id', 'amount', 'stripe_charge_id', 'details'];
    public $timestamps = true;

    public function package()
    {
        return $this->hasOne(QuotationPackage::class, 'id', 'quotation_package_id');
    }

    public function operator()
    {
        return $this->hasOne(Operator::class, 'id', 'operator_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return date("d-m-Y", strtotime($value));
    }
}
