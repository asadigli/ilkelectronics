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
<title>{{__('app.Slide_control')}}</title>
@endsection
@section('body')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>{{__('app.Slide_control')}}</h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                          {{__('app.Slide_control')}}
                          <small class="urls-slide">
                            <a @if(isset($_GET['type'])) @if($_GET['type'] === "poster") class="active" @endif @endif href="/{{Request::path()}}?type=poster">Poster</a> -
                            <a @if(isset($_GET['type'])) @if($_GET['type'] === "slide") class="active" @endif @endif href="/{{Request::path()}}?type=slide">Slide</a> -
                            <a @if(isset($_GET['page'])) @if($_GET['tp'] === "posters") class="active" @endif @endif href="/{{Request::path()}}?page=list&tp=posters">{{__('app.Poster_list')}}</a> -
                            <a @if(isset($_GET['page'])) @if($_GET['tp'] === "slides") class="active" @endif @endif href="/{{Request::path()}}?page=list&tp=slides">{{__('app.Slide_list')}}</a>
                          </small>
                        </h2>
                    </div>
                    @if(isset($_GET['type']))
                    <div class="body">
                      @if(!empty($_GET['poster']))
                      @php($pst = App\Posters::find($_GET['poster']))
                      @endif
                        <form @if(!empty($_GET['poster'])) action="/admin/update-poster/{{$pst->id}}" @else action="/admin/create-poster" @endif method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="row clearfix">
                            @if(1 == 3)
                              <div class="col-sm-12">
                                <select class="form-control" id="dependent">
                                  <option value=""  @if(!isset($pst)) selected @endif>-- {{__('app.Independent')}} --</option>
                                  <option value="0" @if(isset($pst) && !empty($pst->prod_id)) selected @endif>{{__('app.Product')}}</option>
                                  <option value="1" @if(isset($pst) && !empty($pst->page_id)) selected @endif>{{__('app.Page')}}</option>
                                  <option value="2" @if(isset($pst) && !empty($pst->news_id)) selected @endif>{{__('app.News')}}</option>
                                </select>
                              </div>
                              <hr>
                              @endif
                              <input type="hidden" name="page_type" value="{{$_GET['type']}}">
                              <div class="col-sm-12">
                                @if($_GET['type'] !== "slide" && 1 == 2)
                                  <div class="form-group">
                                    <label for="product_name">{{__('app.Start_date')}}</label>
                                    <div class="form-line">
                                        <input type="date" name="start_date" class="form-control" @if(isset($pst)) @endif/>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="product_name">{{__('app.End_date')}}</label>
                                    <div class="form-line">
                                        <input type="date" name="end_date" class="form-control" @if(isset($pst)) @endif/>
                                    </div>
                                  </div>
                                  @endif
                                  <br>
                                  <div class="form-group">
                                    <label for="description">{{__('app.Title')}}</label>
                                    <div class="form-line">
                                        <input type="text" name="title" class="form-control" placeholder="{{__('app.Title')}}..." @if(isset($pst)) value="{{$pst->title}}" @endif>
                                    </div>
                                  </div>
                              </div>
                          </div>
                          @if($_GET['type'] === "slide")
                          <h2 class="card-inside-title">{{__('app.Details')}}</h2>
                          <div class="form-group">
                              <div class="form-line">
                                  <textarea rows="3" name="title" class="form-control no-resize auto-growth" placeholder="{{__('app.Details')}}...">@if(isset($pst)){{$pst->details}}@endif</textarea>
                              </div>
                          </div>
                          @endif
                          <div class="form-group">
                            <label for="images">{{__('app.Images')}}</label>
                            <input type="file" name="image" class="form-control" @if(empty($pst)) required @endif>
                          </div>
                          <div class="row clearfix">
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label for="product_name">{{__('app.Button_name')}} ({{__('app.If_it_has')}})</label>
                                <div class="form-line">
                                    <input type="text" name="button" id="btn_active" class="form-control" placeholder="{{__('app.Button_name')}}..." data-word="{{__('app.Link')}}" @if(isset($pst)) value="{{$pst->button}}" @endif/>
                                </div>
                              </div>
                            </div>
                          </div><hr>
                          <div class="demo-switch">
                              <div class="switch">
                                <input type="hidden" name="status" @if(isset($pst)) value="{{$pst->status}}" @else value="1" @endif>
                                <label>{{__('app.Not_active')}}<input type="checkbox" @if(isset($pst)) @if($pst->status == 1) checked @endif @else checked @endif><span class="lever"></span>{{__('app.Active')}}</label>
                              </div>
                          </div>
                          <div class="form-group">
                            <button type="submit" class="btn btn-primary pull-right">{{__('app.Update')}}</button>
                          </div>
                        </form>
                    </div>
                    @elseif(isset($_GET['page']))
                    <div class="body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{__('app.Title')}}</th>
                                    <th>{{__('app.Status')}}</th>
                                    <th>{{__('app.Image')}}</th>
                                    <th>{{__('app.Operations')}}</th>
                                </tr>
                            </thead>
                            <tbody id="poster_id">
                              @foreach($posters as $key => $poster)
                                <tr data-id="{{$poster->id}}">
                                    <th scope="row">{{$key + 1}}.</th>
                                    <td>{{$poster->title}}</td>
                                    <td>
                                      <div class="demo-switch">
                                          <div class="switch">
                                              <input type="hidden" name="status" @if($poster->status == 1) value="1" @else value="0" @endif>
                                              <label>{{__('app.Status')}}<input type="checkbox" id="poster_change" data-poster="{{$poster->id}}" @if($poster->status == 1) checked @endif><span class="lever"></span></label>
                                          </div>
                                      </div>
                                    </td>
                                    <td><img src="/uploads/posters/{{$poster->image}}" class="poster-list-img" alt="{{$poster->title}}"></td>
                                    <td class="list-btns">
                                      @php($typee = $poster->type == 0 ? "slide" : "poster")
                                      <a data-id="{{$poster->id}}" class="btn btn-danger delete"  data-toggle="modal" data-target="#slide_modal" data-text="{{__('app.Are_you_sure_to_delete_poster')}}" data-words="{{__('app.Delete_poster')}},{{__('app.Delete')}},{{__('app.Close')}}"><i class="fa fa-trash"></i></a>
                                      <a href="/{{Request::path()}}?type={{$typee}}&poster={{$poster->id}}" class="btn btn-success"><i class="fa fa-cog"></i></a>
                                    </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                        <a id="save_order" class="btn btn-primary pull-right"><i class="fa fa-save"></i> </a>
                    </div>
                    @endif
                    <div id="slide_modal" class="modal fade" role="dialog"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('foot')
<script type="text/javascript">
  var page = 'slide_control';
</script>
<script src="/adm/plugins/jquery/jquery.min.js"></script>
<script src="/adm/plugins/bootstrap/js/bootstrap.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<!-- <script src="/adm/plugins/bootstrap-select/js/bootstrap-select.js"></script> -->
<script src="/adm/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
<script src="/adm/plugins/node-waves/waves.js"></script>
<script src="/adm/plugins/autosize/autosize.js"></script>
<script src="/adm/plugins/momentjs/moment.js"></script>
<script src="/adm/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<script src="/adm/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="/adm/js/admin.js"></script>
<script src="/adm/js/pages/forms/basic-form-elements.js"></script>
@endsection
