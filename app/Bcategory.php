<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bcategory extends Model
{
    public $timestamps = false;

    protected $fillable = ['language_id', 'name', 'slug', 'status', 'serial_number'];

    // Relationship
    public function blogs() :HasMany
    {
      return $this->hasMany(Blog::class);
    }
}
