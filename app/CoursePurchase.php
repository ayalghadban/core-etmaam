<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CoursePurchase extends Model
{
  protected $fillable = [
    'user_id',
    'order_number',
    'first_name',
    'last_name',
    'email',
    'course_id',
    'currency_code',
    'current_price',
    'previous_price',
    'payment_method',
    'payment_status',
    'invoice'
  ];

  //Relationships
  public function courseSellTo() :BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function course() : HasOne
  {
    return $this->hasOne(Course::class, 'id', 'course_id');
  }

  public function user() : BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
