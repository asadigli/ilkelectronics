@extends('layouts.ms')
@section('head')
<meta name="description" content="">
<meta name="keywords" content="">
<meta property=”og:title” content=”{{conf("Site_title")}}”/>
<meta property=”og:url” content=””/>
<meta property=”og:site_name” content=”{{conf("Site_title")}}”/>
<meta property=”og:image” content=”https://ilkelectronics.az/img/logo.png”/>
<meta property=”og:type” content=”store”/>
<meta property=”og:description” content=””/>
<meta name="twitter:title" content="{{conf("Site_title")}}">
<meta name="twitter:description" content="">
<meta name="twitter:image" content="https://ilkelectronics.az/img/logo.png">
<meta name="twitter:site" content="{{conf("Site_title")}}">
<meta name="twitter:creator" content="{{conf("Site_title")}}">
<title>{{conf("Site_title")}}</title>
@endsection
@section('body')
<div id="home">
	<div class="container">
		<div class="home-wrap">
			<div id="home-slick">
				@if(count($pss))
				@foreach($pss as $ps)
				<div class="banner banner-1">
					<img {{isset($img_ldng) ? $img_ldng : 'src='}}"/uploads/posters/{{$ps->image}}" alt="{{$ps->title}}">
					<div class="banner-caption">
						<h1 class="primary-color">{{$ps->title}} </h1>
						<h3 class="white-color font-weak">{{$ps->details}}</h3>
						@if(isset($ps->button) && !empty($ps))
						 <a href="{{$ps->button_href}}" class="primary-btn" style="background:{{$arr_colors[$ps->button_type]}}" target='_blank'>{{$ps->button}}</a>
						@endif
					</div>
				</div>
				@endforeach
				@else
				<div class="banner banner-1">
					<img {{isset($img_ldng) ? $img_ldng : 'src='}}"/uploads/posters/default-slide.jpg" alt="{{conf('Site_title')}}">
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
<div class="section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					@foreach($brands as $brand)
					<div class="col-md-2 col-sm-6 brand-image" title="{{$brand->brand}}">
						<a href="/brand/{{strtolower($brand->brand)}}">
							<img {{isset($img_ldng) ? $img_ldng : 'src='}}"/uploads/brands/{{$brand->image}}" alt="{{$brand->brand}}">
						</a>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
