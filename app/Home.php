<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Home extends Model
{
    protected $fillable = ['language_id', 'theme', 'html', 'css', 'components', 'styles'];

    public $timestamps = false;

    //Relationship
    public function language() :BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
