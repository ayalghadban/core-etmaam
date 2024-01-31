@extends('front.default.layout')

@section('pagename')
 -
 @if (empty($category))
 {{__('All')}}
 @else
 {{$category->name}}
 @endif
 {{__('cataloge')}}
@endsection

@section('meta-keywords', "$be->services_meta_keywords")
@section('meta-description', "$be->services_meta_description")

@section('content')

@section('breadcrumb-title', convertUtf8($bs->service_title))
@section('breadcrumb-subtitle', convertUtf8($bs->service_subtitle))
@section('breadcrumb-link', convertUtf8($bs->service_title))




<div class="container keepaway">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col-lg-4 col-md-6">
                <div class="shop-search mt-30">
                    <input type="text" placeholder="ابحث باسم الخدمة" class="input-search" name="search" value="">
                    <i class="fas fa-search input-search-btn cursor-pointer"></i>
                </div>
            </div>
            
        </div>
        <div class="row justify-content-center">
          <div class="col-12 tabs-services-box">
              <div class="tabs-services "> الكل</div>
              <div class="tabs-services active"> خدمات المستثمرين 
            </div>

              <div class="tabs-services"> خدمات المنشآت  </div>

              <div class="tabs-services">  الزكاة والضريبة  </div>
              <div class="tabs-services">  الخدمات القانونية  </div>

              
              <div class="tabs-services"> الاستشارات  </div>
              <div class="tabs-services"> الخدمات المساندة  </div>


          </div>
          <div class="col-12 serv-link">
            عند تسجيل دخولك إلى منصة إتمام للخدمات بإمكانك إضافة خدماتك الإلكترونية المفضلة وإزالتها والتحكم بها <a href=""> من هنا</a>
          </div>

          <!-- start modal section -->
          <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
       
                <div class="modal-content">
                    <div class="modal-header modal-website">
                      <button type="button" class="close close-modal-website" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body modal-website-body">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <img class="serv-logo" src="assets/front/img/services/Layer_x0020_1.svg" alt="">

                            <h5 class="ser-tit">تجديد السجل تجاري</h5>
                            <p class="cat-tit">  خدمات الشركات</p>
                                <div class="custom-market-line-button">
                                    <button class="w-100"><i class="far fa-hand-pointer ml-2"></i>   اطلب الخدمة</button>
                                </div>
                            

                        </div>
                        <div class="col-12 col-md-8">
                            <div class="row">
                                <div class="col-12 mt-2 ser-des ">
                                    خدمة إلكترونية تقدمها وزارة التجارة تمكن المستفيد من طلب إصدار سجل تجاري والموافقة عليه، والحصول على رقم عضوية بالغرفة التجارية، ودون الحاجة إلى مراجعة فروع الوزار    
                                </div>

                                <div class="col-12 mt-3 mb-2">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-money-bill-alt"></i>تكلفة الخدمة </span>
                                            <span class="details-span">150 ريال </span>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-clock"></i>مدة التنفيذ</span>
                                            <span class="details-span">24 ساعة </span>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <span class="details-span-tit mt-2"><i class="far fa-money-bill-alt"></i>الملفات المطلوية </span>
                                            <ul class="details-span-ul"> 
                                                <li>    الهوية الوطنية </li>
                                                <li>    اسم السجل التجاري </li>
                                                <li>    شعار الشركة </li>
                                        </ul>
                                        </div>
                                         
                                        <div class="col-12">
                                            <span class="details-span-tit mt-2"><i class="far fa-money-bill-alt"></i>الشروط  </span>
                                            <ul class="details-span-ul"> 
                                                <li> ألا يكون مقدم الطلب موظفا حكوميا، او احد الشركاء</li>
                                                <li>  أن يكون عمر مقدم الطلب والشركاء أكبر من 18 عاما</li>
                                                <li>   ن يكون لدى مقدم الطلب والشركاء حسب فعال على ابشر. (يمكنك طلب التسجيل في ابشر من هنا).</li>
                                                 </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                        
                    </div>
                    </div>
              </div>
            </div>
          </div>

          
                    <!-- end modal section -->


          <div class="col-12">
              <div class="row">
                  <div class="col-md-4  col-12 mb-3">
                    <div class=" serv-box">
                        <div class="row">
                      
                            <div class="col-5">
                                <img class="serv-logo" src="assets/front/img/services/Layer_x0020_1.svg" alt="">
                          
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="custom-market-line-button p-0 ">
                                                <button class="w-100 but-deatils " data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-question"></i>    تفاصل الخدمة</button>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5 class="ser-tit">تجديد السجل تجاري</h5>
                                    <p class="cat-tit">  خدمات الشركات</p>

                                </div>
                        
                                <div class="col-12 mt-3 mb-2">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-money-bill-alt"></i>تكلفة الخدمة </span>
                                            <span class="details-span">150 ريال </span>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-clock"></i>مدة التنفيذ</span>
                                            <span class="details-span">24 ساعة </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="custom-market-line-button">
                                        <button class="w-100"><i class="far fa-hand-pointer ml-2"></i>   اطلب الخدمة</button>
                                    </div>
                                </div>
                        
    
                        </div>
                    </div>
                  </div>
                  <div class="col-md-4  col-12 mb-3">
                    <div class=" serv-box">
                        <div class="row">
                      
                            <div class="col-5">
                                <img class="serv-logo" src="assets/front/img/services/Layer_x0020_1.svg" alt="">
                          
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="custom-market-line-button p-0 ">
                                                <button class="w-100 but-deatils " data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-question"></i>    تفاصل الخدمة</button>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5 class="ser-tit">تجديد السجل تجاري</h5>
                                    <p class="cat-tit">  خدمات الشركات</p>

                                </div>
                        
                                <div class="col-12 mt-3 mb-2">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-money-bill-alt"></i>تكلفة الخدمة </span>
                                            <span class="details-span">150 ريال </span>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-clock"></i>مدة التنفيذ</span>
                                            <span class="details-span">24 ساعة </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="custom-market-line-button">
                                        <button class="w-100"><i class="far fa-hand-pointer ml-2"></i>   اطلب الخدمة</button>
                                    </div>
                                </div>
                        
    
                        </div>
                    </div>
                  </div>
                  <div class="col-md-4  col-12 mb-3">
                    <div class=" serv-box">
                        <div class="row">
                      
                            <div class="col-5">
                                <img class="serv-logo" src="assets/front/img/services/Layer_x0020_1.svg" alt="">
                          
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="custom-market-line-button p-0 ">
                                                <button class="w-100 but-deatils " data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-question"></i>    تفاصل الخدمة</button>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5 class="ser-tit">تجديد السجل تجاري</h5>
                                    <p class="cat-tit">  خدمات الشركات</p>

                                </div>
                        
                                <div class="col-12 mt-3 mb-2">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-money-bill-alt"></i>تكلفة الخدمة </span>
                                            <span class="details-span">150 ريال </span>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-clock"></i>مدة التنفيذ</span>
                                            <span class="details-span">24 ساعة </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="custom-market-line-button">
                                        <button class="w-100"><i class="far fa-hand-pointer ml-2"></i>   اطلب الخدمة</button>
                                    </div>
                                </div>
                        
    
                        </div>
                    </div>
                  </div>
                  <div class="col-md-4  col-12 mb-3">
                    <div class=" serv-box">
                        <div class="row">
                      
                            <div class="col-5">
                                <img class="serv-logo" src="assets/front/img/services/Layer_x0020_1.svg" alt="">
                          
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="custom-market-line-button p-0 ">
                                                <button class="w-100 but-deatils " data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-question"></i>    تفاصل الخدمة</button>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5 class="ser-tit">تجديد السجل تجاري</h5>
                                    <p class="cat-tit">  خدمات الشركات</p>

                                </div>
                        
                                <div class="col-12 mt-3 mb-2">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-money-bill-alt"></i>تكلفة الخدمة </span>
                                            <span class="details-span">150 ريال </span>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-clock"></i>مدة التنفيذ</span>
                                            <span class="details-span">24 ساعة </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="custom-market-line-button">
                                        <button class="w-100"><i class="far fa-hand-pointer ml-2"></i>   اطلب الخدمة</button>
                                    </div>
                                </div>
                        
    
                        </div>
                    </div>
                  </div>
                  <div class="col-md-4  col-12 mb-3">
                    <div class=" serv-box">
                        <div class="row">
                      
                            <div class="col-5">
                                <img class="serv-logo" src="assets/front/img/services/Layer_x0020_1.svg" alt="">
                          
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="custom-market-line-button p-0 ">
                                                <button class="w-100 but-deatils " data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-question"></i>    تفاصل الخدمة</button>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5 class="ser-tit">تجديد السجل تجاري</h5>
                                    <p class="cat-tit">  خدمات الشركات</p>

                                </div>
                        
                                <div class="col-12 mt-3 mb-2">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-money-bill-alt"></i>تكلفة الخدمة </span>
                                            <span class="details-span">150 ريال </span>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-clock"></i>مدة التنفيذ</span>
                                            <span class="details-span">24 ساعة </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="custom-market-line-button">
                                        <button class="w-100"><i class="far fa-hand-pointer ml-2"></i>   اطلب الخدمة</button>
                                    </div>
                                </div>
                        
    
                        </div>
                    </div>
                  </div>
                  <div class="col-md-4  col-12 mb-3">
                    <div class=" serv-box">
                        <div class="row">
                      
                            <div class="col-5">
                                <img class="serv-logo" src="assets/front/img/services/Layer_x0020_1.svg" alt="">
                          
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="custom-market-line-button p-0 ">
                                                <button class="w-100 but-deatils " data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-question"></i>    تفاصل الخدمة</button>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5 class="ser-tit">تجديد السجل تجاري</h5>
                                    <p class="cat-tit">  خدمات الشركات</p>

                                </div>
                        
                                <div class="col-12 mt-3 mb-2">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-money-bill-alt"></i>تكلفة الخدمة </span>
                                            <span class="details-span">150 ريال </span>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-clock"></i>مدة التنفيذ</span>
                                            <span class="details-span">24 ساعة </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="custom-market-line-button">
                                        <button class="w-100"><i class="far fa-hand-pointer ml-2"></i>   اطلب الخدمة</button>
                                    </div>
                                </div>
                        
    
                        </div>
                    </div>
                  </div>
                  <div class="col-md-4  col-12 mb-3">
                    <div class=" serv-box">
                        <div class="row">
                      
                            <div class="col-5">
                                <img class="serv-logo" src="assets/front/img/services/Layer_x0020_1.svg" alt="">
                          
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="custom-market-line-button p-0 ">
                                                <button class="w-100 but-deatils " data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-question"></i>    تفاصل الخدمة</button>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5 class="ser-tit">تجديد السجل تجاري</h5>
                                    <p class="cat-tit">  خدمات الشركات</p>

                                </div>
                        
                                <div class="col-12 mt-3 mb-2">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-money-bill-alt"></i>تكلفة الخدمة </span>
                                            <span class="details-span">150 ريال </span>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-clock"></i>مدة التنفيذ</span>
                                            <span class="details-span">24 ساعة </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="custom-market-line-button">
                                        <button class="w-100"><i class="far fa-hand-pointer ml-2"></i>   اطلب الخدمة</button>
                                    </div>
                                </div>
                        
    
                        </div>
                    </div>
                  </div>
                  <div class="col-md-4  col-12 mb-3">
                    <div class=" serv-box">
                        <div class="row">
                      
                            <div class="col-5">
                                <img class="serv-logo" src="assets/front/img/services/Layer_x0020_1.svg" alt="">
                          
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="custom-market-line-button p-0 ">
                                                <button class="w-100 but-deatils " data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-question"></i>    تفاصل الخدمة</button>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5 class="ser-tit">تجديد السجل تجاري</h5>
                                    <p class="cat-tit">  خدمات الشركات</p>

                                </div>
                        
                                <div class="col-12 mt-3 mb-2">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-money-bill-alt"></i>تكلفة الخدمة </span>
                                            <span class="details-span">150 ريال </span>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-clock"></i>مدة التنفيذ</span>
                                            <span class="details-span">24 ساعة </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="custom-market-line-button">
                                        <button class="w-100"><i class="far fa-hand-pointer ml-2"></i>   اطلب الخدمة</button>
                                    </div>
                                </div>
                        
    
                        </div>
                    </div>
                  </div>  <div class="col-md-4  col-12 mb-3">
                    <div class=" serv-box">
                        <div class="row">
                      
                            <div class="col-5">
                                <img class="serv-logo" src="assets/front/img/services/Layer_x0020_1.svg" alt="">
                          
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="custom-market-line-button p-0 ">
                                                <button class="w-100 but-deatils " data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-question"></i>    تفاصل الخدمة</button>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5 class="ser-tit">تجديد السجل تجاري</h5>
                                    <p class="cat-tit">  خدمات الشركات</p>

                                </div>
                        
                                <div class="col-12 mt-3 mb-2">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-money-bill-alt"></i>تكلفة الخدمة </span>
                                            <span class="details-span">150 ريال </span>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <span class="details-span-tit"><i class="far fa-clock"></i>مدة التنفيذ</span>
                                            <span class="details-span">24 ساعة </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="custom-market-line-button">
                                        <button class="w-100"><i class="far fa-hand-pointer ml-2"></i>   اطلب الخدمة</button>
                                    </div>
                                </div>
                        
    
                        </div>
                    </div>
                  </div>

                  
              </div>
          </div>
          
        </div>
   
</div>

  <!--    services section end   -->
@endsection
