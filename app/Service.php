<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
  public $timestamps = false;

  protected $fillable = [
    'language_id', 'scategory_id', 'main_image',
    'title', 'slug', 'content', 'summary', 'serial_number',
    'meta_keywords', 'meta_description', 'feature', 'details_page_status', 'sidebar'];

  public function scategory() :BelongsTo
  {
    return $this->belongsTo(Scategory::class);
  }

  public function portfolios() :HasMany
  {
    return $this->hasMany(Portfolio::class);
  }

  public function language() :BelongsTo
  {
    return $this->belongsTo(Language::class);
  }
}
