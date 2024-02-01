@extends("front.$version.layout")

@section('pagename')
- {{__('app.lp')}}
@endsection

@section('meta-keywords', "$be->packages_meta_keywords")
@section('meta-description', "$be->packages_meta_description")


@section('breadcrumb-title', __('app.lp'))
@section('breadcrumb-subtitle', $be->pricing_subtitle)
@section('breadcrumb-link', __('app.breadlp'))


@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.16/css/intlTelInput.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.16/js/intlTelInput-jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer"


        <!-- Start Landing Section -->

            <div>
        
                    <!--start slider-->
            <div class="hero-area lazy entered loaded" data-bg="/" style="background-size: cover;     background-position: bottom; background-image: url(&quot;https://etmaam.com.sa/assets/front/img/main_34834804y8h0ni4.jpg&quot;);" data-ll-status="loaded">
               <div class="container">
                  <div class="hero-txt">
                     <div class="row">
                        <div class="col-12">
            <span>{{__('app.lp')}} <br> {{__('app.breadlp')}}
            <h3 style="font-weight:400!important" class="slider-des">{{__('app.lpdesc')}} </h3>
                                            <!--<a href="/serv_req" class="boxed-btn spc">تقدم بطلبك</a>-->

                                          <a href="#videoshow" class="hero-boxed-btn">{{__('app.readmore')}}</a>
                                       </div>
                     </div>
                  </div>
               </div>
               <div class="hero-area-overlay" style="background-color: #0A3041;opacity: 0.60;"></div>
            </div>
            <!--end slider-->



    <div class="mobile-serv d-block  d-md-none" style="position: fixed;
    bottom: 22px;
    right: 36%;
    z-index: 99999;
    border-radius: 5px;">
        <a style="border-radius: 50px;" href="https://etmaam.com.sa/serv_req?msource=google" class="boxed-btn shine">{{__('Request A Quote')}}</a>
    </div>



    <!--    introduction area start   -->
    <div class="intro-section" id="videoshow" @if($bs->feature_section == 0) style="margin-top: 0px;" @endif>
        <div class="container">
            @if ($bs->feature_section == 1)
                <div class="hero-features">
                    <div class="row">
                        @foreach ($features as $key => $feature)
                            <style>
                                .sf{{$feature->id}}::after {
                                    background-color: #{{$feature->color}};
                                }
                            </style>
                            <div class="col-md-3 col-sm-6 single-hero-feature sf{{$feature->id}}" style="background-color: #{{$feature->color}};">
                                <div class="outer-container">
                                    <div class="inner-container">
                                        <div class="icon-wrapper">
                                            <!--<i class="{{$feature->icon}}"></i>-->
                                            <img src="{{$feature->icon}}" width="63px" hegith="40px">

                                        </div>
                                        <h3>{{convertUtf8($feature->title)}}</h3>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

    <!--    introduction area end   -->


        <!-- End Services Section -->
    </div>




       @if ($bs->intro_section == 1)
       <div class="" >
                  <div class="about-us">
       <div class="container">  
          <div class="row">
        
                     <div class=" col-12 col-lg-6 mb-4 " style="min-height: 260px;">
                        <div class="intro-bg"
                            style="background-image: url('https://etmaam.com.sa/assets/front/img/628fdc7dcad22.jpg'); background-size: cover;">
                            <a id="play-video" class="video-play-button"
                                href="https://www.youtube.com/watch?v=MwzSeuNiO6s">
                                <span></span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 ">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">{{__('Who is Etmaam?')}} </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">{{__('Our Vision')}} </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">{{__('Our Mission')}}</a>
                            </li>
                          </ul>
                          <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <p class="tab-p"> 
                                {{convertUtf8($bs->intro_section_text)}}
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <p  class="tab-p">
                                {{convertUtf8($bs->our_vision)}}
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                <p  class="tab-p">
                                {{convertUtf8($bs->our_mission)}}
                            </div>
                          </div>
                        
                </div>

                       </div>

                </div>
                       </div>
       </div>

                @endif
       






                @if (!serviceCategory())
                    <!--   service section start   -->
                    <section class="services-area pb-130">
                        <div class="container">
                            <div class="row ">
                                <div class="col-lg-12">
                                    <span class="section-title">{{convertUtf8($bs->service_section_title)}}</span>
                                    <h2 class="section-summary hide">{{convertUtf8($bs->service_section_subtitle)}}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row justify-content-center">
                                @foreach ($services as $service)
                                    <div class="col-lg-4 col-md-6 col-sm-8">
                                        <div class="services-item mt-30">
                                            <div class="services-thumb">
                                                <img class="lazy" data-src="{{asset('assets/front/img/services/' . $service->main_image)}}" alt="service" />
                                            </div>
                                            <div class="services-content">
                                                <a class="title" @if($service->details_page_status == 1) href="{{route('front.servicedetails', [$service->slug, $service->id])}}" @endif><h4>{{$service->title}}</h4></a>

                                                <p>
                                                    @if (strlen($service->summary) > 120)
                                                        {{mb_substr($service->summary, 0, 120, 'utf-8')}}<span style="display: none;">{{mb_substr($service->summary, 120, null, 'utf-8')}}</span>
                                                        <a href="#" class="see-more">{{__('see more')}}...</a>
                                                    @else
                                                        {{$service->summary}}
                                                    @endif
                                                </p>

                                                @if ($service->details_page_status == 1)
                                                    <a href="{{route('front.servicedetails', [$service->slug, $service->id])}}">{{__('Read More')}} <i class="fas fa-plus"></i></a>
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
                                    <h2 class="section-title">{{convertUtf8($bs->service_section_title)}}</h2>
                                    <h2 class="section-summary hide">{{convertUtf8($bs->service_section_subtitle)}}</h2>
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
                                                    <img class="lazy" data-src="{{asset('assets/front/img/service_category_icons/'.$scategory->image)}}" alt="">
                                                </div>
                                            @endif
                                            <div class="text">
                                                <h4 style="color:{{convertUtf8($scategory->title_color)}}">{{convertUtf8($scategory->name)}}</h4>
                                                <p>
                                                    @if (strlen($scategory->short_text) > 160)
                                                        {{mb_substr($scategory->short_text, 0, 160, 'utf-8')}}<span style="display: none;">{{mb_substr($scategory->short_text, 160,null, 'utf-8')}}</span>
                                                        <!--<a href="#" class="see-more">{{__('see more')}}...</a>-->
                                                    @else
                                                        {{$scategory->short_text}}
                                                    @endif
                                                </p>
                                                <a href="{{route('front.services', ['category'=>$scategory->id])}}" class="readmore">{{__('View Services')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!--   service category section end orginal   -->
                @endif

<!-- Start Our company section --> <!--    <section class="our-company">--> <!--        <div class="container">--> <!--            <div class="row">--> <!--                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">--> <!--                    <div class="our-company-content">--> <!--                        <div class="our-company-slider">--> <!--                            <div class="our-slider">--> <!--                                <div class="service-slide">--> <!--                                    <div>--> <!--                                        <div class="overlay">--> <!--                                        </div>--> <!--                                        <div class="text">--> <!--                                            <img src="https://etmaam.com.sa/assets/front/img/file.png">--> <!--                                            <h2>خدمات المستثمرين لإتاحة بيئة إستثمارية</h2>--> <!--                                            <a href="#">--> <!--                                                <i class="fa-solid fa-angle-left"></i> <i class="fa-solid fa-angle-left"></i> أعرف أكثر--> <!--                                            </a>--> <!--                                        </div>--> <!--                                    </div>--> <!--                                </div>--> <!--                                <div class="service-slide">--> <!--                                    <div>--> <!--                                        <div class="overlay">--> <!--                                        </div>--> <!--                                        <div class="text">--> <!--                                            <img src="https://etmaam.com.sa/assets/front/img/city.png">--> <!--<h2>تسجيل العلامة التّجاريّة بهدف صونها</h2>--> <!--                                            <a href="#">--> <!--                                                <i class="fa-solid fa-angle-left"></i> <i class="fa-solid fa-angle-left"></i> أعرف أكثر--> <!--                                            </a>--> <!--                                        </div>--> <!--                                    </div>--> <!--                                </div>--> <!--                                <div class="service-slide">--> <!--                                    <div>--> <!--                                        <div class="overlay">--> <!--                                        </div>--> <!--                                        <div class="text">--> <!--                                            <img src="https://etmaam.com.sa/assets/front/img/edit.png">--> <!--                                            <h2>إدارة الخدمات الإلكترونيّة المختلفة</h2>--> <!--                                            <a href="#">--> <!--                                                <i class="fa-solid fa-angle-left"></i> <i class="fa-solid fa-angle-left"></i> أعرف أكثر--> <!--                                            </a>--> <!--                                        </div>--> <!--                                    </div>--> <!--                                </div>--> <!--                                <div class="service-slide">--> <!--                                    <div>--> <!--                                        <div class="overlay">--> <!--                                        </div>--> <!--                                        <div class="text">--> <!--                                            <img src="https://etmaam.com.sa/assets/front/img/zoom.png">--> <!--                                            <h2>خدمات تحويل الشكل القانوني للمنشات</h2>--> <!--                                            <a href="#">--> <!--                                                <i class="fa-solid fa-angle-left"></i> <i class="fa-solid fa-angle-left"></i> أعرف أكثر--> <!--                                            </a>--> <!--                                        </div>--> <!--                                    </div>--> <!--                                </div>--> <!--                                <div class="service-slide">--> <!--                                    <div>--> <!--                                        <div class="overlay">--> <!--                                        </div>--> <!--                                        <div class="text">--> <!--                                            <img src="https://etmaam.com.sa/assets/front/img/hammer.png">--> <!--                                            <h2>خدمات تحويل الشكل القانوني للمنشات</h2>--> <!--                                            <a href="#">--> <!--                                                <i class="fa-solid fa-angle-left"></i> <i class="fa-solid fa-angle-left"></i> أعرف أكثر--> <!--                                            </a>--> <!--                                        </div>--> <!--                                    </div>--> <!--                                </div>--> <!--                                <div class="service-slide">--> <!--                                    <div>--> <!--                                        <div class="overlay">--> <!--                                        </div>--> <!--                                        <div class="text">--> <!--                                            <img src="https://etmaam.com.sa/assets/front/img/file-capped.png">--> <!--                                            <h2>خدمات تأسيس الشّركات والمؤسسات</h2>--> <!--                                            <a href="#">--> <!--                                                <i class="fa-solid fa-angle-left"></i> <i class="fa-solid fa-angle-left"></i> أعرف أكثر--> <!--                                            </a>--> <!--                                        </div>--> <!--                                    </div>--> <!--                                </div>--> <!--                            </div>--> <!--                        </div>--> <!--                    </div>--> <!--                </div>--> <!--                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">--> <!--                    <div class="our-company-content">--> <!--                        <h1 style="align-content: end;--> <!--    border-bottom: solid;--> <!--    font-weight: 600;--> <!--    padding: 5px;">--> <!--أبرز خدمات إتمام--> <!--</h1>--> <!--                    </div>--> <!--                </div>--> <!--            </div>--> <!--        </div>--> <!--    </section>--> <!-- End Our company section -->






    <!-- Start Contact form Section -->

    <section class="" id="contactus">
        <div class="container">
            <div class="row">

                <div class="col-md-6 mb-4 ">
                    <div class="container">
                            <div class="row ">
                                <div class="col-lg-12">
                                    <span class="section-title">{{__('app.quickservice')}}</span>
                                </div>
                            </div>
                        </div>
                             <div class="container ">
            <div class="row">


                        
                <form action="{{route('front.sendmail')}}" class="contact-form" method="POST" id="QuickForm" style="">
                    @csrf
                    
                    <div class="form-group" style="display:none;"> 
                   <input name="msource" type="text" value="{{ request()->get('msource')}}"  placeholder="" id="msource2">
                    <input name="secure" type="text"  placeholder="" id="secure">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-element">
                                <input name="name" type="text" placeholder="{{__('messages.responsible_person_placeholder')}} *" required>
                            </div>
                            @if ($errors->has('name'))
                            <p class="text-danger mb-0">{{$errors->first('name')}}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="form-element">
                                <input name="email" type="email" placeholder="{{__('messages.email_placeholder')}}">
                            </div>
                            @if ($errors->has('email'))
                            <p class="text-danger mb-0">{{$errors->first('email')}}</p>
                            @endif
                        </div>
                        
                                                <div class="col-md-6">
                            <div class="form-element">
                                <select name="subject" style="width:100%;" id="">
                                    @if($currentLang->code == 'ar')
                                      <option disabled selected  value> -- اختر الخدمة -- </option>
<option>خدمات تأسيس المؤسسات والشركات</option>
<option>خدمات وزارة الاستثمار (تأسيس الشركات الأجنبية)</option>
<option>خدمات تحويل الشكل القانوني للمنشآت</option>
<option>خدمات تسجيل العلامات التجارية</option>
<option>خدمات التأمين التعاوني للمنشآت</option>
<option>خدمات تسجيل العمالة ذات المهن العليا</option>
<option>خدمات اعتماد لوائح تنظيم العمل</option>
<option>خدمات الشطب وإنهاء السجلات والنشاط وجميع الملفات لدى جميع الجهات</option>
<option>خدمات تخفيف الأعباء المالية عن المنشآت</option>
<option>خدمات إدارة المنصات الحكومية للمنشآت</option>
<option>خدمات الدعم المباشر لتحديات الوزارات الحكومية</option>
<option>خدمات إتمام لإدارة الرواتب (نظام حماية الأجور)</option>
<option>خدمات مراجعة ومتابعة المعاملات المتعلقة في وزارة الموارد البشرية</option>
<option>خدمات وزارة التجارة</option>
<option>خدمات وزارة الاعلام</option>
<option>خدمات هيئة الزكاة والضريبة والجمارك</option>
<option>خدمات الدفاع المدني (سلامة)</option>
<option>خدمات الاستشارات القانونية في مجال العلاقات الحكومية</option>
<option>خدمات الاشتراك في باقات الاستشارات والخدمات</option>
<option>خدمات الاشتراك في برامج هدف</option>
<option>خدمات منصة بلدي</option>
<option>خدمات منصة قوى</option>
<option>الخدمات القانونية (الاستشارات القانونية، التمثيل القضائي في القضايا العمالية والتجارية)</option>
<option>خدمات أخرى</option>

                                        @else
                                      <option disabled selected  value> -- Select The Service -- </option>
<option>Services for Establishing Institutions and Companies</option>
<option>Ministry of Investment Services (Establishment of Foreign Companies)</option>
<option>Services for Changing the Legal Form of institutions</option>
<option>Trademark Registration Services</option>
<option>Cooperative Insurance Services for institutions</option>
<option>Registration Services for Highly Skilled Workers</option>
<option>Accreditation Services for Labor Regulations</option>
<option>Services for Deletion, Termination of Records, Activities, and All Files from all Authorities</option>
<option>Services for Alleviating Financial Burdens on institutions</option>
<option>Services for Managing Government Platforms for institutions</option>
<option>Direct Support Services for Government Ministries' Challenges</option>
<option>Etmaam services for Salary Management (Wages Protection System)</option>
<option>Services for Reviewing and Monitoring Transactions related to the Ministry of Human Resources</option>
<option>Services for the Ministry of Commerce</option>
<option>Services for the Ministry of Information</option>
<option>Services for the Zakat, Tax, and Customs Authority (zakatca)</option>
<option>Civil Defense Services (Salama)</option>
<option>Legal Consultation Services in the Field of Government Relations</option>
<option>Subscription Services for Consultations and Services Packages</option>
<option>Subscription Services for Hadef Programs</option>
<option>Baladi Platform Services</option>
<option>Qiawa Platform Services</option>
<option>Legal Services (Legal Consultations, Judicial Representation in Labor and Commercial Cases)</option>
<option>Other Services</option>
@endif
                                </select>

                            </div>

                            @if ($errors->has('subject'))
                            <p class="text-danger mb-0">{{$errors->first('subject')}}</p>
                            @endif
                        </div>
                        
                        
                        <div class="col-md-6">
                            <div class="form-element">
                                <input name="mobile" type="tel" style="width:100%;" placeholder="{{__('messages.mobile_placeholder')}} *" required>
                            </div>
                        </div>

                        

                        

                        
                        <div class="col-md-12">
                            <div class="form-element">
                                <textarea name="message" id="comment" cols="30" rows="10" placeholder="{{__('Comment')}} *" required></textarea>
                            </div>
                            @if ($errors->has('message'))
                            <p class="text-danger mb-0">{{$errors->first('message')}}</p>
                            @endif
                        </div>
                        @if ($bs->is_recaptcha == 1)
                        <div class="col-lg-12 mb-4">
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!}
                            @if ($errors->has('g-recaptcha-response'))
                            @php
                            $errmsg = $errors->first('g-recaptcha-response');
                            @endphp
                            <p class="text-danger mb-0">{{__("$errmsg")}}</p>
                            @endif
                        </div>
                        @endif

                        <div class="col-md-12 mb-4">
                            <div class="form-element no-margin">
                                <input type="submit" value="{{__('Submit')}}" style="padding: 12px 34px !important;">
                            </div>
                        </div>
                    </div>
                </form>
                
                        <button type="button" class="btn-sub font-lg btn btn-success" style="background-color: #0A3041; border: 1px solid #0A3041;hover:color: #0A3041;color:#fff;display:none;" onclick="back()" id="btnID2">
        {{__('app.backtopervious')}}
    </button>

</div>
</div>

                    
                </div>

 <div class=" col-12 col-lg-6 mb-4  get-touch-box" >
                        <div class="container">
                            <div class="row ">
                                <div class="col-lg-12">
                                    <span class="section-title">{{__('app.contactinfo')}}</span>
                                </div>
                            </div>
                        </div>


 	<div class="gt-th-row"> 	
 	<div class="gt-th-card" data-column-id="mpc_column-761a549dc999b0">

 			<div class="gt-th-card-item">
 				<div class="first-box">
 					<div class="gt-tc-icon-wrap"><img src="https://img.icons8.com/bubbles/55/000000/whatsapp.png" />
 					</div>
 					<p class="gt-tc-bx-head">{{__('app.whatsappetm')}}</p>
 				</div>
 				<div class="second-box">
 					<p class="gt-tc-bx-content">
 {{__('app.whatsappetmdesc')}}
 					</p><a class="get-touch-bx-anchor my_btn"
 						href="https://wa.me/966554799222">  {{__('app.talkwithus')}}</a>
 				</div>
 			</div>

 		</div>

 		<div class="gt-th-card" data-column-id="mpc_column-9761a549dc995c4">



 			<div class="gt-th-card-item">
 				<div class="first-box">
 					<div class="gt-tc-icon-wrap"><img src="https://img.icons8.com/bubbles/55/000000/cell-phone.png" />
 					</div>
 					<p class="gt-tc-bx-head">{{__('app.mobileetma')}}</p>
 				</div>

 				<div class="second-box">
 					<p class="gt-tc-bx-content">
 					            {{__('app.contactetm')}}

 					    
 					</p><a class="get-touch-bx-anchor" href="tel:920022444">
 						920022444</a>
 				</div>
 			</div>


 		</div>
 		 		<div class="gt-th-card" data-column-id="mpc_column-4661a549dc991b4">

 			<div class="gt-th-card-item">
 				<div class="first-box">
 					<div class="gt-tc-icon-wrap">
 						<img src="https://img.icons8.com/bubbles/54/000000/google-maps.png" />
 					</div>
 					<p class="gt-tc-bx-head">{{__('app.locationetm')}}</p>
 				</div>
 				<div class="second-box">
 					<p class="gt-tc-bx-content">
                        {{__('app.locationdecs')}}
 					     </p><a class="get-touch-bx-anchor"
 						href="https://goo.gl/maps/oistULBhfFniKAoA9">    {{__('app.findus')}}</a>
 				</div>
 			</div>



 		</div>

 	</div>

 	<div class="gt-th-social-links mb-4">
 		<p class="gt-th-paragraph"> {{__('app.followus')}}</p>
 		<!--<a href="#"><img style="width: 57px;padding: 5px;" src="images/linkedin.png" alt=""></a>-->
              <a href="https://www.twitter.com/etmaam2" class="social-link-icon twitter"><img src="https://etmaam.com.sa/assets/front/img/twitter01.png" alt="twitter"></a>
              <a href="https://www.facebook.com/439979456929558" class="social-link-icon facebook"><img src="https://etmaam.com.sa/assets/front/img/Facebook01.png" alt="facebook"></a>
              <a href="https://www.instagram.com/etmaam2" class="social-link-icon instagram"><img src="https://etmaam.com.sa/assets/front/img/instagram01.png" alt="instagram"></a>
              <!--<a href="#"><img style="width: 57px;padding: 5px;" src="images/snapchat.png" src="images/snapchat.png" alt=""></a>-->
              <a href="https://www.youtube.com/user/modhaf" class="social-link-icon youtube"><img src="https://etmaam.com.sa/assets/front/img/youtube01.webp" alt="youtube"></a>

 	</div>

                </div>
                
            </div>
    </section>



    <!-- Start Success Section  -->

    <!--<section class="success">-->
    <!--   <div class="container">  -->
    <!--      <div class="row">-->
        
    <!--                 <div class=" col-12 col-lg-12 mt-2 ">-->
    <!--            <div class="success-content">-->
    <!--                <h1> نجاحنا مدفوع بمجموعة من العوامل ; فريق عمل متفاني وادارة ذات روية ثاقبة فضلا عن قدرتنا على الابتكار المدعومة بخبرتنا الطويلة في الخدمات وريادة الأعمال</h1>-->
    <!--                <img src="https://etmaam.com.sa/assets/front/img/building.png">-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--    </div>-->
    <!--</section>-->


    <!-- End Success Section -->


<!--<section class="clients"> <div class="container"> <div class="row"> <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> <div class="clients-content"> <h1>علاقة قوية وموثوقة مع عملائنا</h1> <div> <div class="left"> <div class="inner-left"> <div> <h2>النمو</h2> <h3>+300%</h3> </div> <div> <h2>استشارة مجانية</h2> <h3>+20000</h3> </div> </div> <span class="horizntal-line"></span> <div class="inner-right"> <img src="https://etmaam.com.sa/assets/front/img/arrow.png"> <img src="https://etmaam.com.sa/assets/front/img/stats.png"> </div> </div> <div class="right"> <div class="inner-left"> <div> <h2>عملاء راضون</h2> <h3>+10000</h3> </div> <div> <h2>تقييم ايجابي</h2> <h3>+5000</h3> </div> </div> <span class="horizntal-line"></span> <div class="inner-right"> <img src="https://etmaam.com.sa/assets/front/img/user.png"> <img src="https://etmaam.com.sa/assets/front/img/speed.png"> </div> </div> </div> </div> </div> <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> <div class="clients-content"> <img class="worldico" src="https://etmaam.com.sa/assets/front/img/Group 57.png"> </div> </div> </div> </div> </section>-->



    <!-- Start Clients Section -->
<!-- php dd($statistics); ?>-->

            <!--    statistics section start    -->
            <div class="statistics-section" @if($bs->home_version != 'parallax') style="background-image: url('{{asset('assets/front/img/'.$be->statistics_bg)}}'); background-size:cover;" @endif id="statisticsSection" @if($bs->home_version == 'parallax') data-parallax="scroll" data-speed="0.2" data-image-src="{{asset('assets/front/img/'.$be->statistics_bg)}}" @endif>
                <div class="statistics-container">
                    <div class="container">
                        <div class="row no-gutters">
                            @foreach ($statistics as $key => $statistic)
                                <div class="col-lg-3 col-md-6">
                                    <div class="round"
                                         data-value="1"
                                         data-number="{{convertUtf8($statistic->quantity)}}"
                                         data-size="200"
                                         data-thickness="6"
                                         data-fill="{
                     &quot;color&quot;: &quot;#ffffff&quot;
                     }">
                                        <strong></strong>
                                        <h5><i class="{{$statistic->icon}}" style="color:#fff;"></i> {{convertUtf8($statistic->title)}}</h5>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!--    statistics section end    -->



    <!-- End Clients Section -->












        @if ($bs->testimonial_section == 1)
  <!--   Testimonial section start    -->
  <div class="testimonial-section pb-115 ">
     <div class="container">
        <div class="row ">
           <div class="col-lg-12">
              <h2 class="section-title keepaway">{{convertUtf8($bs->testimonial_title)}}</h2>
              <h2 class="section-summary hide">{{convertUtf8($bs->testimonial_subtitle)}}</h2>
           </div>
        </div>
        <div class="row">
           <div class="col-md-12">
              <div class="testimonial-carousel owl-carousel owl-theme">
                 @foreach ($testimonials as $key => $testimonial)
                   <div class="single-testimonial">
                      <div class="img-wrapper"><img class="lazy" data-src="{{asset('assets/front/img/testimonials/'.$testimonial->image)}}" alt=""></div>
                      <div class="client-desc">
                         <p class="comment">{{convertUtf8($testimonial->comment)}}</p>
                         <h6 class="name">{{convertUtf8($testimonial->name)}}</h6>
                         <p class="rank">{{convertUtf8($testimonial->rank)}}</p>
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


  @if ($bs->call_to_action_section == 1)
  <!--    call to action section start    -->
  <div class="cta-section" style="background-image: url('{{asset('assets/front/img/'.$bs->cta_bg)}}');background-size:cover;">
     <div class="container">
        <div class="cta-content">
           <div class="row">
              <div class="col-md-9 col-lg-7">
                 <h3>{{convertUtf8($bs->cta_section_text)}}</h3>
              </div>
              <div class="col-md-3 col-lg-5 contact-btn-wrapper">
                 <a href="{{$bs->cta_section_button_url}}" class="boxed-btn contact-btn"><span>{{convertUtf8($bs->cta_section_button_text)}}</span></a>
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
     <div class="container {{$be->theme_version != 'dark' ? 'top-border' : ''}}">
        <div class="row">
           <div class="col-md-12">
              <div class="partner-carousel owl-carousel owl-theme common-carousel">
                 @foreach ($partners as $key => $partner)
                   <a class="single-partner-item d-block" href="{{$partner->url}}" target="_blank">
                      <div class="outer-container">
                         <div class="inner-container">
                            <img class="lazy" data-src="{{asset('assets/front/img/partners/'.$partner->image)}}" alt="">
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


    
    <style>
