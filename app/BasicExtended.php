<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BasicExtended extends Model
{
    // table name
    protected $table = 'basic_settings_extended';

    protected $fillable = ['language_id','pricing_title',
   'pricing_subtitle','pricing_section','is_order_package',
   'is_packages','cookie_alert_status','cookie_alert_text',
   'cookie_alert_button_text','order_mail','is_career',
   'is_calendar','career_title','career_subtitle',
   'event_calendar_title','event_calendar_subtitle',
   'default_language_direction','home_meta_keywords',
   'home_meta_description','services_meta_keywords',
   'services_meta_description','packages_meta_keywords',
   'packages_meta_description','portfolios_meta_keywords',
   'portfolios_meta_description','team_meta_keywords',
   'team_meta_description','career_meta_keywords',
   'career_meta_description','calendar_meta_keywords',
   'calendar_meta_description','gallery_meta_keywords',
   'gallery_meta_description','faq_meta_keywords',
   'faq_meta_description','blogs_meta_keywords',
   'blogs_meta_description','contact_meta_keywords',
   'contact_meta_description','quote_meta_keywords',
   'quote_meta_description','is_facebook_pexel',
   'facebook_pexel_script'];

   
    public $timestamps = false;

    //Relationships
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
