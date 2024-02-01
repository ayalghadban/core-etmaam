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
@section('breadcrumb-link', __('About Us'))



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
</style>
<div class="about-us">
    
  <div class="intro-section" @if($bs->feature_section == 0) style="margin-top: 0px;" @endif>
     <div class="container">


       @if ($bs->intro_section == 1)
       
                <div class="row">

                    <div class=" col-12 col-lg-6 mb-4 " style="min-height: 260px;">
                        <div class="intro-bg"
                            style="background-image: url('https://etmaam.com.sa/cms/assets/front/img/628fdc7dcad22.jpg'); background-size: cover;">
                            <a id="play-video" class="video-play-button"
                                href="https://www.youtube.com/watch?v=uUMNxsSLOJQ">
                                <span></span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">من هى إتمام </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">رؤيتُنا </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">مهمّتُنا</a>
                            </li>
                          </ul>
                          <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <p class="tab-p">شركة تأسست عام ٢٠٠٨ في مجال خدمات الأعمال والدعم المباشر لقطاعاتها المختلفة، تساعد في وضع خطط استراتيجية ومنهجية، وتقدم توجيهات وحلولا متكاملة وسريعة لجميع الصعوبات والمشكلات التي تقف في وجه المؤسسات والشركات، حيث يقوم عماد الشركة على فريق عمل مؤهل واسع الاطلاع لتوفير الخيارات والاستشارات لتحقيق مصالح العملاء وتطور أعمالهم بوتيرة سريعة.</p>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <p  class="tab-p">نحنُ نصبُّ بصرَنا وبصيرتَنا وجُلَّ اهتمامِنا لتحقيقِ مكانةً عاليةَ المستوى في الجودةِ والاحترافِ في الخدمات، ولا نغضُّ طرفاً عنِ الرّيادةِ في هذا المجالِ في المملكة، كشركةٍ خدميّةٍ متنوّعةٍ تبذلُ قصارى الجهدِ وتسخّرُ كلَّ الطّاقاتِ لإرضاءِ عملائِها وموظّفيها لنسيرَ معاً يداً بيدٍ على طريقِ التّميّزِ والإبداع.</p>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                <p  class="tab-p">نجتهدُ في إتمامَ دائماً في ترسيخِ قواعدَ متينةٍ في أرضِ الابتكارِ لكافّةِ الخدماتِ التي نقدّمها، ونعملُ بشكلٍ دؤوبٍ على خلقِ فرصٍ جديدةٍ وحلولٍ مثاليّةٍ واستثماراتٍ واستشاراتٍ من شأنِها تطويرُ الكفاءةِ والفاعليّةِ وبناءُ حلقةٍ مترابطةٍ بينَنا وبينَ الشّركاتِ والوزاراتِ والهيئاتِ الحكوميّةِ المختصّة، ونطمحُ بلعبٍ دورٍ محوريٍّ بارزٍ في نموِّ ونجاحِ عملائِنا وازدهارِ أعمالِهم.</p>
                            </div>
                          </div>
                        
                </div>

                
                </div>
       @endif
       
       
       
       <h2 class="e-header-sub mt-4">    لماذا إتمام ؟</h2>
                <p class="about-p-des "> 
                    عندما تضع أمامك كل الخيارات المتاحة للمقارنة فإنك حتماً ستختار إتمام لتميز خدماتنا وابداعنا المتواصل. عندما تختارنا فإنك تختار الجودة والخبرة التي اختارها أكبر الشركات في المملكة   وما يميزنا عن الاخرين هو  <b>العملُ الجماعي  , الإبداع,التّحفيزُ والمحاسبة  , النّزاهة  </b>   

                     </p>
                <div class="row service-content">
                    <div class="col-12 col-md-3 dir-cust  mt-4 ">
                        <div class="box-service">
                            <img src="assets/front/icons/wallet-egor.svg" alt="">
                            <h4 style="color: #225476;">حماية الأجور</h4>
                            <p>مختصون في نظام حماية الأجور والذي تم تطبيقه على جميع المنشآت في القطاع الخاص منذ عام 2015 حيث تولت شركة إتمام .
                            </p>
         
                        </div>
                    </div>
                    <div class="col-12 col-md-3 dir-cust  mt-4 ">
                        <div class="box-service">
                            <img src="assets/front/icons/handshake (2).svg" alt="">
                            <h4 style="color: #A159FF;">إستشارات ونصائح
                            </h4>
                            <p>تقدم إتمام استشارات ونصائح على أيدي خبراء في مجال الأعمال و القانون والشؤون المالية وتطوير الشركات وأكثر لتتحرك نحو أهدافك وطموحك</p>
         
                        </div>
                    </div>
                    <div class="col-12 col-md-3 dir-cust  mt-4 ">
                        <div class="box-service">
                            <img src="assets/front/icons/laptop (1).svg" alt="">
                            <h4 style="color: #00524D;"> تدريب عن بعد
                            </h4>
                            <p>مجموعة العمليات المرتبطة بنقل وتوصيل مختلف أنواع المعرفة المتعلقة في عالم الأعمال إلى المتدربين دورات تدريبية اونلاين
                            </p>
         
                        </div>
                    </div>
                    <div class="col-12 col-md-3 dir-cust  mt-4 ">
                        <div class="box-service">
                            <img src="assets/front/icons/customer-service.svg" alt="">
                            <h4 style="color: #FF0707;"> الدعم التقني
                            </h4>
                            <p>
                                توفير المساعدة على نطاق واسع، ورسم خطط وإنشاء وتطوير بنية معلوماتية أساسية، وخدمات دعم التكنولوجيا للشركات وللمؤسسات
        
                            </p>
         
                        </div>
                    </div>
                    <div class="col-12 col-md-3 dir-cust  mt-4 ">
                        <div class="box-service">
                            <img src="assets/front/icons/coding.svg" alt="">
                            <h4 style="color: #AE8910;"> تصميم المواقع
                            </h4>
                            <p>
                                توفير المساعدة على نطاق واسع، ورسم خطط وإنشاء وتطوير بنية معلوماتية أساسية، وخدمات دعم التكنولوجيا للشركات وللمؤسسات
        
                            </p>
         
                        </div>
                    </div>
                    <div class="col-12 col-md-3 dir-cust  mt-4 ">
                        <div class="box-service">
                            <img src="assets/front/icons/global-network.svg" alt="">
                            <h4 style="color: #16C389;"> التسويق الإلكتروني
                            </h4>
                            <p>
                                توفير المساعدة على نطاق واسع، ورسم خطط وإنشاء وتطوير بنية معلوماتية أساسية، وخدمات دعم التكنولوجيا للشركات وللمؤسسات
        
                            </p>
         
                        </div>
                    </div>
                    <div class="col-12 col-md-3 dir-cust  mt-4 ">
                        <div class="box-service">
                            <img src="assets/front/icons/wallet-egor.svg" alt="">
                            <h4 style="color: #225476;">حماية الأجور</h4>
                            <p>مختصون في نظام حماية الأجور والذي تم تطبيقه على جميع المنشآت في القطاع الخاص منذ عام 2015 حيث تولت شركة إتمام .
                            </p>
         
                        </div>
                    </div>
                    <div class="col-12 col-md-3 dir-cust  mt-4 ">
                        <div class="box-service">
                            <img src="assets/front/icons/handshake (2).svg" alt="">
                            <h4 style="color: #A159FF;">إستشارات ونصائح
                            </h4>
                            <p>تقدم إتمام استشارات ونصائح على أيدي خبراء في مجال الأعمال و القانون والشؤون المالية وتطوير الشركات وأكثر لتتحرك نحو أهدافك وطموحك</p>
         
                        </div>
                    </div>
                </div>
     </div>
  </div>
  
  </div>

  <!--    introduction area end   -->

  <div class="testimonial-section pb-115" id="whyus">
     <div class="container">
        <div class="row" >

           <div class="col-lg-2">
              <h2 class="section-title keepaway">{{__('Why Etmaam?')}}</h2>
              <p style="color:#93a4af;font-size:16px;">
{{__('When you have all the options available for comparison, you will definitely choose Etmaam because of the excellence of our services and our continued creativity when you choose us; you choose the quality and experience chosen by the largest companies in the Kingdom.')}}
              </p>
           </div>


           <div class="col-lg-10">
               
              <p style="font-size: 14px;color:#93a4af !important; font-weight:400 !important; border-right: 1px solid #f0f0f0; padding: 3%; margin-top: 13px;" class="section-title keepaway">
                  
                  @if ($currentLang->code == "ar")
                  مع ما يشهده عصرنا من تطور في مجال الخدمات والثورة التكنولوجية الحديثة، أصبح وجود خبراء متخصصين ضرورة حتمية لإدراة العلاقات الحكومية من خلال التعامل والتواصل والربط المنظم بين مختلف الإدارات الحكومية، لإنجاز المعاملات وإبرام العقود بشكل سليم ودقيق وبالوقت المحدد، وبعيدا عن الأنماط التقليدية السابقة. هذا ما دفع العديد من الشركات والمؤسسات باتجاه البحث عمن يملكون المعرفة والقدرة المطلوبتين في الإجراءات والأنظمة والقوانين لتحقيق مصالحها مع أغلب المواقع الحكومية التي تحتاجها.  <br>
 لذلك تسعى المنشآت والمؤسسات الصغيرة والمتوسطة للبحث عن تعاقد مع شركات الخبرة       "Outsourcing"  لإدارة عملياتها الحكومية من تراخيص وسجلات وموظفين  للتفرغ لإدارة المشاريع التجارية . <br>
