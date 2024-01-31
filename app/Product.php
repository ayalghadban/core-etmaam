<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'language_id',
        'stock',
        'sku',
        'category_id',
        'tags',
        'feature_image',
        'summary',
        'description',
        'current_price',
        'previous_price',
        'rating',
        'status',
        'meta_keywords',
        'meta_description',
        'type',
        'download_link',
        'download_file'
    ];

    //relations
    public function category() :HasOne
    {
        return $this->hasOne(Pcategory::class,'id','category_id');
    }

    public function product_images() :HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function language() :BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
