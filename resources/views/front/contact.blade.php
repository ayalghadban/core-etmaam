@extends("front.$version.layout")


@section('pagename')
- {{__('Contact Us')}}
@endsection

@section('meta-keywords', "$be->contact_meta_keywords")
@section('meta-description', "$be->contact_meta_description")

<!--<style>-->
<!--.map-wrapper {-->
<!--    max-height: 350px;-->
<!--}-->
<!--.nav-pills .nav-link.active, .nav-pills .show>.nav-link {-->

<!--        padding:0px 6px 8px;-->
<!--        margin: 0px 5px 5px 5px;-->
<!--        background-color: transparent !important;-->
<!--        border-bottom: 2px solid #225476  !important ;-->
<!--        color:#225476 !important;-->
<!--        border-radius: 0;-->
<!--       font-weight: 600;-->
<!--}-->

<!--.nav-pills .nav-link{-->
<!--    padding: 0px 6px 8px;-->
<!--        margin:0px 5px 5px 5px;-->
<!--        font-weight: 500;-->
<!--    color: #505050;-->
<!--}-->
<!--.contact-form-section .single-info {-->
<!--    padding: 30px 25px !important;-->
<!--}-->
<!--.tab-content{-->
<!--     margin:0px  5px ;-->
<!--}-->
<!--</style>-->

@section('breadcrumb-title', $bs->contact_title)
@section('breadcrumb-subtitle', $bs->contact_subtitle)
@section('breadcrumb-link', __('Contact Us'))

@section('content')


