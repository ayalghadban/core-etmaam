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
@section('breadcrumb-link', __('Cataloge'))



                <div class="featured-arrows"></div>
                <div class="tab-content">
                    <div id="cat1" class="tab-pane active">
                        <div class="featured-slide">
                            
                            @foreach ($fproducts as $product)
                                <div class="shop-item">
                                    <a class="shop-img" href="{{route('front.product.details',$product->slug)}}">
                                        <img class="lazy" data-src="{{asset('assets/front/img/product/featured/'.$product->feature_image)}}" alt="">
                                    </a>
                                    <div class="shop-info">
                                        @if ($bex->product_rating_system == 1 && $bex->catalog_mode == 0)
                                        <div class="rate">
                                            <div class="rating" style="width:{{$product->rating * 20}}%"></div>
                                        </div>
                                        @endif
                                        <h3><a href="{{route('front.product.details',$product->slug)}}">{{strlen($product->title) > 40 ? mb_substr($product->title,0,40,'utf-8') . '...' : $product->title}}</a></h3>
                                        @if ($bex->catalog_mode == 0)
                                            <div class="shop-price">
                                                <p class="price">
                                                    <span class="off-price">
                                                        {{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}{{$product->current_price}}{{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }}
                                                    </span>
                                                    @if (!empty($product->previous_price))
                                                    <span class="main-price">
                                                        {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$product->previous_price}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}
                                                    </span>
                                                    @endif
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

<link rel="preconnect" href="https://assets.salla.sa" />
<link rel="stylesheet" href="https://assets.salla.cloud/sallaicons.css" />
<link rel="stylesheet" href="https://assets.salla.cloud/themes/y/dist/css/bootstrap-rtl-grid.min.css?v2.34-theme-utils">
<link rel="stylesheet" href="https://etmaam.com.sa/cms/assets/front/css/app-homepage.css?v2.34-theme-utils">
<link rel="stylesheet" href="https://assets.salla.cloud/themes/y/dist/css/intl-tel-input.css?v2.34-theme-utils">

<style>
	.splide--draggable>.splide__track>.splide__list>.splide__slide {
		width: 230px;
		margin-left: 20px;
	}
button.btn.btn--oval.btn--padded.btn--grey.active {
    background: #173c56;
    color: #fff;
    font-weight: bold;
}
	.splide__arrow {
		border-radius: 5px;
		background-color: #174563;
		fill: white;
		opacity: 1;
	}

	.product-block {
		text-align: center;
		border: 1px solid #e4e4e4;
		border-radius: 0 !important;
	}



	.product-block .overflow-product {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: 10;
		background-color: #174563d3;
		justify-content: center;
		align-items: center;
		display: none;
	}

	.product-block:hover .overflow-product {
		display: flex;
	}


	.product-block .overflow-product .btn--add-to-cart {
		border-radius: 50% !important;
		background-color: white !important;
		position: relative !important;
		top: 0;
		left: 0;
		width: 40px;
		height: 40px;
		font-size: 20px;
		transform: translateX(0);
		padding: 0;

		box-shadow: 0px 2px 5px #00000069;
	}

	.product-block .overflow-product .btn--add-to-cart i {
		line-height: 40px;
	}

	.product-block .product-block__info {
		background-color: #fafafa;
		border-top: 1px solid #edeaea;
	}

	.product-block .product-block__info .price-wrapper {
		color: #edb02d;
		font-weight: bolder;
		font-size: 1.2rem;
	}

	.product-block .product-block__info .price-wrapper .txt-price {
		color: black !important;
		font-size: 1rem;
	}

	.product-block .product-block__info .title {
		color: black !important;
		font-size: 1.2rem;
	}

	.product-block .product-block__thumb {
		height: 150px !important;
	}

	.product-block.contain .product-block__thumb .thumb-wrapper img {
		width: 100% !important;
	}

</style>

