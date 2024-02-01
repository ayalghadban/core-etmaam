@extends('front.default.layout')

@section('pagename')
 -
 {{__('About Us')}}
@endsection

@section('meta-keywords', "$be->services_meta_keywords")
@section('meta-description', "$be->services_meta_description")

@section('content')

@section('breadcrumb-title', __('About Us'))
@section('breadcrumb-subtitle', convertUtf8($bs->service_subtitle))
@section('breadcrumb-link',  __('Who is Etmaam?'))



<style>
    .intro-section {
     margin-top: 0px!important; 
        
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
</style>
<div class="about-us">
    
  <div class="intro-section" @if($bs->feature_section == 0) style="margin-top: 0px;" @endif>
     <div class="container">


       @if ($bs->intro_section == 1)
       
                <div class="row">

                    <div class=" col-12 col-lg-6 mb-4 " style="min-height: 260px;">
                        <div class="intro-bg"
                            style="background-image: url('https://etmaam.com.sa/assets/front/img/628fdc7dcad22.jpg'); background-size: cover;">
                            <a id="play-video" class="video-play-button"
                                href="{{$bs->intro_section_button_url}}">
                                <span></span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 ">
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
       @endif
       


       <h2 class="section-title mt-4" style="font-family:tajawal !important">{{__('Why Etmaam?')}}</h2>
                <p class="about-p-des "> 
{{__('app.whyEtmaam')}}
                     </p>
                     
</p>

  </div>
  </div>
  
  </div>

  <!--    introduction area end   -->




            <!--// here is services start orginal-->
            @if ($bs->service_section == 1)
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
            @endif


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
                                        <h5><i style="color:#fff" class="{{$statistic->icon}}"></i> {{convertUtf8($statistic->title)}}</h5>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!--    statistics section end    -->






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



@endsection
