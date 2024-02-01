@extends("front.$version.layout")

@section('pagename')
- {{__('Packages')}}
@endsection

@section('meta-keywords', "$be->packages_meta_keywords")
@section('meta-description', "$be->packages_meta_description")


@section('breadcrumb-title', $be->pricing_title)
@section('breadcrumb-subtitle', $be->pricing_subtitle)
@section('breadcrumb-link', __('Packages'))


@section('content')



<style>
    #package_2 .single-pricing-table .price h1{
        color:#225476 !important;
    }
</style>


            <!--// package bundels , wps-->
            <section class="packages-section">
                <div class="container">
                    <div class="row text-center">
                        <div class="col-lg-12 px-0">
                            <div class="tab-back">
                                <ul class="nav nav-tabs ul-tab" id="myTab" role="tablist">
                                    @foreach($sections as $section)
                                        <li class="nav-item li-tab" role="presentation">
                                            <a data-toggle="tab" aria-controls="home" class="nav-link @if($loop->first) active @endif" id="package-{{$section->id}}-tab" href="#package_{{$section->id}}" role="tab_{{$section->id}}" aria-selected="true">
                                                {{$section->name}}
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-12 px-0">
                            <h5 class="mt-4 mb-3 sub-header">
                                {{__('app.desc_pack')}}
                            </h5>
                            <button type="button" class="btn btn-cal" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-calculator mr-2 ml-2"></i>
                                                            {{__('app.countyourpack')}}

                            </button>
                            <div class="modal fade bd-example-modal-lg modal_shown" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-calculator mr-2 ml-2"></i>
                                            {{__('app.countyourpack')}}
                                            </h5>
                                            <button type="button" class="close m-0 p-0 close-modal" data-dismiss="modal" aria-label="{{__('app.close')}}">
                                                <span class="close-modal">x</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <!--start our code clac-->
                                            <div class="row" id="app">
                                                <div class="col-12 col-md-5">
                                                    <form id="myform" class="row" action="">
                                                        <div class="col-12">

                                                            <div class="form-element mb-3 hide-package-modal" style="">
                                                                <label>  {{__('app.staffnum')}}</label>

                                                                <input  style=" height: 38px; border-radius: 4px !important;"  name="staffnum" v-on:input="calculatePrice()" type="number" min="0" max="99999" required="" class="form-control onlyNumbers" step="any" v-model="num_of_employees" placeholder="0" id="texur">

                                                            </div>

                                                            <div class="form-element   mb-0">
                                                                <label style="text-align: start;">{{__('app.typepack')}}</label>
                                                                <select v-on:change="calculatePrice()" name="packtype" v-model="pack" class="form-control">
                                                                    <option value="" disabled>
                                                                {{__('app.chosetypepack')}}
                                                                    </option>

                                                                    <option value="silver">
                                                                {{__('app.silver')}}
                                                                    </option>

                                                                    <option value="gold">
                                                                {{__('app.gold')}}
                                                                    </option>
                                                                    <option value="platinum">
                                                                {{__('app.plat')}}
                                                                    </option>
                                                                    <!--<option value="plat">-->
                                                                    <!--    البلاتينية-->
                                                                    <!--</option>-->
                                                                </select>


                                                            </div>

                                                            <div class="form-element mb-1 mt-3 calc_subscribe_wage_protection hide-package-modal">
                                                                <label class="mb-0">
                                                        {{__('app.wantwps')}}
                                                                </label>
                                                                <div class="">

                                                                    <select name="wps" v-on:change="calculatePrice()" v-model="save_salary" class="form-control" :disabled="!selectData">
                                                                        <option value="true">
                                                        {{__('app.yes')}}
                                                                        </option>
                                                                        <option value="false">
                                                        {{__('app.no')}}
                                                                        </option>
                                                                    </select>


                                                                </div>
                                                            </div>




                                                            <!--<div class="form-element mb-1 hide-package-modal" style="">-->
                                                            <!--  <label>  {{__('app.staffnum')}} الإضافيين المتوقعين</label>-->

                                                            <!--                   <input name="staffthink" type="number" min="0" max="90" class="form-control onlyNumbers" v-model="future_employees" placeholder="">-->

                                                            <!--</div>-->




                                                            <div class="form-element mb-3 hide-package-modal" style="">
                                                                <label>  {{__('app.years')}}</label>

                                                                <input style="background: #dddddd; height: 38px; border-radius: 4px !important;" name="years" type="number" disabled="disabled" min="0" max="5" class="form-control onlyNumbers" v-model="period" placeholder="">

                                                            </div>



                                                            <!--<button type="button" class="btn btn-cal-inside" id="calculatePackage">-->
                                                            <!--<i class="fas fa-calculator mr-2 ml-2"></i>احسب قيمة اشتراكك </button>-->
                                                            <button  @click="resetInput" type="button" class="btn btn-cal-inside rest-btn bas disabled" disabled>
                                                                <i class="fas fa-redo"></i> {{__('app.rest')}}
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <div class="box-price mt-3">
                                                        <div class="mb-3">
                                                            <div class="price">
                                                                {{__('app.costwillbe')}}
                                                            </div>
                                                            <div class="price-nu">
          <span id="calc_half_year_value">

                            <p name="price" id="price" v-if="num_of_employees <= 100" ><?php echo "{{cost}}";?> 
                            {{__('app.riyal')}}
                                  <span class="durations">/ {{__('app.yearly')}} <small>(شامل الضريبة)</small></span>
                            </p>

                    <input id="sal1" name="sal1" style="display:none">
                <p style="font-size: 16px; color: red; font-weight: bold;" v-if="num_of_employees > 100">
{{__('app.stafflargerthan100')}}                    </p>

          </span>
                                                            </div>
                                                        </div>
                                                        <div>

                                                        </div>
                                                    </div>
                                                    <p class="my-3 text-center" id="noteText">
      <span style="text-decoration: underline; font-weight: bold;">
        <a href="/faq#category21" target="_blank">{{__('app.countroles')}}</a>
      </span>
                                                    </p>
                                                </div>
                                            </div>


                                            <script src="/assets/front/js/axios.min.js"></script>
                                            <script src="/assets/front/js/vue.js"></script>

                            <script type="application/javascript">
                                var app = new Vue({
                                    el: '#app',
                                    data: {
                                        info: [],
                                        pack: null,
                                        cost: 0,
                                        num_of_employees: 0,
                                        future_employees: 0,
                                        fcost: 0,
                                        period: 1,
                                        save_salary: false,
                                        vartxt: 99,
                                        selectData: 1
                                    },
                                    methods: {
                                        packtypeOnChange(event) {
                                            console.log(event.target.value);
                                            this.calculatePrice();
                                        },
                                        salaryOnChange(event) {
                                            console.log(event.target.value);
                                            this.calculatePrice();
                                        },
                                        resetInput() {
                                            this.cost = "0";
                                            this.pack = "";
                                            this.num_of_employees = "";
                                            this.save_salary = "false";
                                        },
                                        calculatePrice() {
                                            if (this.pack == 'silver') {
                                                this.cost = 7500 * this.period;
                                                if (this.num_of_employees > 4) {
                                                    this.cost += (this.num_of_employees - 4) * 500 * this.period;
                                                }
                                                if (this.save_salary == 'true') {
                                                    this.cost += 3000 * this.period;
                                                }
                                                this.cost = this.cost / 100 * 115;
                                            } else if (this.pack == 'gold') {
                                                this.cost = 13500 * this.period;
                                                if (this.num_of_employees > 9) {
                                                    this.cost += (this.num_of_employees - 9) * 750 * this.period;
                                                }
                                                this.save_salary = 'true';
                                                this.cost = this.cost / 100 * 115;
                                            } else if (this.pack == 'platinum') {
                                                this.save_salary = 'true';
                                                this.cost = 20000 * this.period;
                                                if (this.num_of_employees > 9) {
                                                    this.cost += (this.num_of_employees - 9) * 1000 * this.period;
                                                }
                                                this.cost = this.cost / 100 * 115;
                                            } else {
                                                this.cost = 0;
                                            }
                            
                                            if (this.num_of_employees < 1) {
                                                this.cost = "0";
                                            }
                            
                                            if (this.pack != 'silver') {
                                                this.selectData = 0;
                                            } else {
                                                this.selectData = 1;
                                            }
                            
                                            document.getElementById('sal1').value = this.cost;
                                            document.getElementById('salview').innerHTML = this.cost;
                                            document.getElementById('packtype').innerHTML = this.pack;
                                            document.getElementById('packtype10').innerHTML = document.getElementById('packtype').innerHTML;
                                            document.getElementById('numemp').innerHTML = this.num_of_employees;
                                            document.getElementById('numemp0').innerHTML = document.getElementById('numemp').innerHTML;
                                            document.getElementById('wps').innerHTML = this.save_salary;
                                            document.getElementById('wps0').innerHTML = document.getElementById('wps').innerHTML;
                                            document.getElementById('numthink').innerHTML = this.future_employees;
                                            document.getElementById('numthink0').innerHTML = document.getElementById('numthink').innerHTML;
                                            document.getElementById('yearshow').innerHTML = this.period;
                                            document.getElementById('yearshow0').innerHTML = document.getElementById('yearshow').innerHTML;
                                            document.getElementById('costforfuture').innerHTML = this.fcost;
                                        },
                                        copyText: function(text_name, message) {
                                            let testingCodeToCopy = document.querySelector('#' + text_name);
                                            let msg_item = document.getElementById(message);
                                            testingCodeToCopy.setAttribute('type', 'text');
                                            testingCodeToCopy.select();
                            
                                            try {
                                                var successful = document.execCommand('copy');
                                                var msg = successful ? 'Copied!' : 'Failed!';
                                                msg_item.innerHTML = msg;
                                            } catch (err) {
                                                msg_item.innerHTML = msg;
                                            }
                            
                                            testingCodeToCopy.setAttribute('type', 'hidden');
                                            window.getSelection().removeAllRanges();
                                        },
                                    },
                                    mounted() {
                                    }
                                });
                            
                                $("#texur").keypress(function() {
                                    if ($(this).val().length > 0) {
                                        $("#texur").css("border", "1px solid #666666");
                                        $('.bas').removeAttr('disabled');
                                        $('.bas').removeClass('disabled');
                                    }
                                });
                            </script>


                                            <!--end our code clac-->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="tab-content" id="myTabContent" style="width: 100%;">
                            @foreach($sections as $section)
                                <div role="tabpanel" aria-labelledby="package-#{{$section->id}}-tab" style="width: 100%;" class="tab-pane fade @if($loop->first) active @endif show" id="package_{{$section->id}}">
                                    <div class="row">
                                        <!--/packages/-->

                                        @foreach ($section->packages as $key => $package)
                                            @if($section->id == 2 || $section->id == 5)
                                                <div class="col-12 col-md-3 package-section" style="padding:0;">
                                            @else
                                                <div class="col-12 col-md-4 package-section">
                                            @endif
                                                <div class="single-pricing-table">
                                                <span class="title">
                                         {{convertUtf8($package->title)}}
                                                </span>
                                                    <div class="price">
                                                    <span class="start">
                                                    {{__('app.startform')}}
                                                    </span>
                                                        <h1>
                                                            <!--{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}-->
                                                            {{$package->price}}
                                                            <!--{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}-->
                                                        </h1>

                                                        <span class="started">
                                                            {{__('Riyal/Yearly')}}
                                                        </span>
                                                    </div>
                                                    @if($section->id == 2 || $section->id == 5)
                                                        <div class="employee">
                                                            <i class="fas fa-users"></i>
                                                            {{$package->staffnum}}
                                                        </div>
                                                    @endif
                                                    <a href="{{route('front.package_quote',$package->id)}}" class="pricing-btn">
                                                    {{__('app.requestque')}}
                                                        </a>
                                                    <div class="features">

                                                        @if(!is_null($package->services))
                                                            @foreach($cats->whereIn('id', explode(',',$package->services)) as $cat)
                                                                <div class="accordion" id="accordion{{$package->id}}-{{$cat->id}}">
                                                                    <div class="card mb-30">
                                                                        <a class="collapsed card-header" href="#" data-toggle="collapse" aria-expanded="false" id="heading{{$package->id}}-{{$cat->id}}" data-target="#collapse{{$package->id}}-{{$cat->id}}" aria-controls="collapse{{$package->id}}-{{$cat->id}}">
                                                                            <span class="toggle_btn"></span>
                                                                            <p class="feature-line-title">
                                                                                <i class="fas fa-check ch-checked"></i>
                                                                                {{$cat->name}}
                                                                            </p>
                                                                        </a>
                                                                        <div class="collapse" id="collapse{{$package->id}}-{{$cat->id}}" aria-labelledby="heading{{$package->id}}-{{$cat->id}}" data-parent="#accordion{{$package->id}}-{{$cat->id}}">
                                                                            <div class="card-body">
                                                                                <div class="pack-des">
                                                                                    @foreach($cat->package_services as $service)
                                                                                        <?php //echo ($service->id); ?>
                                                                                        @if(in_array($service->id,explode(',',$package->services_included)))
                                                                                            <p>{{$service->name}}</p>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>


                                            </div>


                                        @endforeach

                                    </div>
                                </div>

                            @endforeach
                        </div>
                    </div>
                </div>
            </section>



      <!--    faq area start   -->
    <div class="container">

                      <div class="row px-0 keepaway">
                    <div class="col-8">
                <h2 class="section-title">
                    {{__('How can we help?')}}
                    </h2>
                    </div>

                    <div class="col-4  " style="text-align: left;"> <a href="/faqs" class=" readmore_link m-1" style="top: 25px;color: #235577;
    font-weight: 600;">{{__('All Questions')}} <i class="fas fa-angle-double-left"></i></a>
                    </div>
                </div>


                    <div class="col-lg-12">
                <div class="faq-section py-0">
                    <div class="row">
                        <div class="col-lg-6">
                           <div class="accordion" id="accordionExample1">
                              @for ($i=0; $i < ceil(count($faqs)/2); $i++)
                              <div class="card">
                                 <div class="card-header" id="heading{{$faqs[$i]->id}}">
                                    <h2 class="mb-0">
                                       <button class="btn btn-link collapsed btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{$faqs[$i]->id}}" aria-expanded="false" aria-controls="collapse{{$faqs[$i]->id}}">
                                       {{convertUtf8($faqs[$i]->question)}}
                                       </button>
                                    </h2>
                                 </div>
                                 <div id="collapse{{$faqs[$i]->id}}" class="collapse" aria-labelledby="heading{{$faqs[$i]->id}}" data-parent="#accordionExample1">
                                    <div class="card-body">
                                       {{convertUtf8($faqs[$i]->answer)}}
                                    </div>
                                 </div>
                              </div>
                              @endfor
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="accordion" id="accordionExample2">
                              @for ($i=ceil(count($faqs)/2); $i < count($faqs); $i++)
                              <div class="card">
                                 <div class="card-header" id="heading{{$faqs[$i]->id}}">
                                    <h2 class="mb-0">
                                       <button class="btn btn-link collapsed btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{$faqs[$i]->id}}" aria-expanded="false" aria-controls="collapse{{$faqs[$i]->id}}">
                                       {{convertUtf8($faqs[$i]->question)}}
                                       </button>
                                    </h2>
                                 </div>
                                 <div id="collapse{{$faqs[$i]->id}}" class="collapse" aria-labelledby="heading{{$faqs[$i]->id}}" data-parent="#accordionExample2">
                                    <div class="card-body">
                                       {{convertUtf8($faqs[$i]->answer)}}
                                    </div>
                                 </div>
                              </div>
                              @endfor
                           </div>
                        </div>
                     </div>
                </div>
            </div>

    </div>

      <!--    faq area end   -->




