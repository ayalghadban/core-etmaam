<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faq extends Model
{
    public $timestamps = false;

    protected $fillable = ['language_id', 'question', 'answer', 'serial_number', 'category_id', 'feature', 'display_all', 'deleted'];

    //Relationship
    public function faqCategory(): BelongsTo
    {
        return $this->belongsTo(FAQCategory::class, 'category_id', 'id');
    }
}
