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
    margin:10px;
        border-radius: 0px;
    border: 1px solid #92929e;
    box-shadow: unset;
}
.p-p{
    font-size: 17px;
    color: #161616;
    text-align: center;
    padding-bottom: 10px;
    min-height: 58px;
}
@media screen and (max-width: 800px) {
    .dsa{
        width: 40%!important;
    }
}


</style>




<div class="container">
        <div class="row ">
            
        @foreach($downloads as $download)
            <div class="col-md-3 col-sm-6 col-xs-12   mt-4 ">
                <div class="box-bank">
                    <p class="p-p">{{$download->title}}</p>
                    <label class="bank-label" for=""> 
                    <!--{{$download->description}}-->
                    @if($download->file_type == 'pdf')
                    <img src="https://etmaam.com.sa/assets/front/dc/pdf.png" width="30px" heigth="30px">
                    @elseif($download->file_type == 'doc')
                    <img src="https://etmaam.com.sa/assets/front/dc/word.png" width="30px" heigth="30px">
                    @elseif($download->file_type == 'xlsx')
                    <img src="https://etmaam.com.sa/assets/front/dc/excel-file.png" width="30px" heigth="30px">
                    @else
                 {{$download->file_type}}    
                    @endif
</label>
<br>
            <a href="{{$download->download_file}}" class="readmore-btn"><span>{{__('app.clickhere')}}</span></a>
            </div>
            </div>
            
            @endforeach

        </div>
        
    </div>



<div class="container">
        <div class="row ">
<a href="https://etmaam.com.sa/downloads" class="readmore-btn dsa" style="margin: 1.5% !important; background: #e6e6e6; color: #000; border-radius: 9px; box-shadow: -1px 0 17px -3px #f1f1f1; font-size: 12px!important; width: 15%;">
    <span>{{__('app.goback')}}</span></a>
</div>
</div>

    @endsection