@endsection




@section('scripts')
<script>

    $(document).on('click', '#calculatePackage', function() {
        var year_value = 0
        var half_year_value = 0
        var selected_package = $('#select-package').find('option:selected');
        if (selected_package.data('category') != 0) {
            if ((!selected_package.data('is_fixed_employees')) && (parseInt($('#standard_employees').val()) < parseInt(selected_package.data('standard_employees')))) {
                $('#standard_employees').val(selected_package.data('standard_employees'))
            }
            if (selected_package.data('price')) {
                year_value += parseInt(selected_package.data('price'))
            }
            if (!selected_package.data('is_fixed_employees')) {
                year_value += (parseInt($('#standard_employees').val()) - parseInt(selected_package.data('standard_employees'))) * parseInt(selected_package.data('employee_price'));
            }
            if (selected_package.data('wage_protection_price')) {
                $('.radio_wage_protection').each(function(index, element) {
                    if ($(element).is(':checked')) {
                        if ($(element).val() === 'yes') {
                            year_value += parseInt(selected_package.data('wage_protection_price'))
                        }
                    }
                })
            }
            $('#calc_year_value').text(year_value)
            $('#calc_half_year_value').text(year_value / 2)
        }
    });
  $('#masonry-package').imagesLoaded( function() {
    // items on button click
    $('.filter-btn').on('click', 'li', function () {
      var filterValue = $(this).attr('data-filter');
      $grid.isotope({
        filter: filterValue
      });
    });
    // menu active class
    $('.filter-btn li').on('click', function (e) {
      $(this).siblings('.active').removeClass('active');
      $(this).addClass('active');
      e.preventDefault();
    });
    var $grid = $('.masonry-row').isotope({
      itemSelector: '.package-column',
      percentPosition: true,
      masonry: {
        columnWidth: 0
      }
    });
  });
</script>
@endsection
