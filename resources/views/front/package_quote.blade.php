@extends("front.$version.layout")

@section('pagename')
    - {{__('messages.package_quote')}}
@endsection

@section('meta-keywords', "$be->packages_meta_keywords")
@section('meta-description', "$be->packages_meta_description")


@section('breadcrumb-title', __('messages.package_quote'))
@section('breadcrumb-subtitle', $be->pricing_subtitle)
@section('breadcrumb-link', __('messages.package_quote'))
@section('scripts')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.16/css/intlTelInput.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.16/js/intlTelInput-jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
    .select2-container--default.select2-container--disabled .select2-selection--single {
    background-color: #f9f9f9;
    cursor: default;
}
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
                        for (let i = 0; i < data.length; i++) {
                            options +=`<option value="${data[i].id}">${data[i].name}</option>`;
                        }
                    }

                    $("#service_id").html(options);
                    $("#service_id").removeAttr('disabled');
                });

            });

            $("select[name='maincategory_id']").on('change', function() {
                $("#sub_category_id").attr('disabled','disabled');

                let langId = $(this).val();
                let url = "{{url('/')}}/request/" + langId + "/get_packages";

                $.get(url, function(data) {
                    let options = `<option value="" disabled selected>{{__('messages.package_type_placeholder')}}</option>`;

                    if (data.length == 0) {
                        options += `<option value="" disabled>${'لا يوجد باقات حاليا'}</option>`;
                    } else {
                        for (let i = 0; i < data.length; i++) {
                            options +=`<option value="${data[i].id}">${data[i].title}</option>`;
                        }
                    }

                    $("#sub_category_id").html(options);
                    $("#sub_category_id").removeAttr('disabled');
                });
            });


