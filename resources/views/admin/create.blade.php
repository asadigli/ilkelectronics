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
@if(Request::is("admin/slide-and-poster"))
@else
<title>@if(!empty($news)) {{$news->title}} @else {{__('app.Add_news')}} @endif - {{conf("admin_title")}}</title>
@endif
@endsection
@section('body')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>@if(!empty($news)) {{__('app.Edit')}} @else {{__('app.Add')}} @endif</h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                          @if(Request::is("admin/slide-and-poster"))
                            {{__('app.Slide_control')}}
                          @else
                            @if(!empty($news)) {{__('app.Edit_news')}} @else {{__('app.Add_news')}} @endif
                            <small><a href="/admin/news-list">{{__('app.News_list')}}</a> </small>
                          @endif
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">{{__('app.Reset')}}</a></li>
                                    <li><a href="javascript:void(0);">{{__('app.Refresh')}}</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                      @if(Request::is("admin/slide-and-poster"))
                      @else
                      <form @if(!empty($news)) action="/admin/edit-news/{{$news->id}}" @else action="/admin/add-new-news" @endif method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="row clearfix">
                              <div class="col-sm-12">
                                  <div class="form-group">
                                    <label for="product_name">{{__('app.News_slug')}}</label>
                                    <div class="form-line">
                                        <input type="text" name="slug" class="form-control" @if(!empty($news)) value="{{$news->slug}}" @endif placeholder="{{__('app.News_slug')}}" />
                                    </div>
                                  </div>
                                  <br>
                                  <div class="form-group">
                                    <label for="description">{{__('app.News_title')}}</label>
                                    <div class="form-line">
                                        <input type="text" name="title" @if(!empty($news)) value="{{$news->title}}" @endif class="form-control" placeholder="{{__('app.News_title')}}">
                                    </div>
                                  </div>
                              </div>
                          </div>
                          <h2 class="card-inside-title">{{__('app.News')}}</h2>
                          <div class="form-group">
                              <div class="form-line">
                                  <textarea rows="3" name="body" class="form-control no-resize auto-growth" placeholder="{{__('app.News')}}">@if(Request::is('admin/news-edit/*')){{$news->body}}@endif</textarea>
                              </div>
                          </div>
                          <div class="form-group">
                            <label for="images">{{__('app.Images')}}</label>
                            <input type="file" name="images[]" class="form-control" multiple @if(empty($news)) required @endif>
                          </div>
                          <div class="demo-switch">
                              <div class="switch">
                                  <input type="hidden" name="status" @if(!empty($news)) @if($news->status != 1)  value="0" @else value="1" @endif @else value="0" @endif>
                                  <label>{{__('app.Not_active')}}<input type="checkbox" @if(!empty($news) && $news->status != 1) checked @endif><span class="lever"></span>{{__('app.Active')}}</label>
                              </div>
                          </div>
                          <div class="form-group">
                            <button type="submit" class="btn btn-primary pull-right">@if(!empty($news)) {{__('app.Update')}}  @else {{__('app.Add')}} @endif</button>
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
  var page = 'create';
</script>
<script src="/adm/plugins/jquery/jquery.min.js"></script>
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
