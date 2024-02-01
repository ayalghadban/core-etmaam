<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    public function language()
    {
        return $this->belongsTo('App\Language');
    }

    public function category()
    {
        return $this->belongsTo('App\RequestCategory','cat_id');
    }
}
