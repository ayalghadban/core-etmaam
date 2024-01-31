<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Slider extends Model
{
    protected $fillable = ['language_id', 'title', 'title_font_size',
    'bold_text', 'bold_text_font_size', 'bold_text_color', 'text', 'text_font_size',
    'button_text', 'button_text_font_size', 'button_url', 'image', 'side_image', 'serial_number',
    'created_at', 'updated_at', 'another_button_text', 'another_button_text_font_size', 'another_button_url'];

    //Relation
    public function language() :BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
