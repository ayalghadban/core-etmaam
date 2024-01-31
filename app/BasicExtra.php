<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BasicExtra extends Model
{
    // table name
    protected $table = 'basic_settings_extra';

    protected $fillable = [
        'language_id', 'is_ticket', 'is_shop', 'is_user_panel',
        'base_currency_symbol', 'base_currency_symbol_position',
        'base_currency_text', 'base_currency_text_position', 'base_currency_rate', 'tax',
        'is_facebook_login', 'facebook_app_id',
        'facebook_app_secret', 'client_feedback_subtitle',
        'is_google_login', 'google_client_secret', 'google_client_id',
        'product_guest_checkout', 'product_rating_system', 'package_guest_checkout', 'timezone',
        'recurring_billing', 'expiration_reminder', 'preloader_status',
        'preloader', 'course_title', 'course_subtitle', 'course_details_title',
        'is_course', 'knowledgebase_title', 'knowledgebase_subtitle',
        'knowledgebase_details_title', 'donation_guest_checkout', 'is_donation',
        'is_event', 'event_guest_checkout', 'service_category', 'catalog_mode',
        'is_course_rating', 'push_notification_icon', 'contact_addresses',
        'contact_numbers', 'contact_mails', 'latitude', 'longitude', 'map_zoom',
        'home_page_pagebuilder', 'custom_page_pagebuilder',
        'is_whatsapp', 'whatsapp_number', 'whatsapp_popup_message',
        'whatsapp_header_title', 'whatsapp_popup', 'client_feedback_title',
        'faq_category_status', 'gallery_category_status', 'package_category_status',
    ];

    public $timestamps = false;

    // Relationships
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
