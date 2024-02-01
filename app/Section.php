<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public function packages(){
        return $this->hasMany(Package::class)->where('order_status',1);
    }
}
