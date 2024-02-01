@extends("front.$version.layout")

@section('pagename')
- {{__('banks')}}
@endsection

@section('meta-keywords', "$be->packages_meta_keywords")
@section('meta-description', "$be->packages_meta_description")


@section('breadcrumb-title', __('banks'))
@section('breadcrumb-subtitle', $be->pricing_subtitle)
@section('breadcrumb-link', __('banks'))


@section('content')
<div class="container">
        <div class="row ">
            <div class="col-12 col-md-4  mt-4 ">
                <div class="box-bank">
                    <img class="bank-img" src="https://etmaam.com.sa/assets/lfm/files/1/rajhi.jpg" alt="">
                    <!--<h4> مصرف الراجحي</h4>-->
                    <label class="bank-label" for=""> 
{{__('Account Number')}}                    
                    </label>
                    <p class="bank-p">306608018333220</p>
                    <label class="bank-label" for=""> 
{{__('International Account Number (IBAN)')}}                    
                    </label>
                    <p class="bank-p">SA1880000306608018333220</p>
                    <label class="bank-label" for=""> 
{{__('Account owner :')}}                    
                    </label>
                    <p class="bank-p"> {{__('Etmaam Alinjaz For Business Services Company')}} </p>
                </div>
            </div>
            
            <div class="col-12 col-md-4  mt-4 ">
                <div class="box-bank">
                    <img class="bank-img" src="https://etmaam.com.sa/assets/lfm/files/1/ahla.jpg" alt="">
                    <!--<h4>البنك الأهلي </h4>-->
                    <label class="bank-label" for="">  {{__('Account Number')}}         </label>
                    <p class="bank-p">58300000037001</p>
                    <label class="bank-label" for="">  {{__('International Account Number (IBAN)')}}   </label>
                    <p class="bank-p">SA7110000058300000037001</p>
                    <label class="bank-label" for="">  {{__('Account owner :')}}                                         </label>
                    <p class="bank-p"> {{__('Etmaam Alinjaz For Business Services Company')}} </p>
                </div>
            </div>
            <div class="col-12 col-md-4  mt-4 ">
                <div class="box-bank">
                    <img class="bank-img" src="https://etmaam.com.sa/assets/lfm/files/1/baled.png" alt="">
                    <!--<h4> بنك البلاد </h4>-->
                    <label class="bank-label" for="">  {{__('Account Number')}}         </label>
                    <p class="bank-p">926130350160005</p>
                    <label class="bank-label" for="">  {{__('International Account Number (IBAN)')}}   </label>
                    <p class="bank-p">SA6615000926130350160005</p>
                    <label class="bank-label" for="">  {{__('Account owner :')}}                                         </label>
                    <p class="bank-p"> {{__('Etmaam Alinjaz For Business Services Company')}} </p>
                </div>
            </div>
            

            <div class="col-12 col-md-4  mt-4 ">
                <div class="box-bank">
                    <img class="bank-img" src="https://etmaam.com.sa/assets/lfm/files/1/alinma.jpg" alt="">
                    <!--<h4>بنك الأنماء</h4>-->
                    <label class="bank-label" for="">  {{__('Account Number')}}         </label>
                    <p class="bank-p">68202504273000</p>
                    <label class="bank-label" for="">  {{__('International Account Number (IBAN)')}}   </label>
                    <p class="bank-p">SA6305000068202504273000</p>
                    <label class="bank-label" for="">  {{__('Account owner :')}}                                         </label>
                    <p class="bank-p"> {{__('Etmaam Alinjaz For Business Services Company')}} </p>
                </div>
            </div>
            <div class="col-12 col-md-4  mt-4 ">
                <div class="box-bank">
                    <img class="bank-img" src="https://etmaam.com.sa/assets/lfm/files/1/alriyadh.jpg" alt="">
                    <!--<h4>بنك الرياض </h4>-->
                    <label class="bank-label" for="">  {{__('Account Number')}}         </label>
                    <p class="bank-p">3373012079940</p>
                    <label class="bank-label" for="">  {{__('International Account Number (IBAN)')}}   </label>
                    <p class="bank-p">SA3120000003373012079940</p>
                    <label class="bank-label" for="">  {{__('Account owner :')}}                                         </label>
                    <p class="bank-p"> {{__('Etmaam Alinjaz For Business Services Company')}} </p>
                </div>
            </div>


        </div>
        
    </div>
    
    @endsection




