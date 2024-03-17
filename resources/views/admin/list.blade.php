@extends('admin.adms')
@section('head')
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<link href="/adm/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/adm/plugins/node-waves/waves.css" rel="stylesheet" />
<link href="/adm/plugins/animate-css/animate.css" rel="stylesheet" />
<link href="/adm/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="/adm/css/style.css" rel="stylesheet">
<link href="/adm/css/themes/all-themes.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/fontawesome.min.css">
@if(Request::is('admin/page-list'))
<title>{{__('app.Page_list')}} - {{conf("admin_title")}}</title>
@elseif(Request::is('admin/news-list'))
<title>{{__('app.News_list')}} - {{conf("admin_title")}}</title>
@elseif(Request::is('admin/comment-list'))
<title>{{__('app.Comment_list')}} - {{conf("admin_title")}}</title>
@elseif(Request::is('admin/users-list'))
<title>{{__('app.User_list')}} - {{conf("admin_title")}}</title>
@else
<title>{{__('app.Product_list')}} - {{conf("admin_title")}}</title>
@endif
@endsection
@section('body')
<section class="content">
    <div class="container-fluid">
        <div class="block-header"><h2>{{__('app.List')}}</h2>
          <hr>
          <p>
            <a class="btn btn-primary" data-toggle="collapse" href="#categories_list" role="button" aria-expanded="false" aria-controls="categories_list">
              {{__('app.Categories')}}
            </a>
          </p>
          @if(isset($cats))
          <div class="collapse" id="categories_list">
            <!-- <div class="card card-xbody"> -->
              <div class="btn-group">
                @foreach($cats as $cat)
                <a href="?category={{$cat->id}}" class="btn btn-success @if(isset($_GET['category']) && $_GET['category'] == $cat->id) btn-success-active @endif">{{$cat->name}}</a>
                @endforeach
              </div>
            <!-- </div> -->
          </div>
          @endif
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header"><h2>
                      @if(Request::is('admin/page-list'))
                      {{__('app.Page_list')}}
                      @elseif(Request::is('admin/news-list'))
                      {{__('app.News_list')}}
                      @elseif(Request::is('admin/comment-list'))
                      {{__('app.Comment_list')}}
                      @elseif(Request::is('admin/users-list'))
                      {{__('app.User_list')}}
                      @else
                      {{__('app.Product_list')}}
                      @if(Auth::user()->role_id >= 3)
                      <a href="#" class="btn btn-primary pull-right" id="compress_prods"><i class="fa fa-sync"></i> </a>
                      @endif
                      @endif
                    </h2>
                  </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable" @if(Request::is('admin/product-list')) id="prod_list" @endif>
                                <thead id="copy_to_tfoot">
                                  @if(Request::is('admin/page-list'))
                                    <tr>
                                      <td>{{__('app.Parent_page')}}</td>
                                      <td>{{__('app.Page_shortname')}}</td>
                                      <td>{{__('app.Page_title')}}</td>
                                      <td>{{__('app.Page_body')}}</td>
                                      <td>{{__('app.Footer')}} / {{__('app.Header')}}</td>
                                      <td>#</td>
                                    </tr>
                                  @elseif(Request::is('admin/news-list'))
                                  <tr>
                                    <td>ID</td>
                                    <td>{{__('app.Title')}}</td>
                                    <td>{{__('app.News_slug')}}</td>
                                    <td>{{__('app.News')}}</td>
                                    <td>{{__('app.Status')}}</td>
                                    <td>{{__('app.Operations')}}</td>
                                  </tr>
                                  @elseif(Request::is('admin/comment-list'))
                                  <tr>
                                    <td>ID</td>
                                    <td>{{__('app.Title')}}</td>
                                    <td>{{__('app.News_slug')}}</td>
                                    <td>{{__('app.News')}}</td>
                                    <td>{{__('app.Status')}}</td>
                                    <td>{{__('app.Operations')}}</td>
                                  </tr>
                                  @elseif(Request::is('admin/users-list'))
                                  <tr>
                                    <td>ID</td>
                                    <td>{{__('app.Name')}}</td>
                                    <td>{{__('app.Gender')}} / {{__('app.Age')}}</td>
                                    <td>{{__('app.Email')}} / {{__('app.Contact_number')}}</td>
                                    <td>{{__('app.Status')}}</td>
                                    <td>{{__('app.Operations')}}</td>
                                  </tr>
                                  @else
                                    <tr>
                                      <th>ID</th><th>{{__('app.Product_name')}}</th><th>{{__('app.Price')}} / {{__('app.Old_price')}}</th>
                                      <th>{{__('app.Quantity')}}</th><th>{{__('app.Views')}}</th><th>#</th>
                                    </tr>
                                  @endif
                                </thead>
                                <tfoot></tfoot>
                                <tbody>
                                    @if(Request::is('admin/page-list'))
                                      @foreach($pages as $page)
                                      <tr>
                                        <td>
                                          @php($pg = App\Pages::find($page->parent_id))
                                          @if(!empty($pg))
                                          <b>{{$pg->shortname}}</b>
                                          @else
                                          <i style="color:red;">{{__('app.No_parent_page')}}</i>
                                          @endif
                                        </td>
                                        <td>{{$page->shortname}}</td>
                                        <td>{{$page->title}}</td>
                                        <td>{{str_limit($page->body, $limit = 100, $end = '...')}}
                                          @if(strlen($page->body) > 100)
                                          <a class="read_more" data-toggle="modal" data-target="#promodal" data-text="{{$page->body}}" data-words="{{__('app.More')}},{{__('app.Close')}}">{{__('app.More')}}</a>
                                          @endif
                                        </td>
                                        <td class="page-list-rd-btns">
                                          <div class="demo-switch">
                                              <div class="switch">
                                                  <input type="hidden" name="status" @if($page->status == 1) value="1" @else value="0" @endif>
                                                  <label>{{__('app.Status')}}<input type="checkbox" data-page="{{$page->id}}" @if($page->status == 1) checked @endif><span class="lever"></span></label>
                                              </div>
                                          </div>
                                          <hr>
                                          <div class="demo-switch">
                                              <div class="switch">
                                                  <input type="hidden" name="important" @if($page->important == 1) value="1" @else value="0" @endif>
                                                  <label>{{__('app.Important')}}<input type="checkbox" data-page="{{$page->id}}" @if($page->important == 1) checked @endif><span class="lever"></span></label>
                                              </div>
                                          </div>
                                          <hr>
                                          <div class="demo-switch">
                                              <div class="switch">
                                                  <input type="hidden" name="footer" @if($page->footer == 1) value="1" @else value="0" @endif>
                                                  <label>{{__('app.In_footer')}}<input type="checkbox" data-page="{{$page->id}}" @if($page->footer == 1) checked @endif id="pg_footer"><span class="lever"></span></label>
                                              </div>
                                          </div>
                                          <hr>
                                          <div class="demo-switch">
                                              <div class="switch">
                                                  <input type="hidden" name="footer_type" @if($page->footer_type == 1) value="1" @else value="0" @endif>
                                                  <label>{{conf('footer_title_1')}}<input type="checkbox" data-page="{{$page->id}}" @if($page->footer_type == 1) checked @endif id="pg_footer_type"><span class="lever"></span>{{conf('footer_title_2')}}</label>
                                              </div>
                                          </div>
                                          <hr>
                                          <div class="demo-switch">
                                              <div class="switch">
                                                  <input type="hidden" name="header"  @if($page->header == 1) value="1" @else value="0" @endif >
                                                  <label>{{__('app.In_header')}}<input type="checkbox" data-page="{{$page->id}}"  @if($page->header == 1) checked @endif id="pg_header"><span class="lever"></span></label>
                                              </div>
                                          </div>
                                        </td>
                                        <td class="list-btns">
                                          <a class="btn btn-danger dl_page" data-id="{{$page->id}}" data-toggle="modal" data-target="#promodal" data-text="{{__('app.Are_you_sure_to_delete_page')}}" data-words="{{__('app.Delete_page')}},{{__('app.Delete')}},{{__('app.Close')}}"><i class="fa fa-trash"></i></a>
                                          <a class="btn btn-success edit_page_modal" data-id="{{$page->id}}" data-toggle="modal" data-target="#promodal" data-words="{{__('app.Edit_page')}},{{__('app.Delete')}},{{__('app.Close')}},{{__('app.Update')}},{{__('app.Page_slug')}},{{__('app.Page_title')}},{{__('app.Parent_page')}},{{__('app.Page_body')}},{{__('app.Page_shortname')}}"><i class="fa fa-cog"></i></a>
                                          <a class="btn btn-primary" href="/admin/page-tabs/{{$page->slug}}"><i class="fa fa-plus"></i></a>
                                          <a class="btn btn-primary" href='/admin/change-image-order/page/{{$page->slug}}'><i class="fa fa-image"></i> </a>
                                        </td>
                                      </tr>
                                      @endforeach
                                    @elseif(Request::is('admin/news-list'))
                                      @foreach($news as $n)
                                      <tr>
                                        <td>{{$n->id}}</td>
                                        <td>{{$n->title}}</td>
                                        <td>{{$n->slug}}</td>
                                        <td>
                                          {{str_limit($n->body, $limit = 100, $end = '...')}}
                                            @if(strlen($n->body) > 100)
                                            <a class="read_more_news" data-toggle="modal" data-target="#promodal" data-text="{{$n->body}}" data-words="{{__('app.More')}},{{__('app.Close')}}">{{__('app.More')}}</a>
                                            @endif
                                        </td>
                                        <td class="page-list-rd-btns">
                                          <div class="demo-switch">
                                              <div class="switch">
                                                  <input type="hidden" name="status" @if($n->status == 1) value="1" @else value="0" @endif>
                                                  <label>{{__('app.Status')}}<input type="checkbox" data-news="{{$n->id}}" @if($n->status == 1) checked @endif><span class="lever"></span></label>
                                              </div>
                                          </div>
                                        </td>
                                        <td class="list-btns">
                                          <a class="btn btn-danger delete dl_news" data-id="{{$n->id}}" data-toggle="modal" data-target="#promodal" data-text="{{__('app.Are_you_sure_to_delete_news')}}" data-words="{{__('app.Delete_news')}},{{__('app.Delete')}},{{__('app.Close')}}"><i class="fa fa-trash"></i></a>
                                          <a class="btn btn-success" href="/admin/news-edit/{{$n->id}}"><i class="fa fa-cog"></i></a>
                                          <a class="btn btn-primary" href='/admin/change-image-order/news/{{$n->slug}}'><i class="fa fa-image"></i> </a>
                                        </td>
                                      </tr>
                                      @endforeach
                                    @elseif(Request::is('admin/comment-list'))
                                    @elseif(Request::is('admin/users-list'))

                                    @foreach($users as $user)
                                    <tr>
                                      <td>{{$user->id}}</td>
                                      <td>{{$user->name}} {{$user->surname}}</td>
                                      <td>@if($user->name == 0) {{__('app.Male')}} @else {{__('app.Female')}} @endif / {{\Carbon\Carbon::parse($user->birthdate)->age}}</td>
                                      <td>{{$user->email}} / {{$user->contact_number}}</td>
                                      <td>---</td>
                                      <td>---</td>
                                    </tr>
                                    @endforeach

                                    @else
                                      @foreach($pros as $pro)
                                      <tr>
                                          <td>{{$pro->prod_id}}</td>
                                          <td>{{$pro->productname}}</td>
                                          <td>{{$pro->price}} {{currency()}} @if(!empty($pro->old_price)) / {{$pro->old_price}} {{currency()}} @endif</td>
                                          <td>{{$pro->quantity}}</td>
                                          <td>{{$pro->views}}</td>
                                          <td class="list-btns">
                                            @csrf
                                            <a class="btn btn-danger delete dl_prod" data-id="{{$pro->id}}" data-toggle="modal" data-target="#promodal" data-text="{{__('app.Are_you_sure_to_delete_product')}}" data-words="{{__('app.Delete_product')}},{{__('app.Delete')}},{{__('app.Close')}}"><i class="fa fa-trash"></i></a>
                                            <a class="btn btn-success" href="/admin/edit-product/{{$pro->id}}"><i class="fa fa-cog"></i></a>
                                            <a class="btn btn-primary" data-id="{{$pro->id}}" data-toggle="modal" data-target="#promodal"><i class="fa fa-eye"></i></a>
                                            <a class="btn btn-warning boost_it" data-max="{{$pro->price}}" data-id="{{$pro->id}}" data-toggle="modal" data-target="#promodal" data-words="{{__('app.Boost_product')}},{{__('app.Boost')}},{{__('app.Close')}},{{__('app.End_date')}},{{__('app.Start_date')}},{{__('app.Discount_amount')}}"><i class="fa fa-heart"></i> </a>
                                          </td>
                                      </tr>
                                      @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div id="promodal" class="modal fade" role="dialog"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('foot')
<script type="text/javascript">
  var page = 'list';
</script>
<script src="/adm/plugins/jquery/jquery.min.js"></script>
<script src="/adm/plugins/bootstrap/js/bootstrap.js"></script>
<!-- <script src="/adm/plugins/bootstrap-select/js/bootstrap-select.js"></script> -->
<script src="/adm/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
<script src="/adm/plugins/node-waves/waves.js"></script>
<script src="/adm/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="/adm/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script src="/adm/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
<script src="/adm/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
<script src="/adm/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
<script src="/adm/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
<script src="/adm/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
<script src="/adm/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
<script src="/adm/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
<script src="/adm/js/admin.js"></script>
<script src="/adm/js/pages/tables/jquery-datatable.js"></script>
@endsection