var mainCategoryMaps = {
            'ar': {
                '55': '1', '56': '1', '57': '1',
                '62': '2', '63': '2', '64': '2', '65': '2'
            },
            'en': {
                '58': '4', '59': '4', '60': '4',
                '66': '5', '67': '5', '68': '5', '69': '5'
            }
        };

        var currentLang = "{{$currentLang->code}}"; // يجب أن تكون القيمة 'ar' أو 'en'

        function setDefaultValues(packageId) {
            var mainCategoryMap = mainCategoryMaps[currentLang] || {};
            var mainCategoryValue = mainCategoryMap[packageId];
            if (!mainCategoryValue) return; // إذا لم تكن القيمة مُعرفة، نعود مبكرًا

            $('select[name="maincategory_id"]').val(mainCategoryValue).trigger('change');

            setTimeout(function() {
                var valueExists = $("#sub_category_id option[value='" + packageId + "']").length > 0;
                if(valueExists) {
                    $("#sub_category_id").val(packageId).trigger('change').select2();
                }
            }, 5000); // يمكن زيادة الوقت إذا لزم الأمر
        }

        var packageIdFromUrl = "{{ request()->segment(count(request()->segments())) }}";
        setDefaultValues(packageIdFromUrl);


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
            </div>
        </div>

        <div class="row ">
            <div class="col-lg-12">

                <h2 class="legend tit-form mb-2">{{__('messages.company_details')}}</h2>
                <form id="ajaxForm" class="modal-form" action="{{route('store_package')}}" method="POST">
                    @csrf
                    

                    <div class="row">
                        <div class=" col-12 col-lg-6">
                            <div class="form-element mb-4">
                                
                  <div class="form-group" style="display:none;"> 
                    <input name="secure" type="text"  placeholder="" id="secure">
                    </div>

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
                                <label>{{__('messages.cr')}}</label>
                                <input name="cr" type="text" value="{{old('cr')}}" placeholder="{{__('messages.cr_placeholder')}}">
                                @if($errors->first('cr'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('cr')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class=" col-12 col-lg-6">
                            <div class="form-element mb-4">
                                <label>{{__('messages.email')}}</label>
                                <input name="email" type="email" value="{{old('email')}}" placeholder="{{__('messages.email_placeholder')}}">
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

{{--                        <div class=" col-6">--}}
{{--                            <div class="form-element ">--}}
{{--                                <label>{{__('messages.company_type')}}</label>--}}
{{--                                <select name="client_type">--}}
{{--                                    <option value="" selected="" disabled="">{{__('messages.company_type_placeholder')}}</option>--}}
{{--                                    <option>شركة</option>--}}
{{--                                    <option>مؤسسة</option>--}}
{{--                                    <option>فرد</option>--}}
{{--                                </select>--}}
{{--                                @if($errors->first('client_type'))--}}
{{--                                    <div class="alert alert-danger" role="alert">--}}
{{--                                        {{$errors->first('client_type')}}--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}

                    </div>






                    <h2 class="legend tit-form mb-2 mt-2">{{__('messages.package_details')}}</h2>

                    <div class="row">
                        <div class=" col-6">
                            <div class="form-element mb-4">
                                <label>{{__('messages.package_cat')}}</label>
                                <select name="maincategory_id" @if (url()->current() != 'https://etmaam.com.sa/package_quote') disabled @endif>
                                    <option value="" selected="" disabled="">{{__('messages.package_cat_placeholder')}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" @if($package && $package->section->id) selected @endif>
                                            {{$category->name}}
                                        </option>
                                    @endforeach
                                </select>
                                @if($errors->first('package_id'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('package_id')}}
                                    </div>
                                @endif
                            </div>
                        </div>



                        <div class=" col-6">
                            <div class="form-element mb-4">
                                <label>{{__('messages.package_type')}}</label>
                                <select name="package_id" id="sub_category_id" @if(!isset($package)) disabled @endif @if (url()->current() != 'https://etmaam.com.sa/package_quote') disabled @endif>
                                    <option value="" selected="" disabled="">{{__('messages.package_type_placeholder')}}</option>
                                    @if($package)
                                    @foreach($package->section->packages as $pack)
                                        <option value="{{$pack->id}}" @if($pack->id == $package->id) selected @endif>
                                            {{$pack->title}}
                                        </option>
                                    @endforeach
                                        @endif
                                </select>
                                @if($errors->first('package_id'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('package_id')}}
                                    </div>
                                @endif
                            </div>
                        </div>


                        <div class="col-12 col-lg-6">
                            <div class="form-element mb-4">
                                <label>{{__('messages.package_period')}}</label>
                                <select name="period"  id="period" >
                                    <option value="" selected="" disabled="">{{__('messages.package_period_placeholder')}}</option>
@if($currentLang->code == "ar")
<option @if(old('period') == 'سنوي') selected @endif selected>سنوي</option>
<!--<option  @if(old('period') == 'نصف سنوي') selected @endif>نصف سنوي</option>-->

@elseif($currentLang->code == "en")
<option  @if(old('period') == 'Annual') selected @endif selected>Annual</option>
<!--<option  @if(old('period') == 'Semi-Annual') selected @endif>Semi-Annual</option>-->
@endif

                                </select>
                                @if($errors->first('period'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('period')}}
                                    </div>
                                @endif
                            </div>
                        </div>


                        <div class=" col-12 col-lg-6">
                            <div class="form-element mb-4">
                                <label>{{__('messages.package_emp_num')}}</label>
                                <input name="emp_num" type="number" value="{{old('emp_num')}}" placeholder="{{__('messages.package_emp_num_placeholder')}}">
                                @if($errors->first('emp_num'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('emp_num')}}
                                    </div>
                                @endif
                            </div>
                        </div>



@if(request()->segment(count(request()->segments())) == 55 || request()->segment(count(request()->segments())) == 60)

                        <div class="col-12 col-lg-6">
                            <div class="form-element mb-4">
                                <label>{{__('messages.package_salary')}}</label>
                                <select name="salary_safety"  id="period" >
                                    <option value="" selected="" disabled="">{{__('messages.package_salary_placeholder')}}</option>
                                    @if($currentLang->code == "ar")
                                        <option @if(old('salary_safety') == 'نعم')  @endif>نعم</option>
                                        <option  @if(old('salary_safety') == 'لا') selected @endif>لا</option>

                                    @elseif($currentLang->code == "en")
                                        <option  @if(old('salary_safety') == 'Yes')  @endif>Yes</option>
                                        <option  @if(old('salary_safety') == 'No') selected @endif>No</option>
                                    @endif
                                </select>
                                @if($errors->first('salary_safety'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('salary_safety')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        
                    @else
                      <!--لن يظهر حقل wps-->
                    @endif


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
                        <div class=" col-12 col-lg-3 hide">
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
    
    

@endsection




