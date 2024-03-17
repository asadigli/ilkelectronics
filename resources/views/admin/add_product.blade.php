@extends('admin.adms')
@section('head')
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<link href="/adm/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/adm/plugins/node-waves/waves.css" rel="stylesheet" />
<link href="/adm/plugins/animate-css/animate.css" rel="stylesheet" />
<link href="/adm/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
<link href="/adm/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="/adm/plugins/waitme/waitMe.css" rel="stylesheet" />
<link href="/adm/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<link href="/adm/css/style.css" rel="stylesheet">
<link href="/adm/css/themes/all-themes.css" rel="stylesheet" />
@if(Request::is('admin/add-category'))
<title>{{__('app.Add_new_category')}} - {{conf("admin_title")}}</title>
@elseif(!empty($pro))
<title>{{__('app.Edit_product')}} - {{conf("admin_title")}}</title>
@elseif(Request::is('admin/change-image-order/*'))
<title>{{__('app.Change_order')}}</title>
@elseif(Request::is('admin/products-tabs/*'))
<title>{{__('app.Add_product_tabs')}} - {{conf("admin_title")}}</title>
@elseif(!empty($page))
<title>{{__('app.Page_tabs')}} - {{conf("admin_title")}}</title>
@else
<title>{{__('app.Add_new_product')}} - {{conf("admin_title")}}</title>
@endif
@endsection
@section('body')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
          @if(!empty($pro))
            <h2>{{__('app.Edit')}}</h2>
          @else
            <h2>{{__('app.Add')}}</h2>
          @endif
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            @if(Request::is('admin/add-category')) {{__('app.Add_new_category')}}
                            <small><a href="/admin/add-product">{{__('app.Add_new_product')}}</a> </small>
                            @elseif(Request::is('admin/add-loan/*'))
                            {{__('app.Add_new_loan')}}
                            @elseif(Request::is('admin/change-image-order/*'))
                            {{__('app.Change_order')}}
                            @elseif(!empty($pro))
                            {{__('app.Edit_product')}}
                            <small><a href='/admin/change-image-order/product/{{$pro->slug}}'>{{__('app.Update_image_order')}}</a> |
                              <a href="/admin/products-tabs/{{$pro->slug}}"> {{__('app.Add_product_tabs')}}</a> |
                              <a href="/admin/add-loan/{{$pro->slug}}">{{__('app.Add_new_loan')}}</a>
                            </small>
                            @elseif(!empty($page))
                            {{__('app.Page_tabs')}}
                            @elseif(Request::is('admin/products-tabs/*'))
                            {{__('app.Add_product_tabs')}}
                            <small></small>
                            @else {{__('app.Add_new_product')}}
                            <small><a href="/admin/add-category">{{__('app.Add_new_category')}}</a> </small>
                            @endif
                        </h2>
                    </div>
                    <div class="body">
                      @if(Request::is('admin/add-category'))
                      <form action="/admin/add-new-category" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h2 class="card-inside-title">{{__('app.Parent_category')}}</h2>
                          <div class="row clearfix">
                              <div class="col-sm-12">
                                  <select class="form-control show-tick" name="parent">
                                      <option value="">-- {{__('app.Independent')}} --</option>
                                      @foreach(App\Category::whereNull('parent_id')->get() as $ct)
                                        <option value="{{$ct->id}}">{{$ct->name}}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="col-sm-12">
                                <div class="form-group">
                                  <label for="product_name">{{__('app.Category')}}</label>
                                  <div class="form-line">
                                      <input type="text" name="name" class="form-control" placeholder="{{__('app.Category')}}" required/>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <button type="submit" class="btn btn-primary pull-right">{{__('app.Add')}}</button>
                              </div>
                            </div>
                            </div>
                        </form>
                      @if(App\Category::all()->count() > 0)
                        <div class="card">
                          <div class="body table-responsive">
                              <table class="table">
                                  <thead><tr><th>{{__('app.Category')}}</th><th>{{__('app.Parent_category')}}</th><th>{{__('app.Number_of_products')}}</th><th>X</th></tr></thead>
                                  <tbody id="cat_list">
                                      @foreach(App\Category::orderBy('order','ASC')->get() as $k => $ct)
                                      <tr data-id="{{$ct->id}}">
                                          <th scope="row">{{$k}}.</th>
                                          <td>{{$ct->name}}</td>
                                          <td>@if(!empty($ct->parent_id)) {{App\Category::find($ct->parent_id)->name}} @endif</td>
                                          <td>@if(!empty($ct->parent_id)) {{App\Products::where('category',$ct->id)->count()}} @else
                                             @php($ids = [])
                                             @foreach(App\Category::where('parent_id',$ct->id)->get() as $cts)
                                             @php($ids[] = $cts->id)
                                             @endforeach
                                             {{App\Products::whereIn('category',$ids)->count()}}
                                             @endif</td>
                                          <td><a data-id="{{$ct->id}}" data-text="{{__('app.Are_you_sure_to_delete_category')}}" data-toggle="modal" data-target="#deletemodal" class="btn btn-danger dlt_category" data-words="{{__('app.Delete_Category')}},{{__('app.Delete')}},{{__('app.Close')}}">X</a> </td>
                                      </tr>
                                      @endforeach
                                  </tbody>
                              </table>
                              <a id="update_cat_list" class="btn btn-primary pull-right"><i class="fa fa-save"></i></a>
                              <div id="deletemodal" class="modal fade" role="dialog"></div>
                          </div>
                        </div>
                      @endif
                      @elseif(Request::is('admin/change-image-order/*'))
                      @if(!empty($pro))
                      <span>{{$pro->prod_id}}: {{$pro->productname}}</span>
                      @endif
                      <a href="#" class="btn btn-primary my-btn pull-right">{{__('app.Reorder')}}</a><br><br>
                      <hr>
                      <ul class="image-list">
                          @foreach($images as $key => $img)
                          <li data-id="{{$key}}">
                            <b>{{$key + 1}}. </b>
                            <img src="{{$url}}{{$img->image}}" data-id="{{$img->id}}">
                            <a class="btn btn-danger delete_image" data-id="{{$img->id}}" data-toggle="modal"
                              data-target="#delete_img" data-text="{{__('app.Are_you_sure_to_delete_image')}}"
                              data-words="{{__('app.Delete_image')}},{{__('app.Delete')}},{{__('app.Close')}}"><i class="fa fa-trash"></i></a>
                          </li>
                          @endforeach
                      </ul>
                      <div id="delete_img" class="modal fade" role="dialog"></div>
                      @elseif(Request::is('admin/add-loan/*'))
                      <div class="body table-responsive">
                        <h5>{{$product->prod_id}}: {{$product->productname}}
                        </h5>
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>{{__('app.Duration')}}</th>
                              <th>{{__('app.Rate')}}</th>
                              <th>{{__('app.Image')}}</th>
                              <th>#</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($pro_loans as $pl)
                            <form action="/admin/update-loan/{{$pl->id}}" method="POST" class="new_loan_form" enctype="multipart/form-data">
                              @csrf @php($pp = App\Products::where('slug',$product->slug)->first())
                              <input type="hidden" name="prod_id" value="{{$pp->id}}">
                              <tr>
                                  <td><input type="number" class="tab_inputs" name="duration" value="{{$pl->duration}}" placeholder="{{__('app.Duration')}}..." required> </td>
                                  <td><input type="number" class="tab_inputs" name="rate" value="{{$pl->rate}}" placeholder="{{__('app.Rate')}}..." required> </td>
                                  <td><input type="file" name="images"> </td>
                                  <td><a href="/admin/delete-loan-type/{{$pl->id}}" class="btn btn-danger"><i class="fa fa-trash"></i> </a>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i></button>
                                  </td>
                              </tr>
                            </form>
                            @endforeach
                            <tr>
                              <form action="/admin/add-new-loan" method="POST" enctype="multipart/form-data">
                                @csrf @php($pp = App\Products::where('slug',$product->slug)->first())
                                <input type="hidden" name="prod_id" value="{{$pp->id}}">
                                <td><input type="number" class="tab_inputs" name="duration" placeholder="{{__('app.Duration')}}..." required> </td>
                                <td><input type="number" class="tab_inputs" name="rate" placeholder="{{__('app.Rate')}}..." required> </td>
                                <td><input type="file" name="images"> </td>
                                <td><a href="#" class="btn btn-danger"><i class="fa fa-trash"></i> </a>
                                  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i></button>
                                 </td>
                              </form>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      @elseif(Request::is('admin/products-tabs/*') | !empty($page))
                      <div class="body table-responsive">
                        <h5>@if(empty($page)) {{$pro->prod_id}}: {{$pro->productname}} @else
                          {{$page->shortname}}: {{$page->title}}
                          @endif
                        </h5>
                        <table class="table table-bordered" id="tab_table">
                          <thead>
                            <tr>
                              <th>{{__('app.Title')}}</th>
                              <th>{{__('app.Details')}}</th>
                              <th>#</th>
                            </tr>
                          </thead>
                          <tbody @if(!empty($page)) data-page-id="{{$page->id}}" @else data-id="{{$pro->id}}" @endif data-words="{{__('app.Title')}},{{__('app.Details')}}"></tbody>
                        </table>
                        <div class="pull-right">
                          <a id="add_new_tab" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                          <a id="save_new_tabs" class="btn btn-primary"><i class="fa fa-save"></i></a>
                        </div>
                      </div>
                      @else
                        <form @if(!empty($pro)) action="/admin/update-product/{{$pro->id}}" @else action="/admin/add-new-product" @endif method="POST" enctype="multipart/form-data">
                          @csrf
                          <h2 class="card-inside-title">{{__('app.Category')}}</h2>
                          <div class="row clearfix">
                              <div class="col-sm-6 pcats">
                                  <select class="form-control show-tick" id="pcat" @if(!empty($pro)) data-select="{{App\Category::find($pro->category)->parent_id}}" @endif required>
                                      <option @if(empty($pro)) selected @endif>-- {{__('app.Select_category')}} --</option>
                                      @foreach(App\Category::whereNull('parent_id')->get() as $ct)
                                          <option value="{{$ct->id}}" @if(!empty($pro)) @if($ct->id == App\Category::find($pro->category)->parent_id) selected @endif @endif>{{$ct->name}}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="col-sm-6 pcats">
                                  <select class="form-control" id="psubcat" @if(!empty($pro)) data-select="{{$pro->category}}" @endif data-default="{{__('app.Select_category')}}" required></select>
                              </div>
                          </div>
                          <input type="hidden" id="hidden_sub" name="category" @if(!empty($pro)) value="{{$pro->category}}" @endif>
                          <div class="row clearfix">
                              <div class="col-sm-12">
                                <div class="form-group">
                                  <label for="product_name">{{__('app.ID')}}</label>
                                  <div class="form-line">
                                      <input type="text" name="prod_id" class="form-control" @if(!empty($pro)) value="{{$pro->prod_id}}" @endif placeholder="{{__('app.ID')}}" required/>
                                  </div>
                                </div>
                                  <div class="form-group">
                                    <label for="product_name">{{__('app.Product_slug')}}</label>
                                    <div class="form-line">
                                        <input type="text" name="slug" class="form-control" @if(!empty($pro)) value="{{$pro->slug}}" @endif placeholder="{{__('app.Product_slug')}}" />
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="product_name">{{__('app.Product_name')}}</label>
                                    <div class="form-line">
                                        <input type="text" name="productname" class="form-control" @if(!empty($pro)) value="{{$pro->productname}}" @endif placeholder="{{__('app.Product_name')}}" required/>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="price">{{__('app.Price')}}</label>
                                    <div class="form-line">
                                        <input type="number" name="price" class="form-control" min="0" step="0.01" @if(!empty($pro)) value="{{$pro->price}}" @endif placeholder="{{__('app.Price')}}" required>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="old_price">{{__('app.Old_price')}}</label>
                                    <div class="form-line">
                                        <input type="number" name="old_price" class="form-control" min="0" step="0.01" @if(!empty($pro)) value="{{$pro->old_price}}" @endif placeholder="{{__('app.Old_price')}}">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="quantity">{{__('app.Quantity')}}</label>
                                    <div class="form-line">
                                        <input type="number" name="quantity" min="0" class="form-control" @if(!empty($pro)) value="{{$pro->quantity}}" @endif placeholder="{{__('app.Quantity')}}" required>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="quantity">{{__('app.Brand')}}</label>
                                    <div class="form-line">
                                        <input type="text" name="brand" class="form-control" @if(!empty($pro)) value="{{$pro->brand}}" @endif placeholder="{{__('app.Brand')}}" required>
                                    </div>
                                  </div>
                                  <div class="demo-switch">
                                      <div class="switch">
                                          <input type="hidden" name="condition" @if(empty($pro)) value="1" @else value="{{$pro->condition}}" @endif>
                                          <label>{{__('app.Used')}}<input type="checkbox" @if(!empty($pro)) @if($pro->condition == 1) checked @endif @else checked @endif><span class="lever"></span>{{__('app.New')}}</label>
                                      </div>
                                  </div><br>
                                  <div class="form-group">
                                    <label for="description">{{__('app.Description_title')}}</label>
                                    <div class="form-line">
                                        <input type="text" name="description_title" @if(!empty($pro)) value="{{$pro->description_title}}" @endif class="form-control" placeholder="{{__('app.Description_title')}}">
                                    </div>
                                  </div>
                              </div>
                          </div>
                          <h2 class="card-inside-title">{{__('app.Description')}}</h2>
                          <div class="form-group">
                              <div class="form-line">
                                  <textarea rows="3" name="description" class="form-control no-resize auto-growth" placeholder="{{__('app.Description')}}">@if(!empty($pro)){{$pro->description}}@endif</textarea>
                              </div>
                          </div>
                          <div class="form-group">
                            <label for="images">{{__('app.Images')}}</label>
                            <input type="file" name="images[]" class="form-control" multiple @if(empty($pro)) required @endif>
                          </div>
                          <div class="demo-switch">
                              <div class="switch">
                                  <input type="hidden" name="status" @if(empty($pro)) value="1" @else value="{{$pro->status}}" @endif>
                                  <label>{{__('app.Not_active')}}<input type="checkbox" @if(!empty($pro)) @if($pro->status == 1) checked @endif @else checked @endif><span class="lever"></span>{{__('app.Active')}}</label>
                              </div>
                          </div>
                          <div class="form-group">
                            <button type="submit" class="btn btn-primary pull-right">@if(!empty($pro)) {{__('app.Update')}}  @else {{__('app.Add')}} @endif</button>
                          </div>
                        </form>
                      @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('foot')
<script type="text/javascript">
  var page = 'add_product';
</script>
<script src="/adm/plugins/jquery/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="/adm/plugins/bootstrap/js/bootstrap.js"></script>
<script src="/adm/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script src="/adm/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
<script src="/adm/plugins/node-waves/waves.js"></script>
<script src="/adm/plugins/autosize/autosize.js"></script>
<script src="/adm/plugins/momentjs/moment.js"></script>
<script src="/adm/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<script src="/adm/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="/adm/js/admin.js"></script>
<script src="/adm/js/pages/forms/basic-form-elements.js"></script>
@endsection
