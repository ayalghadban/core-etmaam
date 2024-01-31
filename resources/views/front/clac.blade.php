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


<div class="site-header" id="header">
    <img width="15%" height="15%" src="https://etmaam.com.sa/assets/front/img/check.svg">
		<h2 class="site-header__title" style="margin:20px;color:#007bff;" > 
		{{__('app.yourordersent')}}    
    S- {{__('app.wsuccess')}}    
		</h2>


    </div>

        
    <div class="appricat">

        <h4 class="introdiction">
     {{__('app.wehappy')}}
     <br>
{{__('app.youcan')}} 
<a href="https://etmaam.com.sa/contact">{{__('app.callus')}}</a>
{{__('app.anyelsehelp')}}
<br>
{{__('app.thnx')}}
        </h4>

<br>
        <img width="155px" height="155px" src="https://etmaam.com.sa/assets/front/img/line-step.svg">

    </div>

    <div class="container">
        <div class="row">
                                                <!--col-xl-3 col-lg-3 col-sm-6-->
                
                                                
                
                                                
                
                                

<div class="col-12 col-md-4 dir-cust  mt-3 ">
<div class="rectanglexx"></div>
<div class="single-category">
                                        <div class="img-wrapper">
<img class="lazy entered loaded" data-src="https://etmaam.com.sa/assets/front/img/receive-order.svg" alt="" data-ll-status="loaded" src="https://etmaam.com.sa/assets/front/img/receive-order.svg">
</div>
                                    <div class="text">
<h4 style="color:#017CB6">{{__('app.t1')}}</h4>
<p style="color:#3D3D3D;    font-weight: 500 !important;">
                {{__('app.sd1')}}

<span style="display: none;"></span>

</p><div class="stepfly">
    <p>{{__('app.s1')}}</p>
</div>
    <!--<a href="#" class="see-more">عرض المزيد...</a>-->
<!--<a href="https://etmaam.com.sa/services?category=103" class="readmore">عرض الخدمات</a>-->
</div>
</div>





</div><div class="col-12 col-md-4 dir-cust  mt-3 ">
<div class="rectanglexx az"></div>
<div class="single-category">
                                        <div class="img-wrapper">
<img class="lazy entered loaded" data-src="https://etmaam.com.sa/assets/front/img/confirm-order.svg" alt="" data-ll-status="loaded" src="https://etmaam.com.sa/assets/front/img/confirm-order.svg">
</div>
                                    <div class="text">
<h4 style="color:#004767">{{__('app.t2')}}</h4>
<p style="color:#3D3D3D;    font-weight: 500 !important;">
                {{__('app.sd2')}}

<span style="display: none;"></span>

</p><div class="stepfly blue">
    <p>{{__('app.s2')}}</p>
</div>
    <!--<a href="#" class="see-more">عرض المزيد...</a>-->
</div>
</div>





</div><div class="col-12 col-md-4 dir-cust  mt-3 ">
<div class="rectanglexx"></div>
<div class="single-category">
                                        <div class="img-wrapper">
<img class="lazy entered loaded lessize" data-src="https://etmaam.com.sa/assets/front/img/finish-order.png" alt="" data-ll-status="loaded" src="https://etmaam.com.sa/assets/front/img/finish-order.png">
</div>
                                    <div class="text">
<h4 style="color:#017CB6">{{__('app.t3')}}</h4>
<p style="color:#3D3D3D;    font-weight: 500 !important;">
                {{__('app.sd3')}}
<span style="display: none;"></span>

</p><div class="stepfly ">
    <p> {{__('app.s3')}}</p>
</div>
    <!--<a href="#" class="see-more">عرض المزيد...</a>-->
</div>
</div>
</div>
                                        </div>
    </div>


    



<style>



.site-header {
    margin: 0 auto;
    padding: 50px 0 0;
    max-width: 820px;
}
.site-header__title {
    /* color:linear-gradient(90deg, rgba(167,214,63,1) 0%, rgba(159,212,64,1) 9%, rgba(57,181,74,1) 100%); */
    color:#6dc545;
    margin: 0;
    font-family: Montserrat, sans-serif;
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1.1;
    text-transform: uppercase;
    -webkit-hyphens: auto;
    -moz-hyphens: auto;
    -ms-hyphens: auto;
    hyphens: auto;
}
@media only screen and (max-width: 800px) {
    .site-header {
        padding-top: 80px;
    }
    .site-header__title {
        font-size: 1.6rem;
    margin:13px 0px 13px 0px !important;
        font-weight: 500 !important;
    }
    
    .introdiction {
        line-height: 38px;
    margin-top: 20px;
}

.appricat {
    padding: 0px !important;
}

.row{
        padding: 10px;
}
}


.single-category img {
    width: 86px;
}


.dir-cust {
    text-align: center !important;
    background: #F8FAFB;
    border-radius: 25px;
    padding: 25px 18px 25px 18px;
    border: solid 2px #ffffff;
    margin-bottom: 100px;
}

.stepfly {
    background-color: #017CB6;
    color: #fff;
    padding: 2px 2px 2px 2px;
    border-radius: 30px 10px 10px 10px;
    width: 55%;
    position: absolute;
    top: 90%;
    left: 45%;
}
.stepfly p {
    font-size: 16px !important;
}

.single-category .text {
    margin-top: 10px;
    margin-bottom: 26%;
}

.img-wrapper {
    margin-top: 6%;
}

.rectanglexx {
    height: 9px;
    width: 50%;
    background-color: #017CB6;
    position: absolute;
    top: -10px;
    right: 80px ;
    opacity: 50%;
}
.stepfly.blue {
    background: #004767;
}

.rectanglexx.az{
    background-color: #004767;
}
.rectanglexx.bz {
    background-color: #1968D1;
}
.single-category .text p{
    margin-bottom: 7px !important;
}

img.lazy.entered.loaded.lessize {
    width: 71px;
    margin-bottom: 15px;
    margin-top: 4px;
}

.appricat {
    text-align: center;
    padding: 0px 20% 0px 20%;
}

.introdiction{
    color:#3D3D3D
}

div#header {
    text-align: center;
}
</style>

@endsection



