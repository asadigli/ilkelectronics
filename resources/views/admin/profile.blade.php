@extends('admin.adms')
@section('head')
<title>{{Auth::user()->name}} {{Auth::user()->surname}} - {{conf("admin_title")}}</title>
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<link href="/adm/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/adm/plugins/node-waves/waves.css" rel="stylesheet" />
<link href="/adm/plugins/animate-css/animate.css" rel="stylesheet" />
<link href="/adm/css/style.css" rel="stylesheet">
<link href="/adm/css/themes/all-themes.css" rel="stylesheet" />
@endsection
@section('body')
    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-3">
                    <div class="card profile-card">
                        <div class="profile-header">&nbsp;</div>
                        <div class="profile-body">
                            <div class="image-area user-prof-image pimg">
                                <img data-src="/uploads/avatars/{{Auth::user()->avatar}}" alt="{{Auth::user()->name}} {{Auth::user()->surname}}" />
                            </div>
                            <div class="content-area">
                                <h3>{{Auth::user()->name}} {{Auth::user()->surname}}</h3>
                                <p>
                                  @if(Auth::user()->role_id == 2) Admin
                                  @elseif(Auth::user()->role_id == 3)
                                  Baş admin
                                  @else
                                  Developer
                                  @endif
                                </p>
                            </div>
                        </div>
                        <!-- <div class="profile-footer">
                            <button class="btn btn-primary btn-lg waves-effect btn-block">FOLLOW</button>
                        </div> -->
                    </div>
                </div>
                <div class="col-xs-12 col-sm-9">
                    <div class="card">
                        <div class="body">
                            <div>
                                <ul class="nav nav-tabs profile-set-section" role="tablist">
                                    <li role="presentation"><a href="#profile_settings" aria-controls="settings" role="tab" data-toggle="tab">{{__('app.Account_settings')}}</a></li>
                                    <li role="presentation"><a href="#change_password" aria-controls="settings" role="tab" data-toggle="tab">{{__('app.Change_password')}}</a></li>
                                    <li role="presentation"><a href="#change_image" aria-controls="settings" role="tab" data-toggle="tab">{{__('app.Change_profile_picture')}}</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in" id="profile_settings">
                                        <form class="form-horizontal" action="/update-profile-data" method="POST">
                                          @csrf
                                            <div class="form-group">
                                                <label for="NameSurname" class="col-sm-2 control-label">{{__('app.Name')}}</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="name" placeholder="{{__('app.Name')}}..." value="{{Auth::user()->name}}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="NameSurname" class="col-sm-2 control-label">{{__('app.Surname')}}</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="surname" placeholder="{{__('app.Surname')}}..." value="{{Auth::user()->surname}}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="Email" class="col-sm-2 control-label">{{__('app.E_mail')}}</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <input type="email" class="form-control" name="email" placeholder="{{__('app.E_mail')}}..." value="{{Auth::user()->email}}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="Email" class="col-sm-2 control-label">{{__('app.Phone')}}</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="phone" placeholder="{{__('app.Phone')}}..." value="{{Auth::user()->phone}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="Email" class="col-sm-2 control-label">{{__('app.Birthdate')}}</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <input type="date" class="form-control" name="birthdate" @if(!empty(Auth::user()->birthdate)) value="{{\Carbon\Carbon::parse(Auth::user()->birthdate)->format('Y-m-d')}}" @endif max="{{date('Y-m-d',strtotime('-13 year',time()))}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" class="btn btn-primary">{{__('app.Update')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade in" id="change_password">
                                        <form class="form-horizontal" action="/update-user-password" method="POST">
                                          @csrf
                                            <div class="form-group">
                                                <label for="OldPassword" class="col-sm-3 control-label">{{__('app.Old_password')}}</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" name="password" id="current-password" placeholder="{{__('app.Old_password')}}..." autocomplete="off" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="NewPassword" class="col-sm-3 control-label">{{__('app.New_password')}}</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="{{__('app.New_password')}}..." autocomplete="off" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="NewPasswordConfirm" class="col-sm-3 control-label">{{__('app.New_password')}} ({{__('app.Confirm')}})</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="{{__('app.Confirm')}}..." autocomplete="off" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9">
                                                    <button type="submit" class="btn btn-primary">{{__('app.Update')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade in" id="change_image">
                                        <form class="form-horizontal" id="img_up_form" action="/change-user-profile" method="POST" enctype="multipart/form-data">
                                          @csrf
                                            <div class="form-group">
                                                <label for="NewPasswordConfirm" class="col-sm-3 control-label">{{__('app.Choose_image')}} </label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="file" class="form-control" name="user_image" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9">
                                                    <button type="submit" class="btn btn-primary">{{__('app.Update')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
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
  var page = 'profile';
</script>
<script src="/adm/plugins/jquery/jquery.min.js"></script>
<script src="/adm/plugins/bootstrap/js/bootstrap.js"></script>
<script src="/adm/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script src="/adm/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
<script src="/adm/plugins/node-waves/waves.js"></script>
<script src="/adm/js/admin.js"></script>
<script src="/adm/js/pages/examples/profile.js"></script>
@endsection