<!--    contact form and map start   -->
<div class="contact-form-section">
    <div class="container">


        <div class="contact-infos mb-5">
            <div class="row no-gutters">
                <div class="col-lg-4 single-info-col">
                    <div class="single-info wow fadeInRight" data-wow-duration="1s" style="visibility: visible; animation-duration: 1s; animation-name: fadeInRight;">
                        <div class="icon-wrapper"><i class="fas fa-home" style="margin: 14px;"></i></div>
                        <div class="info-txt">
                            @php
                                $addresses = explode(PHP_EOL, $bex->contact_addresses);
                            @endphp
                            @foreach ($addresses as $address)
                            <p><i class="fas fa-map-pin base-color mr-1"></i> {{$address}}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 single-info-col">
                    <div class="single-info wow fadeInRight" data-wow-duration="1s" data-wow-delay=".2s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.2s; animation-name: fadeInRight;">
                        <div class="icon-wrapper"><i class="fas fa-phone" style="margin: 14px;"></i></div>
                        <div class="info-txt">
                            @php
                                $phones = explode(',', $bex->contact_numbers);
                            @endphp
                            @foreach ($phones as $phone)
                            <a href="tel:{{$phone}}"><p>{{$phone}}</p></a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 single-info-col">
                    <div class="single-info wow fadeInRight" data-wow-duration="1s" data-wow-delay=".4s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.4s; animation-name: fadeInRight;">
                        <div class="icon-wrapper"><i class="far fa-envelope" style="margin: 14px;"></i></div>
                        <div class="info-txt">
                            @php
                                $mails = explode(',', $bex->contact_mails);
                            @endphp
                            @foreach ($mails as $mail)
                            <a href="mailto:{{$mail}}"><p>{{$mail}}</p></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>






        <div class="row">
            <div class="col-lg-6">
              <h3>
                    <span class="section-title">{{convertUtf8($bs->contact_form_title)}}</span>
              </h3>


                <p  style="font-size:16px; margin-bottom:15px;" class="">{{convertUtf8($bs->contact_form_subtitle)}}</p>
                <form action="{{route('front.sendmail')}}" class="contact-form" method="POST">
                    @csrf
                    
                    <div class="form-group" style="display:none;"> 
                    <input name="secure" type="text"  placeholder="" id="secure">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-element">
                                <input name="name" type="text" placeholder="{{__('messages.company_name')}} / {{__('messages.responsible_person_placeholder')}}" required>
                            </div>
                            @if ($errors->has('name'))
                            <p class="text-danger mb-0">{{$errors->first('name')}}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="form-element">
                                <input name="email" type="email" placeholder="{{__('messages.email_placeholder')}}" required>
                            </div>
                            @if ($errors->has('email'))
                            <p class="text-danger mb-0">{{$errors->first('email')}}</p>
                            @endif
                        </div>
                        
                    <div class="col-md-12">
                            <div class="form-element">
                                <input name="mobile" type="tel" style="width:100%;" placeholder="{{__('messages.mobile_placeholder')}}" required>
                                   

                            </div>
                            
                            
                            @if ($errors->has('subject'))
                            <p class="text-danger mb-0">{{$errors->first('subject')}}</p>
                            @endif
                        </div>

                        
                        <div class="col-md-12">
                            <div class="form-element">
                                <select name="subject" style="width:100%;" id="">
                                    @if($currentLang->code == 'ar')
                                      <option disabled selected value> -- سبب التواصل -- </option>
                                    <option>اقتراح</option>
                                    <option>شكوى</option>
                                    <option>أخرى</option>
                                        @else
                                      <option disabled selected value> -- The reason for contacting -- </option>
                                        <option>Suggestion</option>
                                        <option>Complain</option>
                                        <option>Other</option>
                                        @endif
                                </select>

                            </div>
                            
                            
                            
                            
                            
                            @if ($errors->has('subject'))
                            <p class="text-danger mb-0">{{$errors->first('subject')}}</p>
                            @endif
                        </div>
                        
                        
                        <div class="col-md-12">
                            <div class="form-element">
                                <textarea name="message" id="comment" cols="30" rows="10" placeholder="{{__('Comment')}}" required></textarea>
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
            </div>


           <div class="col-md-6 ">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">{{__('Riyadh')}}</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">{{__('Khobar')}}</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">{{__('Mahayel Aseer')}}                    </a>
                    </li>
                  </ul>
                  <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"><div class="map-wrapper">
                        <div id="map">
                            <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=24.737133026123047,%2046.78093719482422+(My%20Business%20Name)&amp;t=&amp;z={{$bex->map_zoom}}&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                        </div>
                    </div></div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"><div class="map-wrapper">
                        <div id="map">
                            <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q={{$bex->latitude}},%20{{$bex->longitude}}+(My%20Business%20Name)&amp;t=&amp;z={{$bex->map_zoom}}&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                        </div>
                    </div></div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"><div class="map-wrapper">
                        <div id="map">
                            <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=18.549381256103516,%2042.048641204833984+(My%20Business%20Name)&amp;t=&amp;z={{$bex->map_zoom}}&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                        </div>
                    </div></div>
                  </div>

        </div>


        </div>
    </div>
</div>


<style>
    #rc-imageselect, .g-recaptcha {
   display: inline; //the most important
}

#rc-imageselect{
   max-width: 100%;
}

.g-recaptcha>div>div{
   width: 100% !important;
   height: 78px;
   transform:scale(0.77); 
   webkit-transform:scale(0.77);
   text-align: center;
   position: relative;
}

</style>

<script>
    $(function(){
  function rescaleCaptcha(){
    var width = $('.g-recaptcha').parent().width();
    var scale;
    if (width < 302) {
      scale = width / 302;
    } else{
      scale = 1.0; 
    }

    $('.g-recaptcha').css('transform', 'scale(' + scale + ')');
    $('.g-recaptcha').css('-webkit-transform', 'scale(' + scale + ')');
    $('.g-recaptcha').css('transform-origin', '0 0');
    $('.g-recaptcha').css('-webkit-transform-origin', '0 0');
  }

  rescaleCaptcha();
  $( window ).resize(function() { rescaleCaptcha(); });

});

</script>
<!--    contact form and map end   -->
@endsection
