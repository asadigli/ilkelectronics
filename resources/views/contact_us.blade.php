@extends('layouts.ms')
@section('head')
@if(empty($pro))
<meta name="description" content="">
<meta name="keywords" content="">
<title>{{__('app.Contact_us')}} - {{conf("Site_title")}}</title>
@else
<meta name="description" content="">
<meta name="keywords" content="">
<title>{{__('app.Order_online')}} - {{conf("Site_title")}}</title>
@endif
@endsection
@section('body')
	<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="/">{{__('app.Home')}}</a></li>
				<li class="active">
					@if(Request::is('order-product/*'))
					{{__('app.Order_online')}}
					@else
					{{__('app.Contact_us')}}
					@endif
				</li>
			</ul>
		</div>
	</div>
	<div class="section">
		<div class="container">
			<div class="row">
					@if(empty($pro))
					<form method="POST" action="/send-message">
							@csrf
						<div class="col-md-6">
              <div class="section-title">
									<h4 class="title">{{__('app.Contact_us')}}</h4>
							</div>
							<div id="contact_form" class="profile-section">
								<div class="col-md-12">
									<div class="form-group row">
										<input id="name" type="text" placeholder="{{ __('app.Name') }}..." class="input" @if(Auth::check()) value="{{ Auth::user()->name }}" disabled @endif required autocomplete="name" autofocus>
										@error('name')
												<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
										@enderror
									</div>
									<div class="form-group row">
											<input id="email" type="email" placeholder="{{ __('app.E_mail') }}..." class="input" @if(Auth::check()) value="{{ Auth::user()->email }}" disabled @endif required autocomplete="email">
											@error('email')
												<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
											@enderror
									</div>
									<div class="form-group row">
											<textarea id="body" class="input @error('email') is-invalid @enderror" placeholder="{{__('app.Your_message')}}..."></textarea>
											@error('body')
												<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
											@enderror
									</div>
									<div class="form-group row mb-0 pull-right">
										<a class="cust-btn">{{ __('app.Send') }}</a>
									</div>
								</div>
							</div>
						</div>
					</form>
					@else
						<div class="col-md-6">
							<div class="section-title">
									<h4 class="title">{{__('app.Information')}}</h4>
							</div>
							<div id="order_form" class="profile-section">
								<div class="form-group row">
									<label for="product_id">ID</label>
									<input id="product_id" type="text" value="{{$pro->prod_id}}" class="input" readonly required>
								</div>
								@if(isset($_GET['loan_type'])) <input type="hidden" id="order_type" value="{{$_GET['loan_type']}}"> @endif
								<div class="form-group row">
									<label for="productname">{{__('app.Product')}}</label>
									<input id="productname" type="text" value="{{$pro->productname}}" class="input" readonly required>
								</div>
								<div class="form-group row">
									<label for="quantity">{{__('app.Quantity')}}</label>
									<input id="quantity" type="number" placeholder="{{__('app.Quantity')}}..." value="1" class="input" required>
								</div>
								<div class="form-group row">
									<label for="name">{{__('app.Your_name')}}</label>
									<input id="name" type="text" @if(Auth::check()) value="{{Auth::user()->name}}" readonly @else placeholder="{{__('app.Your_name')}}..." @endif class="input" required>
								</div>
								<div class="form-group row">
									<label for="surname">{{__('app.Your_surname')}}</label>
									<input id="surname" type="text" @if(Auth::check()) value="{{Auth::user()->surname}}" readonly @else placeholder="{{__('app.Your_surname')}}..." @endif class="input" required>
								</div>
								<div class="form-group row">
									<label for="fathername">{{__('app.Father_name')}}</label>
									<input id="fathername" type="text" placeholder="{{__('app.Father_name')}}..." class="input" required>
								</div>
								<div class="form-group row">
									<label for="birthdate">{{__('app.Birthdate')}}</label>
									<input id="birthdate" type="date" @if(Auth::check() && !empty(Auth::user()->birthdate)) value="{{\Carbon\Carbon::parse(Auth::user()->birthdate)->format('Y-m-d')}}" @endif class="input" required>
								</div>
								<div class="form-group row">
									<label for="region">{{__('app.Region')}}</label>
									<input id="region" type="text" placeholder="{{__('app.Region')}}..." class="input" required>
								</div>
								<div class="form-group row">
									<label for="address">{{__('app.Living_address')}}</label>
									<input id="address" type="text" placeholder="{{__('app.Living_address')}}..." class="input" required>
								</div>
								<div class="form-group row" @if(Auth::check()) style="display:none" @endif>
									<label for="gender">{{__('app.Gender')}}</label>
									<select class="input" id="gender">
										<option value="0">Male</option>
										<option value="1">Female</option>
									</select>
								</div>
								<div class="form-group row">
									<label for="contact_number">{{__('app.Contact_number')}}</label>
									<input id="contact_number" type="text" @if(Auth::check()) value="{{Auth::user()->phone}}" @endif class="input" placeholder="{{__('app.Contact_number')}}..." required>
								</div>
								<div class="form-group row">
									<label for="email">{{__('app.E_mail')}}</label>
										<input id="email" type="email" placeholder="{{ __('app.E_mail') }}..." class="input" @if(Auth::check()) value="{{ Auth::user()->email }}" disabled @endif required autocomplete="email">
								</div>
								<div class="form-group row mb-0 pull-right">
									<a class="cust-btn" id="order_product">{{ __('app.Order_now') }}</a>
								</div>
							</div>
						</div>
					@endif
					<div class="col-md-6">
						<div class="profile-section">
							@if(empty($pro))
							<div class="section-title">
									<h4 class="title">{{__('app.My_account')}}</h4>
							</div>
							<div class="input-checkbox">
									<div class="prof_sec">
											@if(Auth::check())
											<ul>
												<li><i class="fa fa-chevron-left"></i>  <a href="/profile"> {{__('app.Account_settings')}}</a></li>
												<li> <i class="fa fa-chevron-left"></i> <a href="/profile?action=password-change"> {{__('app.Change_password')}}</a></li>
											</ul>
											@else
											<ul>
												<li> <i class="fa fa-chevron-left"></i> <a href="/account?action=register"> {{__('app.Register')}}</a></li>
											</ul>
											@endif
											{{conf("Contact_page_text")}}
									</div>
								</div>
								@else
								<div class="section-title">
										<h4 class="title">{{__('app.Order_online')}}</h4>
								</div>
								<div class="input-checkbox">
										<div class="prof_sec">
												{{conf("Order_page_text")}}
										</div>
									</div>
								@endif
							</div>
						</div>
					</div>
			</div>
</div>
@endsection
