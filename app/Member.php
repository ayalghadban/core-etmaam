<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    protected $fillable = ['language_id', 'name', 'rank', 'image', 'facebook', 'twitter', 'instagram', 'linkedin', 'feature'];
    public $timestamps = false;

    //Relationships
    public function language() : BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
