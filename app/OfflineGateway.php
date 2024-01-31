<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfflineGateway extends Model
{
    protected $fillable = ['id', 'language_id', 'name', 'short_description', 'instructions', 'serial_number', 'status', 'is_receipt', 'receipt'];

    //Relations
    public function offline_gateway() :BelongsTo
    {
        return $this->belongsTo(OfflineGateway::class);
    }
}
