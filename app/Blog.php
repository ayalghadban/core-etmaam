<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    public $timestamps = true;

    protected $fillable = ['language_id','bcategory_id', 'title',
    'author', 'slug', 'main_image', 'content', 'sidebar',
    'meta_keywords', 'meta_description', 'serial_number',
    'related_article_id', 'created_at', 'updated_at'];

    //Relationships
    public function bcategory() :BelongsTo
    {
      return $this->belongsTo(Bcategory::class);
    }

    public function language() :BelongsTo
    {
      return $this->belongsTo(Language::class);
    }
    
}
