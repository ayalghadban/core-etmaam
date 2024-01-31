<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Scategory extends Model
{
  public $timestamps = false;

  protected $fillable = ['language_id', 'name', 'title_color', 'image', 'short_text', 'status', 'serial_number', 'feature', 'type'];

  //Relations
  public function services() :HasMany
  {
    return $this->hasMany(Service::class);
  }

  public function language() :BelongsTo
  {
    return $this->belongsTo(Language::class);
  }
}
