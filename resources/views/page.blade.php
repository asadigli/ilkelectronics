@extends('layouts.ms')
@section('head')
@if(empty($page))
<meta name="description" content="">
<meta name="keywords" content="">
<meta property=”og:title” content=””/>
<meta property=”og:url” content=””/>
<meta property=”og:site_name” content=””/>
<meta property=”og:image” content=””/>
<meta property=”og:type” content=””/>
<meta property=”og:description” content=””/>
<title>{{__('app.Page')}} - {{conf("Site_title")}}</title>
@else
<meta name="description" content="">
<meta name="keywords" content="">
<meta property=”og:title” content=””/>
<meta property=”og:url” content=””/>
<meta property=”og:site_name” content=””/>
<meta property=”og:image” content=””/>
<meta property=”og:type” content=””/>
<meta property=”og:description” content=””/>
<title>{{$page->shortname}} - {{conf("Site_title")}}</title>
@endif
@endsection
@section('body')
	<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="/">{{__('app.Home')}}</a></li>
				<li class="active">{{$page->shortname}}</li>
			</ul>
		</div>
	</div>
	<div class="section">
		<div class="container">
			<div class="row">
				<div id="aside" class="col-md-3">
					<div class="aside">
						<h3 class="aside-title">{{__('app.News')}}</h3>
						@foreach(App\News::where('status',1)->get() as $newss)
						<div class="product product-widget">
							<div class="product-thumb">
								@php($img = App\Images::where('news_id',$newss->id)->orderBy('order','asc')->first())
								@if(!empty($img))
								<img src="/uploads/news/{{$img->image}}" alt="{{$newss->title}}">
								@else
								<img src="/uploads/news/defualt.png" alt="{{$newss->title}}">
								@endif
							</div>
							<div class="product-body">
								<h2 class="product-name"><a href="/news/{{$newss->slug}}" title="{{$newss->title}}">{{str_limit($newss->title,$limit = 30, $end = "...")}}</a></h2>
								<small>{{\Carbon\Carbon::parse($newss->created_at)->format('d M, Y')}}</small>
							</div>
						</div>
						@endforeach
					</div>
				</div>
				<div id="main" class="col-md-9">
					@if(empty($page))
					@else
					<div class="news-details">
						@php($imgs = App\Images::where('page_id',$page->id)->orderBy('order','asc')->get())
						@if(count($imgs) != 0)
							<div class="news-big-image">
								<div class="slideshow-container">
									@foreach($imgs as $i => $img)
										<div class="mySlides" style="display:none;">
									    <img src="/uploads/pages/{{$img->image}}" style="width:100%" alt="{{$page->title}}">
									  </div>
									@endforeach
									<a class="prev">&#10094;</a>
									<a class="next">&#10095;</a>
								</div>
							</div>
						@endif
						<div class="news-body-section">
							<h3><a href="/page/{{$page->slug}}" title="{{$page->title}}">{{$page->title}}</a> </h3>
							<p>{!!$page->body!!}</p>
						</div>
						@if(App\Protab::where('page_id',$page->id)->count() != 0)
							@foreach(App\Protab::where('page_id',$page->id)->orderBy('order','ASC')->get() as $key => $pt)
							<div class="pg-tabs">
								<a class="accordion" href="#tab_{{$key}}">{{$pt->title}} <i class="fa fa-chevron-down"></i> </a>
								<div class="panel">
								  <p>{!! $pt->description !!}</p>
								</div>
							</div>
							@endforeach
						@endif
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection
@section('foot')
@endsection
