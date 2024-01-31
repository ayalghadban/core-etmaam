<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = ['title', 'language_id', 'price', 'description', 'serial_number', 'meta_keywords', 'meta_description', 'color', 'order_status', 'link', 'image', 'feature', 'duration', 'category_id'];

    //Relations
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function package_orders(): HasMany
    {
        return $this->hasMany(PackageOrder::class);
    }

    public function current_subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'current_package_id');
    }

    public function next_subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'next_package_id');
    }

    public function pending_subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'pending_package_id');
    }

    public function packageCategory(): BelongsTo
    {
        return $this->belongsTo(PackageCategory::class, 'category_id', 'id');
    }
}
