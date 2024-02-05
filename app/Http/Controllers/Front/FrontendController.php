<?php

namespace App\Http\Controllers\Front;

use App\{
    Archive, Article, ArticleCategory, BasicExtended as BE, BasicExtra, BasicSetting as BS,
    Blog, Bcategory, CalendarEvent, ContactMail, Donation, DonationDetail,
    Event, EventCategory, Exception, Faq, FAQCategory, Feature, Gallery, GalleryCategory, Home,
    Http\Controllers\Controller, Jcategory, Job, Language, Member, OfflineGateway, Package,
    PackageCategory, PackageInput, PackageOrder, PackageRequest, Page, Partner, PaymentGateway,
    Pcategory, Point, Portfolio, Product, Quote, QuoteInput, Request, RequestCategory, RssFeed,
    RssPost, Scategory, Section, Service, ServiceRequest, Session, Statistic, Subscriber,
    Subscription, Testimonial, Slider
};

use Carbon\Carbon;
use Illuminate\Support\Facades\{
    App, DB, Validator as FacadesValidator
};
use Mail;
use PDF;
use Auth;
use Config;

class FrontendController extends Controller
{
    public function __construct()
    {
        $bs = BS::first();
        $be = BE::first();

        Config::set('captcha.sitekey', $bs->google_recaptcha_site_key);
        Config::set('captcha.secret', $bs->google_recaptcha_secret_key);
    }


    public function index()
    {
        $currentLang = Language::firstWhere('code', session('lang')) ?? Language::where('is_default', 1)->first();
        $data['currentLang'] = $currentLang;
        $lang_id = $currentLang->id;

        $data['categories'] = PackageCategory::where('language_id', $lang_id)
            ->where('status', 1)
            ->orderBy('serial_number', 'ASC')
            ->get();

        $data['sections'] = Section::with('packages')
            ->where('active', 1)
            ->where('language_id', $lang_id)
            ->get();

        $data['cats'] = RequestCategory::with('services')
            ->where('language_id', $lang_id)
            ->orderBy('order_cat_pack', 'ASC')
            ->get();

        $data['sliders'] = Slider::where('language_id', $lang_id)
            ->orderBy('serial_number', 'ASC')
            ->get();

        $data['features'] = Feature::where('language_id', $lang_id)
            ->orderBy('serial_number', 'ASC')
            ->get();

        $version = $currentLang->basic_extended->theme_version;
        $pageBuilderEnabled = $currentLang->basic_extra->home_page_pagebuilder;

        $data = $this->loadData($data, $version, $lang_id, $pageBuilderEnabled);

        $view = $this->getViewForTheme($version, $pageBuilderEnabled);
        return view($view, $data);
    }

    private function loadData($data, $version, $lang_id, $pageBuilderEnabled)
    {
        if ($pageBuilderEnabled == 0) {
            $data['portfolios'] = Portfolio::where('language_id', $lang_id)
                ->where('feature', 1)
                ->orderBy('serial_number', 'ASC')
                ->limit(10)
                ->get();

            $data['points'] = Point::where('language_id', $lang_id)
                ->orderBy('serial_number', 'ASC')
                ->get();

            $data['statistics'] = Statistic::where('language_id', $lang_id)
                ->orderBy('serial_number', 'ASC')
                ->get();

            $data['testimonials'] = Testimonial::where('language_id', $lang_id)
                ->orderBy('serial_number', 'ASC')
                ->get();

            $data['faqs'] = Faq::where('language_id', $lang_id)
                ->orderBy('serial_number', 'ASC')
                ->where('feature', 1)
                ->where('deleted', 0)
                ->get();

            $data['members'] = Member::where('language_id', $lang_id)
                ->where('feature', 1)
                ->get();

            $data['blogs'] = Blog::where('language_id', $lang_id)
                ->orderBy('created_at', 'DESC')
                ->limit(3)
                ->get();

            $data['partners'] = Partner::where('language_id', $lang_id)
                ->orderBy('serial_number', 'ASC')
                ->get();

            $data['packages'] = Package::where('language_id', $lang_id)
                ->where('feature', 1)
                ->orderBy('serial_number', 'ASC')
                ->get();

            $data['scategories'] = Scategory::where('language_id', $lang_id)
                ->where('feature', 1)
                ->where('status', 1)
                ->where('type', null)
                ->orderBy('serial_number', 'ASC')
                ->get();

            $data['scategorieshigh'] = Scategory::where('language_id', $lang_id)
                ->where('feature', 1)
                ->where('status', 1)
                ->where('type', 1)
                ->orderBy('serial_number', 'ASC')
                ->get();

            if (!serviceCategory()) {
                $data['services'] = Service::where('language_id', $lang_id)
                    ->where('feature', 1)
                    ->orderBy('serial_number', 'ASC')
                    ->get();
            }
        } else {
            $data['home'] = Home::where('theme', $version)
                ->where('language_id', $lang_id)
                ->first();
        }

        return $data;
    }

    private function getViewForTheme($themeVersion, $pageBuilderEnabled)
    {
        $viewPrefix = 'front.';
        $viewSuffix = ($pageBuilderEnabled == 1) ? '' : '1';

        $themeViews = [
            'gym' => 'gym.index',
            'car' => 'car.index',
            'cleaning' => 'cleaning.index',
            'construction' => 'construction.index',
            'logistic' => 'logistic.index',
            'lawyer' => 'lawyer.index',
            'default' => 'default.index',
            'dark' => 'default.index',
        ];

        return $viewPrefix . ($themeViews[$themeVersion] ?? 'default.index') . $viewSuffix;
    }

    // cataloge
    public function cataloge()
{
    $currentLang = Language::firstWhere('code', session('lang')) ?? Language::where('is_default', 1)->first();
    App::setLocale($currentLang->code);
    $be = $currentLang->basic_extended;
    $version = $be->theme_version;
    $data = [
        'currentLang' => $currentLang,
        'version' => $currentLang->basic_extended->theme_version,
    ];

    switch ($data['version']) {
        case 'gym':
        case 'car':
        case 'cleaning':
        case 'construction':
        case 'logistic':
        case 'lawyer':
            return view("front.{$data['version']}.cataloge", $data);
        case 'default':
        case 'dark':
        case 'ecommerce':
            $data['fproducts'] = Product::where('status', 1)->where('is_feature', 1)->where('language_id', $currentLang->id)->orderBy('id', 'DESC')->limit(10)->get();
            $data['version'] = $version == 'dark' ? 'default' : $version;
            $data['categories'] = Pcategory::with('products')->where('status', 1)->where('language_id', $currentLang->id)->where('is_feature', 1)->get();
            return view("front.default.cataloge", $data);
    }
}
    //about function
    public function about()
{
    // Determine the current language
    $currentLang = Language::firstWhere('code', session('lang')) ?? Language::where('is_default', 1)->first();

    // Set the current language locale
    App::setLocale($currentLang->code);

    // Initialize data array with current language
    $data = [
        'currentLang' => $currentLang,
        'version' => $currentLang->basic_extended->theme_version,
    ];
    // Check the theme version and load the appropriate view
    switch ($data['version']) {
        case 'gym':
        case 'car':
        case 'cleaning':
        case 'construction':
        case 'logistic':
        case 'lawyer':
            // Load theme-specific view for about page
            return view("front.{$data['version']}.about", $data);
        case 'default':
        case 'dark':
        case 'ecommerce':
            // Load default view for about page
            $lang_id = $currentLang->id;
            // Fetch data required for the default theme
            $data['scategories'] = Scategory::where('language_id', $lang_id)->where('feature', 1)->where('status', 1)->where('type', null)->orderBy('serial_number', 'ASC')->get();
            $data['statistics'] = Statistic::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
            $data['partners'] = Partner::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
            $data['categories'] = FAQCategory::where('language_id', $lang_id)->where('status', 1)
                ->orderBy('serial_number', 'ASC')->get();
            $data['testimonials'] = Testimonial::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
            // Load the default about view
            return view('front.default.about', $data);
    }
}


    //banks

    public function banks()
{
    // Determine the current language
    $currentLang = Language::firstWhere('code', session('lang')) ?? Language::where('is_default', 1)->first();

    // Set the current language locale
    App::setLocale($currentLang->code);

    // Initialize data array with current language
    $data = [
        'currentLang' => $currentLang,
        'version' => $currentLang->basic_extended->theme_version,
    ];

    // Check the theme version and load the appropriate view
    switch ($data['version']) {
        case 'gym':
        case 'car':
        case 'cleaning':
        case 'construction':
        case 'logistic':
        case 'lawyer':
            // Load theme-specific view for banks page
            return view("front.{$data['version']}.banks", $data);
        case 'default':
        case 'dark':
        case 'ecommerce':
            // Load the default view for banks page
            $data['version'] = $data['version'] == 'dark' ? 'default' : $data['version'];
            return view('front.banks', $data);
    }
}

    //links
    public function links()
{
    // Determine the current language
    $currentLang = Language::firstWhere('code', session('lang')) ?? Language::where('is_default', 1)->first();

    // Set the current language locale
    App::setLocale($currentLang->code);

    // Initialize data array with the current language
    $data = [
        'currentLang' => $currentLang,
        'version' => $currentLang->basic_extended->theme_version,
    ];

    // Check the theme version and load the appropriate view
    switch ($data['version']) {
        case 'gym':
        case 'car':
        case 'cleaning':
        case 'construction':
        case 'logistic':
        case 'lawyer':
            // Load theme-specific view for links page
            return view("front.{$data['version']}.links", $data);
        case 'default':
        case 'dark':
        case 'ecommerce':
            // Load the default view for links page
            $data['version'] = $data['version'] == 'dark' ? 'default' : $data['version'];
            return view('front.links', $data);
    }
}
public function lp()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;
        $lang_id = $currentLang->id;
        $data['features'] = Feature::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $data['statistics'] = Statistic::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $data['partners'] = Partner::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $data['testimonials'] = Testimonial::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();

        $data['scategories'] = Scategory::where('language_id', $lang_id)->where('feature', 1)->where('status', 1)->where('type', null)->orderBy('serial_number', 'ASC')->get();
        $data['scategorieshigh'] = Scategory::where('language_id', $lang_id)->where('feature', 1)->where('status', 1)->where('type', 1)->orderBy('serial_number', 'ASC')->get();
        if (!serviceCategory()) {
            $data['services'] = Service::where('language_id', $lang_id)->where('feature', 1)->orderBy('serial_number', 'ASC')->get();
        }
        App::setLocale($currentLang->code);
        $data['categories'] = \App\RequestCategory::where('language_id', $currentLang->id)->where('active', 1)->where('cat_id', 0)->orderBy('order_cat', 'ASC')->get();
        // dd($data);
        App::setLocale($currentLang->code);
        //  $service = \App\Request::find(156);
        $service = \App\Request::find(old('service_id'));
        $data['service'] = $service;
        if ($service) {
            $data['subcats'] = \App\RequestCategory::find(\App\Request::find($service->id)->category->cat_id)->category();
        }

        if ($currentLang->code == 'ar') {
            $data['cities'] = array("الرياض", "جدة", "مكة المكرمة", "المدينة المنورة", "الطائف", "الدمام", "الخبر", "تبوك", "الخرج", "بريدة", "خميس مشيط", "الهفوف", "المبرز", "حفر الباطن", "حائل", "نجران", "الجبيل", "أبها", "ينبع", "عنيزة", "عرعر", "سكاكا", "جازان", "القريات", "الظهران", "القطيف", "الباحة", "بيشة", "اخرى", "الدلم", "الدلم", "الدلم", "حوطه بني تميم", "الحريق", "الافلاج", "الخماسين", "السليل", "حريملاء", "ثادق", "رغبة", "ضرما", "المزاحمية", "مرات", "شقراء", "القصب", "ساجر", "الدوادمي", "القويعية", "عفيف", "الخاصرة", "رماح", "شوية", "المجمعة", "الزلفي", "الغاط", "الارطاويه", "سدير", "البدائع", "المذنب", "الرس", "البكيريه", "رياض الخبرا", "الأسياح", "شري", "الفوارة", "عقلة الصقور", "البطــين", "مــدرج", "الدليميــه", "البتــراء", "القـريـن", "الذيبية", "النبهانيه", "دخنة", "ام حــزم", "ضليع رشيد", "ضريه", "قبــه", "الخبرا", "السر", "ثرمداء", "حلبان", "ملهم", "القوارة", "وادي الدواسر", "الجمش", "البجادية", "الاحساء", "رحيمة", "النعيرية", "الخفجي", "السفانية", "بقيق", "الثقبة", "سيهات", "صفوى", "قريه", "رأس تنورة", "قرى الإحساء", "العقير", "سلوى", "الحنى", "حرض", "العيون", "عين دار", "القيصومة", "الرقعي", "الذيبية", "مدينة الملك خالد العسكرية", "سامودا", "ام قليب", "ابن طواله", "الصداوي", "السعيرة", "الحليقه", "بقعاء", "موقق", "ضرغط", "طابه", "الحايط", "قرى حائل", "جبه", "تربة-حائل", "الشملي", "الروضة", "الكهفة", "السليمي", "الخطة", "الشنان", "مدينة الأمير عدبالعزيز بن مساعد الاقتصادية (حائل)", "دومة الجندل", "طبرجل", "قارا", "صـــوير", "هــديـب", "الاضارع", "اللقـائـــط", "زلــــوم", "طريف", "رفحا", "حالة عمار", "الوجه", "حقل", "تيماء", "ضباء", "البدع", "شرما", "المويلح", "القحزه", "قيال", "الشرف", "مقنا", "الخريبة", "البئر", "الجهراء", "شواق", "القليبه", "البديعه", "الديسه", "المعظم", "فجر", "الروضة", "الخرمة", "تربة-الطائف", "بنى مالك", "رنيه", "المويه", "ظـــــــلم", "بحرة", "مستورة", "ذهبان", "عسفان", "ابو راكه", "بالحارث", "قياء", "ترعة ثقيف", "غزايل", "الليث", "رابغ", "القنفذة", "خليص", "الكامل", "مدركه", "الجمـوم", "الشـرائع", "مدينة الملك عبدالله الاقتصادية برابغ", "مدينة المعرفة الاقتصادية", "العلا", "المهد", "الحناكية", "الحسو", "الثمد", "العمق", "الشقران", "المليليح", "السويرقيه", "الفريش", "وادي الفرع", "خيبر", "الصلصلة", "الصويدرة", "الشقره", "ثرب", "لفه", "املج", "بدر", "الواسطة", "المسيجيد", "بلجرشي", "المندق", "بني حسن", "دوس", "القري", "المخواه", "غامد الزناد", "قلوي", "الشعـــــراء", "العقيق", "قرى الحجاز", "تثليث", "سراة عبيدة", "احد رفيدة", "ظهران الجنوب", "النماص", "محائل", "رجال ألمع", "تنومة", "بني عمرو", "المجاردة", "قناءوالبحر", "الربوعة", "القحمة", "جيزان", "ابو عريش", "الشقيري", "الريث الشقيق", "ضمد", "فيفا", "صبيا", "صامطة - الطوال", "فرسان", "الداير بني مالك", "هروب", "احد المسارحة - الخوبة", "شروره", "العبيله", "بدر الجنوب", "الوديعة", "حبونا", "يدمه", "مدينة جازان للصناعات الأساسية والتحويلية");
        } else {
            $data['cities'] = array("Riyadh", "Jeddah", "Mecca", "Medina", "Ta'if", "Dammam", "Khobar", "Tabuk", "Al-Kharj", "Buraydah", "Khamis Mushait", "Al-Hufuf", "Al-Mubarraz", "Hafar Al-Batin", "Ha'il", "Najran", "Jubail", "Abha", "Yanbu", "Unaizah", "Arar", "Sakakah", "Jazan", "Qurayyat", "Dhahran", "Al-Qatif", "Al-Baha", "Bishah", "Accra", "Ad-Dilam", "Hautat Bani Tamim", "Al-Hareeq", "Aflaj", "Al-khamasin", "Saleel", "Harimlaa", "Thadiq", "Ragbah", "Dharmaa", "Muzahmiyyah", "Marat", "Shaqraa", "Al-Qasab", "Sajir", "Dawadmi", "Quwaiyah", "Afeef", "Khasirah", "Remaah", "Shuwiyah", "Majma'ah", "Zulfi", "Al-Ghat", "Al-Artaweeiyah", "Sudair", "Al-Bada'a", "Al-Mithnab", "Al-Rass", "Al-Bukayriyah", "Riyadh Al-Khabra", "Al-Asyah", "Shiri", "Fawarah", "Aqlit Al-Sukour", "Al-Bateen", "Mudraj", "Dulaimiyah", "Al-Batraa", "Al-Qareen", "Thaibiyah", "Nabhaniyah", "Daknah", "Um Hazm", "Dali' Rasheed", "Diryah", "Qubbah", "Al-Khabra", "Al-Ssir", "Tharmadaa", "Halban", "Mulham", "Quwarah", "Wadi Al-Dawasir", "Al-Jamsh", "Bajadiyah", "Al-Hasa", "Rahima", "Nua'iriyah", "Al-Kafji", "Safaniyah", "Beqaiq", "Thuqbah", "Saihat", "Safwa", "Qaryah", "Ras Tanurah", "Al-Hasa Villages", "Uqair", "Salwa", "Al-Hana", "Harid", "Al-Oyoun", "Ain Dar", "Qaisumah", "Al-Raq'i", "Military city of king Khalid", "Samuda", "Um Qulaib", "Ibn Tawalah", "Sadawi", "Al-Sa'erah", "Al-Haliqah", "Buqa'a", "Moqiq", "Durghut", "Tabah", "Al-Ha'it", "Ha'il Villages", "Jibah", "Turbit Ha'il", "Al-Shamli", "Rawdah", "Al-Kahfa", "Sulaymi", "Al-Khotta", "Shinan", "Economic city of prince Abd Al-Aziz Bin musa'id (Ha'il)", "Dumat Al-Jandal", "Tabarjal", "Qarah", "Suwair", "Hudaid", "Al-Adar'i", "Al-Laqai't", "Zalloum", "Tareef", "Rafha", "Halit Ammar", "Al-Wajh", "Haqil", "Taima'a", "Diba'a", "Al-Bid'a", "Sharma", "Muwilih", "Kahza", "Qiyal", "Al-Shuruf", "Miqna", "Kuraybah", "Al-Bi'er", "Jahraa", "Shiwaq", "Qulaybah", "Badi'a", "Al-Disah", "Mu'atham", "Fajir", "Al-Khirmah", "Turbit Al-Ta'if", "Bani Malik", "Rinaih", "Al-Moyah", "Thulam", "Bahrah", "Mastourah", "Thahban", "Asfan", "Abu Rakah", "Bilharith", "Qiya'a", "Tir'it Thaqif", "Ghazail", "Al-Laith", "Rabigh", "Qunfuthah", "Khulais", "Al-Kamil", "Mudrakah", "Al-Jumum", "Al-Sharai'", "Economic city of king Abdullah (Rabigh)", "Economic city of knowledge", "Al-Ula", "Al-Mahd", "Al-Hanakiya", "Al-Hasew", "Al-Thamid", "Al-Omiq", "Shaqran", "Mulailih", "Swairqiyah", "Al-Farish", "Wadi Al-Firi'", "Khaybar", "Salsa", "Suwiydrah", "Thirib", "Laffih", "Amlaj", "Badr", "Al-Wasitah", "Musayjid", "Biljarshi", "Al-Minduq", "Bani Hassan", "Doos", "Al-Qirri", "Mikwah", "Ghamid Al-Zinad", "Qalawi", "Sha'raa", "Al-Aqeeq", "Al-Hijaz Villages", "Tathlith", "Surat Obaydah", "Ohud Rafidah", "Dhahran Al-Janoub", "Al-Nammas", "Muhai'l", "Rijal Alm'a", "Tannumah", "Bani Amro", "Al-Majardah", "Qina' Wilbahir", "Rabboa'a", "Al-Qahmah", "Jizan", "Abu Areesh", "Al-Shuqayri", "Al-Raith AL-Shaqiq", "Dumd", "Fifa", "Sibya", "Samtit Al-Tiwal", "Farasan", "Dayer Bani Malik", "Huroub", "Ohud Al-Masariha - Al-Khoba", "Shrurah", "Al-Obaylah", "Badr Al-Janoub", "Al-Wadi'a", "Hubunah", "Yedma", "Jazan city of basic and transformed industries");
        }
        $version = $be->theme_version;

        if ($version == 'gym') {
            return view('front.gym.lp', $data);
        } elseif ($version == 'car') {
            return view('front.car.lp', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.lp', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.lp', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.lp', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.lp', $data);
        } elseif ($version == 'default' || $version == 'dark' || $version == 'ecommerce') {
            $data['version'] = $version == 'dark' ? 'default' : $version;

            return view('front.lp', $data);
        }
    }

    public function tools()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;
        App::setLocale($currentLang->code);
        $version = $be->theme_version;
        if ($version == 'gym') {
            return view('front.gym.tools', $data);
        } elseif ($version == 'car') {
            return view('front.car.tools', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.tools', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.tools', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.tools', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.tools', $data);
        } elseif ($version == 'default' || $version == 'dark' || $version == 'ecommerce') {
            $data['version'] = $version == 'dark' ? 'default' : $version;
            $lang_id = $currentLang->id;
            $data['downloads'] = DB::table('downloads')->where('language_id', $lang_id)->where('deleted', 0)->where('cat_id', request('id'))->orderBy('id', 'ASC')->get();
            return view('front.tools', $data);
        }
    }




    // dawnload
    // page for download catagory
    public function downloads()
{
    $currentLang = Language::where('code', session('lang'))->firstOr(fn() => Language::where('is_default', 1)->first());

    $data = [
        'currentLang' => $currentLang,
    ];

    $be = $currentLang->basic_extended;
    App::setLocale($currentLang->code);

    $version = $be->theme_version;

    $viewName = $this->getViewName($version);

    if ($version == 'default' || $version == 'dark' || $version == 'ecommerce') {
        $data['version'] = $version == 'dark' ? 'default' : $version;
        $data['downloads'] = $this->getDownloads($currentLang->id);

        return view('front.downloads', $data);
    }

    return view($viewName, $data);
}

private function getViewName($version)
{
    $themeMap = [
        'gym' => 'front.gym.downloads',
        'car' => 'front.car.downloads',
        'cleaning' => 'front.cleaning.downloads',
        'construction' => 'front.construction.downloads',
        'logistic' => 'front.logistic.downloads',
        'lawyer' => 'front.lawyer.downloads',
    ];

    return $themeMap[$version] ?? 'front.downloads';
}