<body>

	<section class="home-block home-block--bg home-block--slide-products ">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<ul class="tabs-heads tabs-heads--center">
						    
						   @foreach($categories as $cat)
						<li class="tab-head">
							<button class="btn btn--oval btn--padded btn--grey @if ($loop->first)active @endif
 "
								data-tab-target="#{{str_replace(' ','-',$cat->slug)}}">
							{{$cat->name}}
							</button>
						</li>
						@endforeach
						
						
					
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="tabs-body">
					     @foreach($categories as $cat)
						<div id="{{str_replace(' ','-',$cat->slug)}}" data-tab-content="{{$cat->slug}}" class="tab-body @if ($loop->first)active @endif">
							<div class="splide splide-products splide--products-slider  splide--rtl splide--draggable is-active"
								 style="visibility: visible;">
								<div class="splide__arrows"><button class="splide__arrow splide__arrow--prev"
										type="button" aria-controls="splide02-track" aria-label="Previous slide"><svg
											xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40"
											height="40">
											<path
												d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z">
											</path>
										</svg></button><button class="splide__arrow splide__arrow--next" type="button"
										aria-controls="splide02-track" aria-label="Go to first slide"><svg
											xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40"
											height="40">
											<path
												d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z">
											</path>
										</svg></button></div>
                      
					                
                                          	
                          <div class="splide__track">
                        		<ul class="splide__list">

										@foreach($cat->products as $product)
										<li class="splide__slide" aria-hidden="true"
											tabindex="-1">
											<div class="product-block contain anime-item" id="product_593163929">
												<div class="overflow-product">
													<a href="{{$product->link_salla}}" class="btn btn--floated btn--add-to-cart "
														aria-label="Add To Cart" data-on-click="cart-quick-add"
														data-id="1085029762">
														<i class="sicon-shopping-bag"></i>
													</a>
												</div>
												<div class="product-block__thumb">
													<a href="{{$product->link_salla}}" class="thumb-wrapper"
														aria-label="إصدار سجل تجاري">
													    
														<img class="loaded" width="100%" height="150"
															src="{{asset('assets/front/img/product/featured/'.$product->feature_image)}}"
															data-src="{{asset('assets/front/img/product/featured/'.$product->feature_image)}}"
															alt="">
													</a>
												</div>
												<div class="product-block__info">
													<a href="{{$product->link_salla}}" class="product-title">
														<h2 class="title title--primary title--small">{{$product->title}}
														</h2>
														<p></p>
													</a>
													<div class="price-wrapper">
														<span>{{$product->current_price}}</span>
														<span class="txt-price">ر.س</span>
													</div>
												</div>

											</div>
										</li>
										@endforeach
			
						
									</ul>
								</div>
							</div>
						</div>
						@endforeach
	
					
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://etmaam.store/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
		data-cf-settings="7be9a6e814f63341bc0531df-|49" defer=""></script>
	<script defer src="https://etmaam.com.sa/cms/assets/front/js/v652eace1692a40cfa3763df669d7439c1639079717194.js"
		integrity="sha512-Gi7xpJR8tSkrpF7aordPZQlW2DLtzUlZcumS8dMQjwDHEnw9I7ZLyiOj/6tZStRBGtGgN6ceN6cMH8z7etPGlw=="
		data-cf-beacon='{"rayId":"6eb89368be775c80","token":"0ba4cd7067784c07aa8f5f733dd0f1a2","version":"2021.12.0","si":100}'
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/js/splide.min.js"></script>
	<script>
	    
	    $(document).ready(function($) {
	    	

	    		$('.tab-head').on('click', '.btn', function(event) {
	    			event.preventDefault();
	    			/* Act on the event */
	    			$('.tab-head .btn').removeClass('active');
	    			$(this).addClass('active');
	    			
	    			$('.tab-body').removeClass('active');
	    			$($(this).data('tab-target')).addClass('active');
	    		});
	    });
		
		var splide = new Splide('.splide', {

			perMove: 1,
			padding: "20px",
			trimSpace: true,
			type: "loop",
			gap: 20,
			lazyLoad: true,
			fixedWidth: "230px",
			direction: "rtl",
			pagination: false,
			autoplay: true
		});

		splide.mount();

	</script>
</body>
<script
	src="https://cdn.polyfill.io/v3/polyfill.min.js?flags=gated&features=Promise%2CObject.assign%2CObject.values%2CArray.prototype.find%2CArray.prototype.findIndex%2CArray.prototype.includes%2CString.prototype.includes%2CString.prototype.startsWith%2CString.prototype.endsWith%2Cdocument.getElementsByClassName%2CPromise.prototype.finally%2CString.prototype.includes%2CNumber.isNaN%2Ces6%2CEvent%2CCustomEvent"
	type="7be9a6e814f63341bc0531df-text/javascript"></script>
<script type="7be9a6e814f63341bc0531df-text/javascript" defer
	src="https://assets.salla.cloud/themes/y/dist/js/manifest.js?v2.34-theme-utils"></script>
<script defer src="https://etmaam.store/languages/assets/1646826835.js" type="7be9a6e814f63341bc0531df-text/javascript">
</script>
<script type="7be9a6e814f63341bc0531df-text/javascript" defer src="vendor.home.js"></script>
<script type="7be9a6e814f63341bc0531df-text/javascript">
	document.addEventListener('DOMContentLoaded', function () {
		window.salla && salla.event && salla.event.dispatchEvents({
			"page.view": {
				"route": "store.home",
				"link": "https:\/\/etmaam.store"
			},
			"services::tawk.init": {
				"services": {
					"tawk": {
						"id": "5f5f7bcf4704467e89eed175",
						"region": "default"
					}
				}
			}
		})
	})

</script>
<div class="pace-demo hidden">
	<div class="theme_tail_circle">
		<div class="pace_progress" data-progress-text="60%" data-progress="60"></div>
		<div class="pace_activity"></div>
	</div>
</div>
<div id="div_ajax"></div>













  <!--    services section start   -->
  <div class="service-section">
     <div class="container">
        <div class="row">
           <div class="col-lg-8">
              <div class="row">





<script src="https://etmaam.com.sa/cms/assets/front/js/v652eace1692a40cfa3763df669d7439c1639079717194.js"></script>
<script src="https://etmaam.com.sa/cms/assets/front/js/vendor.home.js"></script>


</div>
</div>
</div>
</div>
</div>

  <!--    services section end   -->
@endsection
