<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    public $timestamps = false;

    protected $fillable = ['icon', 'url', 'serial_number'];
}
