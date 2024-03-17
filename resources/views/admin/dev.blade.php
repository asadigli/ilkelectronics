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
<title>Development - {{conf("admin_title")}}</title>
@endsection
@section('body')
<section class="content">
    <div class="container-fluid">
        <div class="block-header"><h2>Development</h2></div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Development
                            <small class="url-link"></small>
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
                          <h2 class="card-inside-title">Development</h2>
                          <div class="row clearfix">
                             <div class="col-sm-12">
                                 <select class="form-control show-tick" id="select_file">
                                     <option value="ms.css">master.css</option>
                                     <option value="ms.js">master.js</option>
                                 </select>
                             </div>
                          </div>
                          <h2 class="card-inside-title">Code</h2>
                          <div class="form-group">
                              <div class="form-line">
                                  <textarea name="description" id="code_review" placeholder="{{__('app.Description')}}"><h2>test</h2></textarea>
                                  <div class="txt_replacer">
                                      <div class="rp_item">
                                        <label for="termSearch">Search</label>
                                        <input type="text" id="termSearch" name="termSearch" placeholder="First word..." />
                                      </div>
                                      <div class="rp_item">
                                        <label for="termReplace">Replace</label>
                                        <input type="text" id="termReplace" name="termReplace" placeholder="Second word..."/>
                                      </div>
                                      <div class="rp_item">
                                        <label for="caseSensitive">Case Sensitive</label>
                                        <input type="checkbox" name="caseSensitive" id="caseSensitive" />
                                      </div>
                                      <div class="rp_btns">
                                        <a href="#" onclick="SAR.find(); return false;" id="find">FIND</a>
                                        <a href="#" onclick="SAR.findAndReplace(); return false;" id="findAndReplace">FIND/REPLACE</a>
                                        <a href="#" onclick="SAR.replaceAll(); return false;" id="replaceAll">REPLACE ALL</a>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="demo-switch">
                              <div class="switch">
                                  <label>{{__('app.Not_active')}}<input type="checkbox" name="status" checked value="1"><span class="lever"></span>{{__('app.Active')}}</label>
                              </div>
                          </div>
                          <div class="form-group">
                            <button class="btn btn-primary pull-right" title="{{__('app.Save')}}" id="save_code" style="display:none;"><i class="fa fa-save"></i></button>
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
  var page = 'dev';
</script>
<script src="/adm/plugins/jquery/jquery.min.js"></script>
<script src="/adm/plugins/bootstrap/js/bootstrap.js"></script>
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
