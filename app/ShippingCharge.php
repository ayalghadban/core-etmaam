<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingCharge extends Model
{
    protected $fillable = ['title','text','language_id','charge'];

    public function language() :BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
