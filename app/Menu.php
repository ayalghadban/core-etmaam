<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    protected $fillable = ['language_id', 'menues'];

    //Relations

    public function language() : BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