private function getDownloads($langId)
{
    return DB::table('downloads')
        ->where('language_id', $langId)
        ->where('cat_id', 0)
        ->where('deleted', 0)
        ->orderBy('id', 'ASC')
        ->get();
}


    // download file

    // page for files catagory

    public function downloads_files()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;
        App::setLocale($currentLang->code);
        $version = $be->theme_version;
        if ($version == 'gym') {
            return view('front.gym.downloads_files', $data);
        } elseif ($version == 'car') {
            return view('front.car.downloads_files', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.downloads_files', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.downloads_files', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.downloads_files', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.downloads_files', $data);
        } elseif ($version == 'default' || $version == 'dark' || $version == 'ecommerce') {
            $data['version'] = $version == 'dark' ? 'default' : $version;
            $lang_id = $currentLang->id;
            $data['downloads'] = DB::table('downloads')->where('language_id', $lang_id)->where('deleted', 0)->where('cat_id', request('id'))->orderBy('id', 'ASC')->get();
            return view('front.downloads_files', $data);
        }
    }

    // thanks
    public function thankyou()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;
        App::setLocale($currentLang->code);
        $version = $be->theme_version;
        $id = 1;
        $data['id'] = $id;
        if ($version == 'gym') {
            return view('front.gym.banks', $data);
        } elseif ($version == 'car') {
            return view('front.car.banks', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.banks', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.banks', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.banks', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.banks', $data);
        } elseif ($version == 'default' || $version == 'dark' || $version == 'ecommerce') {
            $data['version'] = $version == 'dark' ? 'default' : $version;
            return view('front.thankyou', $data);
        }
    }

    // serv req
    public function serv_req()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;

        // ياكابتن محمد حاولت ارتبه من الاكبر للاصغر لكن لم يضبط بشار مر من هنا
        $data['categories'] = RequestCategory::where('language_id', $currentLang->id)->where('active', 1)->where('cat_id', 0)->orderBy('order_cat', 'ASC')->get();
        // dd($data);
        App::setLocale($currentLang->code);
        $service = Request::find(old('service_id'));
        $data['service'] = $service;
        if ($service) {
            $data['subcats'] = RequestCategory::find(\App\Request::find($service->id)->category->cat_id)->category();
        }
        if ($currentLang->code == 'ar') {
            $data['cities'] = array("الرياض", "جدة", "مكة المكرمة", "المدينة المنورة", "الطائف", "الدمام", "الخبر", "تبوك", "الخرج", "بريدة", "خميس مشيط", "الهفوف", "المبرز", "حفر الباطن", "حائل", "نجران", "الجبيل", "أبها", "ينبع", "عنيزة", "عرعر", "سكاكا", "جازان", "القريات", "الظهران", "القطيف", "الباحة", "بيشة", "اخرى", "الدلم", "الدلم", "الدلم", "حوطه بني تميم", "الحريق", "الافلاج", "الخماسين", "السليل", "حريملاء", "ثادق", "رغبة", "ضرما", "المزاحمية", "مرات", "شقراء", "القصب", "ساجر", "الدوادمي", "القويعية", "عفيف", "الخاصرة", "رماح", "شوية", "المجمعة", "الزلفي", "الغاط", "الارطاويه", "سدير", "البدائع", "المذنب", "الرس", "البكيريه", "رياض الخبرا", "الأسياح", "شري", "الفوارة", "عقلة الصقور", "البطــين", "مــدرج", "الدليميــه", "البتــراء", "القـريـن", "الذيبية", "النبهانيه", "دخنة", "ام حــزم", "ضليع رشيد", "ضريه", "قبــه", "الخبرا", "السر", "ثرمداء", "حلبان", "ملهم", "القوارة", "وادي الدواسر", "الجمش", "البجادية", "الاحساء", "رحيمة", "النعيرية", "الخفجي", "السفانية", "بقيق", "الثقبة", "سيهات", "صفوى", "قريه", "رأس تنورة", "قرى الإحساء", "العقير", "سلوى", "الحنى", "حرض", "العيون", "عين دار", "القيصومة", "الرقعي", "الذيبية", "مدينة الملك خالد العسكرية", "سامودا", "ام قليب", "ابن طواله", "الصداوي", "السعيرة", "الحليقه", "بقعاء", "موقق", "ضرغط", "طابه", "الحايط", "قرى حائل", "جبه", "تربة-حائل", "الشملي", "الروضة", "الكهفة", "السليمي", "الخطة", "الشنان", "مدينة الأمير عدبالعزيز بن مساعد الاقتصادية (حائل)", "دومة الجندل", "طبرجل", "قارا", "صـــوير", "هــديـب", "الاضارع", "اللقـائـــط", "زلــــوم", "طريف", "رفحا", "حالة عمار", "الوجه", "حقل", "تيماء", "ضباء", "البدع", "شرما", "المويلح", "القحزه", "قيال", "الشرف", "مقنا", "الخريبة", "البئر", "الجهراء", "شواق", "القليبه", "البديعه", "الديسه", "المعظم", "فجر", "الروضة", "الخرمة", "تربة-الطائف", "بنى مالك", "رنيه", "المويه", "ظـــــــلم", "بحرة", "مستورة", "ذهبان", "عسفان", "ابو راكه", "بالحارث", "قياء", "ترعة ثقيف", "غزايل", "الليث", "رابغ", "القنفذة", "خليص", "الكامل", "مدركه", "الجمـوم", "الشـرائع", "مدينة الملك عبدالله الاقتصادية برابغ", "مدينة المعرفة الاقتصادية", "العلا", "المهد", "الحناكية", "الحسو", "الثمد", "العمق", "الشقران", "المليليح", "السويرقيه", "الفريش", "وادي الفرع", "خيبر", "الصلصلة", "الصويدرة", "الشقره", "ثرب", "لفه", "املج", "بدر", "الواسطة", "المسيجيد", "بلجرشي", "المندق", "بني حسن", "دوس", "القري", "المخواه", "غامد الزناد", "قلوي", "الشعـــــراء", "العقيق", "قرى الحجاز", "تثليث", "سراة عبيدة", "احد رفيدة", "ظهران الجنوب", "النماص", "محائل", "رجال ألمع", "تنومة", "بني عمرو", "المجاردة", "قناءوالبحر", "الربوعة", "القحمة", "جيزان", "ابو عريش", "الشقيري", "الريث الشقيق", "ضمد", "فيفا", "صبيا", "صامطة - الطوال", "فرسان", "الداير بني مالك", "هروب", "احد المسارحة - الخوبة", "شروره", "العبيله", "بدر الجنوب", "الوديعة", "حبونا", "يدمه", "مدينة جازان للصناعات الأساسية والتحويلية");
        } else {
            $data['cities'] = array("Riyadh", "Jeddah", "Mecca", "Medina", "Ta'if", "Dammam", "Khobar", "Tabuk", "Al-Kharj", "Buraydah", "Khamis Mushait", "Al-Hufuf", "Al-Mubarraz", "Hafar Al-Batin", "Ha'il", "Najran", "Jubail", "Abha", "Yanbu", "Unaizah", "Arar", "Sakakah", "Jazan", "Qurayyat", "Dhahran", "Al-Qatif", "Al-Baha", "Bishah", "Accra", "Ad-Dilam", "Hautat Bani Tamim", "Al-Hareeq", "Aflaj", "Al-khamasin", "Saleel", "Harimlaa", "Thadiq", "Ragbah", "Dharmaa", "Muzahmiyyah", "Marat", "Shaqraa", "Al-Qasab", "Sajir", "Dawadmi", "Quwaiyah", "Afeef", "Khasirah", "Remaah", "Shuwiyah", "Majma'ah", "Zulfi", "Al-Ghat", "Al-Artaweeiyah", "Sudair", "Al-Bada'a", "Al-Mithnab", "Al-Rass", "Al-Bukayriyah", "Riyadh Al-Khabra", "Al-Asyah", "Shiri", "Fawarah", "Aqlit Al-Sukour", "Al-Bateen", "Mudraj", "Dulaimiyah", "Al-Batraa", "Al-Qareen", "Thaibiyah", "Nabhaniyah", "Daknah", "Um Hazm", "Dali' Rasheed", "Diryah", "Qubbah", "Al-Khabra", "Al-Ssir", "Tharmadaa", "Halban", "Mulham", "Quwarah", "Wadi Al-Dawasir", "Al-Jamsh", "Bajadiyah", "Al-Hasa", "Rahima", "Nua'iriyah", "Al-Kafji", "Safaniyah", "Beqaiq", "Thuqbah", "Saihat", "Safwa", "Qaryah", "Ras Tanurah", "Al-Hasa Villages", "Uqair", "Salwa", "Al-Hana", "Harid", "Al-Oyoun", "Ain Dar", "Qaisumah", "Al-Raq'i", "Military city of king Khalid", "Samuda", "Um Qulaib", "Ibn Tawalah", "Sadawi", "Al-Sa'erah", "Al-Haliqah", "Buqa'a", "Moqiq", "Durghut", "Tabah", "Al-Ha'it", "Ha'il Villages", "Jibah", "Turbit Ha'il", "Al-Shamli", "Rawdah", "Al-Kahfa", "Sulaymi", "Al-Khotta", "Shinan", "Economic city of prince Abd Al-Aziz Bin musa'id (Ha'il)", "Dumat Al-Jandal", "Tabarjal", "Qarah", "Suwair", "Hudaid", "Al-Adar'i", "Al-Laqai't", "Zalloum", "Tareef", "Rafha", "Halit Ammar", "Al-Wajh", "Haqil", "Taima'a", "Diba'a", "Al-Bid'a", "Sharma", "Muwilih", "Kahza", "Qiyal", "Al-Shuruf", "Miqna", "Kuraybah", "Al-Bi'er", "Jahraa", "Shiwaq", "Qulaybah", "Badi'a", "Al-Disah", "Mu'atham", "Fajir", "Al-Khirmah", "Turbit Al-Ta'if", "Bani Malik", "Rinaih", "Al-Moyah", "Thulam", "Bahrah", "Mastourah", "Thahban", "Asfan", "Abu Rakah", "Bilharith", "Qiya'a", "Tir'it Thaqif", "Ghazail", "Al-Laith", "Rabigh", "Qunfuthah", "Khulais", "Al-Kamil", "Mudrakah", "Al-Jumum", "Al-Sharai'", "Economic city of king Abdullah (Rabigh)", "Economic city of knowledge", "Al-Ula", "Al-Mahd", "Al-Hanakiya", "Al-Hasew", "Al-Thamid", "Al-Omiq", "Shaqran", "Mulailih", "Swairqiyah", "Al-Farish", "Wadi Al-Firi'", "Khaybar", "Salsa", "Suwiydrah", "Thirib", "Laffih", "Amlaj", "Badr", "Al-Wasitah", "Musayjid", "Biljarshi", "Al-Minduq", "Bani Hassan", "Doos", "Al-Qirri", "Mikwah", "Ghamid Al-Zinad", "Qalawi", "Sha'raa", "Al-Aqeeq", "Al-Hijaz Villages", "Tathlith", "Surat Obaydah", "Ohud Rafidah", "Dhahran Al-Janoub", "Al-Nammas", "Muhai'l", "Rijal Alm'a", "Tannumah", "Bani Amro", "Al-Majardah", "Qina' Wilbahir", "Rabboa'a", "Al-Qahmah", "Jizan", "Abu Areesh", "Al-Shuqayri", "Al-Raith AL-Shaqiq", "Dumd", "Fifa", "Sibya", "Samtit Al-Tiwal", "Farasan", "Dayer Bani Malik", "Huroub", "Ohud Al-Masariha - Al-Khoba", "Shrurah", "Al-Obaylah", "Badr Al-Janoub", "Al-Wadi'a", "Hubunah", "Yedma", "Jazan city of basic and transformed industries");
        }
        $version = $be->theme_version;
        if ($version == 'gym') {
            return view('front.gym.about', $data);
        } elseif ($version == 'car') {
            return view('front.car.about', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.about', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.about', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.about', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.about', $data);
        } elseif ($version == 'default' || $version == 'dark' || $version == 'ecommerce') {
            $data['version'] = $version == 'dark' ? 'default' : $version;
            return view('front.serv_req', $data);
        }
    }


    public function package_quote()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;

        $data['categories'] = Section::where('language_id', $currentLang->id)->where('active', 1)->get();

        App::setLocale($currentLang->code);
        if ($currentLang->code == 'ar') {
            $data['cities'] = array("الرياض", "جدة", "مكة المكرمة", "المدينة المنورة", "الطائف", "الدمام", "الخبر", "تبوك", "الخرج", "بريدة", "خميس مشيط", "الهفوف", "المبرز", "حفر الباطن", "حائل", "نجران", "الجبيل", "أبها", "ينبع", "عنيزة", "عرعر", "سكاكا", "جازان", "القريات", "الظهران", "القطيف", "الباحة", "بيشة", "اخرى", "الدلم", "الدلم", "الدلم", "حوطه بني تميم", "الحريق", "الافلاج", "الخماسين", "السليل", "حريملاء", "ثادق", "رغبة", "ضرما", "المزاحمية", "مرات", "شقراء", "القصب", "ساجر", "الدوادمي", "القويعية", "عفيف", "الخاصرة", "رماح", "شوية", "المجمعة", "الزلفي", "الغاط", "الارطاويه", "سدير", "البدائع", "المذنب", "الرس", "البكيريه", "رياض الخبرا", "الأسياح", "شري", "الفوارة", "عقلة الصقور", "البطــين", "مــدرج", "الدليميــه", "البتــراء", "القـريـن", "الذيبية", "النبهانيه", "دخنة", "ام حــزم", "ضليع رشيد", "ضريه", "قبــه", "الخبرا", "السر", "ثرمداء", "حلبان", "ملهم", "القوارة", "وادي الدواسر", "الجمش", "البجادية", "الاحساء", "رحيمة", "النعيرية", "الخفجي", "السفانية", "بقيق", "الثقبة", "سيهات", "صفوى", "قريه", "رأس تنورة", "قرى الإحساء", "العقير", "سلوى", "الحنى", "حرض", "العيون", "عين دار", "القيصومة", "الرقعي", "الذيبية", "مدينة الملك خالد العسكرية", "سامودا", "ام قليب", "ابن طواله", "الصداوي", "السعيرة", "الحليقه", "بقعاء", "موقق", "ضرغط", "طابه", "الحايط", "قرى حائل", "جبه", "تربة-حائل", "الشملي", "الروضة", "الكهفة", "السليمي", "الخطة", "الشنان", "مدينة الأمير عدبالعزيز بن مساعد الاقتصادية (حائل)", "دومة الجندل", "طبرجل", "قارا", "صـــوير", "هــديـب", "الاضارع", "اللقـائـــط", "زلــــوم", "طريف", "رفحا", "حالة عمار", "الوجه", "حقل", "تيماء", "ضباء", "البدع", "شرما", "المويلح", "القحزه", "قيال", "الشرف", "مقنا", "الخريبة", "البئر", "الجهراء", "شواق", "القليبه", "البديعه", "الديسه", "المعظم", "فجر", "الروضة", "الخرمة", "تربة-الطائف", "بنى مالك", "رنيه", "المويه", "ظـــــــلم", "بحرة", "مستورة", "ذهبان", "عسفان", "ابو راكه", "بالحارث", "قياء", "ترعة ثقيف", "غزايل", "الليث", "رابغ", "القنفذة", "خليص", "الكامل", "مدركه", "الجمـوم", "الشـرائع", "مدينة الملك عبدالله الاقتصادية برابغ", "مدينة المعرفة الاقتصادية", "العلا", "المهد", "الحناكية", "الحسو", "الثمد", "العمق", "الشقران", "المليليح", "السويرقيه", "الفريش", "وادي الفرع", "خيبر", "الصلصلة", "الصويدرة", "الشقره", "ثرب", "لفه", "املج", "بدر", "الواسطة", "المسيجيد", "بلجرشي", "المندق", "بني حسن", "دوس", "القري", "المخواه", "غامد الزناد", "قلوي", "الشعـــــراء", "العقيق", "قرى الحجاز", "تثليث", "سراة عبيدة", "احد رفيدة", "ظهران الجنوب", "النماص", "محائل", "رجال ألمع", "تنومة", "بني عمرو", "المجاردة", "قناءوالبحر", "الربوعة", "القحمة", "جيزان", "ابو عريش", "الشقيري", "الريث الشقيق", "ضمد", "فيفا", "صبيا", "صامطة - الطوال", "فرسان", "الداير بني مالك", "هروب", "احد المسارحة - الخوبة", "شروره", "العبيله", "بدر الجنوب", "الوديعة", "حبونا", "يدمه", "مدينة جازان للصناعات الأساسية والتحويلية");
        } else {
            $data['cities'] = array("Riyadh", "Jeddah", "Mecca", "Medina", "Ta'if", "Dammam", "Khobar", "Tabuk", "Al-Kharj", "Buraydah", "Khamis Mushait", "Al-Hufuf", "Al-Mubarraz", "Hafar Al-Batin", "Ha'il", "Najran", "Jubail", "Abha", "Yanbu", "Unaizah", "Arar", "Sakakah", "Jazan", "Qurayyat", "Dhahran", "Al-Qatif", "Al-Baha", "Bishah", "Accra", "Ad-Dilam", "Hautat Bani Tamim", "Al-Hareeq", "Aflaj", "Al-khamasin", "Saleel", "Harimlaa", "Thadiq", "Ragbah", "Dharmaa", "Muzahmiyyah", "Marat", "Shaqraa", "Al-Qasab", "Sajir", "Dawadmi", "Quwaiyah", "Afeef", "Khasirah", "Remaah", "Shuwiyah", "Majma'ah", "Zulfi", "Al-Ghat", "Al-Artaweeiyah", "Sudair", "Al-Bada'a", "Al-Mithnab", "Al-Rass", "Al-Bukayriyah", "Riyadh Al-Khabra", "Al-Asyah", "Shiri", "Fawarah", "Aqlit Al-Sukour", "Al-Bateen", "Mudraj", "Dulaimiyah", "Al-Batraa", "Al-Qareen", "Thaibiyah", "Nabhaniyah", "Daknah", "Um Hazm", "Dali' Rasheed", "Diryah", "Qubbah", "Al-Khabra", "Al-Ssir", "Tharmadaa", "Halban", "Mulham", "Quwarah", "Wadi Al-Dawasir", "Al-Jamsh", "Bajadiyah", "Al-Hasa", "Rahima", "Nua'iriyah", "Al-Kafji", "Safaniyah", "Beqaiq", "Thuqbah", "Saihat", "Safwa", "Qaryah", "Ras Tanurah", "Al-Hasa Villages", "Uqair", "Salwa", "Al-Hana", "Harid", "Al-Oyoun", "Ain Dar", "Qaisumah", "Al-Raq'i", "Military city of king Khalid", "Samuda", "Um Qulaib", "Ibn Tawalah", "Sadawi", "Al-Sa'erah", "Al-Haliqah", "Buqa'a", "Moqiq", "Durghut", "Tabah", "Al-Ha'it", "Ha'il Villages", "Jibah", "Turbit Ha'il", "Al-Shamli", "Rawdah", "Al-Kahfa", "Sulaymi", "Al-Khotta", "Shinan", "Economic city of prince Abd Al-Aziz Bin musa'id (Ha'il)", "Dumat Al-Jandal", "Tabarjal", "Qarah", "Suwair", "Hudaid", "Al-Adar'i", "Al-Laqai't", "Zalloum", "Tareef", "Rafha", "Halit Ammar", "Al-Wajh", "Haqil", "Taima'a", "Diba'a", "Al-Bid'a", "Sharma", "Muwilih", "Kahza", "Qiyal", "Al-Shuruf", "Miqna", "Kuraybah", "Al-Bi'er", "Jahraa", "Shiwaq", "Qulaybah", "Badi'a", "Al-Disah", "Mu'atham", "Fajir", "Al-Khirmah", "Turbit Al-Ta'if", "Bani Malik", "Rinaih", "Al-Moyah", "Thulam", "Bahrah", "Mastourah", "Thahban", "Asfan", "Abu Rakah", "Bilharith", "Qiya'a", "Tir'it Thaqif", "Ghazail", "Al-Laith", "Rabigh", "Qunfuthah", "Khulais", "Al-Kamil", "Mudrakah", "Al-Jumum", "Al-Sharai'", "Economic city of king Abdullah (Rabigh)", "Economic city of knowledge", "Al-Ula", "Al-Mahd", "Al-Hanakiya", "Al-Hasew", "Al-Thamid", "Al-Omiq", "Shaqran", "Mulailih", "Swairqiyah", "Al-Farish", "Wadi Al-Firi'", "Khaybar", "Salsa", "Suwiydrah", "Thirib", "Laffih", "Amlaj", "Badr", "Al-Wasitah", "Musayjid", "Biljarshi", "Al-Minduq", "Bani Hassan", "Doos", "Al-Qirri", "Mikwah", "Ghamid Al-Zinad", "Qalawi", "Sha'raa", "Al-Aqeeq", "Al-Hijaz Villages", "Tathlith", "Surat Obaydah", "Ohud Rafidah", "Dhahran Al-Janoub", "Al-Nammas", "Muhai'l", "Rijal Alm'a", "Tannumah", "Bani Amro", "Al-Majardah", "Qina' Wilbahir", "Rabboa'a", "Al-Qahmah", "Jizan", "Abu Areesh", "Al-Shuqayri", "Al-Raith AL-Shaqiq", "Dumd", "Fifa", "Sibya", "Samtit Al-Tiwal", "Farasan", "Dayer Bani Malik", "Huroub", "Ohud Al-Masariha - Al-Khoba", "Shrurah", "Al-Obaylah", "Badr Al-Janoub", "Al-Wadi'a", "Hubunah", "Yedma", "Jazan city of basic and transformed industries");
        }
        $data['package'] = Package::find(old('package_id'));
        $version = $be->theme_version;
        $data['version'] = $version == 'dark' ? 'default' : $version;
        return view('front.package_quote', $data);
    }

    public function store_serv_req(Request $request)
    {

        // FIX SPAM FORMS IF THIS INPUT IS NOT EMPTY SO WILL DIE;
        if ($request->secure) {
            return redirect()->back()->withErrors('Your form has been submitted');
        }

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        App::setLocale($currentLang->code);

        $rules = [
            'mobile' => 'required|max:25',
            'email' => 'required|email:rfc,dns|max:35',
            'city' => 'required|max:100',
            'category_id' => 'required|max:5',
            'service_id' => 'required|max:5',
            'desc' => 'required|max:1000',
            'suggested_time' => 'required|max:50',
            'client_type' => 'required|max:50',
            'fullname' => 'required|max:50',
            'company_name' => 'required|max:100'
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            // dd($validator->errors());
            return redirect()->back()->withErrors($validator->errors())->withInput();

            //  return redirect()->back(($validator->errors());
        }

        $records =  ServiceRequest::whereDate('created_at', Carbon::now())
            ->where('emp_name', $request->fullname)
            ->where('company_name', $request->company_name)
            ->where('emp_mobile', $request->mobile)
            ->where('emp_email', $request->email)
            ->where('description', $request->desc)
            ->where('request_id', $request->service_id)
            ->where('company_city', $request->city)
            ->where('msource', $request->msource)
            ->count();
        if ($records > 0) {
            return redirect()->to('/');
        }
        $req = new ServiceRequest;
        $req->emp_name = $request->fullname;
        $req->company_name = $request->company_name;
        $req->msource = $request->msource;
        $req->emp_mobile = $request->mobile;
        $req->emp_email = $request->email;
        $req->company_type = $request->client_type;
        $req->company_city = $request->city;
        $req->suitable_time = $request->suggested_time;
        $req->description = $request->desc;
        $req->language_id = $currentLang->id;
        $req->cat_id = $request->category_id;
        $req->request_id = $request->service_id;
        $now = Carbon::now();
        $code = "S-" . rand(10000, 99999);
        $req->uuid = $code;
        $req->save();

        $marketingOptions = [
            'marketing' => 'التسويق',
            'email' => 'الحملة البريدية',
            'google' => 'إعلانات جوجل',
            'twitter' => 'تويتر',
            'instagram' => 'انستقرام',
            'facebook' => 'فيس بوك',
            'youtube' => 'يوتيوب',
            'tiktok' => 'تيك توك',
            'whatsapp' => 'واتساب',
            'linkedin' => 'لينكد إن',
            'telegram' => 'تيليجرام',
            'snapchat' => 'سناب شات',
        ];

        $marketing = isset($marketingOptions[$request->msource]) ? $marketingOptions[$request->msource] : 'الموقع';

        $adminMsg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<!--[if (gte mso 9)|(IE)]>
	<xml>
		<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>etmam Email Template</title>

	<!-- Google Fonts Link -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

	<style type="text/css">

		/*------ Client-Specific Style ------ */
		@-ms-viewport{width:device-width;}
		table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;}
		img{-ms-interpolation-mode:bicubic; border: 0;}
		p, a, li, td, blockquote{mso-line-height-rule:exactly;}
		p, a, li, td, body, table, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%;}
		#outlook a{padding:0;}
		.ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
		.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td,img{line-height:100%;}

		/*------ Reset Style ------ */
		*{-webkit-text-size-adjust:none;-webkit-text-resize:100%;text-resize:100%;}
		table{border-spacing: 0 !important;}
		h1, h2, h3, h4, h5, h6, p{display:block; Margin:0; padding:0;}
		img, a img{border:0; height:auto; outline:none; text-decoration:none;}
		#bodyTable, #bodyCell{ margin:0; padding:0; width:100%;}
		body {height:100%; margin:0; padding:0; width:100%;}

		.appleLinks a {color: #c2c2c2 !important; text-decoration: none;}
		span.preheader { display: none !important; }

		/*------ Google Font Style ------ */
		[style*="Open Sans"],.text {font-family:"Open Sans", Helvetica, Arial, sans-serif !important;}
		/*------ General Style ------ */
		.wrapperWebview, .wrapperBody, .wrapperFooter{width:100%; max-width:600px; Margin:0 auto;}

		/*------ Column Layout Style ------ */
		.tableCard {text-align:center; font-size:0;}

		/*------ Images Style ------ */
		.imgHero img{ width:600px; height:auto; }

	</style>

	<style type="text/css">
		/*------ Media Width 480 ------ */
		@media screen and (max-width:640px) {
			table[class="wrapperWebview"]{width:100% !important; }
			table[class="wrapperEmailBody"]{width:100% !important; }
			table[class="wrapperFooter"]{width:100% !important; }
			td[class="imgHero"] img{ width:100% !important;}
			.hideOnMobile {display:none !important; width:0; overflow:hidden;}
		}
	</style>

</head>

<body dir="rtl" style="background-color:#F9F9F9;">
<center>

	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#F9F9F9;" id="bodyTable">
		<tr>
			<td align="center" valign="top" style="padding-right:10px;padding-left:10px;" id="bodyCell">
				<!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" style="width:600px;" width="300"><tr><td align="center" valign="top"><![endif]-->



				<!-- Email Wrapper Header Open //-->
				<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;    margin-top: 50px;" width="100%" class="wrapperWebview">
					<tr>
						<td align="center" valign="top">
							<!-- Content Table Open // -->
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td align="center" valign="middle" style="padding-top:20px;padding-bottom:20px;    background: whitesmoke;" class="emailLogo">
										<!-- Logo and Link // -->
										<a href="#" target="_blank" style="text-decoration:none;">
											<img src="https://etmaam.com.sa/assets/front/img/logo.png" alt="" width="150" border="0" style="width:100%; max-width:150px;height:auto; display:block;"/>
										</a>
									</td>
								</tr>
							</table>
							<!-- Content Table Close // -->
						</td>
					</tr>
				</table>
				<!-- Email Wrapper Header Close //-->

				<!-- Email Wrapper Body Open // -->
				<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperBody">
					<tr>
						<td align="center" valign="top">

							<!-- Table Card Open // -->
							<table border="0" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF;border-color:#E5E5E5; border-style:solid; border-width:0 1px 1px 1px;" width="100%" class="tableCard">



								<tr>
									<td align="center" valign="top" style="padding-bottom:40px ;padding-top: 40px;" class="imgHero">
										<!-- Hero Image // -->
										<a href="#" target="_blank" style="text-decoration:none;">
											<img src="https://etmaam.com.sa/assets/front/img/user-subscribe.png" width="300" alt="" border="0" style="width:100%; max-width:150px; height:auto; display:block;" />
										</a>
									</td>
								</tr>

								<tr>
									<td align="center" valign="top" style="padding-bottom:5px;padding-left:20px;padding-right:20px;" class="mainTitle">
										<!-- Main Title Text // -->
										<h2 class="text" style="color:#000000; font-size:28px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:36px; text-transform:none; text-align:center; padding:0; margin:0">
											طلب خدمة جديد #' . $req->id . ' | ' . $request->fullname . '
										</h2>
									</td>
								</tr>

								<tr>
									<td align="center" valign="top" style="padding-bottom:18px;padding-left:20px;padding-right:20px;" class="subTitle">
										<!-- Sub Title Text // -->
										<h4 class="text" style="color:#225476; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											اسم المنشأة
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											 ' . $request->company_name . ' <b style="font-weight: bold;">(' . $request->client_type . ')</b>
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											اسم المسؤول
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
                                            ' . $request->fullname . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											رقم الجوال
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											' . $request->mobile . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											البريد الإلكتروني
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											' . $request->email . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											المدينة
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											' . $request->city . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											الوقت المناسب للتواصل
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											' . $request->suggested_time . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
										نوع الطلب
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
										' . App\Request::find($request->service_id)->name . '
										</h4>

                                        <h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											مصدر العميل
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											' . $marketing . '
										</h4>

										<h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											 تفاصيل الطلب:
										</h4>

									</td>
								</tr>

								<tr>
									<td align="center" valign="top" style="padding-left:20px;padding-right:20px;padding-bottom:40px;" class="containtTable">

										<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription">
											<tr>
												<td align="center" valign="top" style="padding-bottom:20px;" class="description">
													<!-- Description Text// -->
													<p class="text" style="width:500px; color:#666666; font-size:18px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:22px; text-transform:none; text-align:center; padding:0; margin:0">
														' . $request->desc . '
													</p>
												</td>
											</tr>
										</table>


									</td>
								</tr>




							</table>
							<!-- Table Card Close// -->

							<!-- Space -->
							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
								<tr>
									<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
								</tr>
							</table>

						</td>
					</tr>
				</table>
				<!-- Email Wrapper Body Close // -->

				<!-- Email Wrapper Footer Open // -->
				<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperFooter">
					<tr>
						<td align="center" valign="top">
							<!-- Content Table Open// -->
							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
								<tr>
									<td align="center" valign="top" style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="socialLinks">
										<!-- Social Links (Facebook)// -->
										<a href="https://www.facebook.com/etmaam2/" target="_blank" style="display:inline-block;" class="facebook">
											<img src="https://etmaam.com.sa/assets/front/img/facebook.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
										</a>
										<!-- Social Links (Twitter)// -->
										<a href="https://twitter.com/etmaam2" target="_blank" style="display:inline-block;" class="twitter">
											<img src="https://etmaam.com.sa/assets/front/img/twitter.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
										</a>

										<!-- Social Links (Instagram)// -->
										<a href="https://www.instagram.com/etmaam2/" target="_blank" style="display:inline-block;" class="instagram">
											<img src="https://etmaam.com.sa/assets/front/img/instagram.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
										</a>
										<!-- Social Links (Linkdin)// -->
										<a href="https://www.linkedin.com/company/etmaam2" target="_blank" style="display:inline-block;" class="linkdin">
											<img src="https://etmaam.com.sa/assets/front/img/linkdin.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
										</a>
									</td>
								</tr>

								<tr>
									<td align="center" valign="top" style="padding-top:10px;padding-bottom:5px;padding-left:10px;padding-right:10px;" class="brandInfo">
										<!-- Brand Information // -->
										<p class="text" style="color:#777777; font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;">&copy;&nbsp; اتمام للخدمات. | 2022 <span> المنطقة الوسطى - الرياض</span>
										</p>
									</td>
								</tr>

								<tr>
									<td align="center" valign="top" style="padding-top:0px;padding-bottom:20px;padding-left:10px;padding-right:10px;" class="footerLinks">
										<!-- Use Full Links (Privacy Policy)// -->
										<p class="text" style="color:#777777; font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
										<a href="https://etmaam.com.sa/about" style="color:#777777;text-decoration:underline;" target="_blank"> ماذا عنا  </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/serv_req" style="color:#777777;text-decoration:underline;" target="_blank"> اطلب خدمة </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/" style="color:#777777;text-decoration:underline;" target="_blank"> الصفحة الرئيسية  </a>
										</p>
									</td>
								</tr>

								<tr>
									<td align="center" valign="top" style="padding-top:0px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="footerEmailInfo">
										<!-- Information of NewsLetter (Subscribe Info)// -->
										<p class="text" style="color:#777777; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
										اذا كان لديك اي استفسار يمكنك التواصل معنا <a href="mailto:info@etmaam.com.sa" style="color:#777777;text-decoration:underline;" target="_blank">info@etmaam.com.sa</a><br>
										</p>
									</td>
								</tr>



								<!-- Space -->
								<tr>
									<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
								</tr>
							</table>
							<!-- Content Table Close// -->
						</td>
					</tr>

					<!-- Space -->
					<tr>
						<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
					</tr>
				</table>
				<!-- Email Wrapper Footer Close // -->

				<!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
			</td>
		</tr>
	</table>

</center>
</body>
</html>';

        if ($currentLang->code == 'ar') {
            $userMsg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<!--[if (gte mso 9)|(IE)]>
	<xml>
		<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>etmam Email Template</title>

	<!-- Google Fonts Link -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

	<style type="text/css">

		/*------ Client-Specific Style ------ */
		@-ms-viewport{width:device-width;}
		table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;}
		img{-ms-interpolation-mode:bicubic; border: 0;}
		p, a, li, td, blockquote{mso-line-height-rule:exactly;}
		p, a, li, td, body, table, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%;}
		#outlook a{padding:0;}
		.ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
		.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td,img{line-height:100%;}

		/*------ Reset Style ------ */
		*{-webkit-text-size-adjust:none;-webkit-text-resize:100%;text-resize:100%;}
		table{border-spacing: 0 !important;}
		h1, h2, h3, h4, h5, h6, p{display:block; Margin:0; padding:0;}
		img, a img{border:0; height:auto; outline:none; text-decoration:none;}
		#bodyTable, #bodyCell{ margin:0; padding:0; width:100%;}
		body {height:100%; margin:0; padding:0; width:100%;}

		.appleLinks a {color: #c2c2c2 !important; text-decoration: none;}
        span.preheader { display: none !important; }

		/*------ Google Font Style ------ */
		[style*="Open Sans"] {font-family:"Open Sans", Helvetica, Arial, sans-serif !important;}
		/*------ General Style ------ */
		.wrapperWebview, .wrapperBody, .wrapperFooter{width:100%; max-width:600px; Margin:0 auto;}

		/*------ Column Layout Style ------ */
		.tableCard {text-align:center; font-size:0;}

		/*------ Images Style ------ */
		.imgHero img{ width:600px; height:auto; }

	</style>

	<style type="text/css">
		/*------ Media Width 480 ------ */
		@media screen and (max-width:640px) {
			table[class="wrapperWebview"]{width:100% !important; }
			table[class="wrapperEmailBody"]{width:100% !important; }
			table[class="wrapperFooter"]{width:100% !important; }
			td[class="imgHero"] img{ width:100% !important;}
			.hideOnMobile {display:none !important; width:0; overflow:hidden;}
		}
	</style>

</head>

<body dir="rtl" style="background-color:#F9F9F9;">
<center>

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#F9F9F9;" id="bodyTable">
	<tr>
		<td align="center" valign="top" style="padding-right:10px;padding-left:10px;" id="bodyCell">
		<!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" style="width:600px;" width="300"><tr><td align="center" valign="top"><![endif]-->



		<!-- Email Wrapper Header Open //-->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;    margin-top: 50px;" width="100%" class="wrapperWebview">
			<tr>
				<td align="center" valign="top">
					<!-- Content Table Open // -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td align="center" valign="middle" style="padding-top:20px;padding-bottom:20px;    background: whitesmoke;" class="emailLogo">
								<!-- Logo and Link // -->
								<a href="#" target="_blank" style="text-decoration:none;">
									<img src="https://etmaam.com.sa/assets/front/img/logo.png" alt="" width="150" border="0" style="width:100%; max-width:150px;height:auto; display:block;"/>
								</a>
							</td>
						</tr>
					</table>
					<!-- Content Table Close // -->
				</td>
			</tr>
		</table>
		<!-- Email Wrapper Header Close //-->

		<!-- Email Wrapper Body Open // -->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperBody">
			<tr>
				<td align="center" valign="top">

					<!-- Table Card Open // -->
					<table border="0" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF;border-color:#E5E5E5; border-style:solid; border-width:0 1px 1px 1px;" width="100%" class="tableCard">



						<tr>
							<td align="center" valign="top" style="padding-bottom:40px ;padding-top: 40px;" class="imgHero">
								<!-- Hero Image // -->
								<a href="#" target="_blank" style="text-decoration:none;">
									<img src="https://etmaam.com.sa/assets/front/img/user-subscribe.png" width="300" alt="" border="0" style="width:100%; max-width:150px; height:auto; display:block;" />
								</a>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-bottom:5px;padding-left:20px;padding-right:20px;" class="mainTitle">
								<!-- Main Title Text // -->
								<h2 class="text" style="color:#000000;  font-size:28px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:36px; text-transform:none; text-align:center; padding:0; margin:0">
									مرحبا<span>"' . $request->fullname . '"</span>
								</h2>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-bottom:18px;padding-left:20px;padding-right:20px;" class="subTitle">
								<!-- Sub Title Text // -->
								<h4 class="text" style="color:#225476;  font-size:24px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
									لقد تم استقبال طلبك بنجاح
								</h4>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-left:20px;padding-right:20px;padding-bottom:40px;" class="containtTable">

								<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription">
									<tr>
										<td align="center" valign="top" style="padding-bottom:20px;" class="description">
											<!-- Description Text// -->
											<p class="text" style="color:#666666;  font-size:18px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:22px; text-transform:none; text-align:center; padding:0; margin:0">
												نشكركم على طلبكم وسيتم التواصل معكم من قبل أحد المختصين في مجال الخدمة المطلوبة
											</p>
										</td>
									</tr>
								</table>


							</td>
						</tr>




					</table>
					<!-- Table Card Close// -->

					<!-- Space -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
						<tr>
							<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
						</tr>
					</table>

				</td>
			</tr>
		</table>
		<!-- Email Wrapper Body Close // -->

		<!-- Email Wrapper Footer Open // -->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperFooter">
			<tr>
				<td align="center" valign="top">
					<!-- Content Table Open// -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
						<tr>
							<td align="center" valign="top" style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="socialLinks">
								<!-- Social Links (Facebook)// -->
								<a href="https://www.facebook.com/etmaam2/" target="_blank" style="display:inline-block;" class="facebook">
									<img src="https://etmaam.com.sa/assets/front/img/facebook.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
								<!-- Social Links (Twitter)// -->
								<a href="https://twitter.com/etmaam2" target="_blank" style="display:inline-block;" class="twitter">
									<img src="https://etmaam.com.sa/assets/front/img/twitter.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>

								<!-- Social Links (Instagram)// -->
								<a href="https://www.instagram.com/etmaam2/" target="_blank" style="display:inline-block;" class="instagram">
									<img src="https://etmaam.com.sa/assets/front/img/instagram.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
								<!-- Social Links (Linkdin)// -->
								<a href="https://www.linkedin.com/company/etmaam2" target="_blank" style="display:inline-block;" class="linkdin">
									<img src="https://etmaam.com.sa/assets/front/img/linkdin.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:10px;padding-bottom:5px;padding-left:10px;padding-right:10px;" class="brandInfo">
								<!-- Brand Information // -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;">&copy;&nbsp; اتمام للخدمات. | 2022 <span> المنطقة الوسطى - الرياض</span>
								</p>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:0px;padding-bottom:20px;padding-left:10px;padding-right:10px;" class="footerLinks">
								<!-- Use Full Links (Privacy Policy)// -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
									<a href="https://etmaam.com.sa/about" style="color:#777777;text-decoration:underline;" target="_blank"> ماذا عنا  </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/serv_req" style="color:#777777;text-decoration:underline;" target="_blank"> اطلب خدمة </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/" style="color:#777777;text-decoration:underline;" target="_blank"> الصفحة الرئيسية  </a>
								</p>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:0px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="footerEmailInfo">
								<!-- Information of NewsLetter (Subscribe Info)// -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
								اذا كان لديك اي استفسار يمكنك التواصل معنا <a href="mailto:info@etmaam.com.sa" style="color:#777777;text-decoration:underline;" target="_blank">info@etmaam.com.sa</a><br>
								</p>
							</td>
						</tr>



						<!-- Space -->
						<tr>
							<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
						</tr>
					</table>
					<!-- Content Table Close// -->
				</td>
			</tr>

			<!-- Space -->
			<tr>
				<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
			</tr>
		</table>
		<!-- Email Wrapper Footer Close // -->

		<!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
		</td>
	</tr>
</table>

</center>
</body>
</html>';
        } else {
            $userMsg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<!--[if (gte mso 9)|(IE)]>
	<xml>
		<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>etmam Email Template</title>

	<!-- Google Fonts Link -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

	<style type="text/css">

		/*------ Client-Specific Style ------ */
		@-ms-viewport{width:device-width;}
		table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;}
		img{-ms-interpolation-mode:bicubic; border: 0;}
		p, a, li, td, blockquote{mso-line-height-rule:exactly;}
		p, a, li, td, body, table, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%;}
		#outlook a{padding:0;}
		.ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
		.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td,img{line-height:100%;}

		/*------ Reset Style ------ */
		*{-webkit-text-size-adjust:none;-webkit-text-resize:100%;text-resize:100%;}
		table{border-spacing: 0 !important;}
		h1, h2, h3, h4, h5, h6, p{display:block; Margin:0; padding:0;}
		img, a img{border:0; height:auto; outline:none; text-decoration:none;}
		#bodyTable, #bodyCell{ margin:0; padding:0; width:100%;}
		body {height:100%; margin:0; padding:0; width:100%;}

		.appleLinks a {color: #c2c2c2 !important; text-decoration: none;}
        span.preheader { display: none !important; }

		/*------ Google Font Style ------ */
		[style*="Open Sans"],.text {font-family:"Open Sans", Helvetica, Arial, sans-serif !important;}
		/*------ General Style ------ */
		.wrapperWebview, .wrapperBody, .wrapperFooter{width:100%; max-width:600px; Margin:0 auto;}

		/*------ Column Layout Style ------ */
		.tableCard {text-align:center; font-size:0;}

		/*------ Images Style ------ */
		.imgHero img{ width:600px; height:auto; }

	</style>

	<style type="text/css">
		/*------ Media Width 480 ------ */
		@media screen and (max-width:640px) {
			table[class="wrapperWebview"]{width:100% !important; }
			table[class="wrapperEmailBody"]{width:100% !important; }
			table[class="wrapperFooter"]{width:100% !important; }
			td[class="imgHero"] img{ width:100% !important;}
			.hideOnMobile {display:none !important; width:0; overflow:hidden;}
		}
	</style>

</head>

<body dir="ltr" style="background-color:#F9F9F9;">
<center>

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#F9F9F9;" id="bodyTable">
	<tr>
		<td align="center" valign="top" style="padding-right:10px;padding-left:10px;" id="bodyCell">
		<!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" style="width:600px;" width="300"><tr><td align="center" valign="top"><![endif]-->



		<!-- Email Wrapper Header Open //-->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;    margin-top: 50px;" width="100%" class="wrapperWebview">
			<tr>
				<td align="center" valign="top">
					<!-- Content Table Open // -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td align="center" valign="middle" style="padding-top:20px;padding-bottom:20px;    background: whitesmoke;" class="emailLogo">
								<!-- Logo and Link // -->
								<a href="#" target="_blank" style="text-decoration:none;">
									<img src="https://etmaam.com.sa/assets/front/img/logo.png" alt="" width="150" border="0" style="width:100%; max-width:150px;height:auto; display:block;"/>
								</a>
							</td>
						</tr>
					</table>
					<!-- Content Table Close // -->
				</td>
			</tr>
		</table>
		<!-- Email Wrapper Header Close //-->

		<!-- Email Wrapper Body Open // -->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperBody">
			<tr>
				<td align="center" valign="top">

					<!-- Table Card Open // -->
					<table border="0" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF;border-color:#E5E5E5; border-style:solid; border-width:0 1px 1px 1px;" width="100%" class="tableCard">



						<tr>
							<td align="center" valign="top" style="padding-bottom:40px ;padding-top: 40px;" class="imgHero">
								<!-- Hero Image // -->
								<a href="#" target="_blank" style="text-decoration:none;">
									<img src="https://etmaam.com.sa/assets/front/img/user-subscribe.png" width="300" alt="" border="0" style="width:100%; max-width:150px; height:auto; display:block;" />
								</a>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-bottom:5px;padding-left:20px;padding-right:20px;" class="mainTitle">
								<!-- Main Title Text // -->
								<h2 class="text" style="color:#000000;  font-size:28px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:36px; text-transform:none; text-align:center; padding:0; margin:0">
									Dear <span>"' . $request->fullname . '"</span>
								</h2>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-bottom:18px;padding-left:20px;padding-right:20px;" class="subTitle">
								<!-- Sub Title Text // -->
								<h4 class="text" style="color:#225476;  font-size:24px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
									Your service request has been received successfully.
								</h4>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-left:20px;padding-right:20px;padding-bottom:40px;" class="containtTable">

								<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription">
									<tr>
										<td align="center" valign="top" style="padding-bottom:20px;" class="description">
											<!-- Description Text// -->
											<p class="text" style="color:#666666;  font-size:18px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:22px; text-transform:none; text-align:center; padding:0; margin:0">
												Thank you for your trust, our support will reach you shortly.
											</p>
										</td>
									</tr>
								</table>


							</td>
						</tr>




					</table>
					<!-- Table Card Close// -->

					<!-- Space -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
						<tr>
							<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
						</tr>
					</table>

				</td>
			</tr>
		</table>
		<!-- Email Wrapper Body Close // -->

		<!-- Email Wrapper Footer Open // -->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperFooter">
			<tr>
				<td align="center" valign="top">
					<!-- Content Table Open// -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
						<tr>
							<td align="center" valign="top" style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="socialLinks">
								<!-- Social Links (Facebook)// -->
								<a href="https://www.facebook.com/etmaam2/" target="_blank" style="display:inline-block;" class="facebook">
									<img src="https://etmaam.com.sa/assets/front/img/facebook.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
								<!-- Social Links (Twitter)// -->
								<a href="https://twitter.com/etmaam2" target="_blank" style="display:inline-block;" class="twitter">
									<img src="https://etmaam.com.sa/assets/front/img/twitter.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>

								<!-- Social Links (Instagram)// -->
								<a href="https://www.instagram.com/etmaam2/" target="_blank" style="display:inline-block;" class="instagram">
									<img src="https://etmaam.com.sa/assets/front/img/instagram.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
								<!-- Social Links (Linkdin)// -->
								<a href="https://www.linkedin.com/company/etmaam2" target="_blank" style="display:inline-block;" class="linkdin">
									<img src="https://etmaam.com.sa/assets/front/img/linkdin.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:10px;padding-bottom:5px;padding-left:10px;padding-right:10px;" class="brandInfo">
								<!-- Brand Information // -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;">&copy;&nbsp; Etmaam for Services | 2022 <span> Riyadh </span>
								</p>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:0px;padding-bottom:20px;padding-left:10px;padding-right:10px;" class="footerLinks">
								<!-- Use Full Links (Privacy Policy)// -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
									<a href="https://etmaam.com.sa/about" style="color:#777777;text-decoration:underline;" target="_blank"> About us  </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/serv_req" style="color:#777777;text-decoration:underline;" target="_blank"> Request Service </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/" style="color:#777777;text-decoration:underline;" target="_blank"> Home  </a>
								</p>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:0px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="footerEmailInfo">
								<!-- Information of NewsLetter (Subscribe Info)// -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
								For any inquiries, please email us at <a href="mailto:info@etmaam.com.sa" style="color:#777777;text-decoration:underline;" target="_blank">info@etmaam.com.sa</a><br>
								</p>
							</td>
						</tr>



						<!-- Space -->
						<tr>
							<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
						</tr>
					</table>
					<!-- Content Table Close// -->
				</td>
			</tr>

			<!-- Space -->
			<tr>
				<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
			</tr>
		</table>
		<!-- Email Wrapper Footer Close // -->

		<!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
		</td>
	</tr>

</table>

</center>
</body>
</html>';
        }
        // \Illuminate\Support\Facades\Session::flash('success', 'Service added successfully!');

        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;

        $data['categories'] = RequestCategory::where('language_id', $currentLang->id)->where('cat_id', 0)->get();
        // dd($data);


        $version = $be->theme_version;
        $data['version'] = $version == 'dark' ? 'default' : $version;
        // dd(request()->all());


        $be = BasicExtended::first();


        $mail = new PHPMailer(true);

        if ($be->is_smtp == 1) {
            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                //                 $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = $be->smtp_host;                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = $be->smtp_username;                     // SMTP username
                $mail->Password   = $be->smtp_password;                               // SMTP password
                $mail->SMTPSecure = $be->encryption;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = $be->smtp_port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);


                $mail->addAddress($request->email);     // Add a recipient
                //    $mail->addAddress('bashar@etmaam.com.sa');     // Add a recipient

            } catch (Exception $e) {
                // die($e->getMessage());
            }
        } else {
            try {

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);

                $mail->addAddress($request->email);     // Add a recipient
                //      $mail->addAddress('bashar@etmaam.com.sa');
            } catch (Exception $e) {
                // die($e->getMessage());
            }
        }

        // Content
        //  $mail->AltBody = 'برنامه شما از این ایمیل پشتیبانی نمی کند، برای دیدن آن، لطفا از برنامه دیگری استفاده نمائید'; // متنی برای کاربرانی که نمی توانند ایمیل را به درستی مشاهده کنند
        $mail->CharSet = 'UTF-8';
        $mail->ContentType = 'text/html';
        $mail->isHTML(true);                                  // Set email format to HTML

        if ($currentLang->code == 'ar') {
            $mail->Subject = 'تم استقبال طلب الخدمة..وسيتم التواصل معكم';
        } else {
            $mail->Subject = 'Your service request has been submitted';
        }
        $mail->Body    = $userMsg;

        $mail->send();
        $mail->clearAllRecipients();

        if ($be->is_smtp == 1) {
            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                //                    $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = $be->smtp_host;                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = $be->smtp_username;                     // SMTP username
                $mail->Password   = $be->smtp_password;                               // SMTP password
                $mail->SMTPSecure = $be->encryption;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = $be->smtp_port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);


                // Add a recipient
                $mail->addAddress('adham@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('ahmed.j@etmaam.com.sa');     // Add a recipient

                $mail->addAddress('customer_service@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('abdullah.o@etmaam.com.sa');     // Add a recipient

                $mail->addAddress('hedbah@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('sidra@etmaam.com.sa');
                $mail->addAddress('mohammed.h@etmaam.com.sa');

                $mail->addAddress('najat@etmaam.com.sa');
                // Add a recipient
                $mail->addAddress('modhaf@etmaam.com.sa');     // Add a recipient

                // it emails
                $mail->addAddress('design@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('work@mohdabdulbari.com');     // Add a recipient
            } catch (Exception $e) {
                // die($e->getMessage());
            }
        } else {
            try {

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);

                // Add a recipient
                $mail->addAddress('adham@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('ahmed.j@etmaam.com.sa');     // Add a recipient

                $mail->addAddress('customer_service@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('abdullah.o@etmaam.com.sa');     // Add a recipient

                $mail->addAddress('hedbah@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('sidra@etmaam.com.sa');
                $mail->addAddress('najat@etmaam.com.sa');
                $mail->addAddress('mohammed.h@etmaam.com.sa');

                // Add a recipient

                $mail->addAddress('modhaf@etmaam.com.sa');     // Add a recipient
                // it emails
                $mail->addAddress('design@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('work@mohdabdulbari.com');     // Add a recipient
            } catch (Exception $e) {
                // die($e->getMessage());
            }
        }
        //   Mail::to($req->emp_email)->send(new App\Mail\NewServiceRequest($req));
        $mail->CharSet = 'UTF-8';
        $mail->ContentType = 'text/html';
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'طلب خدمة جديد #' . $req->id . ' | ' . $request->company_name;
        $mail->Body    = $adminMsg;
        $mail->send();
        if ($currentLang->code == 'ar') {
            $data['msg_title'] = 'تم ارسال طلبك بنجاح';
            $data['msg'] = " نشكركم على طلبكم وسيتم التواصل معكم من قبل أحد المختصين في
                        مجال الخدمة المطلوبة ";
        } else {
            $data['msg_title'] = 'Your request has been submitted Successfully';
            $data['msg'] = "Thank you for your request, We will get back to you";
        }

        $data['id'] = $req->id;

        return view('front.thankyou', $data);
    }

    public function store_package(Request $request)
    {

        // FIX SPAM FORMS IF THIS INPUT IS NOT EMPTY SO WILL DIE;
        if ($request->secure) {
            return redirect()->back()->withErrors('Your form has been submitted');
        }

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        App::setLocale($currentLang->code);


        $rules = [
            'mobile' => 'required',
            'cr' => 'required',
            'email' => 'required|email:rfc,dns',
            'city' => 'required',
            'desc' => 'required',
            'suggested_time' => 'required',
            'package_id' => 'required',
            'emp_num' => 'required',
            'period' => 'required',
            'fullname' => 'required'
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');

            return redirect()->back()->withErrors($validator->errors())->withInput();

            //  return redirect()->back(($validator->errors());
        }


        //     dd(request()->all());

        // \Illuminate\Support\Facades\Session::flash('success', 'Service added successfully!');

        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;

        //$data['categories'] = \App\RequestCategory::where('language_id', $currentLang->id)->where('cat_id',0)->get();
        // dd($data);
        //dd(request()->all());
        $version = $be->theme_version;
        $data['version'] = $version == 'dark' ? 'default' : $version;
        // dd(request()->all());
        $req = new PackageRequest();
        $req->emp_name = $request->fullname;
        $req->company_name = $request->company_name;
        $req->company_cr = $request->cr;
        $req->emp_mobile = $request->mobile;
        $req->emp_email = $request->email;
        $req->period = $request->period;
        $req->company_city = $request->city;
        $req->suitable_time = $request->suggested_time;
        $req->description = $request->desc;
        $req->package_id = $request->package_id;
        $req->language_id = $currentLang->id;
        $now = Carbon::now();
        $code = "P-" . rand(10000, 99999);
        $req->uuid = $code;
        $req->save();




        $adminMsg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<!--[if (gte mso 9)|(IE)]>
	<xml>
		<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>etmam Email Template</title>

	<!-- Google Fonts Link -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

	<style type="text/css">

		/*------ Client-Specific Style ------ */
		@-ms-viewport{width:device-width;}
		table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;}
		img{-ms-interpolation-mode:bicubic; border: 0;}
		p, a, li, td, blockquote{mso-line-height-rule:exactly;}
		p, a, li, td, body, table, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%;}
		#outlook a{padding:0;}
		.ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
		.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td,img{line-height:100%;}

		/*------ Reset Style ------ */
		*{-webkit-text-size-adjust:none;-webkit-text-resize:100%;text-resize:100%;}
		table{border-spacing: 0 !important;}
		h1, h2, h3, h4, h5, h6, p{display:block; Margin:0; padding:0;}
		img, a img{border:0; height:auto; outline:none; text-decoration:none;}
		#bodyTable, #bodyCell{ margin:0; padding:0; width:100%;}
		body {height:100%; margin:0; padding:0; width:100%;}

		.appleLinks a {color: #c2c2c2 !important; text-decoration: none;}
		span.preheader { display: none !important; }

		/*------ Google Font Style ------ */
		[style*="Open Sans"],.text {font-family:"Open Sans", Helvetica, Arial, sans-serif !important;}
		/*------ General Style ------ */
		.wrapperWebview, .wrapperBody, .wrapperFooter{width:100%; max-width:600px; Margin:0 auto;}

		/*------ Column Layout Style ------ */
		.tableCard {text-align:center; font-size:0;}

		/*------ Images Style ------ */
		.imgHero img{ width:600px; height:auto; }

	</style>

	<style type="text/css">
		/*------ Media Width 480 ------ */
		@media screen and (max-width:640px) {
			table[class="wrapperWebview"]{width:100% !important; }
			table[class="wrapperEmailBody"]{width:100% !important; }
			table[class="wrapperFooter"]{width:100% !important; }
			td[class="imgHero"] img{ width:100% !important;}
			.hideOnMobile {display:none !important; width:0; overflow:hidden;}
		}
	</style>

</head>

<body dir="rtl" style="background-color:#F9F9F9;">
<center>

	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#F9F9F9;" id="bodyTable">
		<tr>
			<td align="center" valign="top" style="padding-right:10px;padding-left:10px;" id="bodyCell">
				<!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" style="width:600px;" width="300"><tr><td align="center" valign="top"><![endif]-->



				<!-- Email Wrapper Header Open //-->
				<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;    margin-top: 50px;" width="100%" class="wrapperWebview">
					<tr>
						<td align="center" valign="top">
							<!-- Content Table Open // -->
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td align="center" valign="middle" style="padding-top:20px;padding-bottom:20px;    background: whitesmoke;" class="emailLogo">
										<!-- Logo and Link // -->
										<a href="#" target="_blank" style="text-decoration:none;">
											<img src="https://etmaam.com.sa/assets/front/img/logo.png" alt="" width="150" border="0" style="width:100%; max-width:150px;height:auto; display:block;"/>
										</a>
									</td>
								</tr>
							</table>
							<!-- Content Table Close // -->
						</td>
					</tr>
				</table>
				<!-- Email Wrapper Header Close //-->

				<!-- Email Wrapper Body Open // -->
				<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperBody">
					<tr>
						<td align="center" valign="top">

							<!-- Table Card Open // -->
							<table border="0" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF;border-color:#E5E5E5; border-style:solid; border-width:0 1px 1px 1px;" width="100%" class="tableCard">



								<tr>
									<td align="center" valign="top" style="padding-bottom:40px ;padding-top: 40px;" class="imgHero">
										<!-- Hero Image // -->
										<a href="#" target="_blank" style="text-decoration:none;">
											<img src="https://etmaam.com.sa/assets/front/img/user-subscribe.png" width="300" alt="" border="0" style="width:100%; max-width:150px; height:auto; display:block;" />
										</a>
									</td>
								</tr>

								<tr>
									<td align="center" valign="top" style="padding-bottom:5px;padding-left:20px;padding-right:20px;" class="mainTitle">
										<!-- Main Title Text // -->
										<h2 class="text" style="color:#000000; font-size:28px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:36px; text-transform:none; text-align:center; padding:0; margin:0">
											طلب باقة جديد #' . $req->id . ' | ' . $request->fullname . '
										</h2>
									</td>
								</tr>

								<tr>
									<td align="center" valign="top" style="padding-bottom:18px;padding-left:20px;padding-right:20px;" class="subTitle">
										<!-- Sub Title Text // -->
										<h4 class="text" style="color:#225476; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											اسم المنشأة
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											' . $request->company_name . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											رقم السجل
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											' . $request->cr . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											اسم المسؤول
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											' . $request->fullname . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											رقم الجوال
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											' . $request->mobile . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											البريد الإلكتروني
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											' . $request->email . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											المدينة
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											' . $request->city . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											الوقت المناسب للتواصل
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											  ' . $request->suggested_time . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
										نوع الباقة
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
										' . Package::find($request->package_id)->title . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
										مدة الاشتراك
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
										' . $request->period . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
										عدد الموظفين
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
										' . $request->emp_num . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
										حماية الاجور
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
										' . $request->salary_safety . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											 الملاحظات
										</h4>

									</td>
								</tr>

								<tr>
									<td align="center" valign="top" style="padding-left:20px;padding-right:20px;padding-bottom:40px;" class="containtTable">

										<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription">
											<tr>
												<td align="center" valign="top" style="padding-bottom:20px;" class="description">
													<!-- Description Text// -->
													<p class="text" style="width:50%;color:#666666; font-size:18px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:22px; text-transform:none; text-align:center; padding:0; margin:0">
														' . $request->desc . '
													</p>
												</td>
											</tr>
										</table>


									</td>
								</tr>




							</table>
							<!-- Table Card Close// -->

							<!-- Space -->
							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
								<tr>
									<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
								</tr>
							</table>

						</td>
					</tr>
				</table>
				<!-- Email Wrapper Body Close // -->

				<!-- Email Wrapper Footer Open // -->
				<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperFooter">
					<tr>
						<td align="center" valign="top">
							<!-- Content Table Open// -->
							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
								<tr>
									<td align="center" valign="top" style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="socialLinks">
										<!-- Social Links (Facebook)// -->
										<a href="https://www.facebook.com/etmaam2/" target="_blank" style="display:inline-block;" class="facebook">
											<img src="https://etmaam.com.sa/assets/front/img/facebook.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
										</a>
										<!-- Social Links (Twitter)// -->
										<a href="https://twitter.com/etmaam2" target="_blank" style="display:inline-block;" class="twitter">
											<img src="https://etmaam.com.sa/assets/front/img/twitter.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
										</a>

										<!-- Social Links (Instagram)// -->
										<a href="https://www.instagram.com/etmaam2/" target="_blank" style="display:inline-block;" class="instagram">
											<img src="https://etmaam.com.sa/assets/front/img/instagram.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
										</a>
										<!-- Social Links (Linkdin)// -->
										<a href="https://www.linkedin.com/company/etmaam2" target="_blank" style="display:inline-block;" class="linkdin">
											<img src="https://etmaam.com.sa/assets/front/img/linkdin.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
										</a>
									</td>
								</tr>

								<tr>
									<td align="center" valign="top" style="padding-top:10px;padding-bottom:5px;padding-left:10px;padding-right:10px;" class="brandInfo">
										<!-- Brand Information // -->
										<p class="text" style="color:#777777; font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;">&copy;&nbsp; اتمام للخدمات. | 2022 <span> المنطقة الوسطى - الرياض</span>
										</p>
									</td>
								</tr>

								<tr>
									<td align="center" valign="top" style="padding-top:0px;padding-bottom:20px;padding-left:10px;padding-right:10px;" class="footerLinks">
										<!-- Use Full Links (Privacy Policy)// -->
										<p class="text" style="color:#777777; font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
										<a href="https://etmaam.com.sa/about" style="color:#777777;text-decoration:underline;" target="_blank"> ماذا عنا  </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/serv_req" style="color:#777777;text-decoration:underline;" target="_blank"> اطلب خدمة </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/" style="color:#777777;text-decoration:underline;" target="_blank"> الصفحة الرئيسية  </a>
										</p>
									</td>
								</tr>

								<tr>
									<td align="center" valign="top" style="padding-top:0px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="footerEmailInfo">
										<!-- Information of NewsLetter (Subscribe Info)// -->
										<p class="text" style="color:#777777; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
										اذا كان لديك اي استفسار يمكنك التواصل معنا <a href="mailto:info@etmaam.com.sa" style="color:#777777;text-decoration:underline;" target="_blank">info@etmaam.com.sa</a><br>
										</p>
									</td>
								</tr>



								<!-- Space -->
								<tr>
									<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
								</tr>
							</table>
							<!-- Content Table Close// -->
						</td>
					</tr>

					<!-- Space -->
					<tr>
						<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
					</tr>
				</table>
				<!-- Email Wrapper Footer Close // -->

				<!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
			</td>
		</tr>
	</table>

</center>
</body>
</html>';

        if ($currentLang->code == 'ar') {
            $userMsg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<!--[if (gte mso 9)|(IE)]>
	<xml>
		<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>etmam Email Template</title>

	<!-- Google Fonts Link -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

	<style type="text/css">

		/*------ Client-Specific Style ------ */
		@-ms-viewport{width:device-width;}
		table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;}
		img{-ms-interpolation-mode:bicubic; border: 0;}
		p, a, li, td, blockquote{mso-line-height-rule:exactly;}
		p, a, li, td, body, table, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%;}
		#outlook a{padding:0;}
		.ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
		.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td,img{line-height:100%;}

		/*------ Reset Style ------ */
		*{-webkit-text-size-adjust:none;-webkit-text-resize:100%;text-resize:100%;}
		table{border-spacing: 0 !important;}
		h1, h2, h3, h4, h5, h6, p{display:block; Margin:0; padding:0;}
		img, a img{border:0; height:auto; outline:none; text-decoration:none;}
		#bodyTable, #bodyCell{ margin:0; padding:0; width:100%;}
		body {height:100%; margin:0; padding:0; width:100%;}

		.appleLinks a {color: #c2c2c2 !important; text-decoration: none;}
        span.preheader { display: none !important; }

		/*------ Google Font Style ------ */
		[style*="Open Sans"],.text {font-family:"Open Sans", Helvetica, Arial, sans-serif !important;}
		/*------ General Style ------ */
		.wrapperWebview, .wrapperBody, .wrapperFooter{width:100%; max-width:600px; Margin:0 auto;}

		/*------ Column Layout Style ------ */
		.tableCard {text-align:center; font-size:0;}

		/*------ Images Style ------ */
		.imgHero img{ width:600px; height:auto; }

	</style>

	<style type="text/css">
		/*------ Media Width 480 ------ */
		@media screen and (max-width:640px) {
			table[class="wrapperWebview"]{width:100% !important; }
			table[class="wrapperEmailBody"]{width:100% !important; }
			table[class="wrapperFooter"]{width:100% !important; }
			td[class="imgHero"] img{ width:100% !important;}
			.hideOnMobile {display:none !important; width:0; overflow:hidden;}
		}
	</style>

</head>

<body dir="rtl" style="background-color:#F9F9F9;">
<center>

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#F9F9F9;" id="bodyTable">
	<tr>
		<td align="center" valign="top" style="padding-right:10px;padding-left:10px;" id="bodyCell">
		<!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" style="width:600px;" width="300"><tr><td align="center" valign="top"><![endif]-->



		<!-- Email Wrapper Header Open //-->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;    margin-top: 50px;" width="100%" class="wrapperWebview">
			<tr>
				<td align="center" valign="top">
					<!-- Content Table Open // -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td align="center" valign="middle" style="padding-top:20px;padding-bottom:20px;    background: whitesmoke;" class="emailLogo">
								<!-- Logo and Link // -->
								<a href="#" target="_blank" style="text-decoration:none;">
									<img src="https://etmaam.com.sa/assets/front/img/logo.png" alt="" width="150" border="0" style="width:100%; max-width:150px;height:auto; display:block;"/>
								</a>
							</td>
						</tr>
					</table>
					<!-- Content Table Close // -->
				</td>
			</tr>
		</table>
		<!-- Email Wrapper Header Close //-->

		<!-- Email Wrapper Body Open // -->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperBody">
			<tr>
				<td align="center" valign="top">

					<!-- Table Card Open // -->
					<table border="0" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF;border-color:#E5E5E5; border-style:solid; border-width:0 1px 1px 1px;" width="100%" class="tableCard">



						<tr>
							<td align="center" valign="top" style="padding-bottom:40px ;padding-top: 40px;" class="imgHero">
								<!-- Hero Image // -->
								<a href="#" target="_blank" style="text-decoration:none;">
									<img src="https://etmaam.com.sa/assets/front/img/user-subscribe.png" width="300" alt="" border="0" style="width:100%; max-width:150px; height:auto; display:block;" />
								</a>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-bottom:5px;padding-left:20px;padding-right:20px;" class="mainTitle">
								<!-- Main Title Text // -->
								<h2 class="text" style="color:#000000;  font-size:28px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:36px; text-transform:none; text-align:center; padding:0; margin:0">
									مرحبا<span>"' . $request->fullname . '"</span>
								</h2>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-bottom:18px;padding-left:20px;padding-right:20px;" class="subTitle">
								<!-- Sub Title Text // -->
								<h4 class="text" style="color:#225476;  font-size:24px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
									لقد تم استقبال طلب الاشتراك في باقة بنجاح
								</h4>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-left:20px;padding-right:20px;padding-bottom:40px;" class="containtTable">

								<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription">
									<tr>
										<td align="center" valign="top" style="padding-bottom:20px;" class="description">
											<!-- Description Text// -->
											<p class="text" style="color:#666666;  font-size:18px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:22px; text-transform:none; text-align:center; padding:0; margin:0">
												نشكركم على طلبكم وسيتم التواصل معكم
											</p>
										</td>
									</tr>
								</table>


							</td>
						</tr>




					</table>
					<!-- Table Card Close// -->

					<!-- Space -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
						<tr>
							<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
						</tr>
					</table>

				</td>
			</tr>
		</table>
		<!-- Email Wrapper Body Close // -->

		<!-- Email Wrapper Footer Open // -->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperFooter">
			<tr>
				<td align="center" valign="top">
					<!-- Content Table Open// -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
						<tr>
							<td align="center" valign="top" style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="socialLinks">
								<!-- Social Links (Facebook)// -->
								<a href="https://www.facebook.com/etmaam2/" target="_blank" style="display:inline-block;" class="facebook">
									<img src="https://etmaam.com.sa/assets/front/img/facebook.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
								<!-- Social Links (Twitter)// -->
								<a href="https://twitter.com/etmaam2" target="_blank" style="display:inline-block;" class="twitter">
									<img src="https://etmaam.com.sa/assets/front/img/twitter.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>

								<!-- Social Links (Instagram)// -->
								<a href="https://www.instagram.com/etmaam2/" target="_blank" style="display:inline-block;" class="instagram">
									<img src="https://etmaam.com.sa/assets/front/img/instagram.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
								<!-- Social Links (Linkdin)// -->
								<a href="https://www.linkedin.com/company/etmaam2" target="_blank" style="display:inline-block;" class="linkdin">
									<img src="https://etmaam.com.sa/assets/front/img/linkdin.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:10px;padding-bottom:5px;padding-left:10px;padding-right:10px;" class="brandInfo">
								<!-- Brand Information // -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;">&copy;&nbsp; اتمام للخدمات. | 2022 <span> المنطقة الوسطى - الرياض</span>
								</p>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:0px;padding-bottom:20px;padding-left:10px;padding-right:10px;" class="footerLinks">
								<!-- Use Full Links (Privacy Policy)// -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
									<a href="https://etmaam.com.sa/about" style="color:#777777;text-decoration:underline;" target="_blank"> ماذا عنا  </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/serv_req" style="color:#777777;text-decoration:underline;" target="_blank"> اطلب خدمة </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/" style="color:#777777;text-decoration:underline;" target="_blank"> الصفحة الرئيسية  </a>
								</p>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:0px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="footerEmailInfo">
								<!-- Information of NewsLetter (Subscribe Info)// -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
								اذا كان لديك اي استفسار يمكنك التواصل معنا <a href="mailto:info@etmaam.com.sa" style="color:#777777;text-decoration:underline;" target="_blank">info@etmaam.com.sa</a><br>
								</p>
							</td>
						</tr>



						<!-- Space -->
						<tr>
							<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
						</tr>
					</table>
					<!-- Content Table Close// -->
				</td>
			</tr>

			<!-- Space -->
			<tr>
				<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
			</tr>
		</table>
		<!-- Email Wrapper Footer Close // -->

		<!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
		</td>
	</tr>

</table>

</center>
</body>
</html>';
        } else {
            $userMsg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<!--[if (gte mso 9)|(IE)]>
	<xml>
		<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>etmam Email Template</title>

	<!-- Google Fonts Link -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

	<style type="text/css">

		/*------ Client-Specific Style ------ */
		@-ms-viewport{width:device-width;}
		table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;}
		img{-ms-interpolation-mode:bicubic; border: 0;}
		p, a, li, td, blockquote{mso-line-height-rule:exactly;}
		p, a, li, td, body, table, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%;}
		#outlook a{padding:0;}
		.ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
		.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td,img{line-height:100%;}

		/*------ Reset Style ------ */
		*{-webkit-text-size-adjust:none;-webkit-text-resize:100%;text-resize:100%;}
		table{border-spacing: 0 !important;}
		h1, h2, h3, h4, h5, h6, p{display:block; Margin:0; padding:0;}
		img, a img{border:0; height:auto; outline:none; text-decoration:none;}
		#bodyTable, #bodyCell{ margin:0; padding:0; width:100%;}
		body {height:100%; margin:0; padding:0; width:100%;}

		.appleLinks a {color: #c2c2c2 !important; text-decoration: none;}
        span.preheader { display: none !important; }

		/*------ Google Font Style ------ */
		[style*="Open Sans"],.text {font-family:"Open Sans", Helvetica, Arial, sans-serif !important;}
		/*------ General Style ------ */
		.wrapperWebview, .wrapperBody, .wrapperFooter{width:100%; max-width:600px; Margin:0 auto;}

		/*------ Column Layout Style ------ */
		.tableCard {text-align:center; font-size:0;}

		/*------ Images Style ------ */
		.imgHero img{ width:600px; height:auto; }

	</style>

	<style type="text/css">
		/*------ Media Width 480 ------ */
		@media screen and (max-width:640px) {
			table[class="wrapperWebview"]{width:100% !important; }
			table[class="wrapperEmailBody"]{width:100% !important; }
			table[class="wrapperFooter"]{width:100% !important; }
			td[class="imgHero"] img{ width:100% !important;}
			.hideOnMobile {display:none !important; width:0; overflow:hidden;}
		}
	</style>

</head>

<body dir="ltr" style="background-color:#F9F9F9;">
<center>

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#F9F9F9;" id="bodyTable">
	<tr>
		<td align="center" valign="top" style="padding-right:10px;padding-left:10px;" id="bodyCell">
		<!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" style="width:600px;" width="300"><tr><td align="center" valign="top"><![endif]-->



		<!-- Email Wrapper Header Open //-->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;    margin-top: 50px;" width="100%" class="wrapperWebview">
			<tr>
				<td align="center" valign="top">
					<!-- Content Table Open // -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td align="center" valign="middle" style="padding-top:20px;padding-bottom:20px;    background: whitesmoke;" class="emailLogo">
								<!-- Logo and Link // -->
								<a href="#" target="_blank" style="text-decoration:none;">
									<img src="https://etmaam.com.sa/assets/front/img/logo.png" alt="" width="150" border="0" style="width:100%; max-width:150px;height:auto; display:block;"/>
								</a>
							</td>
						</tr>
					</table>
					<!-- Content Table Close // -->
				</td>
			</tr>
		</table>
		<!-- Email Wrapper Header Close //-->

		<!-- Email Wrapper Body Open // -->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperBody">
			<tr>
				<td align="center" valign="top">

					<!-- Table Card Open // -->
					<table border="0" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF;border-color:#E5E5E5; border-style:solid; border-width:0 1px 1px 1px;" width="100%" class="tableCard">



						<tr>
							<td align="center" valign="top" style="padding-bottom:40px ;padding-top: 40px;" class="imgHero">
								<!-- Hero Image // -->
								<a href="#" target="_blank" style="text-decoration:none;">
									<img src="https://etmaam.com.sa/assets/front/img/user-subscribe.png" width="300" alt="" border="0" style="width:100%; max-width:150px; height:auto; display:block;" />
								</a>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-bottom:5px;padding-left:20px;padding-right:20px;" class="mainTitle">
								<!-- Main Title Text // -->
								<h2 class="text" style="color:#000000;  font-size:28px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:36px; text-transform:none; text-align:center; padding:0; margin:0">
									Dear <span>"' . $request->fullname . '"</span>
								</h2>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-bottom:18px;padding-left:20px;padding-right:20px;" class="subTitle">
								<!-- Sub Title Text // -->
								<h4 class="text" style="color:#225476;  font-size:24px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
									Your package request has been received successfully.
								</h4>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-left:20px;padding-right:20px;padding-bottom:40px;" class="containtTable">

								<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription">
									<tr>
										<td align="center" valign="top" style="padding-bottom:20px;" class="description">
											<!-- Description Text// -->
											<p class="text" style="color:#666666;  font-size:18px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:22px; text-transform:none; text-align:center; padding:0; margin:0">
												Thank you for your trust, our support will reach you shortly.
											</p>
										</td>
									</tr>
								</table>


							</td>
						</tr>




					</table>
					<!-- Table Card Close// -->

					<!-- Space -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
						<tr>
							<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
						</tr>
					</table>

				</td>
			</tr>
		</table>
		<!-- Email Wrapper Body Close // -->

		<!-- Email Wrapper Footer Open // -->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperFooter">
			<tr>
				<td align="center" valign="top">
					<!-- Content Table Open// -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
						<tr>
							<td align="center" valign="top" style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="socialLinks">
								<!-- Social Links (Facebook)// -->
								<a href="https://www.facebook.com/etmaam2/" target="_blank" style="display:inline-block;" class="facebook">
									<img src="https://etmaam.com.sa/assets/front/img/facebook.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
								<!-- Social Links (Twitter)// -->
								<a href="https://twitter.com/etmaam2" target="_blank" style="display:inline-block;" class="twitter">
									<img src="https://etmaam.com.sa/assets/front/img/twitter.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>

								<!-- Social Links (Instagram)// -->
								<a href="https://www.instagram.com/etmaam2/" target="_blank" style="display:inline-block;" class="instagram">
									<img src="https://etmaam.com.sa/assets/front/img/instagram.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
								<!-- Social Links (Linkdin)// -->
								<a href="https://www.linkedin.com/company/etmaam2" target="_blank" style="display:inline-block;" class="linkdin">
									<img src="https://etmaam.com.sa/assets/front/img/linkdin.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:10px;padding-bottom:5px;padding-left:10px;padding-right:10px;" class="brandInfo">
								<!-- Brand Information // -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;">&copy;&nbsp; Etmaam for Services | 2022 <span> Riyadh </span>
								</p>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:0px;padding-bottom:20px;padding-left:10px;padding-right:10px;" class="footerLinks">
								<!-- Use Full Links (Privacy Policy)// -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
									<a href="https://etmaam.com.sa/about" style="color:#777777;text-decoration:underline;" target="_blank"> About us  </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/serv_req" style="color:#777777;text-decoration:underline;" target="_blank"> Request Service </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/" style="color:#777777;text-decoration:underline;" target="_blank"> Home  </a>
								</p>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:0px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="footerEmailInfo">
								<!-- Information of NewsLetter (Subscribe Info)// -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
								For any inquiries, please email us at <a href="mailto:info@etmaam.com.sa" style="color:#777777;text-decoration:underline;" target="_blank">info@etmaam.com.sa</a><br>
								</p>
							</td>
						</tr>



						<!-- Space -->
						<tr>
							<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
						</tr>
					</table>
					<!-- Content Table Close// -->
				</td>
			</tr>

			<!-- Space -->
			<tr>
				<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
			</tr>
		</table>
		<!-- Email Wrapper Footer Close // -->

		<!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
		</td>
	</tr>

</table>

</center>
</body>
</html>';
        }

        $be = BasicExtended::first();


        $mail = new PHPMailer(true);

        if ($be->is_smtp == 1) {
            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                //                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = $be->smtp_host;                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = $be->smtp_username;                     // SMTP username
                $mail->Password   = $be->smtp_password;                               // SMTP password
                $mail->SMTPSecure = $be->encryption;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = $be->smtp_port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);


                $mail->addAddress($request->email);     // Add a recipient
                //    $mail->addAddress('bashar@etmaam.com.sa');     // Add a recipient

            } catch (Exception $e) {
                // die($e->getMessage());
            }
        } else {
            try {

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);

                $mail->addAddress($request->email);     // Add a recipient
                //      $mail->addAddress('bashar@etmaam.com.sa');
            } catch (Exception $e) {
                // die($e->getMessage());
            }
        }

        // Content
        //  $mail->AltBody = 'برنامه شما از این ایمیل پشتیبانی نمی کند، برای دیدن آن، لطفا از برنامه دیگری استفاده نمائید'; // متنی برای کاربرانی که نمی توانند ایمیل را به درستی مشاهده کنند
        $mail->CharSet = 'UTF-8';
        $mail->ContentType = 'text/html';
        $mail->isHTML(true);                                  // Set email format to HTML
        if ($currentLang->code == 'ar') {
            $mail->Subject = 'تم استقبال طلب الاشتراك في باقة..وسيتم التواصل معكم';
        } else {
            $mail->Subject = 'Your package request has been submitted';
        }

        $mail->Body    = $userMsg;

        $mail->send();
        $mail->clearAllRecipients();

        if ($be->is_smtp == 1) {
            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                //                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = $be->smtp_host;                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = $be->smtp_username;                     // SMTP username
                $mail->Password   = $be->smtp_password;                               // SMTP password
                $mail->SMTPSecure = $be->encryption;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = $be->smtp_port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);

                // Add a recipient
                $mail->addAddress('adham@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('ahmed.j@etmaam.com.sa');     // Add a recipient

                $mail->addAddress('customer_service@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('abdullah.o@etmaam.com.sa');     // Add a recipient

                $mail->addAddress('hedbah@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('sidra@etmaam.com.sa');
                $mail->addAddress('mohammed.h@etmaam.com.sa');

                $mail->addAddress('najat@etmaam.com.sa');
                // Add a recipient
                // Add a recipient
                $mail->addAddress('modhaf@etmaam.com.sa');     // Add a recipient
                // it emails
                $mail->addAddress('work@mohdabdulbari.com');     // Add a recipient
                $mail->addAddress('design@etmaam.com.sa');     // Add a recipient

            } catch (Exception $e) {
                // die($e->getMessage());
            }
        } else {
            try {

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);

                // Add a recipient
                $mail->addAddress('adham@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('ahmed.j@etmaam.com.sa');     // Add a recipient

                $mail->addAddress('customer_service@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('abdullah.o@etmaam.com.sa');     // Add a recipient

                $mail->addAddress('hedbah@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('sidra@etmaam.com.sa');
                $mail->addAddress('mohammed.h@etmaam.com.sa');

                $mail->addAddress('najat@etmaam.com.sa');
                // Add a recipient
                $mail->addAddress('modhaf@etmaam.com.sa');     // Add a recipient
                // it emails
                $mail->addAddress('work@mohdabdulbari.com');     // Add a recipient
                $mail->addAddress('design@etmaam.com.sa');     // Add a recipient
            } catch (Exception $e) {
                // die($e->getMessage());
            }
        }
        //   Mail::to($req->emp_email)->send(new App\Mail\NewServiceRequest($req));
        $mail->CharSet = 'UTF-8';
        $mail->ContentType = 'text/html';
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'طلب باقة جديد #' . $req->id . ' | ' . $request->company_name;
        $mail->Body    = $adminMsg;

        $mail->send();
        //   Mail::to($req->emp_email)->send(new App\Mail\NewServiceRequest($req));

        if ($currentLang->code == 'ar') {
            $data['msg_title'] = 'تم ارسال طلبك بنجاح';
            $data['msg'] = " نشكركم على طلبكم وسيتم التواصل معكم من قبل أحد المختصين في
                        مجال الباقة المطلوبة ";
        } else {
            $data['msg_title'] = 'Your request has been submitted Successfully';
            $data['msg'] = "Thank you for your request, We will get back to you";
        }
        return view('front.thanks', $data);
    }

    public function joinus()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;
        if ($currentLang->code == 'ar') {
            $data['cities'] = array("الرياض", "جدة", "مكة المكرمة", "المدينة المنورة", "الطائف", "الدمام", "الخبر", "تبوك", "الخرج", "بريدة", "خميس مشيط", "الهفوف", "المبرز", "حفر الباطن", "حائل", "نجران", "الجبيل", "أبها", "ينبع", "عنيزة", "عرعر", "سكاكا", "جازان", "القريات", "الظهران", "القطيف", "الباحة", "بيشة", "اخرى", "الدلم", "الدلم", "الدلم", "حوطه بني تميم", "الحريق", "الافلاج", "الخماسين", "السليل", "حريملاء", "ثادق", "رغبة", "ضرما", "المزاحمية", "مرات", "شقراء", "القصب", "ساجر", "الدوادمي", "القويعية", "عفيف", "الخاصرة", "رماح", "شوية", "المجمعة", "الزلفي", "الغاط", "الارطاويه", "سدير", "البدائع", "المذنب", "الرس", "البكيريه", "رياض الخبرا", "الأسياح", "شري", "الفوارة", "عقلة الصقور", "البطــين", "مــدرج", "الدليميــه", "البتــراء", "القـريـن", "الذيبية", "النبهانيه", "دخنة", "ام حــزم", "ضليع رشيد", "ضريه", "قبــه", "الخبرا", "السر", "ثرمداء", "حلبان", "ملهم", "القوارة", "وادي الدواسر", "الجمش", "البجادية", "الاحساء", "رحيمة", "النعيرية", "الخفجي", "السفانية", "بقيق", "الثقبة", "سيهات", "صفوى", "قريه", "رأس تنورة", "قرى الإحساء", "العقير", "سلوى", "الحنى", "حرض", "العيون", "عين دار", "القيصومة", "الرقعي", "الذيبية", "مدينة الملك خالد العسكرية", "سامودا", "ام قليب", "ابن طواله", "الصداوي", "السعيرة", "الحليقه", "بقعاء", "موقق", "ضرغط", "طابه", "الحايط", "قرى حائل", "جبه", "تربة-حائل", "الشملي", "الروضة", "الكهفة", "السليمي", "الخطة", "الشنان", "مدينة الأمير عدبالعزيز بن مساعد الاقتصادية (حائل)", "دومة الجندل", "طبرجل", "قارا", "صـــوير", "هــديـب", "الاضارع", "اللقـائـــط", "زلــــوم", "طريف", "رفحا", "حالة عمار", "الوجه", "حقل", "تيماء", "ضباء", "البدع", "شرما", "المويلح", "القحزه", "قيال", "الشرف", "مقنا", "الخريبة", "البئر", "الجهراء", "شواق", "القليبه", "البديعه", "الديسه", "المعظم", "فجر", "الروضة", "الخرمة", "تربة-الطائف", "بنى مالك", "رنيه", "المويه", "ظـــــــلم", "بحرة", "مستورة", "ذهبان", "عسفان", "ابو راكه", "بالحارث", "قياء", "ترعة ثقيف", "غزايل", "الليث", "رابغ", "القنفذة", "خليص", "الكامل", "مدركه", "الجمـوم", "الشـرائع", "مدينة الملك عبدالله الاقتصادية برابغ", "مدينة المعرفة الاقتصادية", "العلا", "المهد", "الحناكية", "الحسو", "الثمد", "العمق", "الشقران", "المليليح", "السويرقيه", "الفريش", "وادي الفرع", "خيبر", "الصلصلة", "الصويدرة", "الشقره", "ثرب", "لفه", "املج", "بدر", "الواسطة", "المسيجيد", "بلجرشي", "المندق", "بني حسن", "دوس", "القري", "المخواه", "غامد الزناد", "قلوي", "الشعـــــراء", "العقيق", "قرى الحجاز", "تثليث", "سراة عبيدة", "احد رفيدة", "ظهران الجنوب", "النماص", "محائل", "رجال ألمع", "تنومة", "بني عمرو", "المجاردة", "قناءوالبحر", "الربوعة", "القحمة", "جيزان", "ابو عريش", "الشقيري", "الريث الشقيق", "ضمد", "فيفا", "صبيا", "صامطة - الطوال", "فرسان", "الداير بني مالك", "هروب", "احد المسارحة - الخوبة", "شروره", "العبيله", "بدر الجنوب", "الوديعة", "حبونا", "يدمه", "مدينة جازان للصناعات الأساسية والتحويلية");
            $data['partners'] = array("مزود خدمة", "مستشار أعمال", "مستشار قانوني", "اخصائي خدمة عملاء", "محاسب", "مكتب خدمات إلكترونية", "مكتب محاسب قانوني", "مكتب زكاة وضريبة دخل", "شريك استراتيجي", "الإمتياز التجاري");
            array_multisort(array_map('strlen', $data['partners']), $data['partners']);
        } else {
            $data['cities'] = array("Riyadh", "Jeddah", "Mecca", "Medina", "Ta'if", "Dammam", "Khobar", "Tabuk", "Al-Kharj", "Buraydah", "Khamis Mushait", "Al-Hufuf", "Al-Mubarraz", "Hafar Al-Batin", "Ha'il", "Najran", "Jubail", "Abha", "Yanbu", "Unaizah", "Arar", "Sakakah", "Jazan", "Qurayyat", "Dhahran", "Al-Qatif", "Al-Baha", "Bishah", "Accra", "Ad-Dilam", "Hautat Bani Tamim", "Al-Hareeq", "Aflaj", "Al-khamasin", "Saleel", "Harimlaa", "Thadiq", "Ragbah", "Dharmaa", "Muzahmiyyah", "Marat", "Shaqraa", "Al-Qasab", "Sajir", "Dawadmi", "Quwaiyah", "Afeef", "Khasirah", "Remaah", "Shuwiyah", "Majma'ah", "Zulfi", "Al-Ghat", "Al-Artaweeiyah", "Sudair", "Al-Bada'a", "Al-Mithnab", "Al-Rass", "Al-Bukayriyah", "Riyadh Al-Khabra", "Al-Asyah", "Shiri", "Fawarah", "Aqlit Al-Sukour", "Al-Bateen", "Mudraj", "Dulaimiyah", "Al-Batraa", "Al-Qareen", "Thaibiyah", "Nabhaniyah", "Daknah", "Um Hazm", "Dali' Rasheed", "Diryah", "Qubbah", "Al-Khabra", "Al-Ssir", "Tharmadaa", "Halban", "Mulham", "Quwarah", "Wadi Al-Dawasir", "Al-Jamsh", "Bajadiyah", "Al-Hasa", "Rahima", "Nua'iriyah", "Al-Kafji", "Safaniyah", "Beqaiq", "Thuqbah", "Saihat", "Safwa", "Qaryah", "Ras Tanurah", "Al-Hasa Villages", "Uqair", "Salwa", "Al-Hana", "Harid", "Al-Oyoun", "Ain Dar", "Qaisumah", "Al-Raq'i", "Military city of king Khalid", "Samuda", "Um Qulaib", "Ibn Tawalah", "Sadawi", "Al-Sa'erah", "Al-Haliqah", "Buqa'a", "Moqiq", "Durghut", "Tabah", "Al-Ha'it", "Ha'il Villages", "Jibah", "Turbit Ha'il", "Al-Shamli", "Rawdah", "Al-Kahfa", "Sulaymi", "Al-Khotta", "Shinan", "Economic city of prince Abd Al-Aziz Bin musa'id (Ha'il)", "Dumat Al-Jandal", "Tabarjal", "Qarah", "Suwair", "Hudaid", "Al-Adar'i", "Al-Laqai't", "Zalloum", "Tareef", "Rafha", "Halit Ammar", "Al-Wajh", "Haqil", "Taima'a", "Diba'a", "Al-Bid'a", "Sharma", "Muwilih", "Kahza", "Qiyal", "Al-Shuruf", "Miqna", "Kuraybah", "Al-Bi'er", "Jahraa", "Shiwaq", "Qulaybah", "Badi'a", "Al-Disah", "Mu'atham", "Fajir", "Al-Khirmah", "Turbit Al-Ta'if", "Bani Malik", "Rinaih", "Al-Moyah", "Thulam", "Bahrah", "Mastourah", "Thahban", "Asfan", "Abu Rakah", "Bilharith", "Qiya'a", "Tir'it Thaqif", "Ghazail", "Al-Laith", "Rabigh", "Qunfuthah", "Khulais", "Al-Kamil", "Mudrakah", "Al-Jumum", "Al-Sharai'", "Economic city of king Abdullah (Rabigh)", "Economic city of knowledge", "Al-Ula", "Al-Mahd", "Al-Hanakiya", "Al-Hasew", "Al-Thamid", "Al-Omiq", "Shaqran", "Mulailih", "Swairqiyah", "Al-Farish", "Wadi Al-Firi'", "Khaybar", "Salsa", "Suwiydrah", "Thirib", "Laffih", "Amlaj", "Badr", "Al-Wasitah", "Musayjid", "Biljarshi", "Al-Minduq", "Bani Hassan", "Doos", "Al-Qirri", "Mikwah", "Ghamid Al-Zinad", "Qalawi", "Sha'raa", "Al-Aqeeq", "Al-Hijaz Villages", "Tathlith", "Surat Obaydah", "Ohud Rafidah", "Dhahran Al-Janoub", "Al-Nammas", "Muhai'l", "Rijal Alm'a", "Tannumah", "Bani Amro", "Al-Majardah", "Qina' Wilbahir", "Rabboa'a", "Al-Qahmah", "Jizan", "Abu Areesh", "Al-Shuqayri", "Al-Raith AL-Shaqiq", "Dumd", "Fifa", "Sibya", "Samtit Al-Tiwal", "Farasan", "Dayer Bani Malik", "Huroub", "Ohud Al-Masariha - Al-Khoba", "Shrurah", "Al-Obaylah", "Badr Al-Janoub", "Al-Wadi'a", "Hubunah", "Yedma", "Jazan city of basic and transformed industries");
            $data['partners'] = array("Service Provider", "Business Consultant", "Counsel", "Customer Service Specialist", "Accountant", "eServices office", "Chartered accountant office", "Zakat and Income tax office", "Strategic Partner", "Franchise");
            array_multisort(array_map('strlen', $data['partners']), $data['partners']);
        }
        $data['categories'] = \App\RequestCategory::where('language_id', $currentLang->id)->where('cat_id', 0)->get();
        // dd($data);
        App::setLocale($currentLang->code);

        $version = $be->theme_version;
        $data['version'] = $version == 'dark' ? 'default' : $version;
        return view('front.joinus', $data);
    }


    public function store_joinus(Request $request)
    {

        // FIX SPAM FORMS IF THIS INPUT IS NOT EMPTY SO WILL DIE;
        if ($request->secure) {
            return redirect()->back()->withErrors('Your form has been submitted');
        }

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        App::setLocale($currentLang->code);


        $rules = [
            'mobile' => 'required',
            'email' => 'required|email:rfc,dns',
            'city' => 'required',
            'notes' => 'required|max:1000',
            'suggested_time' => 'required',
            'partner_type' => 'required',
            'docs.*' => 'mimes:jpg,bmp,png,pdf,doc,docs,ppt,ppt,pptx,xlsx,xls,csv,jpeg',
            'fullname' => 'required'
        ];







        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            // dd($validator->errors());
            return redirect()->back()->withErrors($validator->errors())->withInput();

            //  return redirect()->back(($validator->errors());
        }





        // \Illuminate\Support\Facades\Session::flash('success', 'Service added successfully!');

        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;

        //$data['categories'] = \App\RequestCategory::where('language_id', $currentLang->id)->where('cat_id',0)->get();
        // dd($data);
        //dd(request()->all());
        $version = $be->theme_version;
        $data['version'] = $version == 'dark' ? 'default' : $version;
        // dd(request()->all());
        $req = new \App\Partnership;
        $req->emp_name = $request->fullname;
        $req->company_name = $request->company_name;
        $req->cr = $request->cr;
        $req->emp_mobile = $request->mobile;
        $req->emp_email = $request->email;
        $req->company_type = $request->partner_type;
        $req->company_city = $request->city;
        $req->suitable_time = $request->suggested_time;
        $req->notes = $request->notes;
        $req->language_id = $currentLang->id;
        $now = Carbon::now();
        $code = "F-" . rand(10000, 99999);
        $req->uuid = $code;
        $req->save();


        $adminMsg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<!--[if (gte mso 9)|(IE)]>
	<xml>
		<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>etmam Email Template</title>

	<!-- Google Fonts Link -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

	<style type="text/css">

		/*------ Client-Specific Style ------ */
		@-ms-viewport{width:device-width;}
		table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;}
		img{-ms-interpolation-mode:bicubic; border: 0;}
		p, a, li, td, blockquote{mso-line-height-rule:exactly;}
		p, a, li, td, body, table, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%;}
		#outlook a{padding:0;}
		.ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
		.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td,img{line-height:100%;}

		/*------ Reset Style ------ */
		*{-webkit-text-size-adjust:none;-webkit-text-resize:100%;text-resize:100%;}
		table{border-spacing: 0 !important;}
		h1, h2, h3, h4, h5, h6, p{display:block; Margin:0; padding:0;}
		img, a img{border:0; height:auto; outline:none; text-decoration:none;}
		#bodyTable, #bodyCell{ margin:0; padding:0; width:100%;}
		body {height:100%; margin:0; padding:0; width:100%;}

		.appleLinks a {color: #c2c2c2 !important; text-decoration: none;}
		span.preheader { display: none !important; }

		/*------ Google Font Style ------ */
		[style*="Open Sans"],.text {font-family:"Open Sans", Helvetica, Arial, sans-serif !important;}
		/*------ General Style ------ */
		.wrapperWebview, .wrapperBody, .wrapperFooter{width:100%; max-width:600px; Margin:0 auto;}

		/*------ Column Layout Style ------ */
		.tableCard {text-align:center; font-size:0;}

		/*------ Images Style ------ */
		.imgHero img{ width:600px; height:auto; }

	</style>

	<style type="text/css">
		/*------ Media Width 480 ------ */
		@media screen and (max-width:640px) {
			table[class="wrapperWebview"]{width:100% !important; }
			table[class="wrapperEmailBody"]{width:100% !important; }
			table[class="wrapperFooter"]{width:100% !important; }
			td[class="imgHero"] img{ width:100% !important;}
			.hideOnMobile {display:none !important; width:0; overflow:hidden;}
		}
	</style>

</head>

<body dir="rtl" style="background-color:#F9F9F9;">
<center>

	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#F9F9F9;" id="bodyTable">
		<tr>
			<td align="center" valign="top" style="padding-right:10px;padding-left:10px;" id="bodyCell">
				<!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" style="width:600px;" width="300"><tr><td align="center" valign="top"><![endif]-->



				<!-- Email Wrapper Header Open //-->
				<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;    margin-top: 50px;" width="100%" class="wrapperWebview">
					<tr>
						<td align="center" valign="top">
							<!-- Content Table Open // -->
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td align="center" valign="middle" style="padding-top:20px;padding-bottom:20px;    background: whitesmoke;" class="emailLogo">
										<!-- Logo and Link // -->
										<a href="#" target="_blank" style="text-decoration:none;">
											<img src="https://etmaam.com.sa/assets/front/img/logo.png" alt="" width="150" border="0" style="width:100%; max-width:150px;height:auto; display:block;"/>
										</a>
									</td>
								</tr>
							</table>
							<!-- Content Table Close // -->
						</td>
					</tr>
				</table>
				<!-- Email Wrapper Header Close //-->

				<!-- Email Wrapper Body Open // -->
				<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperBody">
					<tr>
						<td align="center" valign="top">

							<!-- Table Card Open // -->
							<table border="0" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF;border-color:#E5E5E5; border-style:solid; border-width:0 1px 1px 1px;" width="100%" class="tableCard">



								<tr>
									<td align="center" valign="top" style="padding-bottom:40px ;padding-top: 40px;" class="imgHero">
										<!-- Hero Image // -->
										<a href="#" target="_blank" style="text-decoration:none;">
											<img src="https://etmaam.com.sa/assets/front/img/user-subscribe.png" width="300" alt="" border="0" style="width:100%; max-width:150px; height:auto; display:block;" />
										</a>
									</td>
								</tr>

								<tr>
									<td align="center" valign="top" style="padding-bottom:5px;padding-left:20px;padding-right:20px;" class="mainTitle">
										<!-- Main Title Text // -->
										<h2 class="text" style="color:#000000; font-size:28px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:36px; text-transform:none; text-align:center; padding:0; margin:0">
											طلب انضمام جديد #' . $req->id . ' | ' . $request->fullname . '
										</h2>
									</td>
								</tr>

								<tr>
									<td align="center" valign="top" style="padding-bottom:18px;padding-left:20px;padding-right:20px;" class="subTitle">
										<!-- Sub Title Text // -->
										<h4 class="text" style="color:#225476; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											 اسم المنشأة
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											' . $request->company_name . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											رقم السجل
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											' . $request->cr . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											اسم المسؤول
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											' . $request->fullname . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											رقم الجوال
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											' . $request->mobile . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											البريد الإلكتروني
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											' . $request->email . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											المدينة
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											' . $request->city . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											الوقت المناسب للتواصل
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											' . $request->suggested_time . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
										نوع الشريك
										</h4>
										<h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
										' . $request->partner_type . '
										</h4>
										<h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
											 الملاحظات:
										</h4>

									</td>
								</tr>

								<tr>
									<td align="center" valign="top" style="padding-left:20px;padding-right:20px;padding-bottom:40px;" class="containtTable">

										<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription">
											<tr>
												<td align="center" valign="top" style="padding-bottom:20px;" class="description">
													<!-- Description Text// -->
													<p class="text" style="width:500px;color:#666666; font-size:18px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:22px; text-transform:none; text-align:center; padding:0; margin:0">
														' . $request->notes . '
													</p>
												</td>
											</tr>
										</table>


									</td>
								</tr>




							</table>
							<!-- Table Card Close// -->

							<!-- Space -->
							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
								<tr>
									<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
								</tr>
							</table>

						</td>
					</tr>
				</table>
				<!-- Email Wrapper Body Close // -->

				<!-- Email Wrapper Footer Open // -->
				<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperFooter">
					<tr>
						<td align="center" valign="top">
							<!-- Content Table Open// -->
							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
								<tr>
									<td align="center" valign="top" style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="socialLinks">
										<!-- Social Links (Facebook)// -->
										<a href="https://www.facebook.com/etmaam2/" target="_blank" style="display:inline-block;" class="facebook">
											<img src="https://etmaam.com.sa/assets/front/img/facebook.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
										</a>
										<!-- Social Links (Twitter)// -->
										<a href="https://twitter.com/etmaam2" target="_blank" style="display:inline-block;" class="twitter">
											<img src="https://etmaam.com.sa/assets/front/img/twitter.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
										</a>

										<!-- Social Links (Instagram)// -->
										<a href="https://www.instagram.com/etmaam2/" target="_blank" style="display:inline-block;" class="instagram">
											<img src="https://etmaam.com.sa/assets/front/img/instagram.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
										</a>
										<!-- Social Links (Linkdin)// -->
										<a href="https://www.linkedin.com/company/etmaam2" target="_blank" style="display:inline-block;" class="linkdin">
											<img src="https://etmaam.com.sa/assets/front/img/linkdin.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
										</a>
									</td>
								</tr>

								<tr>
									<td align="center" valign="top" style="padding-top:10px;padding-bottom:5px;padding-left:10px;padding-right:10px;" class="brandInfo">
										<!-- Brand Information // -->
										<p class="text" style="color:#777777; font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;">&copy;&nbsp; اتمام للخدمات. | 2022 <span> المنطقة الوسطى - الرياض</span>
										</p>
									</td>
								</tr>

								<tr>
									<td align="center" valign="top" style="padding-top:0px;padding-bottom:20px;padding-left:10px;padding-right:10px;" class="footerLinks">
										<!-- Use Full Links (Privacy Policy)// -->
										<p class="text" style="color:#777777; font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
										<a href="https://etmaam.com.sa/about" style="color:#777777;text-decoration:underline;" target="_blank"> ماذا عنا  </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/serv_req" style="color:#777777;text-decoration:underline;" target="_blank"> اطلب خدمة </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/" style="color:#777777;text-decoration:underline;" target="_blank"> الصفحة الرئيسية  </a>
										</p>
									</td>
								</tr>

								<tr>
									<td align="center" valign="top" style="padding-top:0px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="footerEmailInfo">
										<!-- Information of NewsLetter (Subscribe Info)// -->
										<p class="text" style="color:#777777; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
										اذا كان لديك اي استفسار يمكنك التواصل معنا <a href="mailto:info@etmaam.com.sa" style="color:#777777;text-decoration:underline;" target="_blank">info@etmaam.com.sa</a><br>
										</p>
									</td>
								</tr>



								<!-- Space -->
								<tr>
									<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
								</tr>
							</table>
							<!-- Content Table Close// -->
						</td>
					</tr>

					<!-- Space -->
					<tr>
						<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
					</tr>
				</table>
				<!-- Email Wrapper Footer Close // -->

				<!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
			</td>
		</tr>
	</table>

</center>
</body>
</html>';

        if ($currentLang->code == 'ar') {
            $userMsg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<!--[if (gte mso 9)|(IE)]>
	<xml>
		<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>etmam Email Template</title>

	<!-- Google Fonts Link -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

	<style type="text/css">

		/*------ Client-Specific Style ------ */
		@-ms-viewport{width:device-width;}
		table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;}
		img{-ms-interpolation-mode:bicubic; border: 0;}
		p, a, li, td, blockquote{mso-line-height-rule:exactly;}
		p, a, li, td, body, table, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%;}
		#outlook a{padding:0;}
		.ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
		.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td,img{line-height:100%;}

		/*------ Reset Style ------ */
		*{-webkit-text-size-adjust:none;-webkit-text-resize:100%;text-resize:100%;}
		table{border-spacing: 0 !important;}
		h1, h2, h3, h4, h5, h6, p{display:block; Margin:0; padding:0;}
		img, a img{border:0; height:auto; outline:none; text-decoration:none;}
		#bodyTable, #bodyCell{ margin:0; padding:0; width:100%;}
		body {height:100%; margin:0; padding:0; width:100%;}

		.appleLinks a {color: #c2c2c2 !important; text-decoration: none;}
        span.preheader { display: none !important; }

		/*------ Google Font Style ------ */
		[style*="Open Sans"],.text {font-family:"Open Sans", Helvetica, Arial, sans-serif !important;}
		/*------ General Style ------ */
		.wrapperWebview, .wrapperBody, .wrapperFooter{width:100%; max-width:600px; Margin:0 auto;}

		/*------ Column Layout Style ------ */
		.tableCard {text-align:center; font-size:0;}

		/*------ Images Style ------ */
		.imgHero img{ width:600px; height:auto; }

	</style>

	<style type="text/css">
		/*------ Media Width 480 ------ */
		@media screen and (max-width:640px) {
			table[class="wrapperWebview"]{width:100% !important; }
			table[class="wrapperEmailBody"]{width:100% !important; }
			table[class="wrapperFooter"]{width:100% !important; }
			td[class="imgHero"] img{ width:100% !important;}
			.hideOnMobile {display:none !important; width:0; overflow:hidden;}
		}
	</style>

</head>

<body dir="rtl" style="background-color:#F9F9F9;">
<center>

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#F9F9F9;" id="bodyTable">
	<tr>
		<td align="center" valign="top" style="padding-right:10px;padding-left:10px;" id="bodyCell">
		<!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" style="width:600px;" width="300"><tr><td align="center" valign="top"><![endif]-->



		<!-- Email Wrapper Header Open //-->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;    margin-top: 50px;" width="100%" class="wrapperWebview">
			<tr>
				<td align="center" valign="top">
					<!-- Content Table Open // -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td align="center" valign="middle" style="padding-top:20px;padding-bottom:20px;    background: whitesmoke;" class="emailLogo">
								<!-- Logo and Link // -->
								<a href="#" target="_blank" style="text-decoration:none;">
									<img src="https://etmaam.com.sa/assets/front/img/logo.png" alt="" width="150" border="0" style="width:100%; max-width:150px;height:auto; display:block;"/>
								</a>
							</td>
						</tr>
					</table>
					<!-- Content Table Close // -->
				</td>
			</tr>
		</table>
		<!-- Email Wrapper Header Close //-->

		<!-- Email Wrapper Body Open // -->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperBody">
			<tr>
				<td align="center" valign="top">

					<!-- Table Card Open // -->
					<table border="0" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF;border-color:#E5E5E5; border-style:solid; border-width:0 1px 1px 1px;" width="100%" class="tableCard">



						<tr>
							<td align="center" valign="top" style="padding-bottom:40px ;padding-top: 40px;" class="imgHero">
								<!-- Hero Image // -->
								<a href="#" target="_blank" style="text-decoration:none;">
									<img src="https://etmaam.com.sa/assets/front/img/user-subscribe.png" width="300" alt="" border="0" style="width:100%; max-width:150px; height:auto; display:block;" />
								</a>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-bottom:5px;padding-left:20px;padding-right:20px;" class="mainTitle">
								<!-- Main Title Text // -->
								<h2 class="text" style="color:#000000;  font-size:28px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:36px; text-transform:none; text-align:center; padding:0; margin:0">
									مرحبا<span>"' . $request->fullname . '"</span>
								</h2>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-bottom:18px;padding-left:20px;padding-right:20px;" class="subTitle">
								<!-- Sub Title Text // -->
								<h4 class="text" style="color:#225476;  font-size:24px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
									لقد تم استقبال طلب الانضمام بنجاح
								</h4>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-left:20px;padding-right:20px;padding-bottom:40px;" class="containtTable">

								<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription">
									<tr>
										<td align="center" valign="top" style="padding-bottom:20px;" class="description">
											<!-- Description Text// -->
											<p class="text" style="color:#666666;  font-size:18px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:22px; text-transform:none; text-align:center; padding:0; margin:0">
												نشكركم على طلبكم وسيتم التواصل معكم
											</p>
										</td>
									</tr>
								</table>


							</td>
						</tr>




					</table>
					<!-- Table Card Close// -->

					<!-- Space -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
						<tr>
							<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
						</tr>
					</table>

				</td>
			</tr>
		</table>
		<!-- Email Wrapper Body Close // -->

		<!-- Email Wrapper Footer Open // -->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperFooter">
			<tr>
				<td align="center" valign="top">
					<!-- Content Table Open// -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
						<tr>
							<td align="center" valign="top" style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="socialLinks">
								<!-- Social Links (Facebook)// -->
								<a href="https://www.facebook.com/etmaam2/" target="_blank" style="display:inline-block;" class="facebook">
									<img src="https://etmaam.com.sa/assets/front/img/facebook.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
								<!-- Social Links (Twitter)// -->
								<a href="https://twitter.com/etmaam2" target="_blank" style="display:inline-block;" class="twitter">
									<img src="https://etmaam.com.sa/assets/front/img/twitter.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>

								<!-- Social Links (Instagram)// -->
								<a href="https://www.instagram.com/etmaam2/" target="_blank" style="display:inline-block;" class="instagram">
									<img src="https://etmaam.com.sa/assets/front/img/instagram.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
								<!-- Social Links (Linkdin)// -->
								<a href="https://www.linkedin.com/company/etmaam2" target="_blank" style="display:inline-block;" class="linkdin">
									<img src="https://etmaam.com.sa/assets/front/img/linkdin.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:10px;padding-bottom:5px;padding-left:10px;padding-right:10px;" class="brandInfo">
								<!-- Brand Information // -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;">&copy;&nbsp; اتمام للخدمات. | 2022 <span> المنطقة الوسطى - الرياض</span>
								</p>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:0px;padding-bottom:20px;padding-left:10px;padding-right:10px;" class="footerLinks">
								<!-- Use Full Links (Privacy Policy)// -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
									<a href="https://etmaam.com.sa/about" style="color:#777777;text-decoration:underline;" target="_blank"> ماذا عنا  </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/serv_req" style="color:#777777;text-decoration:underline;" target="_blank"> اطلب خدمة </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/" style="color:#777777;text-decoration:underline;" target="_blank"> الصفحة الرئيسية  </a>
								</p>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:0px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="footerEmailInfo">
								<!-- Information of NewsLetter (Subscribe Info)// -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
								اذا كان لديك اي استفسار يمكنك التواصل معنا <a href="mailto:info@etmaam.com.sa" style="color:#777777;text-decoration:underline;" target="_blank">info@etmaam.com.sa</a><br>
								</p>
							</td>
						</tr>



						<!-- Space -->
						<tr>
							<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
						</tr>
					</table>
					<!-- Content Table Close// -->
				</td>
			</tr>

			<!-- Space -->
			<tr>
				<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
			</tr>
		</table>
		<!-- Email Wrapper Footer Close // -->

		<!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
		</td>
	</tr>

</table>

</center>
</body>
</html>';
        } else {
            $userMsg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<!--[if (gte mso 9)|(IE)]>
	<xml>
		<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>etmam Email Template</title>

	<!-- Google Fonts Link -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

	<style type="text/css">

		/*------ Client-Specific Style ------ */
		@-ms-viewport{width:device-width;}
		table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;}
		img{-ms-interpolation-mode:bicubic; border: 0;}
		p, a, li, td, blockquote{mso-line-height-rule:exactly;}
		p, a, li, td, body, table, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%;}
		#outlook a{padding:0;}
		.ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
		.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td,img{line-height:100%;}

		/*------ Reset Style ------ */
		*{-webkit-text-size-adjust:none;-webkit-text-resize:100%;text-resize:100%;}
		table{border-spacing: 0 !important;}
		h1, h2, h3, h4, h5, h6, p{display:block; Margin:0; padding:0;}
		img, a img{border:0; height:auto; outline:none; text-decoration:none;}
		#bodyTable, #bodyCell{ margin:0; padding:0; width:100%;}
		body {height:100%; margin:0; padding:0; width:100%;}

		.appleLinks a {color: #c2c2c2 !important; text-decoration: none;}
        span.preheader { display: none !important; }

		/*------ Google Font Style ------ */
		[style*="Open Sans"],.text {font-family:"Open Sans", Helvetica, Arial, sans-serif !important;}
		/*------ General Style ------ */
		.wrapperWebview, .wrapperBody, .wrapperFooter{width:100%; max-width:600px; Margin:0 auto;}

		/*------ Column Layout Style ------ */
		.tableCard {text-align:center; font-size:0;}

		/*------ Images Style ------ */
		.imgHero img{ width:600px; height:auto; }

	</style>

	<style type="text/css">
		/*------ Media Width 480 ------ */
		@media screen and (max-width:640px) {
			table[class="wrapperWebview"]{width:100% !important; }
			table[class="wrapperEmailBody"]{width:100% !important; }
			table[class="wrapperFooter"]{width:100% !important; }
			td[class="imgHero"] img{ width:100% !important;}
			.hideOnMobile {display:none !important; width:0; overflow:hidden;}
		}
	</style>

</head>

<body dir="ltr" style="background-color:#F9F9F9;">
<center>

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#F9F9F9;" id="bodyTable">
	<tr>
		<td align="center" valign="top" style="padding-right:10px;padding-left:10px;" id="bodyCell">
		<!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" style="width:600px;" width="300"><tr><td align="center" valign="top"><![endif]-->



		<!-- Email Wrapper Header Open //-->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;    margin-top: 50px;" width="100%" class="wrapperWebview">
			<tr>
				<td align="center" valign="top">
					<!-- Content Table Open // -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td align="center" valign="middle" style="padding-top:20px;padding-bottom:20px;    background: whitesmoke;" class="emailLogo">
								<!-- Logo and Link // -->
								<a href="#" target="_blank" style="text-decoration:none;">
									<img src="https://etmaam.com.sa/assets/front/img/logo.png" alt="" width="150" border="0" style="width:100%; max-width:150px;height:auto; display:block;"/>
								</a>
							</td>
						</tr>
					</table>
					<!-- Content Table Close // -->
				</td>
			</tr>
		</table>
		<!-- Email Wrapper Header Close //-->

		<!-- Email Wrapper Body Open // -->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperBody">
			<tr>
				<td align="center" valign="top">

					<!-- Table Card Open // -->
					<table border="0" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF;border-color:#E5E5E5; border-style:solid; border-width:0 1px 1px 1px;" width="100%" class="tableCard">



						<tr>
							<td align="center" valign="top" style="padding-bottom:40px ;padding-top: 40px;" class="imgHero">
								<!-- Hero Image // -->
								<a href="#" target="_blank" style="text-decoration:none;">
									<img src="https://etmaam.com.sa/assets/front/img/user-subscribe.png" width="300" alt="" border="0" style="width:100%; max-width:150px; height:auto; display:block;" />
								</a>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-bottom:5px;padding-left:20px;padding-right:20px;" class="mainTitle">
								<!-- Main Title Text // -->
								<h2 class="text" style="color:#000000;  font-size:28px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:36px; text-transform:none; text-align:center; padding:0; margin:0">
									Dear <span>"' . $request->fullname . '"</span>
								</h2>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-bottom:18px;padding-left:20px;padding-right:20px;" class="subTitle">
								<!-- Sub Title Text // -->
								<h4 class="text" style="color:#225476;  font-size:24px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
									Your partnership request has been received successfully.
								</h4>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-left:20px;padding-right:20px;padding-bottom:40px;" class="containtTable">

								<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription">
									<tr>
										<td align="center" valign="top" style="padding-bottom:20px;" class="description">
											<!-- Description Text// -->
											<p class="text" style="color:#666666;  font-size:18px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:22px; text-transform:none; text-align:center; padding:0; margin:0">
												Thank you for your trust, our concerned department will reach you shortly.
											</p>
										</td>
									</tr>
								</table>


							</td>
						</tr>




					</table>
					<!-- Table Card Close// -->

					<!-- Space -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
						<tr>
							<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
						</tr>
					</table>

				</td>
			</tr>
		</table>
		<!-- Email Wrapper Body Close // -->

		<!-- Email Wrapper Footer Open // -->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperFooter">
			<tr>
				<td align="center" valign="top">
					<!-- Content Table Open// -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
						<tr>
							<td align="center" valign="top" style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="socialLinks">
								<!-- Social Links (Facebook)// -->
								<a href="https://www.facebook.com/etmaam2/" target="_blank" style="display:inline-block;" class="facebook">
									<img src="https://etmaam.com.sa/assets/front/img/facebook.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
								<!-- Social Links (Twitter)// -->
								<a href="https://twitter.com/etmaam2" target="_blank" style="display:inline-block;" class="twitter">
									<img src="https://etmaam.com.sa/assets/front/img/twitter.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>

								<!-- Social Links (Instagram)// -->
								<a href="https://www.instagram.com/etmaam2/" target="_blank" style="display:inline-block;" class="instagram">
									<img src="https://etmaam.com.sa/assets/front/img/instagram.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
								<!-- Social Links (Linkdin)// -->
								<a href="https://www.linkedin.com/company/etmaam2" target="_blank" style="display:inline-block;" class="linkdin">
									<img src="https://etmaam.com.sa/assets/front/img/linkdin.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:10px;padding-bottom:5px;padding-left:10px;padding-right:10px;" class="brandInfo">
								<!-- Brand Information // -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;">&copy;&nbsp; Etmaam for Services | 2022 <span> Riyadh </span>
								</p>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:0px;padding-bottom:20px;padding-left:10px;padding-right:10px;" class="footerLinks">
								<!-- Use Full Links (Privacy Policy)// -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
									<a href="https://etmaam.com.sa/about" style="color:#777777;text-decoration:underline;" target="_blank"> About us  </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/serv_req" style="color:#777777;text-decoration:underline;" target="_blank"> Request Service </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/" style="color:#777777;text-decoration:underline;" target="_blank"> Home  </a>
								</p>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:0px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="footerEmailInfo">
								<!-- Information of NewsLetter (Subscribe Info)// -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
								For any inquiries, please email us at <a href="mailto:info@etmaam.com.sa" style="color:#777777;text-decoration:underline;" target="_blank">info@etmaam.com.sa</a><br>
								</p>
							</td>
						</tr>



						<!-- Space -->
						<tr>
							<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
						</tr>
					</table>
					<!-- Content Table Close// -->
				</td>
			</tr>

			<!-- Space -->
			<tr>
				<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
			</tr>
		</table>
		<!-- Email Wrapper Footer Close // -->

		<!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
		</td>
	</tr>

</table>

</center>
</body>
</html>';
        }


        $be = BasicExtended::first();


        $mail = new PHPMailer(true);

        if ($be->is_smtp == 1) {
            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                //                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = $be->smtp_host;                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = $be->smtp_username;                     // SMTP username
                $mail->Password   = $be->smtp_password;                               // SMTP password
                $mail->SMTPSecure = $be->encryption;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = $be->smtp_port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);


                $mail->addAddress($request->email);     // Add a recipient
                //    $mail->addAddress('bashar@etmaam.com.sa');     // Add a recipient

            } catch (Exception $e) {
                // die($e->getMessage());
            }
        } else {
            try {

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);

                $mail->addAddress($request->email);     // Add a recipient
                //      $mail->addAddress('bashar@etmaam.com.sa');
            } catch (Exception $e) {
                // die($e->getMessage());
            }
        }

        // Content
        //  $mail->AltBody = 'برنامه شما از این ایمیل پشتیبانی نمی کند، برای دیدن آن، لطفا از برنامه دیگری استفاده نمائید'; // متنی برای کاربرانی که نمی توانند ایمیل را به درستی مشاهده کنند
        $mail->CharSet = 'UTF-8';
        $mail->ContentType = 'text/html';
        $mail->isHTML(true);
        // Set email format to HTML
        if ($currentLang->code == 'ar') {
            $mail->Subject = 'تم استقبال طلب الإنضمام..وسيتم التواصل معكم';
        } else {
            $mail->Subject = 'Your partnership request has been submitted';
        }

        $mail->Body    = $userMsg;

        $mail->send();
        $mail->clearAllRecipients();

        if ($be->is_smtp == 1) {
            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                //                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = $be->smtp_host;                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = $be->smtp_username;                     // SMTP username
                $mail->Password   = $be->smtp_password;                               // SMTP password
                $mail->SMTPSecure = $be->encryption;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = $be->smtp_port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);


                // Add a recipient
                $mail->addAddress('adham@etmaam.com.sa');     // Add a
                $mail->addAddress('ahmed.j@etmaam.com.sa');     // Add a recipient

                $mail->addAddress('customer_service@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('abdullah.o@etmaam.com.sa');     // Add a recipient

                $mail->addAddress('hedbah@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('sidra@etmaam.com.sa');
                $mail->addAddress('mohammed.h@etmaam.com.sa');

                $mail->addAddress('najat@etmaam.com.sa');
                // Add a recipient
                $mail->addAddress('modhaf@etmaam.com.sa');     // Add a recipient
                // it emails
                $mail->addAddress('design@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('kamal.j@etmaam.com.sa');     // Add a recipient

                // $mail->addAddress('bashar@etmaam.com.sa');     // Add a recipient

            } catch (Exception $e) {
                // die($e->getMessage());
            }
        } else {
            try {

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);

                // Add a recipient
                $mail->addAddress('adham@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('ahmed.j@etmaam.com.sa');     // Add a recipient

                $mail->addAddress('customer_service@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('abdullah.o@etmaam.com.sa');     // Add a recipient

                $mail->addAddress('hedbah@etmaam.com.sa');     // Add a recipient
                $mail->addAddress('sidra@etmaam.com.sa');
                $mail->addAddress('mohammed.h@etmaam.com.sa');

                $mail->addAddress('najat@etmaam.com.sa');
                // Add a recipient
                $mail->addAddress('modhaf@etmaam.com.sa');     // Add a recipient
                // it emails
                $mail->addAddress('design@etmaam.com.sa');     // Add a recipient
                // $mail->addAddress('bashar@etmaam.com.sa');     // Add a recipient
            } catch (Exception $e) {
                // die($e->getMessage());
            }
        }
        //   Mail::to($req->emp_email)->send(new App\Mail\NewServiceRequest($req));
        $mail->CharSet = 'UTF-8';
        $mail->ContentType = 'text/html';
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'طلب انضمام جديد #' . $req->id . ' | ' . $request->company_name;
        $mail->Body    = $adminMsg;

        if ($request->hasFile('docs')) {
            for ($i = 0; $i < count($_FILES['docs']['name']); $i++) {
                $mail->AddAttachment($_FILES['docs']['tmp_name'][$i], $_FILES['docs']['name'][$i]);
            }
        }

        $mail->send();
        //   Mail::to($req->emp_email)->send(new App\Mail\NewServiceRequest($req));

        if ($currentLang->code == 'ar') {
            $data['msg_title'] = 'تم ارسال طلبك بنجاح';
            $data['msg'] = "نشكركم على طلب الانضمام وسيتم التواصل معكم بأقرب فرصة";
        } else {
            $data['msg_title'] = 'Your request has been submitted Successfully';
            $data['msg'] = "Thank you for your request, We will get back to you";
        }
        return view('front.thanks', $data);
    }

    public function services(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;


        $category = $request->category;
        $term = $request->term;

        if (!empty($category)) {
            $data['category'] = Scategory::findOrFail($category);
        }

        $data['services'] = Service::when($category, function ($query, $category) {
            return $query->where('scategory_id', $category);
        })->when($term, function ($query, $term) {
            return $query->where('title', 'like', '%' . $term . '%');
        })->when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC')->paginate(6);


        $version = $be->theme_version;

        if ($version == 'gym') {
            return view('front.gym.services', $data);
        } elseif ($version == 'car') {
            return view('front.car.services', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.services', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.services', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.services', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.services', $data);
        } elseif ($version == 'default' || $version == 'dark' || $version == 'ecommerce') {
            $data['version'] = $version == 'dark' ? 'default' : $version;
            return view('front.services', $data);
        }
    }
    public function test()
    {
        $now = Carbon::now();
        $code = "P1-" . $now->month . $now->year . '-' . rand(100000, 999999);
        dd($code);
    }

    public function packages()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;

        $data['categories'] = PackageCategory::where('language_id', $currentLang->id)
            ->where('status', 1)->orderBy('serial_number', 'ASC')->get();

        $data['packages'] = Package::when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC')->get();

        if (Auth::check()) {
            $data['activeSub'] = Subscription::where('user_id', Auth::user()->id)->where('status', 1);
        }

        $version = $be->theme_version;

        if ($version == 'gym') {
            return view('front.gym.packages', $data);
        } elseif ($version == 'car') {
            return view('front.car.packages', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.packages', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.packages', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.packages', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.packages', $data);
        } elseif ($version == 'default' || $version == 'dark' || $version == 'ecommerce') {
            $data['version'] = $version == 'dark' ? 'default' : $version;
            return view('front.packages', $data);
        }
    }

    public function causes(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $data['bs'] = $currentLang->basic_setting;
        $bex = $currentLang->basic_extra;
        if ($bex->is_donation == 0) {
            return back();
        }
        $be = $currentLang->basic_extended;
        $causes = Donation::query()
            ->where('lang_id', $currentLang->id)
            ->orderByDesc('id')
            ->paginate(6);
        $causes->map(function ($cause) use ($bex) {
            $raised_amount = DonationDetail::query()
                ->where('donation_id', '=', $cause->id)
                ->where('status', '=', "Success")
                ->sum('amount');
            $goal_percentage = $raised_amount > 0 ? (($raised_amount / $cause->goal_amount) * 100) : 0;
            $cause['raised_amount'] = $raised_amount > 0 ? round($raised_amount, 2) : 0;
            $cause['goal_percentage'] = round($goal_percentage, 1);
        });
        $data['causes'] = $causes;
        $data['bex'] = $bex;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;
        return view('front.causes', $data);
    }
    public function causeDetails($slug)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $data['bs'] = $currentLang->basic_setting;
        $bex = $currentLang->basic_extra;
        if ($bex->is_donation == 0) {
            return back();
        }
        $be = $currentLang->basic_extended;
        $version = $be->theme_version;
        $cause = Donation::where('slug', $slug)->firstOrFail();
        $raised_amount = DonationDetail::query()
            ->where('donation_id', '=', $cause->id)
            ->where('status', '=', "Success")
            ->sum('amount');
        $goal_percentage = $raised_amount > 0 ? (($raised_amount / $cause->goal_amount) * 100) : 0;
        $cause['raised_amount'] = $raised_amount > 0 ? round($raised_amount, 2) : 0;
        $cause['goal_percentage'] = round($goal_percentage, 1);
        $data['custom_amounts'] = explode(',', $cause->custom_amount);
        $online = PaymentGateway::where('status', 1)->get();
        $offline = OfflineGateway::where('donation_checkout_status', 1)->orderBy('serial_number', 'ASC')->get();
        $data['offline'] = $offline;
        $data['payment_gateways'] = $online->mergeRecursive($offline);
        $data['cause'] = $cause;
        $data['bex'] = $bex;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;
        $stripeData = PaymentGateway::whereKeyword('stripe')->first();
        $stripe = $stripeData->convertAutoData();
        $data['stripe_key'] =  $stripe['key'];
        return view('front.cause-details', $data);
    }
    public function paymentInstruction(Request $request)
    {
        $offline = OfflineGateway::where('name', $request->name)->select('short_description', 'instructions', 'is_receipt')->first();
        return response()->json(['description' => $offline->short_description, 'instructions' => replaceBaseUrl($offline->instructions), 'is_receipt' => $offline->is_receipt]);
    }
    public function events(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['bex'] = $currentLang->basic_extra;
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;
        $data['bs'] = $currentLang->basic_setting;
        $data['event_categories'] = EventCategory::where('lang_id', $currentLang->id)->where('status', 1)->select('id', 'name')->get();
        $data['events'] = Event::with('eventCategories')
            ->when($request->title, function ($q) use ($request) {
                return $q->where('title', 'like', '%' . $request->title . '%');
            })->when($request->location, function ($q) use ($request) {
                return $q->where('venue_location', 'like', '%' . $request->location . '%');
            })->when($request->category, function ($q) use ($request) {
                return $q->where('cat_id', $request->category);
            })->when($request->date, function ($q) use ($request) {
                return $q->where('date', $request->date);
            })
            ->where('lang_id', $currentLang->id)
            ->orderBy('id', 'DESC')
            ->paginate(6);
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;
        return view('front.events', $data);
    }
    public function eventDetails($slug)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['bex'] = $currentLang->basic_extra;
        $data['bs'] = $currentLang->basic_setting;
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;
        $version = $be->theme_version;
        $event = Event::with('eventCategories')->where('slug', $slug)->firstOrFail();
        $data['event'] = $event;
        $online = PaymentGateway::where('status', 1)->get();
        $offline = OfflineGateway::where('event_checkout_status', 1)->orderBy('serial_number', 'ASC')->get();
        $data['offline'] = $offline;
        $data['payment_gateways'] = $online->mergeRecursive($offline);
        $data["moreEvents"] = Event::with('eventCategories')->where(function ($q) use ($event) {
            $q->where('id', '!=', $event->id)->where('cat_id', '=', $event->cat_id);
        })->where('lang_id', $currentLang->id)->take(5)->orderBy('id', 'DESC')->get();
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;
        $stripeData = PaymentGateway::whereKeyword('stripe')->first();
        $stripe = $stripeData->convertAutoData();
        $data['stripe_key'] =  $stripe['key'];
        return view('front.event-details', $data);
    }

    public function portfolios(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;

        $category = $request->category;

        if (!empty($category)) {
            $data['category'] = Scategory::findOrFail($category);
        }

        $data['portfolios'] = Portfolio::when($category, function ($query, $category) {
            $serviceIdArr = [];
            $serviceids = Service::select('id')->where('scategory_id', $category)->get();
            foreach ($serviceids as $key => $serviceid) {
                $serviceIdArr[] = $serviceid->id;
            }
            return $query->whereIn('service_id', $serviceIdArr);
        })->when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC');

        $version = $be->theme_version;

        if ($version == 'gym') {
            $data['portfolios'] = $data['portfolios']->get();
            return view('front.gym.portfolios', $data);
        } elseif ($version == 'car') {
            $data['portfolios'] = $data['portfolios']->get();
            return view('front.car.portfolios', $data);
        } elseif ($version == 'cleaning') {
            $data['portfolios'] = $data['portfolios']->get();
            return view('front.cleaning.portfolios', $data);
        } elseif ($version == 'construction') {
            $data['portfolios'] = $data['portfolios']->get();
            return view('front.construction.portfolios', $data);
        } elseif ($version == 'logistic') {
            $data['portfolios'] = $data['portfolios']->get();
            return view('front.logistic.portfolios', $data);
        } elseif ($version == 'lawyer') {
            $data['portfolios'] = $data['portfolios']->get();
            return view('front.lawyer.portfolios', $data);
        } elseif ($version == 'default' || $version == 'dark' || $version == 'ecommerce') {
            $data['version'] = $version == 'dark' ? 'default' : $version;
            $data['portfolios'] = $data['portfolios']->get();
            return view('front.portfolios', $data);
        }
    }

    public function portfoliodetails($slug)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['portfolio'] = Portfolio::where('slug', $slug)->firstOrFail();

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.portfolio-details', $data);
    }

    public function servicedetails($slug)
    {

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['service'] = Service::where('slug', $slug)->firstOrFail();

        if ($data['service']->details_page_status == 0) {
            return back();
        }

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.service-details', $data);
    }

    public function careerdetails($slug)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['jcats'] = $currentLang->jcategories()->where('status', 1)->orderBy('serial_number', 'ASC')->get();

        $data['job'] = Job::where('slug', $slug)->firstOrFail();

        $data['jobscount'] = Job::when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->count();

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;


        return view('front.career-details', $data);
    }

    public function blogs(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;

        $lang_id = $currentLang->id;
        $be = $currentLang->basic_extended;

        $category = $request->category;
        $catid = null;
        if (!empty($category)) {
            $data['category'] = Bcategory::where('slug', $category)->firstOrFail();
            $catid = $data['category']->id;
        }
        $term = $request->term;
        $tag = $request->tag;
        $month = $request->month;
        $year = $request->year;
        $data['archives'] = Archive::orderBy('id', 'DESC')->get();
        $data['bcats'] = Bcategory::where('language_id', $lang_id)->where('status', 1)->orderBy('serial_number', 'ASC')->get();
        if (!empty($month) && !empty($year)) {
            $archive = true;
        } else {
            $archive = false;
        }

        $data['blogs'] = Blog::when($catid, function ($query, $catid) {
            return $query->where('bcategory_id', $catid);
        })
            ->when($term, function ($query, $term) {
                return $query->where('title', 'like', '%' . $term . '%');
            })
            ->when($tag, function ($query, $tag) {
                return $query->where('tags', 'like', '%' . $tag . '%');
            })
            ->when($archive, function ($query) use ($month, $year) {
                return $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
            })
            ->when($currentLang, function ($query, $currentLang) {
                return $query->where('language_id', $currentLang->id);
            })->orderBy('created_at', 'desc')->paginate(6);

        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;


        return view('front.blogs', $data);
    }


    public function blogdetails($slug)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;


        $data['blog'] = Blog::where('slug', $slug)->firstOrFail();

        $data['archives'] = Archive::orderBy('id', 'DESC')->get();
        $data['bcats'] = Bcategory::where('status', 1)->where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.blog-details', $data);
    }

    public function knowledgebase()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['bse'] = $currentLang->basic_extra;

        $data['article_categories'] = ArticleCategory::where('language_id', $currentLang->id)
            ->where('status', 1)
            ->orderBy('serial_number', 'ASC')
            ->get();

        $data['currentLang'] = $currentLang;

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.articles', $data);
    }

    public function knowledgebase_details($slug)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['bse'] = $currentLang->basic_extra;

        $data['article_categories'] = ArticleCategory::where('language_id', $currentLang->id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();

        $data['details'] = Article::where('language_id', $currentLang->id)
            ->where('slug', $slug)
            ->firstOrFail();

        $data['currentLang'] = $currentLang;

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.article_details', $data);
    }

    public function rss(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;
        $id = $request->id;
        $data['categories'] = RssFeed::where('language_id', $lang_id)->orderBy('id', 'desc')->get();
        $data['rss_posts']  = RssPost::where('language_id', $lang_id)
            ->when($id, function ($query, $id) {
                return $query->where('rss_feed_id', $id);
            })->orderBy('id', 'desc')->paginate(4);

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;
        if ($version == 'dark') {
            $version = 'default';
        }
        $data['version'] = $version;

        return view('front.rss', $data);
    }

    public function rssdetails($slug, $id)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;
        $data['categories'] = RssFeed::where('language_id', $lang_id)->orderBy('id', 'desc')->get();
        $data['post']  = RssPost::findOrFail($id);

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.rss-details', $data);
    }

    public function contact()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        $data['langg'] = Language::where('code', session('lang'))->first();

        return view('front.contact', $data);
    }

    public function sendmail(Request $request)
    {

        // FIX SPAM FORMS IF THIS INPUT IS NOT EMPTY SO WILL DIE;
        if ($request->secure) {
            return redirect()->back()->withErrors('Your form has been submitted');
        }

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $bs = $currentLang->basic_setting;

        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
            'mobile' => 'required'
        ];
        if ($bs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $request->validate($rules, $messages);
        // إنشاء نسخة جديدة من النموذج "ServiceRequest"
        $req = new \App\ServiceRequest;
        $req->emp_name = isset($request->subject) ? $request->subject : '';
        $req->emp_mobile = $request->mobile;
        $req->emp_email = $request->email;
        $req->company_name = $request->name; // تركها فارغة لأنها ليست جزءًا من الدالة "sendmail"
        $req->msource = $request->msource;
        $req->company_type = ''; // تركها فارغة لأنها ليست جزءًا من الدالة "sendmail"
        $req->company_city = ''; // تركها فارغة لأنها ليست جزءًا من الدالة "sendmail"
        $req->suitable_time = ''; // تركها فارغة لأنها ليست جزءًا من الدالة "sendmail"
        $req->description = $request->message;
        $req->language_id = $currentLang->id;
        $req->cat_id = 0; // تركها فارغة لأنها ليست جزءًا من الدالة "sendmail"
        $req->request_id = 0; // تركها فارغة لأنها ليست جزءًا من الدالة "sendmail"
        $now = Carbon::now();
        $code = "S-" . rand(10000, 99999);
        $req->uuid = $code;

        // حفظ النموذج في قاعدة البيانات
        $req->save();

        $marketingOptions = [
            'marketing' => 'التسويق',
            'email' => 'الحملة البريدية',
            'google' => 'إعلانات جوجل',
            'twitter' => 'تويتر',
            'instagram' => 'انستقرام',
            'facebook' => 'فيس بوك',
            'youtube' => 'يوتيوب',
            'tiktok' => 'تيك توك',
            'whatsapp' => 'واتساب',
            'linkedin' => 'لينكد إن',
            'telegram' => 'تيليجرام',
            'snapchat' => 'سناب شات',
        ];

        $marketing = isset($marketingOptions[$request->msource]) ? $marketingOptions[$request->msource] : 'الموقع';


        $serviceOptions = [
            'خدمات تأسيس المؤسسات والشركات' => '1',
            'خدمات وزارة الاستثمار (تأسيس الشركات الأجنبية)' => '2',
            'خدمات تحويل الشكل القانوني للمنشآت' => '3',
            'خدمات نقل ملكية سجلات المنشآت' => '4',
            'خدمات تسجيل العلامات التجارية' => '5',
            'خدمات التأمين التعاوني للمنشآت' => '6',
            'خدمات تسجيل العمالة ذات المهن العليا' => '7',
            'خدمات اعتماد لوائح تنظيم العمل' => '8',
            'خدمات الشطب وإنهاء السجلات للمنشآت' => '9',
            'خدمات تخفيف الأعباء المالية عن المنشآت' => '10',
            'خدمات إدارة المنصات الحكومية للمنشآت' => '11',
            'خدمات الدعم المباشر لتحديات الوزارات الحكومية' => '12',
            'خدمات وزارة التجارة' => '13',
            'خدمات وزارة الاعلام' => '14',
            'خدمات إتمام لإدارة الرواتب (نظام حماية الأجور)' => '15',
            'خدمات وزارة الموارد البشرية (مكاتب العمل)' => '16',
            'خدمات هيئة الزكاة والضريبة والجمارك' => '17',
            'خدمات الدفاع المدني (سلامة)' => '18',
            'خدمات الاستشارات في العلاقات الحكومية' => '19',
            'خدمات الاشتراك في باقات الاستشارات' => '20',
            'خدمات الاشتراك في عقود الخدمات' => '21',
            'خدمات الاشتراك في برامج هدف' => '22',
            'خدمات منصة بلدي' => '23',
            'خدمات منصة قوى' => '24',
            'الاستشارات القانونية' => '25',
            'التمثيل القضائي في القضايا العمالية' => '26',
            'التمثيل القضائي في القضايا التجارية' => '27',
            'companies and Enterprises Establishment Services' => '28',
            'Ministry of Investment Services (Setup of Foreign Companies)' => '29',
            'Legal Entity Transformation Services' => '30',
            'Transfer of Ownership of Business Records Services' => '31',
            'Trademark Registration Services' => '32',
            'Cooperative Insurance Services for Businesses' => '33',
            'Highly Skilled Labor Registration Services' => '34',
            'Approval of Labor Regulations Services' => '35',
            'Removal and Termination of Business Records Services' => '36',
            'Financial Burden Reduction Services for Businesses' => '37',
            'Government Platforms Management Services for Businesses' => '38',
            'Direct Support Services for Government Ministries\' Challenges' => '39',
            'Ministry of Commerce Services' => '40',
            'Ministry of Information Services' => '41',
            'Payroll Management Completion (WPS System) Services' => '42',
            'Ministry of Human Resources Services (Labor Offices)' => '43',
            'Zakat, Tax, and Customs Authority Services' => '44',
            'Civil Defense (SALAMA) Services' => '45',
            'Government Relations Consultation Services' => '46',
            'Subscription to Consultation Packages Services' => '47',
            'Subscription to Services Contracts' => '48',
            'Subscription to HADAF Programs Services' => '49',
            'BALADI Platform Services' => '50',
            'QIWA Platform Services' => '51',
            'Legal Consultations Services' => '52',
            'Judicial Representation in Labor Cases Services' => '53',
            'Judicial Representation in Commercial Cases Services' => '54',

        ];

        $serviceName = $request->subject;
        $serviceNumber = array_search($serviceName, $serviceOptions);



        $be =  BE::firstOrFail();
        $from = $request->email;
        $to = 'customer_service@etmaam.com.sa';
        $subject = $serviceNumber;
        $message = $request->message;

        $be = BasicExtended::first();







        $mail = new PHPMailer(true);

        if ($be->is_smtp == 1) {
            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                //                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = $be->smtp_host;                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = $be->smtp_username;                     // SMTP username
                $mail->Password   = $be->smtp_password;                               // SMTP password
                $mail->SMTPSecure = $be->encryption;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = $be->smtp_port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);


                $mail->addAddress($request->email);     // Add a recipient
                //    $mail->addAddress('bashar@etmaam.com.sa');     // Add a recipient

            } catch (Exception $e) {
                // die($e->getMessage());
            }
        } else {
            try {

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);

                $mail->addAddress($request->email);     // Add a recipient
                //      $mail->addAddress('bashar@etmaam.com.sa');
            } catch (Exception $e) {
                // die($e->getMessage());
            }
        }

        $userMsg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<!--[if (gte mso 9)|(IE)]>
	<xml>
		<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>etmam Email Template</title>

	<!-- Google Fonts Link -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

	<style type="text/css">

		/*------ Client-Specific Style ------ */
		@-ms-viewport{width:device-width;}
		table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;}
		img{-ms-interpolation-mode:bicubic; border: 0;}
		p, a, li, td, blockquote{mso-line-height-rule:exactly;}
		p, a, li, td, body, table, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%;}
		#outlook a{padding:0;}
		.ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
		.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td,img{line-height:100%;}

		/*------ Reset Style ------ */
		*{-webkit-text-size-adjust:none;-webkit-text-resize:100%;text-resize:100%;}
		table{border-spacing: 0 !important;}
		h1, h2, h3, h4, h5, h6, p{display:block; Margin:0; padding:0;}
		img, a img{border:0; height:auto; outline:none; text-decoration:none;}
		#bodyTable, #bodyCell{ margin:0; padding:0; width:100%;}
		body {height:100%; margin:0; padding:0; width:100%;}

		.appleLinks a {color: #c2c2c2 !important; text-decoration: none;}
        span.preheader { display: none !important; }

		/*------ Google Font Style ------ */
		[style*="Open Sans"],.text {font-family:"Open Sans", Helvetica, Arial, sans-serif !important;}
		/*------ General Style ------ */
		.wrapperWebview, .wrapperBody, .wrapperFooter{width:100%; max-width:600px; Margin:0 auto;}

		/*------ Column Layout Style ------ */
		.tableCard {text-align:center; font-size:0;}

		/*------ Images Style ------ */
		.imgHero img{ width:600px; height:auto; }

	</style>

	<style type="text/css">
		/*------ Media Width 480 ------ */
		@media screen and (max-width:640px) {
			table[class="wrapperWebview"]{width:100% !important; }
			table[class="wrapperEmailBody"]{width:100% !important; }
			table[class="wrapperFooter"]{width:100% !important; }
			td[class="imgHero"] img{ width:100% !important;}
			.hideOnMobile {display:none !important; width:0; overflow:hidden;}
		}
	</style>

</head>

<body dir="rtl" style="background-color:#F9F9F9;">
<center>

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#F9F9F9;" id="bodyTable">
	<tr>
		<td align="center" valign="top" style="padding-right:10px;padding-left:10px;" id="bodyCell">
		<!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" style="width:600px;" width="300"><tr><td align="center" valign="top"><![endif]-->



		<!-- Email Wrapper Header Open //-->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;    margin-top: 50px;" width="100%" class="wrapperWebview">
			<tr>
				<td align="center" valign="top">
					<!-- Content Table Open // -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td align="center" valign="middle" style="padding-top:20px;padding-bottom:20px;    background: whitesmoke;" class="emailLogo">
								<!-- Logo and Link // -->
								<a href="#" target="_blank" style="text-decoration:none;">
									<img src="https://etmaam.com.sa/assets/front/img/logo.png" alt="" width="150" border="0" style="width:100%; max-width:150px;height:auto; display:block;"/>
								</a>
							</td>
						</tr>
					</table>
					<!-- Content Table Close // -->
				</td>
			</tr>
		</table>
		<!-- Email Wrapper Header Close //-->

		<!-- Email Wrapper Body Open // -->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperBody">
			<tr>
				<td align="center" valign="top">

					<!-- Table Card Open // -->
					<table border="0" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF;border-color:#E5E5E5; border-style:solid; border-width:0 1px 1px 1px;" width="100%" class="tableCard">



						<tr>
							<td align="center" valign="top" style="padding-bottom:40px ;padding-top: 40px;" class="imgHero">
								<!-- Hero Image // -->
								<a href="#" target="_blank" style="text-decoration:none;">
									<img src="https://etmaam.com.sa/assets/front/img/user-subscribe.png" width="300" alt="" border="0" style="width:100%; max-width:150px; height:auto; display:block;" />
								</a>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-bottom:5px;padding-left:20px;padding-right:20px;" class="mainTitle">
								<!-- Main Title Text // -->
								<h2 class="text" style="color:#000000;  font-size:28px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:36px; text-transform:none; text-align:center; padding:0; margin:0">
									مرحبا<span>"' . $request->name . '"</span>
								</h2>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-bottom:18px;padding-left:20px;padding-right:20px;" class="subTitle">
								<!-- Sub Title Text // -->
								<h4 class="text" style="color:#225476;  font-size:24px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
									لقد تم استلام طلبكم بنجاح
								</h4>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-left:20px;padding-right:20px;padding-bottom:40px;" class="containtTable">

								<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription">
									<tr>
										<td align="center" valign="top" style="padding-bottom:20px;" class="description">
											<!-- Description Text// -->
											<p class="text" style="color:#666666;  font-size:18px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:22px; text-transform:none; text-align:center; padding:0; margin:0">
												نشكركم على طلبكم وسيتم الرد عليكم بأقرب فرصة
											</p>
										</td>
									</tr>
								</table>


							</td>
						</tr>




					</table>
					<!-- Table Card Close// -->

					<!-- Space -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
						<tr>
							<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
						</tr>
					</table>

				</td>
			</tr>
		</table>
		<!-- Email Wrapper Body Close // -->

		<!-- Email Wrapper Footer Open // -->
		<table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperFooter">
			<tr>
				<td align="center" valign="top">
					<!-- Content Table Open// -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
						<tr>
							<td align="center" valign="top" style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="socialLinks">
								<!-- Social Links (Facebook)// -->
								<a href="https://www.facebook.com/etmaam2/" target="_blank" style="display:inline-block;" class="facebook">
									<img src="https://etmaam.com.sa/assets/front/img/facebook.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
								<!-- Social Links (Twitter)// -->
								<a href="https://twitter.com/etmaam2" target="_blank" style="display:inline-block;" class="twitter">
									<img src="https://etmaam.com.sa/assets/front/img/twitter.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>

								<!-- Social Links (Instagram)// -->
								<a href="https://www.instagram.com/etmaam2/" target="_blank" style="display:inline-block;" class="instagram">
									<img src="https://etmaam.com.sa/assets/front/img/instagram.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
								<!-- Social Links (Linkdin)// -->
								<a href="https://www.linkedin.com/company/etmaam2" target="_blank" style="display:inline-block;" class="linkdin">
									<img src="https://etmaam.com.sa/assets/front/img/linkdin.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
								</a>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:10px;padding-bottom:5px;padding-left:10px;padding-right:10px;" class="brandInfo">
								<!-- Brand Information // -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;">&copy;&nbsp; اتمام للخدمات. | 2022 <span> المنطقة الوسطى - الرياض</span>
								</p>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:0px;padding-bottom:20px;padding-left:10px;padding-right:10px;" class="footerLinks">
								<!-- Use Full Links (Privacy Policy)// -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
									<a href="https://etmaam.com.sa/about" style="color:#777777;text-decoration:underline;" target="_blank"> ماذا عنا  </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/serv_req" style="color:#777777;text-decoration:underline;" target="_blank"> اطلب خدمة </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/" style="color:#777777;text-decoration:underline;" target="_blank"> الصفحة الرئيسية  </a>
								</p>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" style="padding-top:0px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="footerEmailInfo">
								<!-- Information of NewsLetter (Subscribe Info)// -->
								<p class="text" style="color:#777777;  font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
								اذا كان لديك اي استفسار يمكنك التواصل معنا <a href="mailto:info@etmaam.com.sa" style="color:#777777;text-decoration:underline;" target="_blank">info@etmaam.com.sa</a><br>
								</p>
							</td>
						</tr>



						<!-- Space -->
						<tr>
							<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
						</tr>
					</table>
					<!-- Content Table Close// -->
				</td>
			</tr>

			<!-- Space -->
			<tr>
				<td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
			</tr>
		</table>
		<!-- Email Wrapper Footer Close // -->

		<!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
		</td>
	</tr>

</table>

</center>
</body>
</html>';
        $adminMsg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <!--[if (gte mso 9)|(IE)]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>etmam Email Template</title>

    <!-- Google Fonts Link -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <style type="text/css">

        /*------ Client-Specific Style ------ */
        @-ms-viewport{width:device-width;}
        table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;}
        img{-ms-interpolation-mode:bicubic; border: 0;}
        p, a, li, td, blockquote{mso-line-height-rule:exactly;}
        p, a, li, td, body, table, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%;}
        #outlook a{padding:0;}
        .ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
        .ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td,img{line-height:100%;}

        /*------ Reset Style ------ */
        *{-webkit-text-size-adjust:none;-webkit-text-resize:100%;text-resize:100%;}
        table{border-spacing: 0 !important;}
        h1, h2, h3, h4, h5, h6, p{display:block; Margin:0; padding:0;}
        img, a img{border:0; height:auto; outline:none; text-decoration:none;}
        #bodyTable, #bodyCell{ margin:0; padding:0; width:100%;}
        body {height:100%; margin:0; padding:0; width:100%;}

        .appleLinks a {color: #c2c2c2 !important; text-decoration: none;}
        span.preheader { display: none !important; }

        /*------ Google Font Style ------ */
        [style*="Open Sans"],.text {font-family:"Open Sans", Helvetica, Arial, sans-serif !important;}
        /*------ General Style ------ */
        .wrapperWebview, .wrapperBody, .wrapperFooter{width:100%; max-width:600px; Margin:0 auto;}

        /*------ Column Layout Style ------ */
        .tableCard {text-align:center; font-size:0;}

        /*------ Images Style ------ */
        .imgHero img{ width:600px; height:auto; }

    </style>

    <style type="text/css">
        /*------ Media Width 480 ------ */
        @media screen and (max-width:640px) {
            table[class="wrapperWebview"]{width:100% !important; }
            table[class="wrapperEmailBody"]{width:100% !important; }
            table[class="wrapperFooter"]{width:100% !important; }
            td[class="imgHero"] img{ width:100% !important;}
            .hideOnMobile {display:none !important; width:0; overflow:hidden;}
        }
    </style>

</head>

<body dir="rtl" style="background-color:#F9F9F9;">
<center>

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#F9F9F9;" id="bodyTable">
        <tr>
            <td align="center" valign="top" style="padding-right:10px;padding-left:10px;" id="bodyCell">
                <!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" style="width:600px;" width="300"><tr><td align="center" valign="top"><![endif]-->



                <!-- Email Wrapper Header Open //-->
                <table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;    margin-top: 50px;" width="100%" class="wrapperWebview">
                    <tr>
                        <td align="center" valign="top">
                            <!-- Content Table Open // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" valign="middle" style="padding-top:20px;padding-bottom:20px;    background: whitesmoke;" class="emailLogo">
                                        <!-- Logo and Link // -->
                                        <a href="#" target="_blank" style="text-decoration:none;">
                                            <img src="https://etmaam.com.sa/assets/front/img/logo.png" alt="" width="150" border="0" style="width:100%; max-width:150px;height:auto; display:block;"/>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <!-- Content Table Close // -->
                        </td>
                    </tr>
                </table>
                <!-- Email Wrapper Header Close //-->

                <!-- Email Wrapper Body Open // -->
                <table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperBody">
                    <tr>
                        <td align="center" valign="top">

                            <!-- Table Card Open // -->
                            <table border="0" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF;border-color:#E5E5E5; border-style:solid; border-width:0 1px 1px 1px;" width="100%" class="tableCard">



                                <tr>
                                    <td align="center" valign="top" style="padding-bottom:40px ;padding-top: 40px;" class="imgHero">
                                        <!-- Hero Image // -->
                                        <a href="#" target="_blank" style="text-decoration:none;">
                                            <img src="https://etmaam.com.sa/assets/front/img/user-subscribe.png" width="300" alt="" border="0" style="width:100%; max-width:150px; height:auto; display:block;" />
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" valign="top" style="padding-bottom:5px;padding-left:20px;padding-right:20px;" class="mainTitle">
                                        <!-- Main Title Text // -->
                                        <h2 class="text" style="color:#000000; font-size:28px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:36px; text-transform:none; text-align:center; padding:0; margin:0">
                         طلب سريع (' . $serviceNumber . ') جديد  | ' . $request->name . '                        </h2>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" valign="top" style="padding-bottom:18px;padding-left:20px;padding-right:20px;" class="subTitle">
                                        <!-- Sub Title Text // -->
                                        <h4 class="text" style="color:#225476; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
                                          اسم المنشأة
                                        </h4>
                                        <h4 class="text" style="color:#666666; font-size:20px; margin:3px 0; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
                                            ' . $request->name . '
                                        </h4>
                                        <h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
                                            نوع الطلب
                                        </h4>
                                        <h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
                                            ' . $serviceNumber . '
                                        </h4>
                                    <h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
                                            رقم الجوال
                                        </h4>
                                        <h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
                                            ' . $request->mobile . '
                                        </h4>

                                        <h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
                                            البريد الإلكتروني
                                        </h4>
                                        <h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
                                            ' . $request->email . '
                                        </h4>

                                    <h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
                                          المصدر
                                        </h4>
                                        <h4 class="text" style="color:#666666; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
                                            ' . $marketing . '
                                        </h4>

                                        <h4 class="text" style="color:#225476; font-size:20px;margin:3px 0;  font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:5">
                                            الملاحظات
                                        </h4>

                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" valign="top" style="padding-left:20px;padding-right:20px;padding-bottom:40px;" class="containtTable">

                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription">
                                            <tr>
                                                <td align="center" valign="top" style="padding-bottom:20px;" class="description">
                                                    <!-- Description Text// -->
                                                    <p class="text" style="width:50%;color:#666666; font-size:18px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:22px; text-transform:none; text-align:center; padding:0; margin:0">
                                                        ' . $request->message . '
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>


                                    </td>
                                </tr>




                            </table>
                            <!-- Table Card Close// -->

                            <!-- Space -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
                                <tr>
                                    <td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
                <!-- Email Wrapper Body Close // -->

                <!-- Email Wrapper Footer Open // -->
                <table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperFooter">
                    <tr>
                        <td align="center" valign="top">
                            <!-- Content Table Open// -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
                                <tr>
                                    <td align="center" valign="top" style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="socialLinks">
                                        <!-- Social Links (Facebook)// -->
                                        <a href="https://www.facebook.com/etmaam2/" target="_blank" style="display:inline-block;" class="facebook">
                                            <img src="https://etmaam.com.sa/assets/front/img/facebook.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
                                        </a>
                                        <!-- Social Links (Twitter)// -->
                                        <a href="https://twitter.com/etmaam2" target="_blank" style="display:inline-block;" class="twitter">
                                            <img src="https://etmaam.com.sa/assets/front/img/twitter.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
                                        </a>

                                        <!-- Social Links (Instagram)// -->
                                        <a href="https://www.instagram.com/etmaam2/" target="_blank" style="display:inline-block;" class="instagram">
                                            <img src="https://etmaam.com.sa/assets/front/img/instagram.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
                                        </a>
                                        <!-- Social Links (Linkdin)// -->
                                        <a href="https://www.linkedin.com/company/etmaam2" target="_blank" style="display:inline-block;" class="linkdin">
                                            <img src="https://etmaam.com.sa/assets/front/img/linkdin.png" alt="" width="40" border="0" style="height:auto; width:100%; max-width:40px; margin-left:2px; margin-right:2px" />
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" valign="top" style="padding-top:10px;padding-bottom:5px;padding-left:10px;padding-right:10px;" class="brandInfo">
                                        <!-- Brand Information // -->
                                        <p class="text" style="color:#777777; font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;">&copy;&nbsp; اتمام للخدمات. | 2022 <span> المنطقة الوسطى - الرياض</span>
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" valign="top" style="padding-top:0px;padding-bottom:20px;padding-left:10px;padding-right:10px;" class="footerLinks">
                                        <!-- Use Full Links (Privacy Policy)// -->
                                        <p class="text" style="color:#777777; font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
                                            <a href="https://etmaam.com.sa/about" style="color:#777777;text-decoration:underline;" target="_blank"> ماذا عنا  </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/serv_req" style="color:#777777;text-decoration:underline;" target="_blank"> اطلب خدمة </a>&nbsp;|&nbsp;<a href="https://etmaam.com.sa/" style="color:#777777;text-decoration:underline;" target="_blank"> الصفحة الرئيسية  </a>
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" valign="top" style="padding-top:0px;padding-bottom:10px;padding-left:10px;padding-right:10px;" class="footerEmailInfo">
                                        <!-- Information of NewsLetter (Subscribe Info)// -->
                                        <p class="text" style="color:#777777; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;" >
                                            اذا كان لديك اي استفسار يمكنك التواصل معنا <a href="mailto:info@etmaam.com.sa" style="color:#777777;text-decoration:underline;" target="_blank">info@etmaam.com.sa</a><br>
                                        </p>
                                    </td>
                                </tr>



                                <!-- Space -->
                                <tr>
                                    <td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                </tr>
                            </table>
                            <!-- Content Table Close// -->
                        </td>
                    </tr>

                    <!-- Space -->
                    <tr>
                        <td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
                    </tr>
                </table>
                <!-- Email Wrapper Footer Close // -->

                <!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
            </td>
        </tr>
    </table>

</center>
</body>
</html>';

        // Content
        $mail->CharSet = 'UTF-8';
        $mail->ContentType = 'text/html';
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'تم استقبال طلبكم بنجاح';
        $mail->Body = $userMsg;

        $mail->send();
        $mail->clearAllRecipients();


        // Add a recipient
        $mail->addAddress('adham@etmaam.com.sa');     // Add a recipient
        $mail->addAddress('ahmed.j@etmaam.com.sa');     // Add a recipient

        $mail->addAddress('customer_service@etmaam.com.sa');     // Add a recipient
        $mail->addAddress('abdullah.o@etmaam.com.sa');     // Add a recipient

        $mail->addAddress('hedbah@etmaam.com.sa');     // Add a recipient
        $mail->addAddress('sidra@etmaam.com.sa');
        $mail->addAddress('mohammed.h@etmaam.com.sa');

        $mail->addAddress('najat@etmaam.com.sa');
        // Add a recipient
        $mail->addAddress('modhaf@etmaam.com.sa');     // Add a recipient
        // it emails
        $mail->addAddress('design@etmaam.com.sa');     // Add a recipient
        // $mail->addAddress('bashar@etmaam.com.sa');     // Add a recipient


        // if ($request->subject == 'اقتراح' || $request->subject == 'شكوى' || $request->subject == 'اخرى' ) {
        // }

        $mail->CharSet = 'UTF-8';
        $mail->ContentType = 'text/html';
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'طلب سريع #' . $req->id . '  جديد';
        $mail->Body = $adminMsg;
        $mail->send();
        $data['id'] = $req->id;
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;
        $version = $be->theme_version;
        $data['version'] = $version == 'dark' ? 'default' : $version;


        Session::flash('success', 'Email sent successfully!');
        // dd(url()->current());

        if ($request->subject) {
            return view('front.thankyou', $data);
        } else {
            return back();
        }
    }


    public function subscribe(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:subscribers'
        ];

        $validator = FacadesValidator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $subsc = new Subscriber;
        $subsc->email = $request->email;
        $subsc->save();

        return "success";
    }

    public function quote()
    {

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;

        if ($bs->is_quote == 0) {
            return view('errors.404');
        }

        $lang_id = $currentLang->id;

        $data['services'] = Service::all();
        $data['inputs'] = QuoteInput::where('language_id', $lang_id)->get();
        $data['ndaIn'] = QuoteInput::find(10);

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.quote', $data);
    }

    public function sendquote(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;
        $quote_inputs = $currentLang->quote_inputs;

        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];

        $rules = [
            'name' => 'required',
            'email' => 'required|email'
        ];


        $allowedExts = array('zip');
        foreach ($quote_inputs as $input) {
            if ($input->required == 1) {
                $rules["$input->name"][] = 'required';
            }
            // check if input type is 5, then check for zip extension
            if ($input->type == 5) {
                $rules["$input->name"][] = function ($attribute, $value, $fail) use ($request, $input, $allowedExts) {
                    if ($request->hasFile("$input->name")) {
                        $ext = $request->file("$input->name")->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only zip file is allowed");
                        }
                    }
                };
            }
        }

        if ($bs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $request->validate($rules, $messages);

        $fields = [];
        foreach ($quote_inputs as $key => $input) {
            $in_name = $input->name;
            // if the input is file, then move it to 'files' folder
            if ($input->type == 5) {
                if ($request->hasFile("$in_name")) {
                    $fileName = uniqid() . '.' . $request->file("$in_name")->getClientOriginalExtension();
                    $directory = 'assets/front/files/';
                    @mkdir($directory, 0775, true);
                    $request->file("$in_name")->move($directory, $fileName);

                    $fields["$in_name"]['value'] = $fileName;
                    $fields["$in_name"]['type'] = $input->type;
                }
            } else {
                if ($request["$in_name"]) {
                    $fields["$in_name"]['value'] = $request["$in_name"];
                    $fields["$in_name"]['type'] = $input->type;
                }
            }
        }
        $jsonfields = json_encode($fields);
        $jsonfields = str_replace("\/", "/", $jsonfields);


        $quote = new Quote;
        $quote->name = $request->name;
        $quote->email = $request->email;
        $quote->fields = $jsonfields;

        $quote->save();


        // send mail to Admin
        $from = $request->email;
        $to = $be->to_mail;
        $subject = "Quote Request Received";

        $fields = json_decode($quote->fields, true);

        try {

            $mail = new PHPMailer(true);
            $mail->setFrom($from, $request->name);
            $mail->addAddress($to);     // Add a recipient

            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = 'A new quote request has been sent.<br/><strong>Client Name: </strong>' . $request->name . '<br/><strong>Client Mail: </strong>' . $request->email;

            $mail->send();
        } catch (\Exception $e) {
            // die($e->getMessage());
        }

        Session::flash('success', 'Quote request sent successfully');
        return back();
    }

    public function team()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['members'] = Member::when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->get();

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'gym') {
            return view('front.gym.team', $data);
        } elseif ($version == 'car') {
            return view('front.car.team', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.team', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.team', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.team', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.team', $data);
        } elseif ($version == 'default' || $version == 'dark' || $version == 'ecommerce') {
            $data['version'] = $version == 'dark' ? 'default' : $version;
            return view('front.team', $data);
        }
    }

    public function career(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['jcats'] = $currentLang->jcategories()->where('status', 1)->orderBy('serial_number', 'ASC')->get();


        $category = $request->category;
        $term = $request->term;

        if (!empty($category)) {
            $data['category'] = Jcategory::findOrFail($category);
        }

        $data['jobs'] = Job::when($category, function ($query, $category) {
            return $query->where('jcategory_id', $category);
        })->when($term, function ($query, $term) {
            return $query->where('title', 'like', '%' . $term . '%');
        })->when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC')->paginate(4);

        $data['jobscount'] = Job::when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->count();

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.career', $data);
    }

    public function calendar()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $events = CalendarEvent::where('language_id', $lang_id)->get();
        $formattedEvents = [];

        foreach ($events as $key => $event) {
            $formattedEvents["$key"]['title'] = $event->title;

            $startDate = strtotime($event->start_date);
            $formattedEvents["$key"]['start'] = date('Y-m-d H:i', $startDate);

            $endDate = strtotime($event->end_date);
            $formattedEvents["$key"]['end'] = date('Y-m-d H:i', $endDate);
        }

        $data["formattedEvents"] = $formattedEvents;

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.calendar', $data);
    }

    public function gallery()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $data['categories'] = GalleryCategory::where('language_id', $lang_id)->where('status', 1)
            ->orderBy('serial_number', 'ASC')->get();

        $data['galleries'] = Gallery::with('galleryImgCategory')->where('language_id', $lang_id)
            ->orderBy('serial_number', 'ASC')->get();

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.gallery', $data);
    }

    public function faq()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $data['categories'] = FAQCategory::where('language_id', $lang_id)->where('status', 1)
            ->orderBy('serial_number', 'ASC')->get();

        $data['faqs'] = Faq::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.faq', $data);
    }

    public function dynamicPage($slug)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['page'] = Page::where('slug', $slug)->firstOrFail();

        $be = $currentLang->basic_extended;
        $bex = $currentLang->basic_extra;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        if ($bex->custom_page_pagebuilder == 1) {
            return view('front.dynamic', $data);
        } else {
            return view('front.dynamic1', $data);
        }
    }

    public function changeLanguage($lang, Request $request)
    {
        session()->put('lang', $lang);
        app()->setLocale($lang);

        $be = be::first();
        $version = $be->theme_version;

        $redirect = $request->input('redirect') ? $request->input('redirect') : url()->previous();

        return redirect($redirect);
    }

    public function packageorder(Request $request, $id)
    {
        $bex = BasicExtra::first();

        if ($bex->package_guest_checkout == 1 && $request->type != 'guest' && !Auth::check()) {
            Session::put('link', route('front.packageorder.index', $id));
            return redirect(route('user.login', ['redirected' => 'package-checkout']));
        } elseif ($bex->package_guest_checkout == 0 && !Auth::check()) {
            Session::put('link', route('front.packageorder.index', $id));
            return redirect(route('user.login'));
        }
        if ($bex->recurring_billing == 1) {
            $sub = Subscription::select('next_package_id', 'pending_package_id')->where('user_id', Auth::user()->id)->first();

            if (!empty($sub->next_package_id)) {
                Session::flash('error', 'You already have a package to activate in stock.');
                return back();
            }
            if (!empty($sub->pending_package_id)) {
                Session::flash('error', 'You already have a pending subscription request.');
                return back();
            }
        }

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $data['package'] = Package::findOrFail($id);

        if ($data['package']->order_status == 0) {
            return view('errors.404');
        }

        $data['inputs'] = PackageInput::where('language_id', $lang_id)->get();
        $data['gateways']  = PaymentGateway::whereStatus(1)->whereType('automatic')->get();
        $data['ogateways']  = OfflineGateway::wherePackageOrderStatus(1)->orderBy('serial_number', 'ASC')->get();
        $paystackData = PaymentGateway::whereKeyword('paystack')->first();
        $data['paystack'] = $paystackData->convertAutoData();
        $stripeData = PaymentGateway::whereKeyword('stripe')->first();
        $stripe = $stripeData->convertAutoData();
        $data['stripe_key'] =  $stripe['key'];

        $be = be::first();
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.package-order', $data);
    }

    public function submitorder(Request $request)
    {

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;
        $package_inputs = $currentLang->package_inputs;

        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'package_id' => 'required'
        ];

        $allowedExts = array('zip');
        foreach ($package_inputs as $input) {
            if ($input->required == 1) {
                $rules["$input->name"][] = 'required';
            }
            // check if input type is 5, then check for zip extension
            if ($input->type == 5) {
                $rules["$input->name"][] = function ($attribute, $value, $fail) use ($request, $input, $allowedExts) {
                    if ($request->hasFile("$input->name")) {
                        $ext = $request->file("$input->name")->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only zip file is allowed");
                        }
                    }
                };
            }
        }

        if ($bs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $request->validate($rules, $messages);

        $fields = [];
        foreach ($package_inputs as $key => $input) {
            $in_name = $input->name;
            // if the input is file, then move it to 'files' folder
            if ($input->type == 5) {
                if ($request->hasFile("$in_name")) {
                    $fileName = uniqid() . '.' . $request->file("$in_name")->getClientOriginalExtension();
                    $directory = 'assets/front/files/';
                    @mkdir($directory, 0775, true);
                    $request->file("$in_name")->move($directory, $fileName);

                    $fields["$in_name"]['value'] = $fileName;
                    $fields["$in_name"]['type'] = $input->type;
                }
            } else {
                if ($request["$in_name"]) {
                    $fields["$in_name"]['value'] = $request["$in_name"];
                    $fields["$in_name"]['type'] = $input->type;
                }
            }
        }
        $jsonfields = json_encode($fields);
        $jsonfields = str_replace("\/", "/", $jsonfields);

        $package = Package::findOrFail($request->package_id);

        $in = $request->all();
        $in['name'] = $request->name;
        $in['email'] = $request->email;
        $in['fields'] = $jsonfields;

        $in['package_title'] = $package->title;
        $in['package_currency'] = $package->currency;
        $in['package_price'] = $package->price;
        $in['package_description'] = $package->description;
        $fileName = \Str::random(4) . time() . '.pdf';
        $in['invoice'] = $fileName;
        $po = PackageOrder::create($in);


        // saving order number
        $po->order_number = $po->id + 1000000000;
        $po->save();


        // sending datas to view to make invoice PDF
        $fields = json_decode($po->fields, true);
        $data['packageOrder'] = $po;
        $data['fields'] = $fields;


        // generate pdf from view using dynamic datas
        PDF::loadView('pdf.package', $data)->save('assets/front/invoices/' . $fileName);


        // Send Mail to Buyer
        $mail = new PHPMailer(true);

        if ($be->is_smtp == 1) {
            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = $be->smtp_host;                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = $be->smtp_username;                     // SMTP username
                $mail->Password   = $be->smtp_password;                               // SMTP password
                $mail->SMTPSecure = $be->encryption;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = $be->smtp_port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);
                $mail->addAddress($request->email, $request->name);     // Add a recipient

                // Attachments
                $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = "Order placed for " . $package->title;
                $mail->Body    = 'Hello <strong>' . $request->name . '</strong>,<br/>Your order has been placed successfully. We have attached an invoice in this mail.<br/>Thank you.';

                $mail->send();
            } catch (Exception $e) {
                // die($e->getMessage());
            }
        } else {
            try {

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);
                $mail->addAddress($request->email, $request->name);     // Add a recipient

                // Attachments
                $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = "Order placed for " . $package->title;
                $mail->Body    = 'Hello <strong>' . $request->name . '</strong>,<br/>Your order has been placed successfully. We have attached an invoice in this mail.<br/>Thank you.';

                $mail->send();
            } catch (Exception $e) {
                // die($e->getMessage());
            }
        }

        // send mail to Admin
        try {

            $mail = new PHPMailer(true);
            $mail->setFrom($po->email, $po->name);
            $mail->addAddress($be->from_mail);     // Add a recipient

            // Attachments
            $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = "Order placed for " . $package->title;
            $mail->Body    = 'A new order has been placed.<br/><strong>Order Number: </strong>' . $po->order_number;

            $mail->send();
        } catch (\Exception $e) {
            // die($e->getMessage());
        }

        Session::flash('success', 'Order placed successfully!');
        return redirect()->route('front.packageorder.confirmation', [$package->id, $po->id]);
    }


    public function orderConfirmation($packageid, $packageOrderId)
    {
        $data['package'] = Package::findOrFail($packageid);
        $bex = BasicExtra::first();

        if ($bex->recurring_billing == 1) {
            $packageOrder = Subscription::findOrFail($packageOrderId);
        } else {
            $packageOrder = PackageOrder::findOrFail($packageOrderId);
        }

        $data['packageOrder'] = $packageOrder;
        $data['fields'] = json_decode($packageOrder->fields, true);

        $be = be::first();
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        if ($bex->recurring_billing == 1) {
            return view('front.subscription-confirmation', $data);
        } else {
            return view('front.order-confirmation', $data);
        }
    }

    public function loadpayment($slug, $id)
    {
        $data['payment'] = $slug;
        $data['pay_id'] = $id;
        $gateway = '';
        if ($data['pay_id'] != 0 && $data['payment'] != "offline") {
            $gateway = PaymentGateway::findOrFail($data['pay_id']);
        } else {
            $gateway = OfflineGateway::findOrFail($data['pay_id']);
        }
        $data['gateway'] = $gateway;

        return view('front.load.payment', $data);
    }    // Redirect To Checkout Page If Payment is Cancelled



    // Redirect To Success Page If Payment is Comleted

    public function payreturn($packageid)
    {
        return redirect()->route('front.packageorder.index', $packageid)->with('success', __('Pament Compelted!'));
    }
}
