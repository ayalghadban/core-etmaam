<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    protected $fillable = ['language_id', 'title', 'image', 'serial_number', 'created_at', 'updated_at', 'category_id'];

    //Relations
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function galleryImgCategory(): BelongsTo
    {
        return $this->belongsTo(GalleryCategory::class, 'category_id', 'id');
    }
}
