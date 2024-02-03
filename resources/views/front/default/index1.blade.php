@extends('front.default.layout')

@section('meta-keywords', "$be->home_meta_keywords")
@section('meta-description', "$be->home_meta_description")


@section('content')
    <!--   hero area start   -->
    @if ($bs->home_version == 'static')
        @includeif('front.default.partials.static')
    @elseif ($bs->home_version == 'slider')
        @includeif('front.default.partials.slider')
    @elseif ($bs->home_version == 'video')
        @includeif('front.default.partials.video')
    @elseif ($bs->home_version == 'particles')
        @includeif('front.default.partials.particles')
    @elseif ($bs->home_version == 'water')
        @includeif('front.default.partials.water')
    @elseif ($bs->home_version == 'parallax')
        @includeif('front.default.partials.parallax')
    @endif
    <!--   hero area end    -->


    <!--    introduction area start   -->
    <div class="intro-section" @if ($bs->feature_section == 0) style="margin-top: 0px;" @endif>
        <div class="container">
            @if ($bs->feature_section == 1)
                <div class="hero-features">
                    <div class="row">
                        @foreach ($features as $key => $feature)
                            <style>
                                .sf{{ $feature->id }}::after {
                                    background-color: #{{ $feature->color }};
                                }
                            </style>
                            <div class="col-md-3 col-sm-6 single-hero-feature sf{{ $feature->id }}"
                                style="background-color: #{{ $feature->color }};">
                                <div class="outer-container">
                                    <div class="inner-container">
                                        <div class="icon-wrapper">
                                            <i class="{{ $feature->icon }}"></i>
                                        </div>
                                        <h3>{{ convertUtf8($feature->title) }}</h3>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!--// here is services start الخدمات الالكترونية-->

            <!--   service section end   -->
            @if (serviceCategory())
                <!--   service category section start   -->
                <div class="service-categories0 mb-4">
                    <div class="container">
                        <div class="row ">
                            <div class="col-lg-12">
                                <h2 class="section-title keepaway" style="text-align: start;">
                                    {{ convertUtf8($bs->cs_section_title) }}

                                </h2>
                                <h2 class="section-summary hide">{{ convertUtf8($bs->service_section_subtitle) }}</h2>
                            </div>
                        </div>
                    </div>
                    <style>
                        a.single,
                        a.single:hover {
                            text-decoration: none;
                        }

                        button.btn.btn-cal-inside.rest-btn.bas.disabled {
                            background-color: #dddddd;
                            color: #000;
                            border: black;
                        }

                        .owl-item:first-child {
                            display: none;
                        }
                    </style>
                    <div class="container">
                        <div class="row">
                            @foreach ($scategorieshigh as $key => $scategoryhigh)
                                <div class="col-xl-2 col-lg-2 col-6">
                                    <a class="single" href="{{ route('front.serv_req') }}">
                                        <div class="single-category0">
                                            @if (!empty($scategoryhigh->image))
                                                <div class="img-wrapper">
                                                    <img class="lazy iconx-1"
                                                        data-src="{{ asset('assets/front/img/service_category_icons/' . $scategoryhigh->image) }}"
                                                        alt="">
                                                </div>
                                            @endif
                                            <div class="text" style="font-size: 15px !important ; margin-top:10px">
                                                <p style="color:{{ convertUtf8($scategoryhigh->title_color) }}; font-weight: 600;"
                                                    class="serv-name">{{ convertUtf8($scategoryhigh->name) }}</p>
                                                <!--<a href="{{ route('front.services', ['category' => $scategoryhigh->id]) }}" class="readmore">{{ __('View Services') }}</a>-->
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!--   service category section end   -->
            @endif

            <!--// here is services end الخدمات الالكترونية-->

            <!--// here is services start orginal-->
            @if ($bs->service_section == 1)
                @if (!serviceCategory())
                    <!--   service section start   -->
                    <section class="services-area pb-130">
                        <div class="container">
                            <div class="row ">
                                <div class="col-lg-12">
                                    <span class="section-title">{{ convertUtf8($bs->service_section_title) }}</span>
                                    <h2 class="section-summary hide">{{ convertUtf8($bs->service_section_subtitle) }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row justify-content-center">
                                @foreach ($services as $service)
                                    <div class="col-lg-4 col-md-6 col-sm-8">
                                        <div class="services-item mt-30">
                                            <div class="services-thumb">
                                                <img class="lazy"
                                                    data-src="{{ asset('assets/front/img/services/' . $service->main_image) }}"
                                                    alt="service" />
                                            </div>
                                            <div class="services-content">
                                                <a class="title"
                                                    @if ($service->details_page_status == 1) href="{{ route('front.servicedetails', [$service->slug, $service->id]) }}" @endif>
                                                    <h4>{{ $service->title }}</h4>
                                                </a>

                                                <p>
                                                    @if (strlen($service->summary) > 120)
                                                        {{ mb_substr($service->summary, 0, 120, 'utf-8') }}<span
                                                            style="display: none;">{{ mb_substr($service->summary, 120, null, 'utf-8') }}</span>
                                                        <a href="#" class="see-more">{{ __('see more') }}...</a>
                                                    @else
                                                        {{ $service->summary }}
                                                    @endif
                                                </p>

                                                @if ($service->details_page_status == 1)
                                                    <a
                                                        href="{{ route('front.servicedetails', [$service->slug, $service->id]) }}">{{ __('Read More') }}
                                                        <i class="fas fa-plus"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <!--   service section end   -->
                @elseif (serviceCategory())
                    <!--   service category section start   -->
                    <div class="service-categories">
                        <div class="container">
                            <div class="row ">
                                <div class="col-lg-12 ">
                                    <h2 class="section-title">{{ convertUtf8($bs->service_section_title) }}</h2>
                                    <h2 class="section-summary hide">{{ convertUtf8($bs->service_section_subtitle) }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row">
                                @foreach ($scategories as $key => $scategory)
                                    <!--col-xl-3 col-lg-3 col-sm-6-->
                                    <div class="col-12 col-md-3 dir-cust  mt-3 ">
                                        <div class="single-category">
                                            @if (!empty($scategory->image))
                                                <div class="img-wrapper">
                                                    <img class="lazy"
                                                        data-src="{{ asset('assets/front/img/service_category_icons/' . $scategory->image) }}"
                                                        alt="">
                                                </div>
                                            @endif
                                            <div class="text">
                                                <h4 style="color:{{ convertUtf8($scategory->title_color) }}">
                                                    {{ convertUtf8($scategory->name) }}</h4>
                                                <p>
                                                    @if (strlen($scategory->short_text) > 160)
                                                        {{ mb_substr($scategory->short_text, 0, 160, 'utf-8') }}<span
                                                            style="display: none;">{{ mb_substr($scategory->short_text, 160, null, 'utf-8') }}</span>
                                                        <!--<a href="#" class="see-more">{{ __('see more') }}...</a>-->
                                                    @else
                                                        {{ $scategory->short_text }}
                                                    @endif
                                                </p>
                                                <a href="{{ route('front.services', ['category' => $scategory->id]) }}"
                                                    class="readmore">{{ __('View Services') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!--   service category section end orginal   -->
                @endif
            @endif


            @if ($bs->pricing_section == 1)

                <section class="packages-section">
                    <div class="container">
                        <div class="row text-center">
                            <div class="col-lg-12 px-0">
                                <div class="tab-back">
                                    <ul class="nav nav-tabs ul-tab" id="myTab" role="tablist">
                                        @foreach ($sections as $section)
                                            <li class="nav-item li-tab" role="presentation">
                                                <a data-toggle="tab" aria-controls="home"
                                                    class="nav-link @if ($loop->first) active @endif"
                                                    id="package-{{ $section->id }}-tab"
                                                    href="#package_{{ $section->id }}" role="tab_{{ $section->id }}"
                                                    aria-selected="true">
                                                    {{ $section->name }}
                                                </a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-12 px-0">
                                <h5 class="mt-4 mb-3 sub-header">
                                    {{ __('app.desc_pack') }}
                                </h5>
                                <button type="button" class="btn btn-cal" data-toggle="modal"
                                    data-target=".bd-example-modal-lg" id="bpackjs"><i
                                        class="fas fa-calculator mr-2 ml-2"></i>
                                    {{ __('app.countyourpack') }}

                                </button>
                                <div class="modal fade bd-example-modal-lg modal_shown" tabindex="-1" role="dialog"
                                    aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle"><i
                                                        class="fas fa-calculator mr-2 ml-2"></i>
                                                    {{ __('app.countyourpack') }}
                                                </h5>
                                                <button type="button" class="close m-0 p-0 close-modal"
                                                    data-dismiss="modal" aria-label="{{ __('app.close') }}">
                                                    <span class="close-modal">x</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <!--start our code clac-->
                                                <div class="row" id="app">
                                                    <div class="col-12 col-md-5">
                                                        <form id="myform" class="row" action="">
                                                            <div class="col-12">

                                                                <div class="form-element   mb-0">
                                                                    <label
                                                                        style="text-align: start;">{{ __('app.typepack') }}</label>
                                                                    <select v-on:change="calculatePrice()" name="packtype"
                                                                        v-model="pack" class="form-control">
                                                                        <option value="" disabled>
                                                                            {{ __('app.chosetypepack') }}
                                                                        </option>

                                                                        <option value="basic">
                                                                            {{ __('app.silver') }}
                                                                        </option>

                                                                        <option value="silver">
                                                                            {{ __('app.gold') }}
                                                                        </option>
                                                                        <option value="gold">
                                                                            {{ __('app.plat') }}
                                                                        </option>
                                                                        <!--<option value="plat">-->
                                                                        <!--    البلاتينية-->
                                                                        <!--</option>-->
                                                                    </select>

                                                                </div>

                                                                <div
                                                                    class="form-element mb-1 mt-3 calc_subscribe_wage_protection hide-package-modal">
                                                                    <label class="mb-0">
                                                                        {{ __('app.wantwps') }}
                                                                    </label>
                                                                    <div class="">

                                                                        <select name="wps"
                                                                            v-on:change="calculatePrice()"
                                                                            v-model="save_salary" class="form-control">
                                                                            <option value="true">
                                                                                {{ __('app.yes') }}
                                                                            </option>
                                                                            <option value="false">
                                                                                {{ __('app.no') }}
                                                                            </option>
                                                                        </select>


                                                                    </div>
                                                                </div>

                                                                <div class="form-element mb-3 hide-package-modal"
                                                                    style="">
                                                                    <label> {{ __('app.staffnum') }}</label>

                                                                    <input
                                                                        style=" height: 38px; border-radius: 4px !important;"
                                                                        name="staffnum" v-on:input="calculatePrice()"
                                                                        type="number" min="0" max="99999"
                                                                        required="" class="form-control onlyNumbers"
                                                                        step="any" v-model="num_of_employees"
                                                                        placeholder="" id="texur">

                                                                </div>


                                                                <!--<div class="form-element mb-1 hide-package-modal" style="">-->
                                                                <!--  <label>  {{ __('app.staffnum') }} الإضافيين المتوقعين</label>-->

                                                                <!--                   <input name="staffthink" type="number" min="0" max="90" class="form-control onlyNumbers" v-model="future_employees" placeholder="">-->

                                                                <!--</div>-->

                                                                <div class="form-element mb-3 hide-package-modal"
                                                                    style="">
                                                                    <label> {{ __('app.years') }}</label>

                                                                    <input
                                                                        style="background: #dddddd; height: 38px; border-radius: 4px !important;"
                                                                        name="years" type="number" disabled="disabled"
                                                                        min="0" max="5"
                                                                        class="form-control onlyNumbers" v-model="period"
                                                                        placeholder="">

                                                                </div>
                                                                <!--<button type="button" class="btn btn-cal-inside" id="calculatePackage">-->
                                                                <!--<i class="fas fa-calculator mr-2 ml-2"></i>احسب قيمة اشتراكك </button>-->
                                                                <button @click="resetInput" type="button"
                                                                    class="btn btn-cal-inside rest-btn bas disabled"
                                                                    disabled>
                                                                    <i class="fas fa-redo"></i> {{ __('app.rest') }}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <div class="box-price mt-3">
                                                            <div class="mb-3">
                                                                <div class="price">
                                                                    {{ __('app.costwillbe') }}
                                                                </div>
                                                                <div class="price-nu">
                                                                    <span id="calc_half_year_value">

                                                                        <p name="price" id="price"
                                                                            v-if="num_of_employees <= 100">
                                                                            <?php echo '{{cost}}'; ?>
                                                                            {{ __('app.riyal') }}
                                                                            <span class="durations">/
                                                                                {{ __('app.yearly') }}</span>
                                                                        </p>

                                                                        <input id="sal1" name="sal1"
                                                                            style="display:none">
                                                                        <p style="font-size: 16px; color: red; font-weight: bold;"
                                                                            v-if="num_of_employees > 100">
                                                                            {{ __('app.stafflargerthan100') }} </p>

                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div>

                                                            </div>
                                                        </div>
                                                        <p class="my-3 text-center" id="noteText">
                                                            <span style="text-decoration: underline; font-weight: bold;">
                                                                <a href="/faq#category21"
                                                                    target="_blank">{{ __('app.countroles') }}</a>
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>


                                                <!--<script src="assets/front/js/axios.min.js"></script>-->
                                                <script src="/assets/front/js/vue.js"></script>

                                                <!--LOAD JS CLAC PACKAGES WHEN NEEDED (CLICK IT)-->
                                                <script>
                                                    window.onload = function() {
                                                        $.getScript("https://etmaam.com.sa/assets/front/js/packagesrules.js");
                                                        $.getScript("https://etmaam.com.sa/assets/front/js/axios.min.js");

                                                    }
                                                </script>
                                                <!--end our code clac-->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="tab-content" id="myTabContent" style="width: 100%;">
                                @foreach ($sections as $section)
                                    <div role="tabpanel" aria-labelledby="package-#{{ $section->id }}-tab"
                                        style="width: 100%;"
                                        class="tab-pane fade @if ($loop->first) active @endif show"
                                        id="package_{{ $section->id }}">
                                        <div class="row">
                                            <!--/packages/-->

                                            @foreach ($section->packages as $key => $package)
                                                @if ($section->id == 2 || $section->id == 5)
                                                    <div class="col-12 col-md-3 package-section" style="padding:0;">
                                                    @else
                                                        <div class="col-12 col-md-4 package-section">
                                                @endif
                                                <div class="single-pricing-table">
                                                    <span class="title">
                                                        {{ convertUtf8($package->title) }}
                                                    </span>
                                                    <div class="price">
                                                        <span class="start">
                                                            {{ __('app.startform') }}
                                                        </span>
                                                        <h1>
                                                            <!--{{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}-->
                                                            {{ $package->price }}
                                                            <!--{{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }}-->
                                                        </h1>

                                                        <span class="started">
                                                            {{ __('Riyal/Yearly') }}
                                                        </span>
                                                    </div>
                                                    @if ($section->id == 2 || $section->id == 5)
                                                        <div class="employee">
                                                            <i class="fas fa-users"></i>
                                                            {{ $package->staffnum }}
                                                        </div>
                                                    @endif
                                                    <a href="{{ route('front.package_quote', $package->id) }}"
                                                        class="pricing-btn">
                                                        {{ __('app.requestque') }}
                                                    </a>
                                                    <div class="features">

                                                        @if (!is_null($package->services))
                                                            @foreach ($cats->whereIn('id', explode(',', $package->services)) as $cat)
                                                                <div class="accordion"
                                                                    id="accordion{{ $package->id }}-{{ $cat->id }}">
                                                                    <div class="card mb-30">
                                                                        <a class="collapsed card-header" href="#"
                                                                            data-toggle="collapse" aria-expanded="false"
                                                                            id="heading{{ $package->id }}-{{ $cat->id }}"
                                                                            data-target="#collapse{{ $package->id }}-{{ $cat->id }}"
                                                                            aria-controls="collapse{{ $package->id }}-{{ $cat->id }}">
                                                                            <span class="toggle_btn"></span>
                                                                            <p class="feature-line-title">
                                                                                <i class="fas fa-check ch-checked"></i>
                                                                                {{ $cat->name }}
                                                                            </p>
                                                                        </a>
                                                                        <div class="collapse"
                                                                            id="collapse{{ $package->id }}-{{ $cat->id }}"
                                                                            aria-labelledby="heading{{ $package->id }}-{{ $cat->id }}"
                                                                            data-parent="#accordion{{ $package->id }}-{{ $cat->id }}">
                                                                            <div class="card-body">
                                                                                <div class="pack-des">
                                                                                    @foreach ($cat->package_services as $service)
                                                                                        <?php //echo ($service->id);
                                                                                        ?>
                                                                                        @if (in_array($service->id, explode(',', $package->services_included)))
                                                                                            <p>{{ $service->name }}</p>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                        </div>
                                @endforeach
                            </div>
                        </div>
            @endforeach
        </div>
    </div>
    </div>
    </section>
    @endif

    @if ($bs->intro_section == 1)
        <div class="row">
            <div class="col-lg-6 {{ $rtl == 1 ? 'pl-lg-0' : 'pr-lg-0' }}">
                <div class="intro-txt">
                    <span class="section-title">{{ convertUtf8($bs->intro_section_title) }}</span>
                    <h2 class="section-summary">{{ convertUtf8($bs->intro_section_text) }} </h2>
                    @if (!empty($bs->intro_section_button_url) && !empty($bs->intro_section_button_text))
                        <a href="{{ $bs->intro_section_button_url }}" class="intro-btn"
                            target="_blank"><span>{{ convertUtf8($bs->intro_section_button_text) }}</span></a>
                    @endif
                </div>
            </div>
            <div class="col-lg-6 {{ $rtl == 1 ? 'pr-lg-0' : 'pl-lg-0' }} px-md-3 px-0">
                <div class="intro-bg"
                    style="background-image: url('{{ asset('assets/front/img/' . $bs->intro_bg) }}'); background-size: cover;">
                    @if (!empty($bs->intro_section_video_link))
                        <a id="play-video" class="video-play-button" href="{{ $bs->intro_section_video_link }}">
                            <span></span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
    </div>
    </div>
    <!--    introduction area end   -->

    <!--// here is services start الخدمات الالكترونية-->



    <!--// here is services end الخدمات الالكترونية-->



    @if ($bs->approach_section == 1)
        <!--   how we do section start   -->
        <div class="approach-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="approach-summary">
                            <span class="section-title">{{ convertUtf8($bs->approach_title) }}</span>
                            <h2 class="section-summary">{{ convertUtf8($bs->approach_subtitle) }}</h2>
                            @if (!empty($bs->approach_button_url) && !empty($bs->approach_button_text))
                                <a href="{{ $bs->approach_button_url }}" class="boxed-btn"
                                    target="_blank"><span>{{ convertUtf8($bs->approach_button_text) }}</span></a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="approach-lists">
                            @foreach ($points as $key => $point)
                                <li class="single-approach">
                                    <div class="approach-icon-wrapper"><i class="{{ $point->icon }}"></i></div>
                                    <div class="approach-text">
                                        <h4>{{ convertUtf8($point->title) }}</h4>
                                        <p>
                                            @if (strlen($point->short_text) > 150)
                                                {{ mb_substr($point->short_text, 0, 150, 'utf-8') }}<span
                                                    style="display: none;">{{ mb_substr($point->short_text, 150, null, 'utf-8') }}</span>
                                                <a href="#" class="see-more">{{ __('see more') }}...</a>
                                            @else
                                                {{ $point->short_text }}
                                            @endif
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--   how we do section end   -->
    @endif

    <!--/// faq question -->
    <div class="row px-0 keepaway">
        <div class="col-7">
            <h2 class="section-title">{{ __('How can we help?') }}</h2>
        </div>

        <div class="col-5  " style="text-align: end;"> <a href="/faq" class=" readmore_link m-1"
                style="top: 25px;color: #235577;
    font-weight: 600;">{{ __('All Questions') }}<i
                    class="fas m-1 fa-angle-double-right"></i></a>
        </div>
    </div>
    <div class="">
        <div class="faq-section py-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="accordion" id="accordionExample1">
                        @for ($i = 0; $i < ceil(count($faqs) / 2); $i++)
                            <div class="card">
                                <div class="card-header" id="heading{{ $faqs[$i]->id }}">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed btn-block text-left" type="button"
                                            data-toggle="collapse" data-target="#collapse{{ $faqs[$i]->id }}"
                                            aria-expanded="false" aria-controls="collapse{{ $faqs[$i]->id }}">
                                            {{ convertUtf8($faqs[$i]->question) }}
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse{{ $faqs[$i]->id }}" class="collapse"
                                    aria-labelledby="heading{{ $faqs[$i]->id }}" data-parent="#accordionExample1">
                                    <div class="card-body">
                                        <!--old -->
                                        <!--convertUtf8($faqs[$i]->answer)-->
                                        {!! preg_replace(
                                            '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/',
                                            '<a href="$0" target="_blank">$0</a>',
                                            str_replace('-', '<br>', $faqs[$i]->answer),
                                        ) !!}
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
    <!--// end faq-->





    @if ($bs->approach_section == 1)
        <!--   how we do section start   -->
        <div class="approach-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="approach-summary">
                            <h2 class="section-title">{{ convertUtf8($bs->approach_title) }}</h2>
                            <h2 class="section-summary hide">{{ convertUtf8($bs->approach_subtitle) }}</h2>
                            @if (!empty($bs->approach_button_url) && !empty($bs->approach_button_text))
                                <a href="{{ $bs->approach_button_url }}" class="boxed-btn"
                                    target="_blank"><span>{{ convertUtf8($bs->approach_button_text) }}</span></a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="approach-lists">
                            @foreach ($points as $key => $point)
                                <li class="single-approach">
                                    <div class="approach-icon-wrapper"><i class="{{ $point->icon }}"></i></div>
                                    <div class="approach-text">
                                        <h4>{{ convertUtf8($point->title) }}</h4>
                                        <p>
                                            @if (strlen($point->short_text) > 150)
                                                {{ mb_substr($point->short_text, 0, 150, 'utf-8') }}<span
                                                    style="display: none;">{{ mb_substr($point->short_text, 150, null, 'utf-8') }}</span>
                                                <a href="#" class="see-more">{{ __('see more') }}...</a>
                                            @else
                                                {{ $point->short_text }}
                                            @endif
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--   how we do section end   -->
    @endif


    @if ($bs->statistics_section == 1)
        <!--    statistics section start    -->
        <div class="statistics-section"
            @if ($bs->home_version != 'parallax') style="background-image: url('{{ asset('assets/front/img/' . $be->statistics_bg) }}'); background-size:cover;" @endif
            id="statisticsSection"
            @if ($bs->home_version == 'parallax') data-parallax="scroll" data-speed="0.2" data-image-src="{{ asset('assets/front/img/' . $be->statistics_bg) }}" @endif>
            <div class="statistics-container">
                <div class="container">
                    <div class="row no-gutters">
                        @foreach ($statistics as $key => $statistic)
                            <div class="col-lg-3 col-md-6">
                                <div class="round" data-value="1"
                                    data-number="{{ convertUtf8($statistic->quantity) }}" data-size="200"
                                    data-thickness="6"
                                    data-fill="{
                     &quot;color&quot;: &quot;#{{ $bs->base_color }}&quot;
                     }">
                                    <strong></strong>
                                    <h5><i class="{{ $statistic->icon }}"></i> {{ convertUtf8($statistic->title) }}
                                    </h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!--    statistics section end    -->
    @endif


    @if ($bs->portfolio_section == 1)
        <!--    case section start   -->
        <div class="case-section">
            <div class="container">
                <div class="row text-center">
                    <div class="col-lg-6 offset-lg-4">
                        <h2 class="section-title">{{ convertUtf8($bs->portfolio_section_title) }}</h2>
                        <h2 class="section-summary hide">{{ convertUtf8($bs->portfolio_section_text) }}</h2>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="case-carousel owl-carousel owl-theme">
                            @foreach ($portfolios as $key => $portfolio)
                                <div class="single-case single-case-bg-1"
                                    style="background-image: url('{{ asset('assets/front/img/portfolios/featured/' . $portfolio->featured_image) }}');">
                                    <div class="outer-container">
                                        <div class="inner-container">
                                            <h4>{{ strlen($portfolio->title) > 36 ? mb_substr($portfolio->title, 0, 36, 'utf-8') . '...' : $portfolio->title }}
                                            </h4>
                                            @if (!empty($portfolio->service))
                                                <p>{{ $portfolio->service->title }}</p>
                                            @endif

                                            <a href="{{ route('front.portfoliodetails', [$portfolio->slug, $portfolio->id]) }}"
                                                class="readmore-btn"><span>{{ __('Read More') }}</span></a>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--    case section end   -->
    @endif




    @if ($bs->news_section == 1)
        <!--    blog section start   -->
        <div class="blog-section section-padding">
            <div class="container">
                <div class="row px-0 keepaway">
                    <div class="col-7">
                        <h2 class="section-title">{{ convertUtf8($bs->blog_section_title) }}</h2>
                        <h2 class="section-summary hide">{{ convertUtf8($bs->blog_section_subtitle) }}</h2>
                    </div>

                    <div class="col-5  " style="text-align: end;"> <a href="/blogs" class=" readmore_link m-1"
                            style="top: 25px;color: #235577;
    font-weight: 600;"> {{ __('app.All News') }}<i
                                class="fas m-1 fa-angle-double-right"></i></a>
                    </div>
                </div>

                <div class="blog-carousel owl-carousel owl-theme common-carousel">
                    @foreach ($blogs as $key => $blog)
                        <div class="single-blog">
                            <div class="blog-img-wrapper">
                                <img class="lazy" src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}"
                                    alt="">
                            </div>
                            <div class="blog-txt">
                                @php
                                    $blogDate = \Carbon\Carbon::parse($blog->created_at)->locale("$currentLang->code");
                                    $blogDate = $blogDate->translatedFormat('jS F, Y');
                                @endphp

                                @if ($blog->author != null)
                                    <p class="date"><small>{{ __('By') }} <span
                                                class="username">{{ $blog->author }}</span></small> |
                                        <small>{{ $blogDate }}</small>
                                    </p>
                                @else
                                    <p class="date"><small>{{ __('By') }} <span
                                                class="username">{{ $blog->author }} {{ __('Admin') }}</span></small>
                                        | <small>{{ $blogDate }}</small> </p>
                                @endif

                                <h4 class="blog-title"><a
                                        href="{{ route('front.blogdetails', [$blog->id]) }}">{{ strlen($blog->title) > 26 ? mb_substr($blog->title, 0, 26, 'utf-8') . '...' : $blog->title }}</a>
                                </h4>


                                <p class="blog-summary">{!! strlen(strip_tags($blog->content)) > 150
                                    ? mb_substr(strip_tags($blog->content), 0, 150, 'utf-8') . '...'
                                    : strip_tags($blog->content) !!}</p>


                                <a href="{{ route('front.blogdetails', [$blog->id]) }}"
                                    class="readmore-btn"><span>{{ __('Read More') }}</span></a>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!--    blog section end   -->
    @endif




    @if ($bs->testimonial_section == 1)
        <!--   Testimonial section start    -->
        <div class="testimonial-section pb-115 mb-3">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-12 ">
                        <h2 class="section-title keepaway">{{ convertUtf8($bs->testimonial_title) }}</h2>
                        <h2 class="section-summary hide">{{ convertUtf8($bs->testimonial_subtitle) }}</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="testimonial-carousel owl-carousel owl-theme">
                            @foreach ($testimonials as $key => $testimonial)
                                <div class="single-testimonial">
                                    <div class="img-wrapper"><img class="lazy"
                                            data-src="{{ asset('assets/front/img/testimonials/' . $testimonial->image) }}"
                                            alt=""></div>
                                    <div class="client-desc">
                                        <p class="comment">{{ convertUtf8($testimonial->comment) }}</p>
                                        <h6 class="name">{{ convertUtf8($testimonial->name) }}</h6>
                                        <p class="rank">{{ convertUtf8($testimonial->rank) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--   Testimonial section end    -->
    @endif


    @if ($bs->team_section == 1)
        <!--    team section start   -->
        <div class="team-section section-padding"
            @if ($bs->home_version != 'parallax') style="background-image: url('{{ asset('assets/front/img/' . $bs->team_bg) }}'); background-size:cover;" @endif
            @if ($bs->home_version == 'parallax') data-parallax="scroll" data-speed="0.2" data-image-src="{{ asset('assets/front/img/' . $bs->team_bg) }}" @endif>
            <div class="team-content">
                <div class="container">
                    <div class="row text-center">
                        <div class="col-lg-6 offset-lg-4">
                            <h2 class="section-title keepaway" style="color:#fff!important">
                                {{ convertUtf8($bs->team_section_title) }}</h2>
                            <h2 class="section-summary hide">{{ convertUtf8($bs->team_section_subtitle) }}</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="team-carousel common-carousel owl-carousel owl-theme">
                            @foreach ($members as $key => $member)
                                <div class="single-team-member">
                                    <div class="team-img-wrapper">
                                        <img class="lazy"
                                            data-src="{{ asset('assets/front/img/members/' . $member->image) }}"
                                            alt="">
                                        <div class="social-accounts">
                                            <ul class="social-account-lists">
                                                @if (!empty($member->facebook))
                                                    <li class="single-social-account"><a
                                                            href="{{ $member->facebook }}"><i
                                                                class="fab fa-facebook-f"></i></a></li>
                                                @endif
                                                @if (!empty($member->twitter))
                                                    <li class="single-social-account"><a
                                                            href="{{ $member->twitter }}"><i
                                                                class="fab fa-twitter"></i></a></li>
                                                @endif
                                                @if (!empty($member->linkedin))
                                                    <li class="single-social-account"><a
                                                            href="{{ $member->linkedin }}"><i
                                                                class="fab fa-linkedin-in"></i></a></li>
                                                @endif
                                                @if (!empty($member->instagram))
                                                    <li class="single-social-account"><a
                                                            href="{{ $member->instagram }}"><i
                                                                class="fab fa-instagram"></i></a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="member-info">
                                        <h5 class="member-name">{{ convertUtf8($member->name) }}</h5>
                                        <small>{{ convertUtf8($member->rank) }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--    team section end   -->
    @endif

    
    @if ($bs->call_to_action_section == 1)
        <!--    call to action section start    -->
        <div class="cta-section"
            style="background-image: url('{{ asset('../../../../assets/front/img/' . $bs->cta_bg) }}');background-size:cover;">
            <div class="container">
                <div class="cta-content">
                    <div class="row">
                        <div class="col-md-9 col-lg-7">
                            <h3>{{ convertUtf8($bs->cta_section_text) }}</h3>
                        </div>
                        <div class="col-md-3 col-lg-5 contact-btn-wrapper">
                            <a href="{{ $bs->cta_section_button_url }}"
                                class="boxed-btn contact-btn"><span>{{ convertUtf8($bs->cta_section_button_text) }}</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--    call to action section end    -->
    @endif



    @if ($bs->partner_section == 1)
        <!--   partner section start    -->
        <div class="partner-section">
            <div class="container {{ $be->theme_version != 'dark' ? 'top-border' : '' }}">
                <div class="row">
                    <div class="col-md-12">
                        <div class="partner-carousel owl-carousel owl-theme common-carousel">
                            @foreach ($partners as $key => $partner)
                                <a class="single-partner-item d-block" href="{{ $partner->url }}" target="_blank">
                                    <div class="outer-container">
                                        <div class="inner-container">
                                            <img class="lazy"
                                                data-src="{{ asset('assets/front/img/partners/' . $partner->image) }}"
                                                alt="">
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--   partner section end    -->
    @endif

@endsection
