<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Partner extends Model
{
    public $timestamps = false;

    protected $fillable = ['language_id', 'image', 'url', 'serial_number'];

    //Relations
    public function language()  :BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
