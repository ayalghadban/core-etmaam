<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleCategory extends Model
{
    protected $fillable = ['language_id', 'name', 'status', 'serial_number', 'created_at', 'updated_at'];

    //Relationship
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
