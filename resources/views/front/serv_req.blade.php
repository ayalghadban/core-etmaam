@extends("front.$version.layout")

@section('pagename')
    - {{__('messages.serv_req')}}
@endsection

@section('meta-keywords', "$be->packages_meta_keywords")
@section('meta-description', "$be->packages_meta_description")


@section('breadcrumb-title', __('messages.serv_req'))
@section('breadcrumb-subtitle', $be->pricing_subtitle)
@section('breadcrumb-link', __('messages.serv_req'))
@section('scripts')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.16/css/intlTelInput.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.16/js/intlTelInput-jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
    .mobile-serv{
        display:none !important;
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
    </style>
    <script>
        $(document).ready(function() {
            $('select').select2({ height: '50px'});
            $('[name="mobile"]').intlTelInput({	localizedCountries:"AR",initialCountry:"SA",separateDialCode:true,excludeCountries: ['ir','il']});

            $("select[name='category_id']").on('change', function() {
                $("#service_id").attr('disabled','true');


                let langId = $(this).val();
                let url = "{{url('/')}}/request/" + langId + "/get_services";

                $.get(url, function(data) {
                    let options = `<option value="" disabled selected>{{__('messages.service_placeholder')}}</option>`;
                    
                    if (data.length == 0) {
                        options += `<option value="" disabled>${'لا يوجد خدمات متاحة حالياً'}</option>`;
                    } else {
                        $.each( data, function( key, value ) {
                            console.log('loop:',key,value);
                            options +=`<option value="${value.id}">${value.name}</option>`;
                        });
                    }

                    $("#service_id").html(options);
                    $("#service_id").removeAttr('disabled');
                });
            });

            $("select[name='maincategory_id']").on('change', function() {

                $("#service_id").attr('disabled','true');
                $("#sub_category_id").attr('disabled','true');
             //   $('#service_id option:eq(0)').prop('selected', true);
                $('#service_id').val("").trigger('change.select2');


                let langId = $(this).val();
                let url = "{{url('/')}}/request/" + langId + "/get_subcategories";

                $.get(url, function(data) {
                    let options = `<option value="" disabled selected>{{__('messages.subcategory_placeholder')}}</option>`;

                    if (data.length == 0) {
                        options += `<option value="" disabled>${'لا يوجد قسم فرعي'}</option>`;
                    } else {
                        for (let i = 0; i < data.length; i++) {
                            options +=`<option value="${data[i].id}">${data[i].name}</option>`;
                        }
                    }

                    $("#sub_category_id").html(options);
                    $("#sub_category_id").removeAttr('disabled');
                });
            });

        });
    </script>
@endsection
@section('content')

    <style>
        .app-form {
            background: none !important;
        }

        .head-form {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 12px;
            font-family: 'Tajawal';

        }
    </style>




    <div class="container">
        <div class="row">
            <div class="col-12 mb-3" style="padding: 30px 0px 0px 0px;">
                <div class="demo alert alert-warning text-center alert-dismissable">
                    <div>
          <span>
            <img src="https://etmaam.com.sa/assets/front/img/2323.svg">
          </span> {{__('messages.serv_req_welcome')}}  <br>
                    </div>
                </div>
                                                  <div class="col-md-12 text-left ">
                            
    <button type="button" class=" font-lg btn btn-success " style=" border: 1px solid #0A3041;hover:color: #0A3041;color:#fff;" onclick="show()" id="btnID">
       {{__('app.quickservice')}}
    </button>

                        </div>

            </div>
            
        </div>



        <div class="row ">
            <div class="col-lg-12" id="full-form">

                <h2 class="legend tit-form mb-2">{{__('messages.company_details')}}</h2>
                <form id="ajaxForm" class="modal-form" action="{{route('thank.you')}}" method="POST">
                   @csrf
                    <div class="row">

                    <div class="form-group" style="display:none;"> 
                    <input name="secure" type="text"  placeholder="" id="secure">
                    <input name="msource" type="text" value="{{ request()->get('msource')}}"  placeholder="" id="msource">
                    </div>

                        <div class=" col-12 col-lg-6">
                            <div class="form-element mb-4">
                                <label>{{__('messages.company_name')}}</label>
                                <input name="company_name" type="text" value="{{old('company_name')}}" placeholder="{{__('messages.company_name_placeholder')}}">
                                @if($errors->first('company_name'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('company_name')}}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class=" col-12 col-lg-6">
                            <div class="form-element mb-4">
                                <label>{{__('messages.responsible_person')}}</label>
                                <input name="fullname" type="text" value="{{old('fullname')}}" placeholder="{{__('messages.responsible_person_placeholder')}}">
                                @if($errors->first('fullname'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('fullname')}}
                                    </div>
                                @endif
                            </div>
                        </div>


                        <div class=" col-12 col-lg-6">
                            <div class="form-element mb-4">
                                <label>{{__('messages.email')}}</label>
                                <input name="email" type="text" value="{{old('email')}}" placeholder="{{__('messages.email_placeholder')}}">
                                @if($errors->first('email'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('email')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class=" col-12 col-lg-6">
                            <div class="form-element mb-4">
                                <label>{{__('messages.mobile')}}</label>
                                <input name="mobile" type="tel" value="{{old('mobile')}}" placeholder="{{__('messages.mobile_placeholder')}}">
                                @if($errors->first('mobile'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('mobile')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class=" col-6 ">
                            <div class="form-element ">
                                <label>{{__('messages.city')}}</label>
                                <select name="city">
                                    <option value="" selected="" disabled="">{{__('messages.city_placeholder')}}</option>
                                    @foreach($cities as $city)
                                        <option @if($city == old('city')) selected @endif>{{$city}}</option>
                                    @endforeach
                                </select>
                                @if($errors->first('city'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('city')}}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class=" col-6">
                            <div class="form-element ">
                                <label>{{__('messages.company_type')}}</label>
                                <select name="client_type">
                                    <option value="" selected="" disabled="">{{__('messages.company_type_placeholder')}}</option>
                                    @if($currentLang->code == "ar")
                                    <option @if(old('client_type') == 'مؤسسة') selected @endif>مؤسسة</option>
                                    <option @if(old('client_type') == 'شركة') selected @endif>شركة</option>
                                    <option @if(old('client_type') == 'فرد') selected @endif>فرد</option>
                                    @elseif($currentLang->code == "en")
                                     <option @if(old('client_type') == 'Foundation') selected @endif>Foundation</option>
                                     <option @if(old('client_type') == 'Company') selected @endif>Company</option>
                                     <option @if(old('client_type') == 'Individual') selected @endif>Individual</option>
                                    @endif

                                </select>
                                @if($errors->first('client_type'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('client_type')}}
                                    </div>
                                @endif
                            </div>
                        </div>
`
                    </div>






                    <h2 class="legend tit-form mb-2 mt-2">{{__('messages.service_details')}}</h2>

                    <div class="row">
{{--                        <div class=" col-6">--}}
{{--                            <div class="form-element mb-4">--}}
{{--                                <label>{{__('messages.category')}}</label>--}}
{{--                                <select name="maincategory_id">--}}

{{--                                    <option value="" selected="" disabled="">{{__('messages.category_placeholder')}}</option>--}}
{{--                                    @foreach($categories as $category)--}}
{{--                                    <option value="{{$category->id}}" @if($service !=null && $service->category->cat_id == $category->id) selected @endif>{{$category->name}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                                @if($errors->first('category_id'))--}}
{{--                                    <div class="alert alert-danger" role="alert">--}}
{{--                                        {{$errors->first('category_id')}}--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}


                           @php $subcats =  \App\RequestCategory::where('language_id', $currentLang->id)
        ->where('active',1)
        ->where('cat_id','<>',0)
        ->get()->sortBy(function($cat){
            return strlen($cat->name);
        }); @endphp

                        <div class=" col-6">
                            <div class="form-element mb-4">
                                <label>{{__('messages.category')}}</label>
                                <select name="category_id" id="sub_category_id" @if(!isset($subcats))disabled @endif>
                                    <option value="" selected="" disabled="">{{__('messages.category_placeholder')}}</option>
                                    @if(isset($subcats))
                                    @foreach($subcats as $cat)
                                        <option value="{{$cat->id}}" >{{$cat->name}}</option>
                                        @endforeach
                                        @endif
                                </select>
                                @if($errors->first('category_id'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('category_id')}}
                                    </div>
                                @endif
                            </div>
                        </div>
{{--                        <div class=" col-6">--}}
{{--                            <div class="form-element mb-4">--}}
{{--                                <label>{{__('messages.subcategory')}}</label>--}}
{{--                                <select name="category_id" id="sub_category_id" @if(!isset($subcats))disabled @endif>--}}
{{--                                    <option value="" selected="" disabled="">{{__('messages.subcategory_placeholder')}}</option>--}}
{{--                                    @if(isset($subcats))--}}
{{--                                    @foreach($subcats as $cat)--}}
{{--                                        <option value="{{$cat->id}}" @if($cat->id == $service->category->id) selected @endif>{{$cat->name}}</option>--}}
{{--                                        @endforeach--}}
{{--                                        @endif--}}
{{--                                </select>--}}
{{--                                @if($errors->first('category_id'))--}}
{{--                                    <div class="alert alert-danger" role="alert">--}}
{{--                                        {{$errors->first('category_id')}}--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}


                        <div class="col-12 col-lg-6">
                            <div class="form-element mb-4">
                                <label>{{__('messages.service')}}</label>

                                <select name="service_id"  id="service_id" @if($service == null) disabled @endif>
                                    <option value="" selected="" disabled="">{{__('messages.service_placeholder')}}</option>
                                    @if(isset($service))
                                    @foreach($service->category->services as $ser)
                                        <option value="{{$ser->id}}" @if($ser->id == $service->id) selected @endif>{{$ser->name}}</option>
                                    @endforeach
                                        @endif
                                </select>

                                @if($errors->first('service_id'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('service_id')}}
                                    </div>
                               @endif
                            </div>
                        </div>




                        <div class=" col-12 ">
                            <div class="form-element mb-4">
                                <label>{{__('messages.desc')}}</label>
                                <textarea name="desc" id="" cols="30" rows="10" placeholder="{{__('messages.desc_placeholder')}}">{{old('desc')}}</textarea>
                                @if($errors->first('desc'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('desc')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class=" col-12 col-lg-3">
                            <div class="form-element mb-4">
                                <label>{{__('messages.suitable_time')}}</label>
                                <select name="suggested_time" id="suggested_time">
                                    @if($currentLang->code == "ar")
                                    <option selected>الفترة الصباحية من 8 ص إلى 12</option>
                                    <option>الفترة المسائية من 4 م إلى 11</option>
                                @elseif($currentLang->code == "en")
                                    <option selected>Morning shift from 8 AM to 12</option>
                                     <option>Evening from 4 pm to 11 </option>

                            @endif

                                </select>
                            </div>
                        </div>
{{--                        <div class=" col-12 col-lg-6">--}}
{{--                            <div class="form-element mb-4">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-lg-12">--}}
{{--                                        <div class="form-element mb-2">--}}
{{--                                            <label>المرفقات 1 </label>--}}
{{--                                            <input type="file" name="المرفقات_1" value="">--}}
{{--                                        </div>--}}
{{--                                        <p class="text-warning mb-0">** Only zip file is allowed</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn-sub" >{{__('messages.submit')}}</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<br>
         <div class="container ">
            <div class="row">

<div class="col-lg-12">
                        
                <form action="{{route('front.sendmail')}}" class="contact-form" method="POST" id="QuickForm" style="display:none;">
                    @csrf
                    
                    <div class="form-group" style="display:none;"> 
                   <input name="msource" type="text" value="{{ request()->get('msource')}}"  placeholder="" id="msource2">
                    <input name="secure" type="text"  placeholder="" id="secure">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-element">
                                <input name="name" type="text" placeholder="{{__('messages.company_name_placeholder')}}*" required>
                            </div>
                            @if ($errors->has('name'))
                            <p class="text-danger mb-0">{{$errors->first('name')}}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="form-element">
                                <input name="email" type="email" placeholder="{{__('messages.email_placeholder')}} *">
                            </div>
                            @if ($errors->has('email'))
                            <p class="text-danger mb-0">{{$errors->first('email')}}</p>
                            @endif
                        </div>
                        
                                                <div class="col-md-6">
                            <div class="form-element">
                                <select name="subject" style="width:100%;" id="subjectSelect">
                                    @if($currentLang->code == 'ar')
                                      <option disabled selected  value> -- اختر الخدمة -- </option>
        <option value="1">خدمات تأسيس المؤسسات والشركات</option>
        <option value="2">خدمات وزارة الاستثمار (تأسيس الشركات الأجنبية)</option>
        <option value="3">خدمات تحويل الشكل القانوني للمنشآت</option>
        <option value="4">خدمات نقل ملكية سجلات المنشآت</option>
        <option value="5">خدمات تسجيل العلامات التجارية</option>
        <option value="6">خدمات التأمين التعاوني للمنشآت</option>
        <option value="7">خدمات تسجيل العمالة ذات المهن العليا</option>
        <option value="8">خدمات اعتماد لوائح تنظيم العمل</option>
        <option value="9">خدمات الشطب وإنهاء السجلات للمنشآت</option>
        <option value="10">خدمات تخفيف الأعباء المالية عن المنشآت</option>
        <option value="11">خدمات إدارة المنصات الحكومية للمنشآت</option>
        <option value="12">خدمات الدعم المباشر لتحديات الوزارات الحكومية</option>
        <option value="13">خدمات وزارة التجارة</option>
        <option value="14">خدمات وزارة الاعلام</option>
        <option value="15">خدمات إتمام لإدارة الرواتب (نظام حماية الأجور)</option>
        <option value="16">خدمات وزارة الموارد البشرية (مكاتب العمل)</option>
        <option value="17">خدمات هيئة الزكاة والضريبة والجمارك</option>
        <option value="18">خدمات الدفاع المدني (سلامة)</option>
        <option value="19">خدمات الاستشارات في العلاقات الحكومية</option>
        <option value="20">خدمات الاشتراك في باقات الاستشارات</option>
        <option value="21">خدمات الاشتراك في عقود الخدمات</option>
        <option value="22">خدمات الاشتراك في برامج هدف</option>
        <option value="23">خدمات منصة بلدي</option>
        <option value="24">خدمات منصة قوى</option>
        <option value="25">الاستشارات القانونية</option>
        <option value="26">التمثيل القضائي في القضايا العمالية</option>
        <option value="27">التمثيل القضائي في القضايا التجارية</option>
        <option value="28">خدمات الإقامة المميزة</option>

                                        @else
                                      <option disabled selected  value> -- Select The Service -- </option>
        <option value="55">companies and Enterprises Establishment Services</option>
        <option value="29">Ministry of Investment Services (Setup of Foreign Companies)</option>
        <option value="30">Legal Entity Transformation Services</option>
        <option value="31">Transfer of Ownership of Business Records Services</option>
        <option value="32">Trademark Registration Services</option>
        <option value="33">Cooperative Insurance Services for Businesses</option>
        <option value="34">Highly Skilled Labor Registration Services</option>
        <option value="35">Approval of Labor Regulations Services</option>
        <option value="36">Removal and Termination of Business Records Services</option>
        <option value="37">Financial Burden Reduction Services for Businesses</option>
        <option value="38">Government Platforms Management Services for Businesses</option>
        <option value="39">Direct Support Services for Government Ministries Challenges</option>
        <option value="40">Ministry of Commerce Services</option>
        <option value="41">Ministry of Information Services</option>
        <option value="42">Payroll Management Completion (WPS System) Services</option>
        <option value="43">Ministry of Human Resources Services (Labor Offices)</option>
        <option value="44">Zakat, Tax, and Customs Authority Services</option>
        <option value="45">Civil Defense (SALAMA) Services</option>
        <option value="46">Government Relations Consultation Services</option>
        <option value="47">Subscription to Consultation Packages Services</option>
        <option value="48">Subscription to Services Contracts</option>
        <option value="49">Subscription to HADAF Programs Services</option>
        <option value="50">BALADI Platform Services</option>
        <option value="51">QIWA Platform Services</option>
        <option value="52">Legal Consultations Services</option>
        <option value="52">Judicial Representation in Labor Cases Services</option>
        <option value="53">Judicial Representation in Commercial Cases Services</option>
         <option value="54"> Premium Residency Services </option>
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
                                <textarea name="message" id="comment" cols="30" rows="10" placeholder="{{__('messages.desc_placeholder')}} *" required></textarea>
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
                        
                        

<script>
    $('#msource').val(localStorage.getItem("marketing_customer"));
    $('#msource2').val(localStorage.getItem("marketing_customer"));



// التحقق مما إذا كانت القيمة موجودة في الـ local storage أم لا
if (!localStorage.getItem("marketing_customer")) {
  var msource = "{{ request()->get('msource') }}";
  $('#msource').val(msource);

  localStorage.setItem("marketing_customer", msource);
}




                function show() {
            /* Access image by id and change
            the display property to block*/
            document.getElementById('QuickForm').style.display = "block";
            document.getElementById('btnID').style.display = "none";
            document.getElementById('full-form').style.display = "none";
             document.getElementById('btnID2').style.display = "block";


        }
        
                        function back() {
            /* Access image by id and change
            the display property to block*/
            document.getElementById('full-form').style.display = "block";
            document.getElementById('btnID2').style.display = "none";
                        document.getElementById('btnID').style.display = "block";

            document.getElementById('QuickForm').style.display = "none";

        }
        
        
        
        
var stype = "{{ request()->get('stype') }}";
if (stype === 'quick') {
    show();
                 document.getElementById('btnID2').style.display = "none";

}

var serviceValue  = "{{ request()->get('sname') }}";
if (serviceValue) {
    var subjectSelect = document.getElementById("subjectSelect");
    subjectSelect.value = serviceValue;
}
        
</script>

@endsection




