<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EventDetail extends Model
{
    protected $table = "event_details";
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'amount',
        'quantity',
        'currency',
        'currency_symbol',
        'transaction_id',
        'status',
        'receipt',
        'transaction_details',
        'bex_details',
        'event_id',
        'payment_method'
    ];

    // Relationship
    public function event() : BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
