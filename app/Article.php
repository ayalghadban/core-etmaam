<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    //relationships
  public function articleCategory() : BelongsTo
  {
    return $this->belongsTo(ArticleCategory::class);
  }

  public function language() : BelongsTo
{
    return $this->belongsTo(Language::class);
  }
}
