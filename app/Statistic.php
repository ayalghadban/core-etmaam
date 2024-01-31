<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Statistic extends Model
{
    public $timestamps = false;

    protected $fillable = ['language_id', 'title', 'quantity', 'icon', 'image_link', 'serial_number', 'created_at', 'updated_at'];

    //Relation
    public function language() :BelongsTo{
        return $this->belongsTo(Language::class);
    }

}
