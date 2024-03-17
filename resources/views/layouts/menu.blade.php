	<div id="navigation">
		<div class="container">
			<div id="responsive-nav">
				<div class="category-nav show-on-click">
					<span class="category-header">{{__('app.Categories')}} <i class="fa fa-list"></i></span>
					<ul class="category-list">
						@foreach($cats as $ct)
						<li class="dropdown side-dropdown">
							@if($ct->subcats_count) <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"> @else <a href="/category/{{$ct->slug}}"> @endif
								{{$ct->name}}
								@if($ct->subcats_count) <i class="fa fa-angle-right"></i> @endif</a>
								@if($ct->subcats_count)
								<div class="custom-menu">
								<div class="row">
									<div class="col-md-4">
										<ul class="list-links">
											@foreach($ct->subcats as $k => $sub_ct)
												@if($k%2 === 0)
												<li><a href="/category/{{$sub_ct->slug}}">{{$sub_ct->name}}</a></li>
												@endif
											@endforeach
										</ul>
										<hr class="hidden-md hidden-lg">
									</div>
									<div class="col-md-4">
										<ul class="list-links">
											@foreach($ct->subcats as $k => $sub_ct)
												@if($k%2 !== 0)
													<li><a href="/category/{{$sub_ct->slug}}">{{$sub_ct->name}}</a></li>
												@endif
											@endforeach
										</ul>
										<hr class="hidden-md hidden-lg">
									</div>
								</div>
							</div>
								@endif
						</li>
						@endforeach
						<li><a href="/categories">{{__('app.View_all')}}</a></li>
					</ul>
				</div>
				<div class="menu-nav">
					<span class="menu-header">{{__('app.Menu')}} <i class="fa fa-bars"></i></span>
					<ul class="menu-list">
						<li><a href="/">{{__('app.Home')}}</a></li>
						@foreach($header_pages as $page)
						<li @if($page->childs_count) class="dropdown default-dropdown" @endif><a @if($page->childs_count) class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" @else href="/page/{{$page->slug}}" @endif>{{$page->shortname}} @if(count($page->childs) != 0) <i class="fa fa-caret-down"></i> @endif</a>
							@if($page->childs_count)
							<ul class="custom-menu">
								@foreach($page->childs as $pg)
								<li><a href="/page/{{$pg->slug}}">{{$pg->shortname}}</a></li>
								@endforeach
							</ul>
							@endif
						</li>
						@endforeach
						<li><a href="/brands-list">{{__('app.Brand_list')}}</a></li>
						<li><a href="/contact-us">{{__('app.Contact_us')}}</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
