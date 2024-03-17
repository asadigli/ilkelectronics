@extends('layouts.ms')
@section('head')
	@if(Request::is('search-result/*'))
	<meta name="description" content="{{__('app.Search_result')}}: {{$search}}">
	<meta name="keywords" content="">
	<meta property=”og:title” content=”{$search}}”/>
	<meta property=”og:description” content=”{{__('app.Search_result')}}: {{$search}}”/>
	<title>{{$search}} - {{conf("Site_title")}}</title>
	@elseif(Request::is('brand/*'))
	<meta name="description" content="{{$brand}} ">
	<meta name="keywords" content="">
	<meta property=”og:title” content=”{{$brand}}”/>
	<meta property=”og:description” content=”{{$brand}}”/>
	<title>{{$brand}} - {{conf("Site_title")}}</title>
	@else
	<meta name="description" content="{{$cat->name}} ">
	<meta name="keywords" content="">
	<meta property=”og:title” content=”{{$cat->name}}”/>
	<meta property=”og:description” content=”{{$cat->name}}”/>
	<title>{{$cat->name}} - {{conf("Site_title")}}</title>
	@endif

	<meta property=”og:url” content=”https://ilkelectronics.az/{{Request::path()}}”/>
	<meta property=”og:site_name” content=”{{conf("Site_title")}}”/>
	<meta property=”og:image” content=”https://ilkelectronics.az/img/logo.png”/>
	<meta property=”og:type” content=”store”/>
@endsection
@section('body')
	<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="/">{{__('app.Home')}}</a></li>
				@if(Request::is('search-result/*'))
				<li><a>{{__('app.Search_result')}}</a> </li>
				<li class="active">{{$search}} (<span class="prd_cnt"></span>)</li>
				@elseif(Request::is('brand/*'))
				<li><a>{{__('app.Brands')}}</a> </li>
				<li class="active">{{$brand}} (<span class="prd_cnt"></span>)</li>
				@else
				<li><a>{{__('app.Category')}}</a> </li>
				<li class="active">{{$cat->name}} (<span class="prd_cnt"></span>)</li>
				@endif
			</ul>
		</div>
	</div>
	<div class="section">
		<div class="container">
			<div class="row">
				<div id="aside" class="col-md-3">
					@include('layouts.filter')
					<div class="aside">
						<h3 class="aside-title">{{__('app.Top_rated_products')}}</h3>
						@foreach($tp_pros as $tp)
						<div class="product product-widget">
							<div class="product-thumb">
								<img src="/uploads/pro/{{$tp->image}}" alt="{{$tp->productname}}">
							</div>
							<div class="product-body">
								<h2 class="product-name"><a href="/product/{{$tp->slug}}" title="{{$tp->productname}}">{{str_limit($tp->productname,$limit = 80,$end = "...")}}</a></h2>
								<h3 class="product-price">{{number_format($tp->price,2)}} {{currency()}}  @if(!empty($tp->old_price))<br> <del class="product-old-price">{{number_format($tp->old_price,2)}} {{currency()}} </del> @endif</h3>
								<div class="product-rating">
									@for($k=1;$k<=5;$k++)
										@if($k < $tp->rating)
											<i class="fa fa-star"></i>
										@else
											<i class="fa fa-star-o empty"></i>
										@endif
									@endfor
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
				<div id="main" class="col-md-9">
					<div class="store-filter clearfix">
						<div class="pull-right">
							<div class="sort-filter">
								<span class="text-uppercase">{{__('app.Sort_By')}}:</span>
								<select class="input sortby_value">
									<option value="1" data-value="first-cheaps">{{__('app.First_cheaper')}}</option>
									<option value="2" data-value="first-expensives">{{__('app.First_expensive')}}</option>
									<option value="0" data-value="latest-products">{{__('app.Latest_products')}}</option>
									<option value="3" data-value="high-rated-products">{{__('app.High_rated_products')}}</option>
								</select>
								<a class="main-btn icon-btn sortby_value_btn filter-btn"><i class="fa fa-arrow-down"></i></a>
							</div>
						</div>
					</div>
					<div class="product-list prod-data-list">
						@if(false)<div class="prod_loading_overlay"></div>@endif
						<div class="row" @if(Request::is("search-result/search*")) data-ct="{{$cat_id}}" @elseif(isset($brand)) data-br="{{$brand}}" @endif id="prod_list" data-words="{{__('app.New')}},{{__('app.Quick_view')}},{{__('app.Please_wait')}},{{__('app.Order_now')}},{{__('app.Interest_free')}},{{__('app.Discount_on_cash')}}">
						</div>
					</div>
					<div class="pull-right" id="product-pagination">
						<div class="page-filter">
							<span class="text-uppercase">{{__('app.Show')}}:</span>
							<select class="input pg-show">
								<option value="15">15</option>
								<option value="30">30</option>
								<option value="45">45</option>
							</select>
						</div>
						<ul class="store-pages"></ul>
					</div>
					@if(false)
					<div class="load-section" style="display:none">
							<a class="cust-btn">{{__('app.Load_more')}}</a>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection
@section('foot')
@endsection
