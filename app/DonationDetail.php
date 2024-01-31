<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DonationDetail extends Model
{
    protected $table = "donation_details";
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'amount',
        'currency',
        'currency_position',
        'currency_symbol',
        'currency_symbol_position',
        'transaction_id',
        'status',
        'receipt',
        'transaction_details',
        'bex_details',
        'donation_id',
        'payment_method'
    ];

    // Relationship
    public function cause() :BelongsTo
    {
        return $this->belongsTo(Donation::class);
    }
}
