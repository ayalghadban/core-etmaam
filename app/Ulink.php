<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ulink extends Model
{
    public $timestamps = false;

    protected $fillable = ['language_id', 'name', 'url'];

    //Relations
    public function language():BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
