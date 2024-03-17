@extends('admin.adms')
@section('head')
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="/adm/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="/adm/plugins/node-waves/waves.css" rel="stylesheet" />
    <link href="/adm/plugins/animate-css/animate.css" rel="stylesheet" />
    <link href="/adm/plugins/morrisjs/morris.css" rel="stylesheet" />
    <link href="/adm/css/style.css" rel="stylesheet">
    <link href="/adm/css/themes/all-themes.css" rel="stylesheet" />
    <title>{{conf("admin_title")}}</title>
@endsection
@section('body')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>{{__('app.Dashboard')}}</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">shopping_cart</i>
                        </div>
                        <div class="content">
                            <div class="text">{{__('app.Products')}}</div>
                            <div class="number count-to" data-from="0" data-to="{{App\Products::all()->count()}}" data-speed="15" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="content">
                            <div class="text">{{__('app.Users')}}</div>
                            <div class="number count-to" data-from="0" data-to="{{App\User::all()->count()}}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">format_list_bulleted</i>
                        </div>
                        <div class="content">
                            <div class="text">{{__('app.Categories')}}</div>
                            <div class="number count-to" data-from="0" data-to="{{App\Category::all()->count()}}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">insert_drive_file</i>
                        </div>
                        <div class="content">
                            <div class="text">{{__('app.News')}}</div>
                            <div class="number count-to" data-from="0" data-to="{{App\News::all()->count()}}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
            </div>
            @if(false)
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="body bg-cyan">
                            <div class="m-b--35 font-bold">LATEST SOCIAL TRENDS</div>
                            <ul class="dashboard-stat-list">
                                <li>
                                    #socialtrends
                                    <span class="pull-right">
                                        <i class="material-icons">trending_up</i>
                                    </span>
                                </li>
                                <li>
                                    #materialdesign
                                    <span class="pull-right">
                                        <i class="material-icons">trending_up</i>
                                    </span>
                                </li>
                                <li>#adminbsb</li>
                                <li>#freeadmintemplate</li>
                                <li>#bootstraptemplate</li>
                                <li>
                                    #freehtmltemplate
                                    <span class="pull-right">
                                        <i class="material-icons">trending_up</i>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <!-- orders list -->
                  @if(!empty($home_orders) || !empty($home_orders_ns))
                  <div class="card">
                      <div class="header">
                          <h2>{{__('app.Orders')}}</h2>
                      </div>
                      <div class="body">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#not_seen_orders">{{__('app.Orders')}} ({{count($home_orders_ns)}})</a></li>
                            <li><a data-toggle="tab" href="#seen_orders">{{__('app.Seen_orders')}} ({{count($home_orders)}})</a></li>
                          </ul>
                          <div class="tab-content">
                            <div id="not_seen_orders" class="tab-pane fade in active">
                              <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>{{__('app.Orderer')}}</th>
                                            <th>{{__('app.Product')}}</th>
                                            <th>{{__('app.Email')}}</th>
                                            <th>{{__('app.Contact_number')}}</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($home_orders_ns as $or)
                                        <tr>
                                            <td>{{$or->name}} {{$or->surname}}</td>
                                            <td style="width:300px;"><a @if(isset($or->product->slug)) href="/product/{{$or->product->slug}}" target="_blank" @endif >@if(isset($or->product->productname)) {{$or->product->productname}} @else --- @endif</a> </td>
                                            <td>{{$or->email}}</td>
                                            <td>{{$or->contact_number}} </td>
                                            <td>
                                              <div class="btn-group-vertical">
                                                <!-- <button type="button" class="btn btn-danger" title="{{__('app.Delete_order')}}"><i class="fa fa-trash"></i> </button> -->
                                                <button type="button" class="btn btn-success" title="{{__('app.View_order_details')}}" data-toggle="modal" data-target="#view_more{{$or->id}}"><i class="fa fa-eye"></i> </button>
                                                <button type="button" class="btn btn-primary mark_as_read" data-id="{{$or->id}}" title="{{__('app.Mark_as_read')}}"> @if($or->status == 0) <i class="fa fa-envelope"></i> @else <i class="fa fa-envelope-open"></i> @endif</button>
                                              </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="view_more{{$or->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title">{{__('app.Order_detail')}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <ul class="list-group">
                                                  <li class='list-group-item'><b>ID:</b> {{$or->id}}</li>
                                                  <li class='list-group-item'><b>{{__('app.Orderer')}}:</b> {{$or->name}} {{$or->surname}}</li>
                                                  <li class='list-group-item'><b>{{__('app.Father_name')}}:</b> {{$or->father_name}} </li>
                                                  <li class='list-group-item'><b>{{__('app.Product')}}:</b> {{$or->product->productname}}</li>
                                                  <li class='list-group-item'><b>{{__('app.Quantity')}}:</b> {{$or->quantity}}</li>
                                                  <li class='list-group-item'><b>{{__('app.Email')}}:</b> {{$or->email}}</li>
                                                  <li class='list-group-item'><b>{{__('app.ID_card')}}:</b> {{$or->id_seria}} / {{$or->id_number}} / {{$or->id_pin}}</li>
                                                  <li class='list-group-item'><b>{{__('app.Contact_number')}}:</b> {{$or->contact_number}}</li>
                                                  <li class='list-group-item'><b>{{__('app.Gender')}}:</b> @if($or->gender == 0) {{__('app.Male')}} @else {{__('app.Female')}} @endif</li>
                                                  <li class='list-group-item'><b>{{__('app.Birthdate')}}:</b> {{$or->birthdate}}</li>
                                                  <li class='list-group-item'><b>{{__('app.Address')}}:</b> {{$or->city}} / {{$or->address}}</li>
                                                  <li class='list-group-item'><b>{{__('app.Loan')}}:</b> @if(!empty($or->loan)) {{$or->loan->price}}AZN | {{$or->loan->rate}}% | {{$or->loan->duration}} @endif</li>
                                                </ul>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('app.Close')}}</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            </div>
                            <div id="seen_orders" class="tab-pane fade">
                              <div class="table-responsive">
                                  <table class="table table-hover dashboard-task-infos">
                                      <thead>
                                          <tr>
                                              <th>{{__('app.Orderer')}}</th>
                                              <th>{{__('app.Product')}}</th>
                                              <th>{{__('app.Email')}}</th>
                                              <th>{{__('app.Contact_number')}}</th>
                                              <th>#</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach($home_orders as $or)
                                          <tr>
                                              <td>{{$or->name}} {{$or->surname}}</td>
                                              <td style="width:300px;"><a @if(isset($or->product->slug)) href="/product/{{$or->product->slug}}" target="_blank" @endif>@if(isset($or->product->productname)) {{$or->product->productname}} @else --- @endif</a> </td>
                                              <td>{{$or->email}}</td>
                                              <td>{{$or->contact_number}} </td>
                                              <td>
                                                <div class="btn-group-vertical">
                                                  <button type="button" class="btn btn-success" title="{{__('app.View_order_details')}}" data-toggle="modal" data-target="#view_more{{$or->id}}"><i class="fa fa-eye"></i> </button>
                                                  <button type="button" class="btn btn-primary mark_as_read" data-id="{{$or->id}}" title="{{__('app.Mark_as_read')}}"> @if($or->status == 0) <i class="fa fa-envelope"></i> @else <i class="fa fa-envelope-open"></i> @endif</button>
                                                </div>
                                              </td>
                                          </tr>
                                          <div class="modal fade" id="view_more{{$or->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title">{{__('app.Order_detail')}}</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                  <ul class="list-group">
                                                    <li class='list-group-item'><b>ID:</b> {{$or->id}}</li>
                                                    <li class='list-group-item'><b>{{__('app.Orderer')}}:</b> {{$or->name}} {{$or->surname}}</li>
                                                    <li class='list-group-item'><b>{{__('app.Father_name')}}:</b> {{$or->father_name}} </li>
                                                    <li class='list-group-item'><b>{{__('app.Product')}}:</b> @if(isset($or->product->productname)) {{$or->product->productname}} @else --- @endif</li>
                                                    <li class='list-group-item'><b>{{__('app.Quantity')}}:</b> {{$or->quantity}}</li>
                                                    <li class='list-group-item'><b>{{__('app.Email')}}:</b> {{$or->email}}</li>
                                                    <li class='list-group-item'><b>{{__('app.ID_card')}}:</b> {{$or->id_seria}} / {{$or->id_number}} / {{$or->id_pin}}</li>
                                                    <li class='list-group-item'><b>{{__('app.Contact_number')}}:</b> {{$or->contact_number}}</li>
                                                    <li class='list-group-item'><b>{{__('app.Gender')}}:</b> @if($or->gender == 0) {{__('app.Male')}} @else {{__('app.Female')}} @endif</li>
                                                    <li class='list-group-item'><b>{{__('app.Birthdate')}}:</b> {{$or->birthdate}}</li>
                                                    <li class='list-group-item'><b>{{__('app.Address')}}:</b> {{$or->city}} / {{$or->address}}</li>
                                                    <li class='list-group-item'><b>{{__('app.Loan')}}:</b> @if(!empty($or->loan)) {{$or->loan->price}}AZN | {{$or->loan->rate}}% | {{$or->loan->duration}} @endif</li>
                                                  </ul>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('app.Close')}}</button>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          @endforeach
                                      </tbody>
                                  </table>
                              </div>
                            </div>
                          </div>
                      </div>
                  </div>
                  @endif
                  <!-- orders list ends here -->
                    <div class="card">
                        <div class="header">
                            <h2>{{__('app.Most_viewed_products')}}</h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>{{__('app.Product')}}</th>
                                            <th>{{__('app.Creation_date')}}</th>
                                            <th>{{__('app.Views_count')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($home_prods as $pr)
                                        <tr>
                                            <td><a @if(isset($pr->slug)) href="/product/{{$pr->slug}}" target="_blank" @endif > @if(isset($pr->productname)) {{$pr->productname}} @else --- @endif</a> </td>
                                            <td>{{$pr->created_at}}</td>
                                            <td>{{$pr->views}} {{__('app.times')}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- category stat -->
                    <div class="card">
                        <div class="header">
                            <h2>{{__('app.Category_statistics')}}</h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>{{__('app.Category')}}</th>
                                            <th>{{__('app.Creation_date')}}</th>
                                            <th>{{__('app.Views')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cat_list as $ct)
                                          @if(!empty($ct->numbs))
                                          <tr>
                                              <td>{{$ct->id}}</td>
                                              <td><a @if(isset($ct->slug)) href="/category/{{$ct->slug}}" target="_blank" @endif>{{$ct->name}}</a> </td>
                                              <td>{{\Carbon\Carbon::parse($ct->created_at)->format('d M,Y')}}</td>
                                              <td>{{$ct->numbs}} {{__('app.times')}}</td>
                                          </tr>
                                          @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('foot')
    <script src="/adm/plugins/jquery/jquery.min.js"></script>
    <script src="/adm/plugins/bootstrap/js/bootstrap.js"></script>
    <script src="/adm/plugins/bootstrap-select/js/bootstrap-select.js"></script>
    <script src="/adm/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <script src="/adm/plugins/node-waves/waves.js"></script>
    <script src="/adm/plugins/jquery-countto/jquery.countTo.js"></script>
    <script src="/adm/plugins/raphael/raphael.min.js"></script>
    <script src="/adm/plugins/morrisjs/morris.js"></script>
    <script src="/adm/plugins/chartjs/Chart.bundle.js"></script>
    <!-- <script src="/adm/plugins/flot-charts/jquery.flot.js"></script> -->
    <!-- <script src="/adm/plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="/adm/plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="/adm/plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="/adm/plugins/flot-charts/jquery.flot.time.js"></script> -->
    <script src="/adm/plugins/jquery-sparkline/jquery.sparkline.js"></script>
    <script src="/adm/js/admin.js"></script>
    <script src="/adm/js/pages/index.js"></script>
@endsection
