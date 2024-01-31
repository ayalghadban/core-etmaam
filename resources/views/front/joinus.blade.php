@extends("front.$version.layout")

@section('pagename')
    - {{__('messages.joinus')}}
@endsection

@section('meta-keywords', "$be->packages_meta_keywords")
@section('meta-description', "$be->packages_meta_description")


@section('breadcrumb-title', __('messages.joinus'))
@section('breadcrumb-subtitle', $be->pricing_subtitle)
@section('breadcrumb-link', __('messages.joinus'))
@section('scripts')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.16/css/intlTelInput.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.16/js/intlTelInput-jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        'use strict';

        ;( function ( document, window, index )
        {
            var inputs = document.querySelectorAll( '.inputfile' );
            Array.prototype.forEach.call( inputs, function( input )
            {
                var label	 = input.nextElementSibling,
                    labelVal = label.innerHTML;

                input.addEventListener( 'change', function( e )
                {
                    var fileName = '';
                    if( this.files && this.files.length > 1 )
                        fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
                    else
                        fileName = e.target.value.split( '\\' ).pop();

                    if( fileName )
                        label.querySelector( 'span' ).innerHTML = fileName;
                    else
                        label.innerHTML = labelVal;
                });

                // Firefox bug fix
                input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
                input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
            });
        }( document, window, 0 ));
    </script>
    <script>
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
  $(".needbelarge").addClass("col-12 col-lg-3");
        }
        
        
                if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
  $(".needbelarge2").addClass("col-12 col-lg-3");
        }


//         if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
//   $(".needbelarge").removeClass("col-12 col-lg-3");

// }


    </script>
    
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

        .inputfile {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }

        .inputfile + label {
            max-width: 80%;
            font-size: 1.25rem;
            /* 20px */
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
            cursor: pointer;
            display: inline-block;
            overflow: hidden;
            padding: 0.625rem 1.25rem;
            /* 10px 20px */
        }

        .inputfile-2 + label {
            color: #225476;
            border: 2px solid currentColor;
        }

        .inputfile-2:focus + label,
        .inputfile-2.has-focus + label,
        .inputfile-2 + label:hover {
            color: #225476;
        }

        .inputfile-2 a {
            outline: none;
            color: #225476;
            text-decoration: none;
        }

        .inputfile-2 a:hover,
        .inputfile-2 a:focus {
            color: #225476;
        }
         svg{
            fill: #225476;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('select').select2({ height: '50px'});
            $('[name="mobile"]').intlTelInput({	localizedCountries:"AR",initialCountry:"SA",separateDialCode:true,excludeCountries: ['ir','il']});

            $("select[name='category_id']").on('change', function() {
                $("#service_id").removeAttr('disabled');

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
                });
            });

            $("select[name='maincategory_id']").on('change', function() {
                $("#sub_category_id").removeAttr('disabled');

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
          </span> {{__('messages.joinus_welcome')}}  <br>
                    </div>
                </div>
            </div>
        </div>

        <div class="row ">
            <div class="col-lg-12">

{{--                <h2 class="legend tit-form mb-2">{{__('messages.company_details')}}</h2>--}}
                <form id="ajaxForm" class="modal-form" action="{{route('thank.you.partner')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    
                    <div class="form-group" style="display:none;"> 
                    <input name="secure" type="text"  placeholder="" id="secure">
                    </div>
                    <div class="row">
                        <div class=" col-6 needbelarge">
                            <div class="form-element ">
                                <label>{{__('messages.partner_type')}}</label>
                                <select name="partner_type">
                                    <option value="" selected="" disabled="">{{__('messages.partner_type_placeholder')}}</option>
                                    @foreach($partners as $partner)
                                        <option @if($partner == old('partner_type')) selected @endif>{{$partner}}</option>
                                    @endforeach
                                </select>
                                @if($errors->first('partner_type'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('partner_type')}}
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
                                <input name="mobile" type="tel" value="{{old('mobile')}}" placeholder="{{__('messages.mobile_placeholder')}}" minlength="9" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                @if($errors->first('mobile'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('mobile')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class=" col-6 needbelarge2 ">
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
                        <hr>
                        <div class=" col-12 col-lg-6">
                            <div class="form-element mb-4">
                                <label>{{__('messages.company_name')}} {{__('messages.ifoptional')}}</label>
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
                                <label>{{__('messages.cr')}} {{__('messages.ifoptional')}}</label>
                                <input name="cr" type="text" value="{{old('cr')}}" placeholder="{{__('messages.cr_placeholder')}}">
                                @if($errors->first('cr'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('cr')}}
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class=" col-12 ">
                            <div class="form-element mb-4">
                                <label>{{__('messages.notes')}}</label>
                                <textarea name="notes" id="" cols="30" rows="10" placeholder="{{__('messages.notes_placeholder')}}">{{old('notes')}}</textarea>
                                @if($errors->first('notes'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('notes')}}
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
                                                <div class=" col-12 col-lg-6">
                                                    <div class="form-element mb-4">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-element mb-2">
                                                                    <label> {{__('messages.supported_docs')}} <small>({{__('messages.supported_docs_note')}})</small></label>
                                                                    <input type="file" name="docs[]" id="file-2" class="inputfile inputfile-2" data-multiple-caption="{count} {{__('messages.files_selected')}}" multiple />
                                                                    <label for="file-2"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="    font-size: 16px;color:#225476;">{{__('messages.choose_file')}}&hellip;</span></label>
                                                                    @if($errors->first('docs.*'))
                                                                        <div class="alert alert-danger" role="alert">
                                                                            {{$errors->first('docs.*')}}
                                                                        </div>
                                                                    @endif
                                                                </div>
{{--                                                            a--}}

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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




