<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Popup extends Model
{
    protected $fillable = [
        'language_id', 'name', 'image', 'background_image', 'background_color',
        'background_opacity', 'title', 'text', 'button_text', 'button_url',
        'button_color', 'end_date', 'end_time', 'delay', 'serial_number', 'type',
        'created_at', 'updated_at', 'status'
    ];

    //Relation
    public function language() : BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
    
}
