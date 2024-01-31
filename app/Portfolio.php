<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Portfolio extends Model
{
  protected $fillable = ['id', 'language_id', 'title', 'slug', 'start_date', 'submission_date', 'client_name', 'tags', 'featured_image', 'content', 'service_id', 'status', 'serial_number', 'meta_keywords', 'meta_description', 'website_link'];


  //Relations
  public function portfolio_images() :HasMany
  {
    return $this->hasMany(PortfolioImage::class);
  }

  public function service() :BelongsTo
  {
    return $this->belongsTo(Service::class);
  }

  public function language() :BelongsTo
  {
    return $this->belongsTo(Language::class);
  }
}
