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
    .landing-intro {
    background: transparent url(http://www.tsgroup.com.br/assets/images/pattern/pattern4.png) repeat scroll 50% -38.8px;
    padding: 0 0;
    text-align: center;
    width: 50%;
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0.9;
    bottom: 0;
    right: 0;
    margin: auto;
    border-top: dotted #d7e4ed;
    border-right: solid #225476;
    border-bottom: dotted #d7e4ed;
    border-left: solid #225476;        
    }
    .mustwhite{
filter: brightness(0) invert(1);
    }
    img.scale-with-grid {
    position: relative;
}


@media screen and (max-width: 800px) {

.landing-intro{
width:100% !important;
}

.cd-timeline-img img{
    left: -15%
}

h4,h2{
    font-size:16px;
}

a.btn.btn-primary.btn-sm.mt-3 {
    font-size: 12px;
}
 }

</style>
<div class="containery ">
        <div class="row mt-5 ">

<!--    <div class="  m-auto  text-center">-->
<!--    <img  style=" width: 100px;-->
<!--    margin-bottom: 20px;" src="https://etmaam.com.sa/assets/front/img/checked.png" alt="">-->

<!--</div>-->

<div class="aaa" style="
    width: 100%;
    MARGIN: AUTO;
    position: relative;
    text-align: center;
">
    
    <div class="landing-intro "></div>
        <div class="container" style="
    padding: 20px;">
            <div class="row">
                <div class="col-md-12">
                                        <div class="row1full">
                        <div class="panel-pane pane-custom pane-1">
  
      
  
  <div class="pane-content">

<h3 style="font-weight:bold">
              <img  style=" width: 35px;
    margin-bottom: 3px;" src="https://etmaam.com.sa/assets/front/img/checked.png" alt="">

    
{{__('app.yourordersent')}}    
    S-{{$id}}</h3>
<h4> {{__('app.wehappy')}}</h4>
<h4>{{__('app.youcan')}} <a href="/contact">{{__('app.callus')}}</a> {{__('app.anyelsehelp')}}
<br>
{{__('app.thnx')}}
</h4>  </div>

                  <p class="lead"><a class="btn btn-primary btn-sm mt-3" href="https://etmaam.com.sa/" role="button">{{__('app.backhome')}}</a></p>  
  </div>
                      </div>
                </div>

                
            </div>
        </div>
    </div>            
            
            
            
        </div>
        
    </div>
    
    
    
    <!--#2-->
    <div class="container">
        <div class="row ">


<section id="cd-timeline" class="cd-container">
        <div class="cd-timeline-block">
            <div class="cd-timeline-img cd-picture">
                <img class="mustwhite"  src="https://etmaam.com.sa/assets/front/img/reciveorder.svg" alt="Picture">
            </div>
            <!-- cd-timeline-img -->

            <div class="cd-timeline-content">
                <h2>{{__('app.t1')}}</h2>
                <!--<p>تمّ تسجيل طلبكم وتحويله للقسم المعنيّ به.</p>-->
                <span class="cd-date">{{__('app.s1')}}
                <br>
                {{__('app.sd1')}}
                </span>
            </div>
            <!-- cd-timeline-content -->
        </div>
        <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
            <div class="cd-timeline-img cd-movie">
                <img class="mustwhite"  src="https://etmaam.com.sa/assets/front/img/delivery.svg" alt="Movie">
            </div>
            <!-- cd-timeline-img -->

            <div class="cd-timeline-content">
                <h2>{{__('app.t2')}}</h2>
<!--<p style="    font-size: 0.96rem;-->
<!--">-->
<!--سيتّصل بكم الموظّف المعنيّ لمراجعة الطّلب والاستعلام عنه. الرّجاء التّأكّد من الإجابة على الاتّصال، وقد يتمّ التّواصل عبر واتساب.-->

<!--</p>-->
                    
                <span class="cd-date"><storng>{{__('app.s2')}}     <br>
{{__('app.sd2')}}
<!--أمّا طلبات يوم الجمعة فيتمّ تأكيدها يوم السّبت.-->
</span>
            </div>
            <!-- cd-timeline-content -->
        </div>
        <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
            <div class="cd-timeline-img cd-location">
                <img class="mustwhite" src="https://etmaam.com.sa/assets/front/img/dobulechecking.svg" alt="Picture">
            </div>
            <!-- cd-timeline-img -->

            <div class="cd-timeline-content">
<h2>
    {{__('app.t3')}}

</h2>
    <p>
        
<!--بعد تأكيدكم للطّلب يتمّ العمل على تنفيذه وإنجاز الخدمة.-->
         
    </p>           
                <span class="cd-date">{{__('app.s3')}}
                <br>
                {{__('app.sd3')}}
            </div>
            <!-- cd-timeline-content -->
        </div>
        <!-- cd-timeline-block -->

        <div class="cd-timeline-block">
            <!--<div class="cd-timeline-img cd-location is-hidden">-->
            <!--    <img src="nextstep-folder/img/fast-delivery.svg" alt="Location">-->
            <!--</div>-->
            <!-- cd-timeline-img -->

            <!--<div class="cd-timeline-content is-hidden">-->
            <!--    <h2>توصيل الطلب</h2>-->
            <!--    <p>سيقوم موظف شركة أرامكس بالاتصال بكم لترتيب عملية التوصيل</p>-->
            <!--    <span class="cd-date">مدة الإنجاز: خلال ثلاثة أو أربعة أيام عمل</span>-->
            <!--</div>-->
            <!-- cd-timeline-content -->
        </div>
        <!-- cd-timeline-block -->
    </section>



    <div class="  m-auto  text-center">

 @if ($rtl == 1)     
<img class="scale-with-grid" src="https://etmaam.com.sa/assets/front/img/14241353.png" alt="1424135" title="" width="180" height="180">
@elseif ($rtl == 0)
<img class="scale-with-grid" src="https://etmaam.com.sa/assets/front/img/lifeisgood.png" alt="1424135" title="" width="180" height="180">
@endif
</div>


        </div>
        
    </div>
    
    
    <style>


a {
  /*color: #acb7c0;*/
  text-decoration: none;
  font-family: "Open Sans", sans-serif;
}
img {
  max-width: 100%;
}
h1,
h2 {
  font-family: "Open Sans", sans-serif;
  font-weight: bold;
}
/* -------------------------------- 

Modules - reusable parts of our design

-------------------------------- */
.cd-container {
  width: 90%;
  max-width: 1170px;
  margin: 0 auto;
}
.cd-container::after {
  content: '';
  display: table;
  clear: both;
}
/* -------------------------------- 

Main components 

-------------------------------- */
header {
  height: 200px;
  line-height: 300px;
  text-align: center;
  background: #FBD208;
}
header h1 {
  color: black;
  font-size: 24px;
  line-height: 72px;
}
@media only screen and (min-width: 1170px) {
  header {
    height: 300px;
    line-height: 300px;
  }
  header h1 {
    font-size: 24px;
  }
}
#cd-timeline {
  position: relative;
  padding: 2em 0;
  margin-top: 0em;
  margin-bottom: 0em;
}
#cd-timeline::before {
  content: '';
  position: absolute;
  top: 0;
  left: 18px;
  height: 100%;
  width: 4px;
  background: #d7e4ed;
}
@media only screen and (min-width: 1170px) {
  #cd-timeline {
    margin-top: 0em;
    margin-bottom: 0em;
  }
  #cd-timeline::before {
    left: 50%;
    margin-left: -2px;
  }
}
.cd-timeline-block {
  position: relative;
  margin: 2em 0;
}
.cd-timeline-block:after {
  content: "";
  display: table;
  clear: both;
}
.cd-timeline-block:first-child {
  margin-top: 0;
}
.cd-timeline-block:last-child {
  margin-bottom: 0;
}
@media only screen and (min-width: 1170px) {
  .cd-timeline-block {
    margin: 4em 0;
  }
  .cd-timeline-block:first-child {
    margin-top: 0;
  }
  .cd-timeline-block:last-child {
    margin-bottom: 0;
  }
}
.cd-timeline-img {
  position: absolute;
  top: 0;
  left: 0;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  box-shadow: 0 0 0 4px #ffffff, inset 0 2px 0 rgba(0, 0, 0, 0.08), 0 3px 0 4px rgba(0, 0, 0, 0.05);
}
.cd-timeline-img img {
  display: block;
  width: 20px;
  height: 28px;
  position: relative;
  left: 50%;
  top: 50%;
  margin-left: -12px;
  margin-top: -12px;
}
.cd-timeline-img.cd-picture {
  background: #1B81AF;
}
.cd-timeline-img.cd-movie {
  background: #0a3041;
}
.cd-timeline-img.cd-location {
  background: #00a986;
}
@media only screen and (min-width: 1170px) {
  .cd-timeline-img {
    width: 60px;
    height: 60px;
    left: 50%;
    margin-left: -30px;
    -webkit-transform: translateZ(0);
    -webkit-backface-visibility: hidden;
  }
  .cssanimations .cd-timeline-img.is-hidden {
    visibility: hidden;
  }
  .cssanimations .cd-timeline-img.bounce-in {
    visibility: visible;
    -webkit-animation: cd-bounce-1 0.6s;
    -moz-animation: cd-bounce-1 0.6s;
    animation: cd-bounce-1 0.6s;
  }
}
@-webkit-keyframes cd-bounce-1 {
  0% {
    opacity: 0;
    -webkit-transform: scale(0.5);
  }
  60% {
    opacity: 1;
    -webkit-transform: scale(1.2);
  }
  100% {
    -webkit-transform: scale(1);
  }
}
@-moz-keyframes cd-bounce-1 {
  0% {
    opacity: 0;
    -moz-transform: scale(0.5);
  }
  60% {
    opacity: 1;
    -moz-transform: scale(1.2);
  }
  100% {
    -moz-transform: scale(1);
  }
}
@keyframes cd-bounce-1 {
  0% {
    opacity: 0;
    -webkit-transform: scale(0.5);
    -moz-transform: scale(0.5);
    -ms-transform: scale(0.5);
    -o-transform: scale(0.5);
    transform: scale(0.5);
  }
  60% {
    opacity: 1;
    -webkit-transform: scale(1.2);
    -moz-transform: scale(1.2);
    -ms-transform: scale(1.2);
    -o-transform: scale(1.2);
    transform: scale(1.2);
  }
  100% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1);
  }
}
.cd-timeline-content {
  position: relative;
  margin-left: 60px;
  background: white;
  border-radius: 0.25em;
  padding: 1em;
  box-shadow: 0 3px 0 #d7e4ed;
}
.cd-timeline-content:after {
  content: "";
  display: table;
  clear: both;
}
.cd-timeline-content h2 {
  color: #303e49;
}
.cd-timeline-content p,
.cd-timeline-content .cd-read-more,
.cd-timeline-content .cd-date {
  font-size: 0.8125rem;
}
.cd-timeline-content .cd-read-more,
.cd-timeline-content .cd-date {
  display: inline-block;
}
.cd-timeline-content p {
  margin: 1em 0;
  line-height: 1.6;
}
.cd-timeline-content .cd-read-more {
  float: right;
  padding: .8em 1em;
  background: #acb7c0;
  color: white;
  border-radius: 0.25em;
}
.no-touch .cd-timeline-content .cd-read-more:hover {
  background-color: #bac4cb;
}
.cd-timeline-content .cd-date {
  float: left;
  padding: .8em 0;
  opacity: .7;
}
.cd-timeline-content::before {
  content: '';
  position: absolute;
  top: 16px;
  right: 100%;
  height: 0;
  width: 0;
  border: 7px solid transparent;
  border-right: 7px solid white;
}
@media only screen and (min-width: 768px) {
  .cd-timeline-content h2 {
    font-size: 1.25rem;
  }
  .cd-timeline-content p {
    font-size: 1rem;
  }
  .cd-timeline-content .cd-read-more,
  .cd-timeline-content .cd-date {
    font-size: 0.875rem;
  }
}
@media only screen and (min-width: 1170px) {
  .cd-timeline-content {
    margin-left: 0;
    padding: 1.6em;
    width: 45%;
  }
  .cd-timeline-content::before {
    top: 24px;
    left: 100%;
    border-color: transparent;
    border-left-color: white;
  }
  .cd-timeline-content .cd-read-more {
    float: left;
  }
  .cd-timeline-content .cd-date {
    /*position: absolute;*/
    width: 100%;
    right: 122%;
    top: 6px;
    /*font-size: 1rem !important;*/
  }
  .cd-timeline-block:nth-child(even) .cd-timeline-content::before {
    top: 24px;
    left: auto;
    right: 100%;
    border-color: transparent;
    border-right-color: white;
  }
    .cd-timeline-block:nth-child(even) .cd-timeline-content {
    float: right;
  }
  .cd-timeline-block:nth-child(even) .cd-timeline-content .cd-read-more {
    float: right;
  }
  .cd-timeline-block:nth-child(even) .cd-timeline-content .cd-date {
    left: auto;
    right: 122%;
    text-align: right;
  }
  .cssanimations .cd-timeline-content.is-hidden {
    visibility: hidden;
  }
  .cssanimations .cd-timeline-content.bounce-in {
    visibility: visible;
    -webkit-animation: cd-bounce-2 0.6s;
    -moz-animation: cd-bounce-2 0.6s;
    animation: cd-bounce-2 0.6s;
  }
  /* inverse bounce effect on even content blocks */
  .cssanimations .cd-timeline-block:nth-child(even) .cd-timeline-content.bounce-in {
    -webkit-animation: cd-bounce-2-inverse 0.6s;
    -moz-animation: cd-bounce-2-inverse 0.6s;
    animation: cd-bounce-2-inverse 0.6s;
  }
}
@-webkit-keyframes cd-bounce-2 {
  0% {
    opacity: 0;
    -webkit-transform: translateX(-100px);
  }
  60% {
    opacity: 1;
    -webkit-transform: translateX(20px);
  }
  100% {
    -webkit-transform: translateX(0);
  }
}
@-moz-keyframes cd-bounce-2 {
  0% {
    opacity: 0;
    -moz-transform: translateX(-100px);
  }
  60% {
    opacity: 1;
    -moz-transform: translateX(20px);
  }
  100% {
    -moz-transform: translateX(0);
  }
}
@keyframes cd-bounce-2 {
  0% {
    opacity: 0;
    -webkit-transform: translateX(-100px);
    -moz-transform: translateX(-100px);
    -ms-transform: translateX(-100px);
    -o-transform: translateX(-100px);
    transform: translateX(-100px);
  }
  60% {
    opacity: 1;
    -webkit-transform: translateX(20px);
    -moz-transform: translateX(20px);
    -ms-transform: translateX(20px);
    -o-transform: translateX(20px);
    transform: translateX(20px);
  }
  100% {
    -webkit-transform: translateX(0);
    -moz-transform: translateX(0);
    -ms-transform: translateX(0);
    -o-transform: translateX(0);
    transform: translateX(0);
  }
}
@-webkit-keyframes cd-bounce-2-inverse {
  0% {
    opacity: 0;
    -webkit-transform: translateX(100px);
  }
  60% {
    opacity: 1;
    -webkit-transform: translateX(-20px);
  }
  100% {
    -webkit-transform: translateX(0);
  }
}
@-moz-keyframes cd-bounce-2-inverse {
  0% {
    opacity: 0;
    -moz-transform: translateX(100px);
  }
  60% {
    opacity: 1;
    -moz-transform: translateX(-20px);
  }
  100% {
    -moz-transform: translateX(0);
  }
}
@keyframes cd-bounce-2-inverse {
  0% {
    opacity: 0;
    -webkit-transform: translateX(100px);
    -moz-transform: translateX(100px);
    -ms-transform: translateX(100px);
    -o-transform: translateX(100px);
    transform: translateX(100px);
  }
  60% {
    opacity: 1;
    -webkit-transform: translateX(-20px);
    -moz-transform: translateX(-20px);
    -ms-transform: translateX(-20px);
    -o-transform: translateX(-20px);
    transform: translateX(-20px);
  }
  100% {
    -webkit-transform: translateX(0);
    -moz-transform: translateX(0);
    -ms-transform: translateX(0);
    -o-transform: translateX(0);
    transform: translateX(0);
  }
}
</style>



      @if ($rtl == 1)

<style>
  .cd-timeline-block:nth-child(even) .cd-timeline-content {
    float: left !important;
  }
  .cd-timeline-img img{
      left:-38%;
  }
</style>

@endif
    
    @endsection




