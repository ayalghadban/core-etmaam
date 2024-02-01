<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Request;

class ServiceRequest extends Model
{
    use HasFactory;

    public function request(){
        return $this->belongsTo(Request::class);
    }
}
