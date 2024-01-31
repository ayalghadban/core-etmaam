<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{

    protected $fillable = ['language_id', 'article_category_id', 'title',
    'slug', 'content', 'serial_number', 'meta_keywords',
    'meta_description', 'created_at', 'updated_at'];
    
    //relationships
    public function articleCategory(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