* {
    margin: 0;
    padding: 0;
    font-family: Cairo, sans-serif;
    scroll-behavior: smooth;
}
body {
    overflow-x: hidden;
    background-color: #fff;
    scroll-behavior: smooth;
}
a {
    text-decoration: none;
}
.landing {
    min-height: 88vh;
    position: relative;
    background: #04212e;
    background: linear-gradient(121deg, rgb(4 33 46 / 83%) 50%, rgb(18 66 84 / 93%) 100%);
}
.landing > img {
    position: absolute;
    width: 100%;
    bottom: 0;
    z-index: -1;
    top: 0;
    height: 100%;
    object-fit: cover;
}
.landing .landing-content {
    min-height: 46vh;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    margin-top: 144px;
}
.landing .landing-content .text {
    text-align: center;
    color: #fff;
}
.landing .landing-content .text h1 {
    font-size: 48px;
    font-weight: 800;
}
.landing .landing-content .text h2 {
    font-size: 29px;
    font-weight: 400;
    margin-top: 0;
}
.landing .landing-content .text h3 {
    font-size: 27px;
    font-weight: 300;
}
.landing .row > button {
    position: relative;
    left: 50%;
    transform: translateX(-50%);
    background-color: transparent;
    border: none;
    outline: 0;
    font-size: 37px;
    color: #fff;
}
.services {
    background-color: #002637;
    margin-top: 0;
}
.services .service {
    min-height: 370px;
    position: relative;
}
.services .service img {
    width: 123px;
    position: absolute;
    top: -14%;
    right: 20px;
}
.services .service div {
    min-height: 244px;
    padding: 15px;
    background-color: #fff;
    padding-top: 78px;
    text-align: right;
}
.services .service div h1 {
    font-size: 21px;
    font-weight: 700;
    color: #042a3b;
}
.services .service div p {
    font-size: 15px;
}
.our-company {
    background-color: #042a3b;
    padding-top: 50px;
    padding-bottom: 50px;
}
.our-company .our-slider {
    display: flex;
    flex-direction: row;
    align-items: center;
    flex-wrap: wrap;
}
.our-company .our-slider .service-slide {
    width: 33%;
    height: 246px;
    position: relative;
    padding: 23px;
    background-size: cover;
    background-position: center;
    transition: 0.3s;
    background-color: transparent;
}
.our-company .our-slider .service-slide .overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #00000073;
    z-index: 1;
    transition: 0.3s;
    opacity: 0;
}
.our-company .our-slider .service-slide:hover .overlay {
    opacity: 1;
}
.our-company .our-slider .service-slide .text {
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 2;
    position: relative;
}
.our-company .our-slider .service-slide .text img {
    width: 40px;
    transition: 0.3s;
}
.our-company .our-slider .service-slide:hover .text img {
    transform: translateY(-15px);
    -webkit-transform: translateY(-15px);
    -moz-transform: translateY(-15px);
    -ms-transform: translateY(-15px);
    -o-transform: translateY(-15px);
}
.our-company .our-slider .service-slide .text h2 {
    color: #fff;
    font-size: 18px;
    font-weight: 700;
    text-align: center;
}
.our-company .our-slider .service-slide .text a {
    margin-top: 21px;
    display: inline-block;
    background-color: #4688ba;
    color: #002637;
    padding: 12px;
    font-weight: 700;
    padding-right: 30px;
    padding-left: 30px;
    text-decoration: none;
    cursor: pointer;
    transition: 0.3s;
}
.our-company .our-slider .service-slide .text a:hover {
    background-color: #2e6691;
}
.our-company .our-company-content > h1 {
    text-align: right;
    font-size: 48px;
    color: #fff;
}
.our-company .our-slider .service-slide:nth-child(1):hover {
    background-image: url(https://etmaam.com.sa/assets/front/img/a.png);
}
.our-company .our-slider .service-slide:nth-child(2):hover {
    background-image: url(https://etmaam.com.sa/assets/front/img/b.png);
}
.our-company .our-slider .service-slide:nth-child(3):hover {
    background-image: url(https://etmaam.com.sa/assets/front/img/c.png);
}
.our-company .our-slider .service-slide:nth-child(4):hover {
    background-image: url(https://etmaam.com.sa/assets/front/img/d.png);
}
.our-company .our-slider .service-slide:nth-child(5):hover {
    background-image: url(https://etmaam.com.sa/assets/front/img/d.png);
}
.our-company .our-slider .service-slide:nth-child(6):hover {
    background-image: url(https://etmaam.com.sa/assets/front/img/c.png);
}

.clients {
    /*background-color: #4688ba;*/
background: linear-gradient(90deg, rgba(70,136,186,1) 0%, rgba(8,88,123,1) 0%, rgb(10 48 65) 0%, rgba(8,88,123,1) 48%, rgba(70,136,186,1) 100%);
    padding-top: 40px;
    padding-bottom: 40px;
}
.clients .clients-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-end;
}
.clients .clients-content > h1 {
    text-align: right;
    font-size: 25px;
    color: #fff;
    font-weight: 600;
    margin-bottom: 25px;
}
.clients .clients-content > div {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    margin-top: 25px;
}
.clients .clients-content .left {
    display: flex;
    flex-direction: row;
    align-items: flex-start;
}
.clients .clients-content .left .inner-left {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 80px;
    min-height: 250px;
}
.clients .clients-content .left .inner-left h2 {
    font-size: 22px;
    font-weight: 700;
    color: #fff;
    text-align: right;
}
.clients .clients-content .left .inner-left h3 {
    font-size: 22px;
    font-weight: 400;
    color: #fff;
    text-align: right;
}
.clients .horizntal-line {
    display: inline-block;
    height: 100%;
    width: 1px;
    background-color: #ffffff80;
    min-height: 250px;
    margin-left: 12px;
}
.clients .clients-content .left .inner-right {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 21px;
    min-height: 188px;
    justify-content: space-between;
}
.clients .clients-content .left .inner-right img {
    width: 48px;
}
.clients .clients-content .right {
    display: flex;
    flex-direction: row;
    align-items: flex-start;
}
.clients .clients-content .right .inner-left {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 80px;
    min-height: 250px;
}
.clients .clients-content .right .inner-left h2 {
    font-size: 22px;
    font-weight: 700;
    color: #fff;
    text-align: right;
}
.clients .clients-content .right .inner-left h3 {
    font-size: 22px;
    font-weight: 400;
    color: #fff;
    text-align: right;
}
.clients .clients-content .right .inner-right {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 21px;
    min-height: 188px;
    justify-content: space-between;
}
.clients .clients-content .right .inner-right img {
    width: 48px;
}
.clients .clients-content > img {
    width: 90%;
}
.success .success-content {
    padding-top: 40px;
    padding-bottom: 40px;
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    gap: 63px;
}
.success .success-content h1 {
    text-align: right;
    font-size: 23px !important;
    font-weight: 600;
    line-height: 37px;
}
.success .success-content img {
    width: 134px;
}
.contact-form {
padding-top: 35px;    /*padding-top: 50px;*/
    /*padding-bottom: 50px;*/
    /*position: relative;*/
}
.contact-form > img {
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: -1;
    top: 0;
}
.contact-form .form-container > h1 {
    font-size: 19px !important;
    text-align: right;
    color: #fff;
    margin-bottom: 30px;
    padding-right: 22px;
}
.contact-form .form-container form {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
    background-color: #fff;
    padding: 15px;
    border-radius: 7px;
}
.contact-form .form-container form > h1 {
    width: 100%;
    text-align: right;
    font-weight: 700;
    color: #042a3b;
    font-size: 35px;
}
.contact-form .form-container form .input-container {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    width: 100%;
}
.contact-form .form-container form .input-container input {
    width: 100%;
    height: 52px;
    border-radius: 5px;
    border: 2px solid #cfcfcf;
    text-align: right;
    padding: 5px;
    padding-right: 19px;
    outline: 0;
    font-size: 17px;
    border-radius: 15px;
}
.contact-form .form-container form .input-container select {
    width: 100%;
    height: 52px;
    border-radius: 5px;
    border: 2px solid #cfcfcf;
    text-align: right;
    padding: 5px;
    padding-right: 19px;
    outline: 0;
    font-size: 17px;
    border-radius: 15px;
}
.contact-form .form-container form .input-container textarea {
    width: 100%;
    height: 150px;
    border-radius: 5px;
    border: 2px solid #cfcfcf;
    text-align: right;
    padding: 5px;
    padding-right: 19px;
    outline: 0;
    font-size: 17px;
    border-radius: 15px;
}
.contact-form .form-container form .input-container label {
    width: 100%;
    height: 52px;
    border-radius: 5px;
    border: 2px solid #cfcfcf;
    text-align: right;
    padding: 5px;
    padding-right: 19px;
    outline: 0;
    font-size: 17px;
    border-radius: 15px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    font-weight: 400;
    font-size: 20px;
    color: #0d2e3f;
}
.contact-form .form-container form .input-container-half {
    display: flex;
    flex-direction: row-reverse;
    align-items: center;
    justify-content: space-between;
    width: 100%;
}
.contact-form .form-container form .input-container-half input {
    width: 49%;
    height: 52px;
    border-radius: 5px;
    border: 2px solid #cfcfcf;
    text-align: right;
    padding: 5px;
    padding-right: 19px;
    outline: 0;
    font-size: 17px;
    border-radius: 15px;
}
.contact-form .form-container form button {
    width: 180px;
    height: 54px;
    font-size: 17px;
    border: none;
    outline: 0;
    background-color: #0d2e3f;
    color: #fff;
}
.contact-form .contact-information {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    background-color: #073144;
    padding: 20px;
    margin-left: -30px;
}
.contact-form .contact-information > h1 {
    color: #fff;
}
.contact-form .contact-information > div {
    margin-top: 18px;
    text-align: right;
    color: #fff;
    width: 70%;
}
.contact-form .contact-information > div h2 {
    font-size: 22px;
    font-weight: 700;
}
.contact-form .contact-information > div p {
    margin-top: 19px;
    font-size: 16px;
    line-height: 25px;
    font-weight: 400;
}
.contact-form .contact-information > div a {
    display: inline-block;
    margin-top: 16px;
    padding: 10px;
    padding-right: 25px;
    padding-left: 25px;
    border: 3px solid #fff;
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}
.contact-form .contact-information > div a:hover {
    border: 1px solid #002637;
    background-color: #002637;
}
@media (max-width: 950px) {
    .contact-form .contact-information {
        display: none;
    }
}
@media (max-width: 950px) {
    .our-company .our-slider .service-slide {
        width: 214px;
        height: 246px;
        position: relative;
        padding: 23px;
        background-size: cover;
        background-position: center;
        transition: 0.3s;
        background-color: transparent;
    }
    .our-company .our-slider {
        display: block;
    }
    .success .success-content {
        padding-top: 40px;
        padding-bottom: 40px;
        display: flex;
        flex-direction: column-reverse;
        gap: 63px;
        align-items: center;
    }
    .our-company .our-company-content > h1 {
        text-align: right;
        font-size: 26px;
        color: #fff;
    }
}
::placeholder {
    color: #b7b7b7;
    opacity: 1;
}

.breadcrumb-txt {
    display: none;
}
.market-section .section-summary, .section-summary, .packages-section .section-summary {
    margin-top: -6px;
}
.h2.section-summary {
    font-size:22px !importnant;
   line-height:1.5 !imortant;
    margin-bottom:25px !important;
}
.intro-txt{
       padding: 76px 40px 79px 47px !important;

}
.statistics-section .round strong{
    font-size:36px !important;
}
.about-us {
    margin: 50px 0 0;
}
.clients,
.our-company,
.success .success-content {

    direction: ltr;
}

        .app-form {
            background: none !important;
        }

        .head-form {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 12px;
            font-family: 'Tajawal';

        }
.alert-warning img {
    width: 35px;
    filter: brightness(0) invert(1);
}

        .select2-selection__rendered {
            line-height: 50px !important;

        }
        .select2-container .select2-selection--single {
            height: 50px !important;
            border: 1px solid #ddd;
        }
        .select2-selection__arrow {
            height: 50px !important;

        }

        .iti {
            direction: ltr;
            width: 100%;
        }

        .iti--separate-dial-code .iti__selected-dial-code {
            margin-left: 6px;
            padding: 10px;

        }
.contact-form .contact-information > div h2 {
    font-size: 22px;
    font-weight: 700;
    direction: ltr;
}   
    .fa, .fa-brands, .fa-duotone, .fa-light, .fa-regular, .fa-solid, .fa-thin, .fab, .fad, .fal, .far, .fas, .fat{
        font-size: 20px;
    }
    
    
    
    @media only screen and (max-width: 767px) {
.worldico{
    display:none;
}
}


 	.get-touch-box .gt-th-title {
 		text-align: center;
 		color: #121c45;
 	}

 	.get-touch-box .gt-th-paragraph {
 		text-align: center;
 		color: #121c45;
 		font-size: 20px;
 		    margin-left: 25%;
 	}

 	.get-touch-box .gt-th-social-links {
    display: flex;
    border-right: 2px solid #d8d8d8;
    justify-content: center;
    align-items: center;
    flex-direction: row;
    padding: 3px;
    /* height: 285px; */
    text-align: start;
    margin-bottom: 15px;
    transform: translateY(0px);
    background-color: rgba(34,84,118,0.03);
    transition: all .3s ease 0;
    border-width: 1px;
    border-style: solid;
    border-color: #f1f1f1;
    border-image: initial;
    border-radius: 20px; 	    
 	}

 	.get-touch-box .gt-th-social-links .social-link-icon {
 		display: inline-block;
 		padding: 10px;
 		border-radius: 50%;
 		/*box-shadow: 0px 0px 10px #0000001a;*/
 		margin:2px;
 	}

 	.get-touch-box .gt-th-social-links .social-link-icon.twitter {
 		background-color: #d3e4f9;
 	}

 	.get-touch-box .gt-th-social-links .social-link-icon.facebook {
 		background-color: #47599342;
 	}

 	.get-touch-box .gt-th-social-links .social-link-icon.instagram {
 		background-color: #d763972e;
 	}

 	.get-touch-box .gt-th-social-links .social-link-icon.youtube {
 		background-color: #ffd0cd;
 	}

 	.get-touch-box .gt-th-social-links .social-link-icon img {
 		width: 25px;
 	}

 	.get-touch-box .gt-th-row {
 		display: flex;
 		flex-wrap: wrap;
 		margin-top: 40px;
 		gap: 10px;
 	}

 	.get-touch-box .gt-th-row .gt-th-card {
 		flex: 1 0 0;
 		width: 33.33%;
 	}

 	.get-touch-box .gt-th-row .gt-th-card-item {
padding: 20px;
    box-shadow: 0px 0px 0px #0000000e;
    display: flex;
    flex-wrap: nowrap;
    text-align: start;
    margin-bottom: 15px;
    background-color: rgba(34,84,118,0.03);
    transition: all .3s ease 0;
    border-width: 1px;
    border-style: solid;
    border-color: #f1f1f1;
    border-image: initial;
    border-radius: 20px;
    justify-content: space-evenly;
/*padding: 20px;*/
/*    box-shadow: 0px 0px 0px #0000000e;*/
/*    display: flex;*/
    flex-wrap: wrap;
/*    justify-content: space-around;*/
/*    text-align: start;*/
/*    margin-bottom: 15px;*/
/*    background-color: rgba(34,84,118,0.03);*/
/*    transition: all .3s ease 0;*/
/*    border-width: 1px;*/
/*    border-style: solid;*/
/*    border-color: #f1f1f1;*/
/*    border-image: initial;*/
/*    border-radius: 20px;*/
 	    
 	}
 	.get-touch-box .gt-th-row .gt-th-card-item .first-box {
    border-left: unset !important;
    border-bottom: 1px solid #89b6de2b;
    padding-bottom: 16px;
    flex-shrink: 0;
    text-align: center;
    margin-bottom: 12px;
    }

 	.get-touch-box .gt-th-row .gt-th-card-item .first-box .gt-tc-bx-head {
 		background-color: #f2f8ff;
 		color: #121c45;
 		padding: 2px 8px 5px;
 	}

 	.get-touch-box .gt-th-row .gt-th-card-item .second-box {
 		flex-grow: 1;
 		padding: 0 10px;
 	}

 	.get-touch-box .gt-th-row .gt-th-card-item .second-box .gt-tc-bx-content {
 		margin-top: 0;
 		text-align:center;
 	}

 	.get-touch-box .gt-th-row .gt-th-card-item .second-box a {
 		padding: 10px 25px;
 		border: 1px solid #428BCA;
 		text-decoration: none;
 		color: #428BCA;
 		display: inline-block;
 		transition: 0.2s;
    justify-content: center !important;
    display: flex;
 	}

 	.get-touch-box .gt-th-row .gt-th-card-item .second-box a:hover,
 	.get-touch-box .gt-th-row .gt-th-card-item .second-box a:active {

 		border: 1px solid #428BCA;
 		background-color: #428BCA;
 		color: white;

 	}

.get-touch-box .gt-th-social-links .social-link-icon {
    display: inline-block;
    padding: 8px;
    /*border-radius: unset !important;*/
    /*box-shadow: none !important;*/
    /*background: unset !important;*/
}



a.boxed-btn.spc {
    width: 200px;
    color: #fff;
    text-align: center;
    /*border: 2px solid #fff;*/
    text-decoration: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 14px;
    margin-top: 42px;
    position: relative;
    -webkit-transition: .5s;
    transition: .5s;
}


.shine{
    background-image: linear-gradient(270deg, rgba(100, 181, 239, 0) 48.44%, #64b5ef 75.52%, rgba(100, 181, 239, 0) 100%);
    background-repeat: no-repeat;
animation: bg-move linear 5s infinite;
}
@-webkit-keyframes bg-move {
  0%   { background-position: -500px 0; }
  100% { background-position: 1000px 0; }
}
@keyframes bg-move {
  0%   { background-position: -500px 0; }
  100% { background-position: 1000px 0; }
}

    </style>




<script>
// Set Item
localStorage.setItem("marketing_customer", "google");
// Retrieve
document.getElementById("demo").innerHTML = localStorage.getItem("marketing_customer");
</script>


    <!--<script>-->
    <!--    $(document).ready(function() {-->
    <!--        $('select').select2({ height: '50px'});-->
    <!--        $('[name="mobile"]').intlTelInput({	localizedCountries:"AR",initialCountry:"SA",separateDialCode:true,excludeCountries: ['ir','il']});-->

    <!--        $("select[name='category_id']").on('change', function() {-->
    <!--            $("#service_id").attr('disabled','true');-->


    <!--            let langId = $(this).val();-->
    <!--            let url = "{{url('/')}}/request/" + langId + "/get_services";-->

    <!--            $.get(url, function(data) {-->
    <!--                let options = `<option value="" disabled selected>{{__('messages.service_placeholder')}}</option>`;-->
                    
    <!--                if (data.length == 0) {-->
    <!--                    options += `<option value="" disabled>${'لا يوجد خدمات متاحة حالياً'}</option>`;-->
    <!--                } else {-->
    <!--                    $.each( data, function( key, value ) {-->
    <!--                        console.log('loop:',key,value);-->
    <!--                        options +=`<option value="${value.id}">${value.name}</option>`;-->
    <!--                    });-->
    <!--                }-->

    <!--                $("#service_id").html(options);-->
    <!--                $("#service_id").removeAttr('disabled');-->
    <!--            });-->
    <!--        });-->

    <!--        $("select[name='maincategory_id']").on('change', function() {-->

    <!--            $("#service_id").attr('disabled','true');-->
    <!--            $("#sub_category_id").attr('disabled','true');-->
                <!--$('#service_id option:eq(0)').prop('selected', true);-->
    <!--            $('#service_id').val("").trigger('change.select2');-->


    <!--            let langId = $(this).val();-->
    <!--            let url = "{{url('/')}}/request/" + langId + "/get_subcategories";-->

    <!--            $.get(url, function(data) {-->
    <!--                let options = `<option value="" disabled selected>{{__('messages.subcategory_placeholder')}}</option>`;-->

    <!--                if (data.length == 0) {-->
    <!--                    options += `<option value="" disabled>${'لا يوجد قسم فرعي'}</option>`;-->
    <!--                } else {-->
    <!--                    for (let i = 0; i < data.length; i++) {-->
    <!--                        options +=`<option value="${data[i].id}">${data[i].name}</option>`;-->
    <!--                    }-->
    <!--                }-->

    <!--                $("#sub_category_id").html(options);-->
    <!--                $("#sub_category_id").removeAttr('disabled');-->
    <!--            });-->
    <!--        });-->

    <!--    });-->
    <!--</script>-->

<script>
    $(document).ready(function() {

    var width = $(window).width();

    if (width < 950) {
        $('.our-slider').slick({
            dots: true,
            arrows: false,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            centerMode: true,
            variableWidth: true,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000
        });

    }


    $(window).resize(function(e) {

        var width = $(window).width();

        if (width < 950) {
            $('.our-slider').slick({
                dots: true,
                arrows: false,
                infinite: true,
                speed: 300,
                slidesToShow: 1,
                centerMode: true,
                variableWidth: true,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000
            });

        }
    })




    $(".reviews-left").click(function() {
        $(".slick-prev").click();
    })

    $(".reviews-right").click(function() {
        $(".slick-next").click();
    })

    $(".slick-dots button").text("");



    $(".open-nav").click(function() {
        $(".mobile-nav").slideDown(400);
    })

    $(".close-nav").click(function() {
        $(".mobile-nav").slideUp(400);
    })

    $(".mobile-nav ul li").click(function() {
        $(".mobile-nav").slideUp(400);
    })

    $(".goup").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });



});



    $('#msource2').val(localStorage.getItem("marketing_customer"));



// التحقق مما إذا كانت القيمة موجودة في الـ local storage أم لا
if (!localStorage.getItem("marketing_customer")) {
  var msource = "{{ request()->get('msource') }}";
  $('#msource').val(msource);
  localStorage.setItem("marketing_customer", msource);
}

</script>
    
    @endsection




