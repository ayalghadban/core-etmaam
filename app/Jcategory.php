<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jcategory extends Model
{
    protected $fillable = ['language_id', 'name', 'status', 'serial_number', 'created_at', 'updated_at'];

    //Relationship
    public function jobs() :HasMany
    {
        return $this->hasMany(Job::class);
    }
}
