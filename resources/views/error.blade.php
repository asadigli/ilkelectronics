@extends('layouts.ms')
@section('head')
<title>{{__('app.Error')}}</title>
@endsection
@section('body')
	<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="/">{{__('app.Home')}}</a></li>
				<li class="active">{{__('app.Error')}}</li>
			</ul>
		</div>
	</div>
	<div class="section error-page-div">
		<div class="container">
			<div class="row">
				<div class="error-page">
					<h2>@if(Session::has('error_message')) {{session('error_message')}} @else @if($type == '404') {{__('app.Nothing_found')}} @else {{__('app.Internal_error')}} @endif @endif</h2>
					<p>
						<a href="/" class="btn btn-danger">{{__('app.Back_to_home')}}</a>
					</p>
				</div>
			</div>
		</div>
	</div>
@endsection
