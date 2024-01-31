@extends("front.$version.layout")

@section('pagename')
    - {{__('messages.thanks')}}
@endsection

@section('meta-keywords', "$be->packages_meta_keywords")
@section('meta-description', "$be->packages_meta_description")


@section('breadcrumb-title', __('messages.thanks'))
@section('breadcrumb-subtitle', $be->pricing_subtitle)
@section('breadcrumb-link', __('messages.thanks'))

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
        <div class="row mt-5 mb-5">
            <div class=" col-12 col-md-8 m-auto suc-box text-center">

                <div class="suc-icon">
                    <img style="    width: 100px;
    margin-bottom: 20px;" src="{{asset('assets/send-icon.png')}}" alt="">
                    <p class="text-center pay-suc"> {{$msg_title}} </p>
                    <p class="text-center pay-suc-message ">{{$msg}}</p>
                </div>


            </div>
        </div>
    </div>

@endsection




