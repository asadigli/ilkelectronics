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
<title>{{__('app.Brand_list')}} - {{conf("admin_title")}}</title>
@endsection
@section('body')
<section class="content">
    <div class="container-fluid">
        <div class="block-header"><h2>{{__('app.Brand_list')}}</h2></div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header"><h2>
                      {{__('app.Brand_list')}}
                    </h2></div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable">
                                <thead id="copy_to_tfoot">
                                    <tr>
                                      <td>{{__('app.Brand_image')}}</td>
                                      <td>{{__('app.Brand')}}</td>
                                      <td>{{__('app.Status')}}</td>
                                    </tr>
                                </thead>
                                <tfoot></tfoot>
                                <tbody>
                                  @foreach($brands as $k => $brand)
                                    <tr>
                                      <td>
                                        <img @if($brand->id != 0) src="/uploads/brands/{{$brand->image}}" @else style="display:none"  @endif class="brand_img_display show_{{$k}}">
                                        <input type="file" class="brand_image" data-src="{{$k}}" data-id="{{$brand->id}}" data-brand="{{$brand->brand}}">
                                      </td>
                                      <td>
                                        {{$brand->brand}}
                                      </td>
                                      <td>
                                        <div class="switch">
                                            <input type="hidden" class="brand_status stat_{{$k}}" value="{{$brand->status}}">
                                            <label><input type="checkbox" class="update_brand_stat" @if($brand->status != 0) checked @endif data-id="{{$brand->id}}"><span class="lever switch-col-blue"></span></label>
                                        </div>
                                      </td>
                                    </tr>
                                  @endforeach
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
