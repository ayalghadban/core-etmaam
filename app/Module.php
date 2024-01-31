<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Module extends Model
{
    
  public function moduleBelongsToCourse() :BelongsTo
  {
    return $this->belongsTo(Course::class);
  }

  public function lessons()
  {
    return $this->hasMany('App\Lesson');
  }
}
