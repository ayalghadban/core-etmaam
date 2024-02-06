@extends("front.$version.layout")

@section('pagename')
    - {{ __('app.tools') }}
@endsection

@section('meta-keywords', "$be->packages_meta_keywords")
@section('meta-description', "$be->packages_meta_description")


@section('breadcrumb-title', __('app.tools'))
@section('breadcrumb-subtitle', $be->pricing_subtitle)
@section('breadcrumb-link', __('app.tools'))


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
        </div>

    </div>
    <div class="container">
        <div class="row ">

            <div class="col-12 col-md-4  mt-4 ">
                <div class="box-bank">
                    <p class="bank-p">{{ __('app.quiwa') }}</p>
                    <label class="bank-label" for="">

                    </label>

                    <a href="https://www.qiwa.sa/ar/tools-and-calculators/end-of-service-reward-calculator" class="readmore-btn"><span>{{ __('app.clickhere') }}</span></a>
                </div>
            </div>

            <div class="col-12 col-md-4  mt-4 ">
                <div class="box-bank">
                    <p class="bank-p">{{ __('app.calc') }}</p>
                    <label class="bank-label" for="">

                    </label>

                    <a href="https://portaleservices.moj.gov.sa/LaborCalculator/LaborCalculator.aspx" class="readmore-btn"><span>{{ __('app.clickhere') }}</span></a>
                </div>
            </div>

        </div>

    </div>

@endsection
