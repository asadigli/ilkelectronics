@extends('layouts.ms')
@section('head')
<meta name="description" content="">
<meta name="keywords" content="">
<title>{{__('app.My_account')}} - {{conf("Site_title")}}</title>
@endsection
@section('body')
	<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="/">{{__('app.Home')}}</a></li>
				<li class="active">{{__('app.My_account')}}</li>
			</ul>
		</div>
	</div>
	<div class="section">
		<div class="container">
			<div class="row">
					<form method="POST" @if(isset($_GET['action']) && $_GET['action'] === 'password-change') action="/update-user-password" @else action="/update-profile-data" @endif>
							@csrf
						<div class="col-md-6">
              <div class="section-title">
									<h4 class="title">{{__('app.Edit_profile')}}</h4>
							</div>
							<div class="profile-section">
								@if(isset($_GET['action']) && $_GET['action'] === 'password-change')
								<div class="form-group row">
										<input id="current-password" type="password" placeholder="{{__('app.Old_password')}}..." class="input @error('password') is-invalid @enderror" name="password" required autocomplete="off">
										@error('password')
												<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
										@enderror
								</div>
								<div class="form-group row">
										<input id="new_password" type="password" placeholder="{{__('app.New_password')}}..." class="input @error('new_password') is-invalid @enderror" name="new_password" required autocomplete="off">
										@error('new_password')
												<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
										@enderror
								</div>
								<div class="form-group row">
										<input id="new_password_confirmation" type="password" placeholder="{{__('app.New_password')}} ({{__('app.Confirm')}})..." class="input" name="new_password_confirmation" required autocomplete="off">
								</div>
								@else
								<div class="form-group row">
									<input id="name" type="text" placeholder="{{ __('app.Name') }}..." class="input @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" required autocomplete="name" autofocus>
									@error('name')
											<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
									@enderror
								</div>
								<div class="form-group row">
									<input id="surname" type="text" placeholder="{{ __('app.Surname') }}..." class="input @error('surname') is-invalid @enderror" name="surname" value="{{ Auth::user()->surname }}" required autocomplete="surname" autofocus>
									@error('surname')
											<span class="invalid-feedback" role="alert"><strong>{{ surname }}</strong></span>
									@enderror
								</div>
								<div class="form-group row">
										<input id="phone" type="text" placeholder="{{ __('app.Phone_number') }}..." class="input @error('phone') is-invalid @enderror" name="phone" value="{{ Auth::user()->phone }}" autocomplete="phone">
										@error('phone')
											<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
										@enderror
								</div>
								<div class="form-group row">
										<input id="email" type="email" placeholder="{{ __('app.E_mail') }}..." class="input @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required autocomplete="email">
										@error('email')
											<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
										@enderror
								</div>
								<div class="form-group row">
										<input id="birthdate" type="date" @if(!empty(Auth::user()->birthdate)) value="{{\Carbon\Carbon::parse(Auth::user()->birthdate)->format('Y-m-d')}}" @endif max="{{date('Y-m-d',strtotime('-13 year',time()))}}" class="input @error('birthdate') is-invalid @enderror" name="birthdate" required>
										@error('birthdate')
											<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
										@enderror
								</div>
								@endif
								<div class="form-group row mb-0">
									<button type="submit" class="cust-btn">{{ __('app.Update') }}</button>
								</div>
							</div>
						</div>
					</form>
					<div class="col-md-6">
						<div class="profile-section">
							<div class="section-title">
									<h4 class="title">{{__('app.My_account')}}</h4>
							</div>
							<div class="input-checkbox">
									<div class="prof_sec">
											<ul>
												<li @if(isset($_GET['action']) && $_GET['action'] === 'password-change') @else class="active" @endif><i class="fa fa-chevron-left"></i>  <a href="/profile"> {{__('app.Account_settings')}}</a></li>
												<li @if(isset($_GET['action']) && $_GET['action'] === 'password-change') class="active" @endif> <i class="fa fa-chevron-left"></i> <a href="/profile?action=password-change"> {{__('app.Change_password')}}</a></li>
											</ul>
											{{conf("Account_text")}}
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
	</div>
@endsection
