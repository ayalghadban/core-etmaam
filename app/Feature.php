<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feature extends Model
{
    public $timestamps = false;

    protected $fillable = ['language_id', 'icon', 'image', 'title', 'color', 'serial_number'];

    //Relationships
    public function language() : BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
