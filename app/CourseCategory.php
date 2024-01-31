<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseCategory extends Model
{

    protected $fillable = ['language_id', 'name', 'status', 'serial_number', 'created_at', 'updated_at'];

    //Relationship
    public function courses() :HasMany
    {
    return $this->hasMany(Course::class);
    }
}
