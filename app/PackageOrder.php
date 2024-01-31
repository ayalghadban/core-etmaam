<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageOrder extends Model
{
    protected $fillable = ['user_id', 'package_id', 'order_number', 'name', 'email', 'fields', 'nda', 'package_title', 'package_price', 'status', 'package_description', 'invoice', 'method', 'receipt', 'payment_status', 'gateway_type'];

    //Relations

    public function package() : BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
