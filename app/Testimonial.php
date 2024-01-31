<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    public $timestamps = false;

    protected $fillable = ['language_id', 'image', 'comment', 'name', 'rank', 'serial_number'];

    public function language() :BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
