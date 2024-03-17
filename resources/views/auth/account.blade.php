@extends('layouts.ms')
@section('head')
@if(isset($_GET['action']))
	@if($_GET['action'] === 'login')
		<title>{{__('app.Login')}}</title>
	@else
		<title>{{__('app.Register')}}</title>
	@endif
@endif
@endsection
@section('body')
	<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="#">{{__('app.Home')}}</a></li>
				<li class="active">{{__('app.Login')}}</li>
			</ul>
		</div>
	</div>
	<div class="section">
		<div class="container">
			<div class="row">
				@if(isset($_GET['action']))
					@if($_GET['action'] === 'login')
					<form action="{{ route('login') }}" method="POST">
						@csrf
						<div class="col-md-6">
							<div class="billing-details">
								<div class="section-title">
									<h4 class="title">{{__('app.Login')}} </h4>
								</div>
								<div class="acc_section">
									<div class="form-group">
										<label for="email">{{__('app.E_mail')}}</label>
										<input id="email" type="email" name="email" placeholder="{{__('app.E_mail')}}..." value="{{ old('email') }}" required autocomplete="email" autofocus class="input @error('email') is-invalid @enderror">
										@error('email')
												<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
										@enderror
									</div>
									<div class="form-group">
										<label for="password">{{__('app.Password')}}</label>
										<input id="password" type="password" placeholder="{{__('app.Password')}}..." class="input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
										@error('password')
												<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
										@enderror
									</div>
									<div class="form-group">
										<div class="input-checkbox">
											<input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
											<label class="font-weak" for="register">{{__('app.Remember_me')}}</label>
										</div>
									</div>
									<div class="form-group row mb-0">
											<div class="col-md-8 offset-md-4">
													<button type="submit" class="cust-btn">{{ __('app.Login') }}</button>
													<a class="btn btn-link" href="/account?action=password-reset">
															{{__('app.Forgot_password')}}
													</a>
											</div>
									</div>
								</div>
								</div>
							</div>
						</form>
					@elseif($_GET['action'] === 'password-reset')
						<div class="col-md-6">
							<div class="billing-details">
								<div class="section-title">
									<h4 class="title">{{__('app.Reset_password')}} </h4>
								</div>
								<div class="acc_section">
									@if(!isset($_GET['email']) || empty($_GET['email']))
									<form action="/forgot-password" method="POST">
										@csrf
										<div class="form-group">
											<input id="email" type="email" name="email" placeholder="{{__('app.E_mail')}}..." required autocomplete="email" autofocus class="input">
										</div>
										<div class="form-group row mb-0">
											<div class="col-md-8 offset-md-4">
												<button type="submit" class="cust-btn">{{ __('app.Send_code') }}</button>
											</div>
										</div>
									</form>
									@else
										@if(isset($_GET['access_token']) && !empty($_GET['access_token']))
										<form action="/enter-new-password" method="POST">
											@csrf
											<input type="hidden" name="email" value="{{$_GET['email']}}">
											<input type="hidden" name="access_token" value="{{$_GET['access_token']}}">
											<div class="form-group">
												<input id="password" type="password" name="password" placeholder="{{__('app.Password')}}..." required autofocus class="input">
												@error('password')
														<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
												@enderror
											</div>
											<div class="form-group">
												<input id="confirm-password" type="password" name="password_confirmation" placeholder="{{__('app.Confirm_password')}}..." required autofocus class="input">
											</div>
											<div class="form-group row mb-0">
												<div class="col-md-8 offset-md-4">
													<button type="submit" class="cust-btn">{{ __('app.Reset') }}</button>
												</div>
											</div>
										</form>
										@else
										<form action="/check-otp-code-availability" method="POST">
											@csrf
											<input type="hidden" name="email" value="{{$_GET['email']}}">
											<div class="form-group">
												<input id="code" type="number" name="code" placeholder="{{__('app.Code')}}..." required autofocus class="input">
											</div>
											<div class="form-group row mb-0">
												<div class="col-md-8 offset-md-4">
													<button type="submit" class="cust-btn">{{ __('app.Reset') }}</button>
												</div>
											</div>
										</form>
										@endif
									@endif
								</div>
							</div>
						</div>
					@else
					<form method="POST" action="{{ route('register') }}">
							@csrf
						<div class="col-md-6">
							<div class="billing-details">
								<div class="section-title">
									<h4 class="title">{{__('app.Registration')}} </h4>
								</div>
								<div class="acc_section">
									<div class="form-group row">
										<label for="name">{{ __('app.Name') }}</label>
										<input id="name" type="text" placeholder="{{ __('app.Name') }}..." class="input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
										@error('name')
												<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
										@enderror
									</div>
									<div class="form-group row">
										<label for="surname">{{ __('app.Surname') }}</label>
										<input id="surname" type="text" placeholder="{{ __('app.Surname') }}..." class="input @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus>
										@error('surname')
												<span class="invalid-feedback" role="alert"><strong>{{ surname }}</strong></span>
										@enderror
									</div>
									<div class="form-group row">
											<label for="email">{{ __('app.E_mail') }}</label>
											<input id="email" type="email" placeholder="{{ __('app.E_mail') }}..." class="input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
											@error('email')
												<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
											@enderror
									</div>
									<div class="form-group row">
											<label for="birthdate">{{__('app.Birthdate')}}</label>
											<input id="birthdate" type="date" max="{{date('Y-m-d',strtotime('-13 year',time()))}}" class="input @error('birthdate') is-invalid @enderror" name="birthdate">
											@error('birthdate')
												<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
											@enderror
									</div>
									<div class="form-group row">
											<div class="radio-btn-section">
												<input type="radio" name="gender" value="0" required> {{__('app.Male')}}
												<input type="radio" name="gender" value="1" required> {{__('app.Female')}}
											</div>
											@error('gender')
												<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
											@enderror
									</div>
									<div class="form-group row">
										<label for="password">{{ __('app.Password') }}</label>
											<input id="password" type="password" placeholder="{{ __('app.Password') }}..." class="input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
											@error('password')
													<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
											@enderror
									</div>
									<div class="form-group row">
											<label for="password_confirmation">{{ __('app.Confirm_password') }}</label>
											<input id="password-confirm" type="password" placeholder="{{ __('app.Confirm_password') }}..." class="input" name="password_confirmation" required autocomplete="new-password">
									</div>
									<div class="form-group row mb-0">
											<button type="submit" class="cust-btn">{{ __('app.Register') }}</button>
								</div>
								</div>
							</div>
						</div>
					</form>
					@endif
				@endif
					<div class="col-md-6">
						<div class="shiping-methods">
							<div class="section-title">
									<h4 class="title">{{__('app.Why_need_account')}}</h4>
							</div>
							<p>
								{{conf('Reasons_to_open_account')}}
							</p>
							@if(isset($_GET['action']))
								@if($_GET['action'] === 'login')
									<p>{{__('app.Register_now')}}:
										<a href="/account?action=register">{{__('app.Register')}}</a>
									</p>
								@else
								<p> {{__('app.Have_an_account')}}
									<b><a href="/account?action=register">{{__('app.Login')}}</a></b>
								</p>
								@endif
							@endif

							</div>
						</div>
					</div>
			</div>
		</div>
@endsection
@section('foot')
@endsection