<div class="section deals_of_day_parent" style="display:none">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="section-title">
					<h2 class="title">{{__('app.Deals_of_the_day')}}</h2>
					<div class="pull-right">
						<div class="product-slick-dots-1 custom-dots"></div>
					</div>
				</div>
			</div>
			@foreach($rnd_pss as $ps)
			<div class="col-md-3 col-sm-6 col-xs-6 deals_of_day_item">
				<div class="banner banner-2">
					<img {{isset($img_ldng) ? $img_ldng : 'src='}}"/uploads/posters/{{$ps->image}}" alt="{{$ps->title}}">
					<div class="banner-caption">
						<h2 class="white-color">{!! $ps->title !!}</h2>
						@if(!empty($ps->button)) <button class="primary-btn">{{$ps->button}}</button> @endif
					</div>
				</div>
			</div>
			@endforeach
			<div class="col-md-9 col-sm-6 col-xs-6">
				<div class="row">
					<div id="product-slick-1" class="product-slick">
						@foreach($bpro as $bp)
						<div class="product product-single deals_of_day deals_of_day_item">
							<div class="product-thumb">
								<div class="product-label">
								</div>
								@if(!empty($bp->old_price)) <span class="prod-discount"><p>{{(int)$bp->old_price - (int)$bp->price}}</p> <span>{{__('app.Discount_on_cash')}}</span> </span> @endif
								@php($lns = App\Loans::where('prod_id',$bp->id)->where('rate',0)->orderBy('duration','desc')->first())
								@if(!empty($lns))<span class="ln_head"><b>{{$lns->duration}} {{__('app.Interest_free')}}</b></span>@endif
								<ul class="product-countdown pro_countdown" data-date="{{$bp->end_date}}">
									<li><span></span></li><li><span></span></li><li><span></span></li><li><span></span></li>
								</ul>
								@if(App\Images::where('prod_id',$bp->id)->count() == 0)
								<img {{isset($img_ldng) ? $img_ldng : 'src='}}"/img/default.png" alt="{{$bp->productname}}">
								@else @php($img = App\Images::where('prod_id',$bp->id)->orderBy('order','asc')->first())
								<img {{isset($img_ldng) ? $img_ldng : 'src='}}"/uploads/pro/small/{{$img->image}}" alt="{{$bp->productname}}">
								@endif
								<div class="product-rating">
									@for($k=1;$k<=5;$k++)
										@if($k <= $bp->rating)
											<i class="fa fa-star"></i>
										@else
											<i class="fa fa-star-o empty"></i>
										@endif
									@endfor
								</div>
							</div>
							<div class="product-body">
								<h3 class="product-name"><a href="/product/{{$bp->slug}}">{{str_limit($bp->productname,$limit = 80,$end="...")}}</a></h3>
								<h2 class="product-price"> @if(!empty($bp->old_price)) {{$bp->old_price}} @else {{$bp->price}} @endif {{currency()}}</h2>
								<div class="product-btns">
									@if(Auth::check())
										@if(empty(App\Wishlist::where('user_id',Auth::user()->id)->where('prod_id',$bp->id)->first()))
										<a class="primary-btn add-to-cart" data-id="{{$bp->id}}" title="{{__('app.Add_to_wishlist')}}"><i class="fa fa-shopping-cart"></i></a>
										@else
										<a class="primary-btn" title="{{__('app.Added')}}"><i class="fa fa-check"></i></a>
										@endif
										<a href="/order-product/{{$bp->slug}}" class="main-btn">{{__('app.Order_now')}}</a>
									@endif
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="section nxt-sblng">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="section-title">
					<h2 class="title">{{__('app.Latest_products')}}</h2>
				</div>
			</div>
			@foreach($pros as $pro)
			<div class="col-md-3 col-sm-6 col-xs-6">
				<div class="product product-single">
					<div class="product-thumb">
						<div class="product-label">
							@if(nd(\Carbon\Carbon::parse($pro->created_at)->format('Y-m-d'))) <span>{{__('app.New')}}</span> @endif
						</div>
						@if(!empty($pro->old_price)) <span class="prod-discount"><p>{{(int)$pro->old_price - (int)$pro->price}}{{currency()}}</p> <span>{{__('app.Discount_on_cash')}}</span> </span> @endif
						@php($lns = App\Loans::where('prod_id',$pro->id)->where('rate',0)->orderBy('duration','desc')->first())
						@if(!empty($lns))<span class="ln_head"><b>{{$lns->duration}} {{__('app.Interest_free')}}</b></span>@endif
						@if(App\Images::where('prod_id',$pro->id)->count() == 0)
						<img {{isset($img_ldng) ? $img_ldng : 'src='}}"/img/default.png" alt="{{$pro->productname}}">
						@else @php($img = App\Images::where('prod_id',$pro->id)->orderBy('order','asc')->first())
						<img {{isset($img_ldng) ? $img_ldng : 'src='}}"/uploads/pro/small/{{$img->image}}" alt="{{$pro->productname}}">
						@endif
						<div class="product-rating">
							@for($k=1;$k<=5;$k++)
								@if($k <= $pro->rating)
									<i class="fa fa-star"></i>
								@else
									<i class="fa fa-star-o empty"></i>
								@endif
							@endfor
						</div>
					</div>
					<div class="product-body">
						<h3 class="product-name"><a href="/product/{{$pro->slug}}">{{str_limit($pro->productname,$limit = 80,$end="...")}}</a></h3>
						<h2 class="product-price"> @if(!empty($pro->old_price)){{$pro->old_price}} @else {{$pro->price}} @endif {{currency()}}</h2>
						<div class="product-btns">
							@if(Auth::check())
								@if(empty(App\Wishlist::where('user_id',Auth::user()->id)->where('prod_id',$pro->id)->first()))
								<a class="primary-btn add-to-cart" data-id="{{$pro->id}}" title="{{__('app.Add_to_wishlist')}}"><i class="fa fa-shopping-cart"></i></a>
								@else
								<a class="primary-btn" title="{{__('app.Added')}}"><i class="fa fa-check"></i></a>
								@endif
								<a href="/order-product/{{$pro->slug}}" class="main-btn">{{__('app.Order_now')}}</a>
							@endif
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		@include('layouts.most_viewed_products')
		@include('layouts.news')
	</div>
</div>
<div class="information">
	<div><h3><img {{isset($img_ldng) ? $img_ldng : 'src='}}"/img/shipping.png"></h3><p>{{conf("text_1")}}</p></div><div><h3><img {{isset($img_ldng) ? $img_ldng : 'src='}}"/img/price.png"></h3><p>{{conf("text_2")}}</p></div><div><h3><img {{isset($img_ldng) ? $img_ldng : 'src='}}"/img/guarantee.png"></h3><p>{{conf("text_3")}}</p></div><div><h3><img {{isset($img_ldng) ? $img_ldng : 'src='}}"/img/service.png"></h3><p>{{conf("text_4")}}</p></div>
</div>
@endsection
