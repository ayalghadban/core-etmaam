<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuoteInput extends Model
{
    protected $fillable = ['language_id', 'type', 'label', 'name', 'placeholder', 'required', 'active'];

    //Relations
    public function quote_input_options()
    {
        return $this->hasMany(QuoteInputOption::class);
    }

    public function language() {
      return $this->belongsTo(Language::class);
    }
}
