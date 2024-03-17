<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	@section('head')
  @show
	@if(0)
	<link type="text/css" rel="stylesheet" href="/css/ms-dev-mode-file.css?v={{uniqid()}}" />
	@else
	<link type="text/css" rel="stylesheet" href="/css/ms.min.css?v={{uniqid()}}" />
	@endif
	<link rel="shortcut icon" type="image/x-icon" href="/img/icon.png" />
	@if(!empty(conf('Mob_browser_color')))
	<meta name="theme-color" content="{{conf('Mob_browser_color')}}" />
	@endif
	@if(!isLocalhost())
	@include('layouts.google')
	@endif
</head>
<body>
	<header>
		<div id="top-header">
			<div class="container">
				<div class="pull-left hfirst">
					<span>{{__('app.Site_welcome')}}</span>
				</div>
				<div class="pull-right hsec">
					<ul class="header-top-links">
						<li><a href="/news-list">{{__('app.News')}}</a></li>
						@foreach(App\Pages::where('status',0)->where('important',1)->get() as $page)
							<li><a href="/page/{{$page->slug}}">{{$page->shortname}}</a></li>
						@endforeach
						@if(0)
						<!-- <li class="dropdown default-dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">ENG <i class="fa fa-caret-down"></i></a>
							<ul class="custom-menu">
								<li><a href="#">English (ENG)</a></li>
								<li><a href="#">Russian (Ru)</a></li>
								<li><a href="#">French (FR)</a></li>
								<li><a href="#">Spanish (Es)</a></li>
							</ul>
						</li> -->
						@endif
						@if(!empty(conf("currencies")))
						<li class="dropdown default-dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">@if(empty(get("currency"))) AZN @else {{get("currency")}} @endif <i class="fa fa-caret-down"></i></a>
							<ul class="custom-menu">
								@for($k=0;$k<count(explode(',',conf("currencies")));$k++)
								<li><a href="/currency/{{explode(',',conf("currencies"))[$k]}}">{{explode(',',conf("currencies"))[$k]}}</a></li>
								@endfor
							</ul>
						</li>
						@endif
					</ul>
				</div>
			</div>
		</div>

		<div id="header">
			<div class="container">
				<div class="pull-left">
					<div class="header-logo">
						<a class="logo" href="/" title="{{__('app.Logo')}}">
							<img src="/img/logo.png" alt="{{__('app.Logo')}}">
						</a>
					</div>
					<div class="header-search hide">
            <form action="/search-result/search={request}" method="GET" autocomplete="off" class="form-search" accept-charset="utf-8">
							<input class="input search-input" type="text" name="search" placeholder="{{__('app.Search')}}..." @if(Request::is('search-result/*')) value="{{$search}}" @else value="{{ isset($s) ?  $s : ''}}" @endif oninvalid="this.setCustomValidity('{{__('app.Please_enter_value_for_search')}}')" oninput="setCustomValidity('')" required>
							<select class="input search-categories" name="category_id">
								<option value="0">{{__('app.All')}}</option>
                @foreach(App\Category::all() as $ct)
                <option @if(Request::is("search-result/search*")) @if($cat_id == $ct->id) selected @endif @endif value="{{$ct->id}}">{{$ct->name}}</option>
                @endforeach
							</select>
							<button type="submit" class="search-btn"><i class="fa fa-search"></i></button>
						</form>
					</div>
				</div>
				<div class="pull-right">
					<ul class="header-btns">
					<li class="nav-toggle">
						<button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-align-left"></i></button>
					</li>
						@if(Auth::check())
						<li class="header-cart dropdown default-dropdown frst">
							<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
								<div class="header-btns-icon">
									<i class="fa fa-shopping-cart"></i>
									<span class="qty wish_count"></span>
								</div>
							</a>
							<div class="custom-menu wish_head_list">
								<div id="shopping-cart">
									<div class="shopping-cart-list" id="wishlist_head"></div>
									<div class="shopping-cart-btns">
										<a class="primary-btn pull-right" href="/wishlist">{{__('app.More')}} <i class="fa fa-arrow-circle-right"></i></a>
									</div>
								</div>
							</div>
						</li>
						@endif
						<li class="header-account dropdown default-dropdown scnd">
							<div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
								<div class="header-btns-icon">
									<i class="fa fa-user-o"></i>
								</div>
							</div>
							@guest <a href="#">{{__('app.Join')}}</a> @endif
							<ul class="custom-menu">
								@if(Auth::check())
								<li><a href="/profile"><i class="fa fa-user-o"></i> {{__('app.My_account')}}</a></li>
								@if(isAdmin())
								<li><a href="/admin"><i class="fa fa-columns"></i> {{__('app.Panel')}}</a></li>
								@endif
								<li><a href="/wishlist"><i class="fa fa-shopping-cart"></i> {{__('app.My_wishlist')}}</a></li>
								<li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();"><i class="fa fa-angle-left"></i> {{__('app.Logout')}}</a></li>
								<form id="logout-form" action="/logout/user" method="GET" style="display: none;">
										@csrf
								</form>
								@else
								<li><a href="/account?action=login"><i class="fa fa-unlock-alt"></i> {{__('app.Login')}}</a></li>
								<li><a href="/account?action=register"><i class="fa fa-user-plus"></i> {{__('app.Register')}}</a></li>
								@endif
							</ul>
						</li>
						<li class="btn-icon-header dropdown">
							<a id="search_icon">
								<div class="header-btns-icon">
									<i class="fa fa-search"></i>
								</div>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</header>
	@include('layouts.menu')

	@if(session()->has('message'))
			<div class="notify notify-{{session()->get('type') }}">
				<a href="#" class="close">&times;</a>
					{{ session()->get('message') }}
			</div>
	@endif
  @section('body')
  @show
	<footer id="footer" class="section section-grey">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="footer">
						@if(false)
						<div class="footer-logo">
							<a class="logo" href="#">
		            <img src="/img/logo.png" alt="{{config('settings.Site_title')}}">
		          </a>
						</div>
						@endif
						<ul class="footer-social">
							@if(conf('fa-facebook') !== "")
							<li><a href="{{conf('fa-facebook')}}" target="_blank"><i class="fa fa-facebook"></i></a></li>
							@endif
							@if(conf('fa-whatsapp') !== "")
							<li><a href="{{conf('fa-whatsapp')}}" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
							@endif
							@if(conf('fa-instagram') !== "")
							<li><a href="{{conf('fa-instagram')}}" target="_blank"><i class="fa fa-instagram"></i></a></li>
							@endif
							@if(conf('fa-youtube') !== "")
							<li><a href="{{conf('fa-youtube')}}" target="_blank"><i class="fa fa-youtube"></i></a></li>
							@endif
							@if(conf('fa-google-plus') !== "")
							<li><a href="{{conf('fa-google-plus')}}" target="_blank"><i class="fa fa-google-plus"></i></a></li>
							@endif
							@if(conf('fa-pinterest') !== "")
							<li><a href="{{conf('fa-pinterest')}}" target="_blank"><i class="fa fa-pinterest"></i></a></li>
							@endif
							@if(conf('fa-twitter') !== "")
							<li><a href="{{conf('fa-twitter')}}" target="_blank"><i class="fa fa-twitter"></i></a></li>
							@endif
						</ul>
						<p>{!! conf('Footer_slogan') !!}</p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="footer">
						<h3 class="footer-header">{{conf('footer_title_1')}}</h3>
						<ul class="list-links">
							@foreach(App\Pages::where('footer',1)->where('footer_type',0)->get() as $pg)
							<li><a href="/page/{{$pg->slug}}">{{$pg->shortname}}</a></li>
							@endforeach
						</ul>
					</div>
				</div>
				<div class="clearfix visible-sm visible-xs"></div>
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="footer">
						<h3 class="footer-header">{{conf('footer_title_2')}}</h3>
						<ul class="list-links">
							@foreach(App\Pages::where('footer',1)->where('footer_type',1)->get() as $pg)
							<li><a href="/page/{{$pg->slug}}">{{$pg->shortname}}</a></li>
							@endforeach
						</ul>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="footer">
						<h3 class="footer-header">{{__('app.Stay_connected')}}</h3>
						<p>{{__('app.Stay_connected_details')}}</p>
						<div class="form-group">
							<input class="input" placeholder="{{__('app.E_mail')}}..." id="subscribe_input">
						</div>
						<a class="primary-btn" id="subscribe_button">{{__('app.Subscribe')}}</a>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center">
					<div class="footer-copyright">
						{!! conf("footer_copyright") !!}
					</div>
				</div>
			</div>
		</div>
	</footer>
	<script src="//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	@if(0)
	<script src="/js/ms-dev-mode-file.js"></script>
	@else
	<script src="/js/ms.min.js?v={{uniqid()}}" defer></script>
	@endif
  @section('foot')
  @show
</body>

</html>
