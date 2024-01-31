<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageInputOption extends Model
{
    protected $fillable = ['type', 'label', 'name', 'placeholder', 'required'];

    // Relations
    public function package_input() : BelongsTo
    {
        return $this->belongsTo(PackageInput::class);
    }
}
