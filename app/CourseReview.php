<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseReview extends Model
{
  protected $fillable = [
    'user_id',
    'course_id',
    'comment',
    'rating'
  ];

  //Relationship

  public function reviewedCourse() : BelongsTo
  {
    return $this->belongsTo(Course::class);
  }

  public function reviewByUser() : BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }
}
