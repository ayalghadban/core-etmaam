@extends("front.$version.layout")

@section('pagename')
- {{__('app.downloads')}}
@endsection

@section('meta-keywords', "$be->packages_meta_keywords")
@section('meta-description', "$be->packages_meta_description")


@section('breadcrumb-title', __('app.downloads'))
@section('breadcrumb-subtitle', $be->pricing_subtitle)
@section('breadcrumb-link', __('app.downloads'))


@section('content')

<style>
    .box-bank {
    background-color: #ffffff;
}
.box-bank {
    border-radius: 0px;
    border: 1px solid #92929e;
    box-shadow: unset;
}
</style>
<div class="container">
        <div class="row ">

        @foreach($downloads as $download)
            <div class="col-12 col-md-4  mt-4 ">
                <div class="box-bank">
                    <p class="bank-p">{{$download->title}}</p>
                    <label class="bank-label" for="">
                    {{$download->description}}
</label>

            <a href="{{route('download',$download->id)}}" class="readmore-btn"><span>{{__('app.clickhere')}}</span></a>
            </div>
            </div>

            @endforeach
        </div>

    </div>

    @endsection




