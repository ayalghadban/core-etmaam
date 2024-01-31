<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioImage extends Model
{

    public function portfolio() :BelongsTo
    {
      return $this->belongsTo(Portfolio::class);
    }
}
