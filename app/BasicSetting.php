<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BasicSetting extends Model
{

    protected $fillable = [
        'language_id', 'favicon', 'logo', 'website_title', 'base_color', 'secondary_base_color',
        'support_email', 'support_phone', 'breadcrumb',
        'footer_logo', 'footer_text', 'newsletter_text', 'copyright_text',
        'hero_bg', 'hero_section_title', 'hero_section_bold_text', 'hero_section_text', 'hero_section_button_text',
        'hero_section_button_url', 'hero_section_video_link',
        'intro_bg', 'intro_section_title', 'intro_section_text',
        'our_vision', 'our_mission', 'aboutfeu',
        'intro_section_button_text', 'intro_section_button_url', 'intro_section_video_link',
        'cs_section_title', 'service_section_title', 'service_section_subtitle',
        'approach_title', 'approach_subtitle', 'approach_button_text','approach_button_url',
        'cta_bg', 'cta_section_text', 'cta_section_button_text', 'cta_section_button_url',
        'portfolio_section_title', 'portfolio_section_text',
        'team_bg', 'team_section_title', 'team_section_subtitle',
        'contact_form_title', 'contact_form_subtitle',
        'quote_title', 'quote_subtitle', 'tawk_to_script',
        'google_analytics_script', 'is_recaptcha', 'google_recaptcha_site_key',
        'google_recaptcha_secret_key', 'is_tawkto', 'is_disqus',
        'disqus_script', 'is_analytics', 'maintainance_mode',
        'maintainance_text', 'secret_path', 'is_appzi', 'appzi_script',
        'is_addthis', 'addthis_script', 'service_title',
        'service_subtitle', 'portfolio_title', 'portfolio_subtitle',
        'testimonial_title', 'testimonial_subtitle', 'blog_section_title',
        'blog_section_subtitle', 'faq_title', 'faq_subtitle',
        'blog_title', 'blog_subtitle', 'service_details_title',
        'portfolio_details_title', 'blog_details_title', 'gallery_title',
        'gallery_subtitle', 'team_title', 'team_subtitle', 'contact_title',
        'contact_subtitle', 'error_title', 'error_subtitle', 'is_quote',
        'home_version', 'event_title', 'event_subtitle', 'event_details_title',
        'cause_title', 'cause_subtitle', 'cause_details_title', 'feature_section',
        'intro_section', 'service_section', 'approach_section', 'statistics_section',
        'portfolio_section', 'testimonial_section', 'team_section', 'news_section',
        'call_to_action_section', 'partner_section', 'top_footer_section',
        'copyright_section', 'newsletter_section'
    ];

    public $timestamps = false;

    //Relationships
    public function language() :BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
