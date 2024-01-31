<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        "product_order_id",
        "product_id",
        "user_id",
        "title",
        "sku",
        "category",
        "image",
        "summary",
        "description",
        "price",
        "previous_price",

    ];

    // Relationship
    public function product() :BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
