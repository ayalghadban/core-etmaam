<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model
{

    protected $fillable = ['language_id', 'name', 'title', 'subtitle', 'slug', 'status', 'serial_number', 'meta_keywords', 'meta_description', 'created_at', 'updated_at', 'components', 'styles', 'html', 'css', 'body'];

    //Relations
    public function language() : BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
