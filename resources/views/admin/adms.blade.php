<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" type="image/x-icon" href="/img/icon.png" />
    @section('head')
    @show
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style media="screen">
    /* font-display: block; */

      .card .header h2 small a{
        cursor: pointer;
        color: #03a9f4;
      }
      .notify{
        color: white;
        font-weight: bold;
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 17px;
        z-index: 1000;
      }
      .notify-success{
        background: #00adff;
      }
      .notify-danger{
        background: #e31e25;
      }
      .notify a{
        margin-left: 10px;
        display: inline-block;
        color: white;
        opacity: 0.9;
        font-weight: 100;
      }
      .words tr td input,
      .words tr td textarea{
        /* height: 32px; */
        padding: 10px;
        width: 95%;
        height: 100%;
        border-radius: 7px;
        border: none;
        box-shadow: 0 0 6px 0px #cccccc;
      }
      .btns-section{
        width: 90%;
        /* margin-top: 20px; */
        margin: 16px auto 10px auto;
        height: fit-content;
        border-bottom: 1px solid #eeeeee;
      }
      .btns-section div{
        margin: 5px 0 10px 0;
        display: block;
      }
      .btns-section a{
        background: #18b5e4;
        padding: 10px;
        display: inline-block;
        cursor: pointer;
        color: white;
        box-shadow: 0 0 5px 1px #cccccc;
        text-decoration: none;
        margin-left: 2px;
      }
      .btns-section a:hover,
      .btns-section a.active,
      .btns-section a:focus,
      .btns-section a:active{
        background: #137f9e;
      }
      .btn{
        padding: 8px 25px 8px 25px;
        min-height: 38px;
        cursor: pointer;
      }
      .modal-input-list{
        margin-top: 10px;
      }
      .modal-input-list textarea,.modal-input-list input{
        display: block;
        width: 90%;
        border-radius: 6px;
        border: 1px solid #d4d4d4;
        padding: 10px;
      }
      .modal-input-list input{
        height: 38px;
      }
      .modal-input-list label{
        display: block;
      }
      .image-list li{
        list-style-type:none;
        border: 1px solid #e0dfdf;
        padding: 5px;
      }
      .image-list li img{
        height: 183px;
        border: 1px solid #bb9e9e;
        margin: auto;
        display: block;
      }
      .user-prof-image img{
        width: 120px;
      }
      input.tab_inputs{
        width: 100%;
        height: 47px;
        padding: 10px;
        box-shadow: 0 0 3px 1px #cccccc;
        border: none;
      }
      textarea.tab_inputs{
        resize:vertical;
        height: 118px;
        width: 100%;
        padding: 10px;
        box-shadow: 0 0 3px 1px #cccccc;
        border: none;
      }
      .read_more{
        cursor: pointer;
      }
      .modal .modal-header{
        border-bottom: 1px solid #e4e4e4;
      }
      .modal .modal-footer{
        border-top:1px solid #e4e4e4;
      }
      .input-grp input, .input-grp select{
        border: 1px solid #dddddd !important;
        height: 43px;
        border-radius: 10px !important;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        padding-left: 20px !important;
      }
      .input-grp select{
        margin-bottom: 20px;
      }
      #code_review{
        width: 100%;
        height: -webkit-fill-available;
        padding: 7px;
        border: none;
        background: #050505;
        color: #d5d3d3;
        border-radius: 4px;
        box-shadow: 0 0 4px 2px grey;
      }
      .txt_replacer{
        display: block;
        margin-top: 13px;
        margin-bottom: 13px;
      }
      .txt_replacer .rp_item{
        display: inline-block;
      }
      .txt_replacer .rp_item label{
        color: gray;
        font-weight: normal;
        display: inline-block;
      }
      .txt_replacer .rp_item input{
        padding-left: 9px;
          border-radius: 6px;
          border: 1px solid #dddddd;
          color: #065187;
      }
      .txt_replacer .rp_item input[type='checkbox']{
        position: static;
        opacity: 1;
        font-size: 50px;
      }
      .txt_replacer .rp_btns{
        display: inline-block;
      }
      .txt_replacer .rp_btns a{
        background: #08c5e5;
        color: white;
        padding: 7px;
        border-radius: 4px;
        font-size: 11px;
      }
      .static-search{
        width: 100%;
        height: 42px;
        padding: 14px;
        border-radius: 10px;
        border: none;
        box-shadow: 0 0 7px -1px #cccccc;
      }
      ul{
        list-style-type: none;
      }
      .lock-scroll {
        overflow: hidden;
      }
      .deleting_img{
        margin: auto;
        width: 40%;
        display: block;
      }
      .btn_t{
        padding: 10px;
        color: white;
        cursor: pointer;
        /* border: 1px solid #e8e4e4; */
      }
      .btn_t.active{
        border-bottom: 4px solid #6d1a1a;
      }
      .urls-slide{
        margin-top: 10px !important;
      }
      .urls-slide a{
        font-size: 12px;
        border: 1px solid #d8d7d7;
        padding: 5px;
        text-decoration: none;
      }
      .urls-slide a.active{
        color: white !important;
            background: #08a8f4;
            border-color: #08a8f4;
      }
      .poster-list-img{
        width: 54px;
      }
      .brand_img_display{
        max-width: 100px;
        margin-bottom: 10px;
      }
      .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /* top: 100%; */
        left: 50px;
        right: 0;
        width: 311px;
        max-height: 160px;
        overflow: overlay;
      }

      .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
      }

      /*when hovering an item:*/
      .autocomplete-items div:hover {
        background-color: #e9e9e9;
      }

      /*when navigating through the items using the arrow keys:*/
      .autocomplete-active {
        background-color: DodgerBlue !important;
        color: #ffffff;
      }
      .btn-success-active{
        background: #0f580f !important;
      }
    </style>
