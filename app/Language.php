<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Language extends Model
{
    protected $fillable = ['id', 'name', 'is_default', 'code', 'rtl'];

    //Relationships
    public function basic_setting(): HasOne
    {
        return $this->hasOne(BasicSetting::class);
    }

    public function basic_extended(): HasOne
    {
        return $this->hasOne(BasicExtended::class, 'language_id');
    }

    public function basic_extra(): HasOne
    {
        return $this->hasOne(BasicExtra::class, 'language_id');
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }

    public function sliders(): HasMany
    {
        return $this->hasMany(Slider::class);
    }

    public function features(): HasMany
    {
        return $this->hasMany(Feature::class);
    }

    public function points(): HasMany
    {
        return $this->hasMany(Point::class);
    }

    public function statistics(): HasMany
    {
        return $this->hasMany(Statistic::class);
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function partners(): HasMany
    {
        return $this->hasMany(Partner::class);
    }

    public function ulinks(): HasMany
    {
        return $this->hasMany(Ulink::class);
    }

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    public function scategories(): HasMany
    {
        return $this->hasMany(Scategory::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class);
    }

    public function bcategories(): HasMany
    {
        return $this->hasMany(Bcategory::class);
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    public function jcategories(): HasMany
    {
        return $this->hasMany(Jcategory::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function quote_inputs(): HasMany
    {
        return $this->hasMany(QuoteInput::class);
    }

    public function package_inputs(): HasMany
    {
        return $this->hasMany(PackageInput::class);
    }

    public function calendars(): HasMany
    {
        return $this->hasMany(CalendarEvent::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function feed(): HasMany
    {
        return $this->hasMany(RssFeed::class);
    }

    public function sitemaps(): HasMany
    {
        return $this->hasMany(Sitemap::class);
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    public function event_categories(): HasMany
    {
        return $this->hasMany(EventCategory::class, 'lang_id');
    }
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'lang_id');
    }
    public function causes(): HasMany
    {
        return $this->hasMany(Donation::class, 'lang_id');
    }
    public function course_categories(): HasMany
    {
        return $this->hasMany(CourseCategory::class);
    }
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
    public function shippings(): HasMany
    {
        return $this->hasMany(ShippingCharge::class);
    }
    public function pcategories(): HasMany
    {
        return $this->hasMany(Pcategory::class);
    }

    public function offline_gateways(): HasMany
    {
        return $this->hasMany(OfflineGateway::class);
    }

    public function homes(): HasMany
    {
        return $this->hasMany(Home::class);
    }

    public function articleCategories(): HasMany
    {
        return $this->hasMany(ArticleCategory::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function megamenus(): HasMany
    {
        return $this->hasMany(Megamenu::class);
    }

    public function faqCategory(): HasMany
    {
        return $this->hasMany(FAQCategory::class);
    }

    public function galleryCategory(): HasMany
    {
        return $this->hasMany(GalleryCategory::class);
    }

    public function packageCategory(): HasMany
    {
        return $this->hasMany(PackageCategory::class);
    }

    public function popups(): HasMany
    {
        return $this->hasMany(Popup::class);
    }
}