. نحن في إتمام للخدمات ندرك مصالح العملاء وأصحاب الأعمال، ونحرص كل الحرص على تقديم الخدمات المتنوعة والمتميزة ذات الجودة العالية والسرعة المطلوبة والسعر المناسب. يستند كاهل إتمام على فريق متكامل منفرد بخبرة سنواته الطويلة في العلاقات الحكومية.
يسرنا في إتمام للخدمات أن نعرض بعض ما نقدم من خدمات متميزة نعتز بتقديمها لعملائنا ومنها:
<br>
 <span style="color: rgb(35, 85, 119) !important;">●</span> إدارة جميع المواقع الحكومية للمنشآت.
<br>
 <span style="color: rgb(35, 85, 119) !important;">●</span> تأسيس الشركات والمؤسسات. 
<br>
<span style="color: rgb(35, 85, 119) !important;">●</span> الإدارة الكاملة للسجلات والتراخيص.
 <br>
 <span style="color: rgb(35, 85, 119) !important;">●</span> الإدارة الكاملة لمعاملات الموظفين والعمال. 
<br>
<span style="color: rgb(35, 85, 119) !important;">●</span> الدراسة التحليلية وتخفيف الأعباء المالية.
<br>
 <span style="color: rgb(35, 85, 119) !important;">●</span> خدمات التأمين الطبي التعاوني للمنشأة.
