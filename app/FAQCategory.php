<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FAQCategory extends Model
{
  protected $table = 'faq_categories';

  protected $fillable = [
    'language_id',
    'name',
    'status',
    'serial_number'
  ];

  //Relationships
  public function faqCategoryLang() :BelongsTo
  {
    return $this->belongsTo(Language::class);
  }

  public function frequentlyAskedQuestion() : HasMany
  {
    return $this->hasMany(Faq::class, 'category_id', 'id');
  }
}
