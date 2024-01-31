<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pcategory extends Model
{
    protected $fillable = ['name','image','language_id','status','slug'];

    //Relations
    public function products() :HasMany
    {
        return $this->hasMany(Product::class,'category_id','id');
    }

    public function language()  :BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
