<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{

    protected $fillable = [
        'language_id',
        'course_category_id',
        'title',
        'current_price',
        'previous_price',
        'summary',
        'course_image',
        'video_link',
        'overview',
        'instructor_image',
        'instructor_name',
        'instructor_occupation',
        'instructor_details',
        'instructor_facebook',
        'instructor_instagram',
        'instructor_twitter',
        'instructor_linkedin',
        'duration',
        'is_featured',
        'average_rating'
    ];

    //Relationships
    public function courseCategory(): BelongsTo
    {
        return $this->belongsTo(CourseCategory::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }

    public function coursePurchase(): HasMany
    {
        return $this->hasMany(CoursePurchase::class);
    }

    public function review(): HasMany
    {
        return $this->hasMany(CourseReview::class);
    }
}
