<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryCategory extends Model
{
  protected $fillable = [
    'language_id',
    'name',
    'status',
    'serial_number'
  ];

  // Relations
  public function galleryCategoryLang() :BelongsTo
  {
    return $this->belongsTo(Language::class);
  }

  public function galleryImg() :HasMany
  {
    return $this->hasMany(Gallery::class, 'category_id', 'id');
  }
}
