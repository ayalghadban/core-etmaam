<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PackageCategory extends Model
{
  protected $table = 'package_categories';

  protected $fillable = [
    'language_id',
    'name',
    'status',
    'serial_number'
  ];

  // Relationship
  public function packageCategoryLang()  :BelongsTo
  {
    return $this->belongsTo(Language::class);
  }

  public function packageList() :HasMany
  {
    return $this->hasMany(Package::class, 'category_id', 'id');
  }
}
