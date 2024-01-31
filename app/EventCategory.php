<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventCategory extends Model
{
    protected $table = 'event_categories';

    protected $fillable = [
        'name',
        'slug',
        'status',
        'lang_id',
    ];

    //Relationships
    public function events() : HasMany
    {
        return $this->hasMany(Event::class,'cat_id','id');
    }
}
