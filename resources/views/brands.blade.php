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
<div id="breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="/">{{__('app.Home')}}</a></li>
			<li class="active">{{__('app.Brand_list')}}</li>
		</ul>
	</div>
</div>
<div class="section" style="min-height:883px">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section-title">
						<h2 class="title">{{__('app.Brand_list')}}</h2>
						<div class="pull-right">
							<div class="product-slick-dots-1 custom-dots"></div>
						</div>
					</div>
				</div>
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
<div class="information">
	<div><h3><img {{isset($img_ldng) ? $img_ldng : 'src='}}"/img/shipping.png"></h3><p>{{conf("text_1")}}</p></div><div><h3><img {{isset($img_ldng) ? $img_ldng : 'src='}}"/img/price.png"></h3><p>{{conf("text_2")}}</p></div><div><h3><img {{isset($img_ldng) ? $img_ldng : 'src='}}"/img/guarantee.png"></h3><p>{{conf("text_3")}}</p></div><div><h3><img {{isset($img_ldng) ? $img_ldng : 'src='}}"/img/service.png"></h3><p>{{conf("text_4")}}</p></div>
</div>
@endsection
