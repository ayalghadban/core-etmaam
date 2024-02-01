<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestCategory extends Model
{
    use HasFactory;

    public function language()
    {
        return $this->belongsTo('App\Language');
    }

    public function category(){
        if ($this->cat_id == 0){
            return RequestCategory::where('cat_id',$this->id)->get();
        }else{
            return RequestCategory::where('id',$this->id)->first();
        }

    }

    public function services(){
            return $this->hasMany(Request::class,'cat_id')->where('active',1);
    }

    public function package_services(){
        return $this->hasMany(Request::class,'cat_id')->where('active',2);
    }
}
