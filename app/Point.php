<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Point extends Model
{
    public $timestamps = false;

    protected $fillable = ['language_id', 'icon', 'color', 'title', 'short_text', 'serial_number'];

    //Relations
    public function language() : BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