<br>
 <span style="color: rgb(35, 85, 119) !important;">●</span> خدمة إدارة الرواتب وحماية الأجور.
<br>
 <span style="color: rgb(35, 85, 119) !important;">●</span> خدمات تأجير العمالة والاستقدام. 
<br>
<span style="color: rgb(35, 85, 119) !important;">●</span> تقديم الاستشارات العمالية والقانونية. 
<br>
<span style="color: rgb(35, 85, 119) !important;">●</span> التدريب والتأهيل في العلاقات الحكومية.
<br>
<span style="color: rgb(35, 85, 119) !important;">●</span> تسجيل العلامات التجارية
<br>
 تواصل معنا، تعاملك وثقتك بإتمام هدفنا لمنحك أفضل الخدمات والاستشارات والحلول والعروض؛ نجاحك نجاحنا.
@else

With the development of our time in the field of services and the modern technological revolution, the presence of specialized experts has become an imperative to manage government relations through dealing, communication and orderly linking between different government departments, to complete transactions and conclude contracts properly, accurately and on time, and away from previous traditional patterns. This has led many companies and institutions to look for those who have the knowledge and capacity required in procedures, regulations and laws to achieve their interests with most of the government sites they need.
Therefore, SmEs are therefore seeking a contract with outsourcing companies to manage their government operations of licenses, records and full-time employees to manage businesses.
We at Etmaam Services are aware of the interests of clients and business owners, and we are very keen to provide various and distinguished services of high quality, speed and appropriate price. Etmaam is based on a single integrated team with many years of experience in government relations. We are pleased at Etmaam Services to present some of the distinguished services that we are proud to provide to our clients, including:

<br>
 <span style="color: rgb(35, 85, 119) !important;">●</span> 
Management of all government sites for facilities.<br>
 <span style="color: rgb(35, 85, 119) !important;">●</span>
Establishment of companies and institutions.
<br>
<span style="color: rgb(35, 85, 119) !important;">●</span>
Full management of records and licenses.
<br>
 <span style="color: rgb(35, 85, 119) !important;">●</span> 
Full management of employee and worker transactions.
<br>
<span style="color: rgb(35, 85, 119) !important;">●</span> 
Analytical study and alleviation of financial burdens.
<br>
 <span style="color: rgb(35, 85, 119) !important;">●</span> 
Cooperative medical insurance services for the facility.
<br>
 <span style="color: rgb(35, 85, 119) !important;">●</span> 
Payroll administration and wage protection service.
<br>
 <span style="color: rgb(35, 85, 119) !important;">●</span>
Labor rental and recruitment services.
<br>
<span style="color: rgb(35, 85, 119) !important;">●</span>
Providing labor and legal advice.
<br>
<span style="color: rgb(35, 85, 119) !important;">●</span> 
Training and qualification in government relations.
<br>
<span style="color: rgb(35, 85, 119) !important;">●</span>
Trademark Registration
<br>
Contact us, your deal and your trust in Etmaam is our goal to give you the best services, consultations, solutions and offers;
@endif
</p>
           </div>


</div>

</div>

</div>


    <!--our sloutions-->


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
