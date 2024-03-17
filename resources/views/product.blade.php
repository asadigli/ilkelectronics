@extends('layouts.ms')
@section('head')
@php($first_img = App\Images::where('prod_id',$pro->id)->orderBy('order','asc')->get())
<meta name="description" content="{{$pro->productname}}: {{$pro->description}}">
<meta name="keywords" content="">
<meta property=”og:title” content=”{{$pro->productname}}”/>
<meta property=”og:url” content=”https://ilkelectronics.az/{{Request::path()}}”/>
<meta property=”og:site_name” content=”{{conf("Site_title")}}”/>
<meta property=”og:image” @if(count($first_img) > 0) content=”https://ilkelectronics.az/uploads/pro/{{$first_img->first()->image}}” @endif/>
<meta property=”og:type” content=”store”/>
<meta property=”og:description” content=”{{$pro->productname}}: {{$pro->description}}”/>
<title>{{$pro->productname}} - {{conf("Site_title")}}</title>
@endsection
@section('body')
	<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="/">{{__('app.Home')}}</a></li>
				@php($ct = App\Category::find($pro->category))
				@if(!empty($ct))
				<li><a href="/category/{{App\Category::find($ct->parent_id)->slug}}">{{App\Category::find($ct->parent_id)->name}}</a></li>
				<li class="active">{{$ct->name}}</li>
				@endif
			</ul>
		</div>
	</div>
	<div class="section">
		<div class="container">
			<div class="row">
				<div class="product product-details clearfix">
					<div class="col-md-6">
						@php($imgs = App\Images::where('prod_id',$pro->id)->orderBy('order','asc')->get())
						<div @if(count($imgs) !== 0) id="product-main-view" @endif>
							@if(count($imgs) !== 0)
								@foreach($imgs as $img)
									<div class="product-view">
										<img src="/uploads/pro/{{$img->image}}" alt="{{$pro->productname}}">
									</div>
								@endforeach
							@else
							<div class="product-view">
								<img class="pro-default" src="/uploads/pro/default.png" alt="{{$pro->productname}}">
							</div>
							@endif
						</div>
						@if(!empty($pro->old_price))<span class="prod-discount-top"><p>{{(int)$pro->old_price - (int)$pro->price}}{{currency()}}</p> <span>{{__('app.Discount_on_cash')}}</span> </span> @endif
						@if(count($imgs) !== 0)
						<div id="product-view">
							@foreach($imgs as $img)
								<div class="product-view">
									<img src="/uploads/pro/small/{{$img->image}}" alt="{{$pro->productname}}">
								</div>
							@endforeach
						</div>
						@endif
					</div>
					<div class="col-md-6">
						<div class="product-body">
							<div class="product-label">
								@if(nd($pro->created_at))<span>{{__('app.New')}}</span> @endif
								@if(!empty($pro->old_price) && 0) <span class="sale">{{discount($pro->old_price,$pro->price)}} %</span> @endif
							</div>
							<h2 class="product-name">{{$pro->productname}}</h2>

							<h3 class="product-price"> @if(!empty($pro->old_price)) {{$pro->old_price}} @else {{$pro->price}} @endif {{currency()}} </h3>
							<div id="un_product_rating">
								<div class="product-rating"></div>
								<a href="#reviews">{{__('app.Reviews')}} / {{__('app.Add_review')}}</a>
							</div>
							<p><strong>{{__('app.Availability')}}:</strong> @if($pro->quantity > 0) <span class="in_stock">{{__('app.In_stock')}}</span> @else <span class="not_in_stock">{{__('app.Not_in_stock')}}</span> @endif</p>
							<p><strong>{{__('app.Product_ID')}}:</strong> {{$pro->prod_id}}</p>
							<p><strong>{{__('app.Brand')}}:</strong> {{$pro->brand}}</p>
							<div class="product-options">

							</div>

							<div class="product-btns">
								<div class="qty-input">
									<span class="text-uppercase">{{__('app.Quantity')}}: </span>
									<input class="input quantity" type="number" value="1">
								</div>
								<a class="primary-btn add-to-cart" data-id="{{$pro->id}}"><i class="fa fa-shopping-cart"></i></a>
								<a href="/order-product/{{$pro->slug}}" class="main-btn">{{__('app.Order_now')}}</a>
							</div>
							<p class="prod-desc">{!! $pro->description !!}</p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="product-tab">
							<ul class="tab-nav product-tabs">
								<li class="active"><a data-toggle="tab" href="#description">{{__('app.Description')}}</a></li>
								<li><a data-toggle="tab" href="#reviews">{{__('app.Reviews')}} (<b></b>)</a></li>
							</ul>
							<div class="tab-content">
								<div id="description" class="tab-pane fade in active">
									@if(count($lns) > 0)
									<table class="table">
										<thead>
											<tr>
												<th></th>
												<th>{{__('app.Duration')}}</th>
												<th>{{__('app.Rate')}}</th>
												<th>{{__('app.Monthly_payment')}}</th>
											</tr>
										</thead>
								    <tbody>
											@foreach($lns as $k => $ln)
								      <tr @if($k%2 == 0) class="odd" @endif>
												<td><img src="/uploads/icon/{{$ln->card_icon}}" > </td>
								        <td>{{$ln->duration}} ay</td>
												<td><b @if($ln->rate == 0) class="red" @endif>{{$ln->rate}}%</b></td>
								        <td> @if($ln->rate == 0) @endif {{number_format((((($ln->price * $ln->rate)/100) + $ln->price)/$ln->duration)/currency(0),2)}}{{currency()}}</td>
												<td> <a href="/order-product/{{$pro->slug}}?loan_type={{$ln->id}}&rate={{$ln->rate}}&duration={{$ln->duration}}" class="btn btn-primary">{{__('app.Order_now')}}</a> </td>
								      </tr>
											@endforeach
								    </tbody>
								  </table>
									<hr>
									@endif
									@if(count($loans) > 0)
									<h5>{{__('app.Internal_loan')}}</h5>
									<table class="table">
										<thead>
											<tr>
												<th>{{__('app.Duration')}}</th>
												<th>{{__('app.Rate')}}</th>
												<th>{{__('app.Monthly_payment')}}</th>
												<th>{{__('app.Total_will_pay')}}</th>
												<th></th>
											</tr>
										</thead>
								    <tbody>
											@foreach($loans as $k => $ln)
								      <tr @if($k%2 == 0) class="odd" @endif>
								        <td>{{$ln->duration}} ay</td>
												<td><b @if($ln->rate == 0) class="red" @endif>{{$ln->rate}}%</b> </td>
								        <td>{{number_format((((($ln->price * $ln->rate)/100) + $ln->price)/$ln->duration)/currency(0),2)}}{{currency()}}</td>
												<td>{{number_format(((($ln->price * $ln->rate)/100) + $ln->price)/currency(0),2)}}{{currency()}}</td>
												<td> <a href="/order-product/{{$pro->slug}}?loan_type={{$ln->id}}&rate={{$ln->rate}}&duration={{$ln->duration}}" class="btn btn-primary">{{__('app.Order_now')}}</a> </td>
								      </tr>
											@endforeach
								    </tbody>
								  </table>
									<hr>
									@endif
									<table class="table">
								    <tbody>
											@foreach($prod_tabs as $k => $pt)
								      <tr @if($k%2 == 0) class="odd" @endif>
								        <td>{{$pt->title}}</td>
								        <td>{{$pt->description}}</td>
								      </tr>
											@endforeach
								    </tbody>
								  </table>
									@if(false)
									<strong>{{$pro->description_title}}</strong>
									<p>{{$pro->description}}</p>
									@endif
								</div>
								<div id="reviews" class="tab-pane fade in">
									<div class="row">
										<div class="col-md-6">
											<div class="product-reviews" id="prod_review_list" data-id="{{$pro->id}}">
												<p class="no_review" style="display:none;">{{__('app.No_review_here')}}</p>
												<ul class="reviews-pages" id="rev_pg_pro"></ul>
											</div>
										</div>
										<div class="col-md-6">
											<h4 class="text-uppercase">{{__('app.Write_your_review')}}</h4>
											<p>
												@if(config("settings.comment_verification") == 0)
												{{__('app.Your_comment_will_shared_after_verification')}}
												@endif
											</p>
											<div class="review-form">
												<div class="form-group">
													<input class="input" type="text" @if(Auth::check()) value="{{Auth::user()->name}} {{Auth::user()->surname}}" readonly @else placeholder="{{__('app.Name')}}..." @endif id="commenter_name"  />
												</div>
												<div class="form-group">
													<input class="input" type="email" @if(Auth::check()) value="{{Auth::user()->email}}" readonly @else placeholder="{{__('app.E_mail')}}..." @endif id="commenter_email" />
												</div>
												<div class="form-group">
													<textarea class="input" placeholder="{{__('app.Your_comment')}}..." id="comment_section" required></textarea>
												</div>
												<div class="form-group">
													<div class="input-rating">
														<strong class="text-uppercase">{{__('app.Your_rating')}}: </strong>
														<div class="stars">
															<input type="radio" name="rating" value="5" id="star5"/><label for="star5"></label>
															<input type="radio" name="rating" value="4" id="star4" checked/><label for="star4"></label>
															<input type="radio" name="rating" value="3" id="star3"/><label for="star3"></label>
															<input type="radio" name="rating" value="2" id="star2"/><label for="star2"></label>
															<input type="radio" name="rating" value="1" id="star1"/><label for="star1"></label>
														</div>
													</div>
												</div>
												<a class="primary-btn share_comment pull-right" title="{{__('app.Share')}}"><i class="fa fa-arrow-right"></i> </a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section-title">
						<h2 class="title">{{__('app.Similar_products')}}</h2>
					</div>
				</div>
				@foreach($pros as $pr)
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="product product-single">
						<div class="product-thumb">
							<div class="product-label">
								@if(nd(\Carbon\Carbon::parse($pr->created_at)->format('Y-m-d'))) <span>{{__('app.New')}}</span> @endif
							</div>
							@if(!empty($pr->old_price)) <span class="prod-discount"><p>{{(int)$pr->old_price - (int)$pr->price}}{{currency()}}</p> <span>{{__('app.Discount_on_cash')}}</span> </span> @endif
	            @php($lns = App\Loans::where('prod_id',$pr->id)->where('rate',0)->orderBy('duration','desc')->first())
							@if(!empty($lns))<span class="ln_head"><b>{{$lns->duration}} {{__('app.Interest_free')}}</b></span>@endif
							<a href="/product/{{$pr->slug}}" title="{{$pr->productname}}" class="main-btn quick-view"></a>
							@php($im = App\Images::where('prod_id',$pr->id)->orderBy('order','asc')->first())
							@if(!empty($im))
							<img src="/uploads/pro/small/{{$im->image}}" alt="{{$pr->productname}}">
							@else
							<img src="/img/default.png" alt="{{$pr->productname}}">
							@endif
							<div class="product-rating">
								@for($k=1;$k<=5;$k++)
									@if($k <= $pr->rating)
										<i class="fa fa-star"></i>
									@else
										<i class="fa fa-star-o empty"></i>
									@endif
								@endfor
							</div>
						</div>
						<div class="product-body">
							<h3 class="product-name"><a href="/product/{{$pr->slug}}" title="{{$pr->productname}}">{{str_limit($pr->productname,$limit = 80,$end="...")}}</a></h3>
							<h2 class="product-price"> @if(!empty($pr->old_price)) {{$pr->old_price}} @else {{$pr->price}} @endif {{currency()}}</h2>
							<div class="product-btns">
								@if(Auth::check())
									@if(empty(App\Wishlist::where('user_id',Auth::user()->id)->where('prod_id',$pr->id)->first()))
									<a class="primary-btn add-to-cart" data-id="{{$pr->id}}" title="{{__('app.Add_to_wishlist')}}"><i class="fa fa-shopping-cart"></i></a>
									@else
									<a class="primary-btn" title="{{__('app.Added')}}"><i class="fa fa-check"></i></a>
									@endif
									<a href="/order-product/{{$pr->slug}}" class="main-btn">{{__('app.Order_now')}}</a>
								@endif
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
@endsection
@section('foot')
@endsection
