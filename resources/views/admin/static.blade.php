@extends('admin.adms')
@section('head')
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<link href="/adm/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/adm/plugins/node-waves/waves.css" rel="stylesheet" />
<link href="/adm/plugins/animate-css/animate.css" rel="stylesheet" />
<link href="/adm/css/style.css" rel="stylesheet">
<link href="/adm/css/themes/all-themes.css" rel="stylesheet" />
@if(Request::is('admin/translation'))
<title>{{__('app.Translation')}} - {{conf("admin_title")}}</title>
@else
<title>{{__('app.Configuration')}} - {{conf("admin_title")}}</title>
@endif
@endsection
@section('body')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>{{__('app.Translation')}}</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                {{__('app.Translation')}}
                                <small><b></b><b></b></small>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        @if(Request::is('admin/translation'))
                        <div id="addNewWord" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">{{__('app.Add_new_word')}}</h4>
                              </div>
                              <div class="modal-body">
                                <div class="modal-input-list">
                                  <label for="">Index</label>
                                  <input type="text" id="index" placeholder="Index...">
                                </div>
                                <div class="modal-input-list">
                                  <label for="">{{__('app.Translation')}}</label>
                                  <textarea id="word_translate" placeholder="{{__('app.Translation')}}..."></textarea>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('app.Close')}}</button>
                                <button type="button" class="btn btn-primary addnew_w">{{__('app.Add')}}</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="btns-section">
                          <div>
                            @for($i=0;$i<count($dirs);$i++)
                            <a class="folder_name" data-id="{{$dirs[$i]}}">{{$dirs[$i]}}</a>
                            @endfor
                          </div>
                          <div id="exist_files"></div>
                        </div>
                        @else
                        <div id="newConfig" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">{{__('app.Add_new_configuration')}}</h4>
                              </div>
                              <div class="modal-body">
                                <div class="form-group input-grp">
                                  <label for="">{{__('app.Choose_type')}}</label>
                                  <select class="form-control" name="input_type" data-words="{{__('app.Value')}},{{__('app.Not_true_value')}},{{__('app.First_text')}},{{__('app.Second_text')}},Index">
                                    <option selected disabled>{{__('app.Select')}}</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="text_input">Text input</option>
                                    <option value="number_input">Number input</option>
                                    <option value="radio_input">Radio button</option>
                                  </select>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <a class="btn btn-default" data-dismiss="modal">{{__('app.Close')}}</a>
                                <a class="btn btn-primary add_new_conf">{{__('app.Add')}}</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        @endif
                        <div class="body table-responsive">
                            <input type="text" class="static-search" placeholder="{{__('app.Search')}}..." id="search_id" style="display:none;">
                            <table class="table table-striped">
                                <thead id="t_head"><tr><th>#</th><th>Index</th><th>{{__('app.Value')}}</th><th>{{__('app.Operations')}}</th></tr></thead>
                                <tbody class="words" id="words_id"></tbody>
                            </table>
                            <div class=" pull-right">
                              <a class="btn btn-primary add_new_w" data-toggle="modal" @if(Request::is('admin/translation')) data-target="#addNewWord" @else data-target="#newConfig" @endif style="display:none;" title="{{__('app.Add')}}"><i class="fa fa-plus"></i> </a>
                              <a class="btn btn-primary" id="save_files" style="display:none;" title="{{__('app.Save')}}"><i class="fa fa-save"></i></a>
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
  var page = 'static';
</script>
    <script src="/adm/plugins/jquery/jquery.min.js"></script>
    <script src="/adm/plugins/bootstrap/js/bootstrap.js"></script>
    @if(!Request::is('admin/configuration'))
    <script src="/adm/plugins/bootstrap-select/js/bootstrap-select.js"></script>
    @endif
    <script src="/adm/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <script src="/adm/plugins/node-waves/waves.js"></script>
    <script src="/adm/js/admin.js"></script>
@endsection
