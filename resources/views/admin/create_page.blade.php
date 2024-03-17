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
<title>{{__('app.Create_page')}} - {{conf("admin_title")}}</title>
@endsection
@section('body')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>{{__('app.Add')}}</h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{__('app.Create_page')}}
                            <small><a href="/admin/page-list">{{__('app.Page_list')}}</a> </small>
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
                        <form action="/admin/create-new-page" method="POST" enctype="multipart/form-data">
                          @csrf
                          <h2 class="card-inside-title">{{__('app.Pages')}}</h2>
                          <div class="row clearfix">
                              <div class="col-sm-12 pcats">
                                  <select class="form-control show-tick" name="parent_id">
                                      <option selected>-- {{__('app.Select_page')}} --</option>
                                      @foreach($pages as $pg)
                                          <option value="{{$pg->id}}">{{$pg->shortname}}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="row clearfix">
                              <div class="col-sm-12">
                                  <div class="form-group">
                                    <label for="slug">{{__('app.Page_slug')}} ({{__('app.Might_be_empty')}})</label>
                                    <div class="form-line">
                                        <input type="text" name="slug" class="form-control" placeholder="{{__('app.Page_slug')}}" />
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="shortname">{{__('app.Page_shortname')}}</label>
                                    <div class="form-line">
                                        <input type="text" name="shortname" class="form-control" placeholder="{{__('app.Page_shortname')}}" required/>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="price">{{__('app.Page_title')}}</label>
                                    <div class="form-line">
                                        <input type="text" name="title" class="form-control" placeholder="{{__('app.Page_title')}}" required>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="quantity">{{__('app.Page_text')}}</label>
                                    <div class="form-line">
                                        <textarea name="body" class="form-control" placeholder="{{__('app.Page_text')}}" required></textarea>
                                    </div>
                                  </div>
                                  <div class="demo-switch">
                                      <div class="switch">
                                        <input type="hidden" name="important" value="0">
                                          <label>{{__('app.Important')}}<input type="checkbox" ><span class="lever"></span></label>
                                      </div>
                                  </div>
                                  <hr>
                                  <div class="demo-switch">
                                      <div class="switch">
                                        <input type="hidden" name="footer" value="0">
                                          <label>{{__('app.In_footer')}}<input type="checkbox" ><span class="lever"></span>{{__('app.Not_in_footer')}}</label>
                                      </div>
                                  </div>
                                  <hr>
                                  <div class="demo-switch">
                                      <div class="switch">
                                        <input type="hidden" name="footer" value="1">
                                          <label>{{conf('footer_title_1')}}<input type="checkbox" checked><span class="lever"></span>{{conf('footer_title_2')}}</label>
                                      </div>
                                  </div>
                                  <hr>
                                  <div class="demo-switch">
                                      <div class="switch">
                                        <input type="hidden" name="header" value="0">
                                          <label>{{__('app.In_header')}}<input type="checkbox" ><span class="lever"></span>{{__('app.Not_in_header')}}</label>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group">
                            <label for="images">{{__('app.Images')}}</label>
                            <input type="file" name="images[]" class="form-control" multiple>
                          </div>
                          <div class="demo-switch">
                              <div class="switch">
                                  <input type="hidden" name="status" value="0">
                                  <label>{{__('app.Not_active')}}<input type="checkbox" checked><span class="lever"></span>{{__('app.Active')}}</label>
                              </div>
                          </div>
                          <div class="form-group">
                            <button type="submit" class="btn btn-primary pull-right">{{__('app.Create')}}</button>
                          </div>
                        </form>
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
<script src="/adm/plugins/autosize/autosize.js"></script>
<script src="/adm/plugins/momentjs/moment.js"></script>
<script src="/adm/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<script src="/adm/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="/adm/js/admin.js"></script>
<script src="/adm/js/pages/forms/basic-form-elements.js"></script>
@endsection