</head>
<body class="theme-red">
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>{{__('app.Please_wait')}}</p>
        </div>
    </div>
    <div class="overlay"></div>
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="/admin">{{config("settings.admin_title")}}</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">{{__('app.Notifications')}}</li>
                            <li class="body"><ul class="menu" id="notify_section"></ul></li>
                            <li class="footer"><a id="show_more_notification">{{__('app.More')}}</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section>
        <aside id="leftsidebar" class="sidebar">
            <div class="user-info">
                <div class="image pimg">
                    <img data-src="/uploads/avatars/{{Auth::user()->avatar}}" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}} {{Auth::user()->surname}}</div>
                    <div class="email">{{Auth::user()->email}}</div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="/admin/profile"><i class="material-icons">person</i>Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('logout') }}"
            									 onclick="event.preventDefault();
            																 document.getElementById('logout-form').submit();"><i class="material-icons">input</i> {{__('app.Logout')}}</a></li>

            								<form id="logout-form" action="/logout/user" method="GET" style="display: none;">
            										@csrf
            								</form>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="menu">
                <ul class="list">
                    <li class="header">{{__('app.Main_navigation')}}</li>
                    <li @if(Request::is('admin')) class="active" @endif>
                        <a href="/admin">
                            <i class="material-icons">home</i>
                            <span>{{__('app.Home')}}</span>
                        </a>
                    </li>
                    <li @if(Request::is('admin/slide-and-poster')) class="active" @endif>
                        <a href="/admin/slide-and-poster?type=poster">
                            <i class="material-icons">slideshow</i>
                            <span>{{__('app.Slide_and_poster')}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">format_list_bulleted</i>
                            <span>{{__('app.List')}}</span>
                        </a>
                        <ul class="ml-menu">
                            <li @if(Request::is('admin/product-list')) class="active" @endif>
                                <a href="/admin/product-list">{{__('app.Product_list')}}</a>
                            </li>
                            <li @if(Request::is('admin/categories-list')) class="active" @endif>
                                <a href="/admin/categories-list">{{__('app.Category_list')}}</a>
                            </li>
                            <li @if(Request::is('admin/page-list')) class="active" @endif>
                                <a href="/admin/page-list">{{__('app.Page_list')}}</a>
                            </li>
                            <li @if(Request::is('admin/news-list')) class="active" @endif>
                                <a href="/admin/news-list">{{__('app.News_list')}}</a>
                            </li>
                            <li @if(Request::is('admin/users-list')) class="active" @endif>
                                <a href="/admin/users-list">{{__('app.User_list')}}</a>
                            </li>
                            <li @if(Request::is('admin/comment-list')) class="active" @endif>
                                <a href="/admin/comment-list">{{__('app.Comment_list')}}</a>
                            </li>
                            <li @if(Request::is('admin/brands-list')) class="active" @endif>
                              <a href="/admin/brands-list">{{__('app.Brand_list')}}</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">add_circle_outline</i>
                            <span>{{__('app.Add')}}</span>
                        </a>
                        <ul class="ml-menu">
                            <li @if(Request::is('admin/add-product')) class="active" @endif>
                                <a href="/admin/add-product">{{__('app.Add_new_product')}}</a>
                            </li>
                            <li @if(Request::is('admin/add-category')) class="active" @endif>
                                <a href="/admin/add-category">{{__('app.Add_new_category')}}</a>
                            </li>
                            <li @if(Request::is('admin/create-page')) class="active" @endif>
                                <a href="/admin/create-page">{{__('app.Create_page')}}</a>
                            </li>
                            <li @if(Request::is('admin/add-news')) class="active" @endif>
                                <a href="/admin/add-news">{{__('app.Add_news')}}</a>
                            </li>
                            @if(isDev())
                            <li @if(Request::is('admin/add-user')) class="active" @endif>
                                <a href="/admin/add-user">{{__('app.Add_new_user')}}</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @if(isSecAdmin())
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">add_circle_outline</i>
                            <span>Static</span>
                        </a>
                        <ul class="ml-menu">
                            <li @if(Request::is('admin/translation')) class="active" @endif>
                              <a href="/admin/translation">
                                  <span>{{__('app.Translation')}}</span>
                              </a>
                            </li>
                            <li @if(Request::is('admin/configuration')) class="active" @endif>
                                <a href="/admin/configuration">
                                  <span>{{__('app.Configuration')}}</span>
                                </a>
                            </li>
                            @if(isDev())
                            <li @if(Request::is('admin/development')) class="active" @endif>
                                <a href="/admin/development">
                                  <span>Development</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if(isSecAdmin())
                    <li>
                        <a href="/admin/seo-improvement">
                            <i class="material-icons">grade</i>
                            <span>SEO</span>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="/">
                            <i class="material-icons">arrow_back</i>
                            <span>{{__('app.Back_to_store')}}</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="legal">
                <div class="copyright">
                    &copy; {{date('Y')}} <a href="/">{{config("settings.admin_title")}}</a>
                </div>
            </div>
        </aside>
    </section>
    @if(session()->has('message'))
  			<div class="notify notify_0 notify-{{session()->get('type') }}">
  				<a href="#" class="close">&times;</a>
  					{{ session()->get('message') }}
  			</div>
  	@endif
    @section('body')
    @show
    <script src="//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @section('foot')
    @show
    <script src="/adm/js/demo.js?v={{md5(microtime())}}"></script>

</body>

</html>
