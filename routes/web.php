<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Pages;
use App\News;


Route::get('/get-lang-list','Controller@get_langs');
Route::get('/error','Controller@error_page');
Route::get('/error-500','Controller@error_five_hundred');
Route::get('/','ProductController@index');
Route::get('/currency/{currency}','Controller@change_currency');

Route::get('/search-result/search={request}','DataController@searchedproducts');
Route::get('/get-search-result','DataController@searchedproducts_ajax');
Route::post('/subscribe','DataController@subscribe');

Route::get('/category/{slug}','DataController@category_page');
Route::get('/get-category-products','DataController@category_page_ajax'); // ajax
Route::get('/categories','DataController@get_all_categories');

Route::get('/brand/{brand?}','DataController@brand_function');
Route::get('/brands-list','DataController@brands_list');
// Route::get('/brand-list','BrandController@brand_list_store');
Route::post('/check-consistency','Controller@consistent_url');

Route::get('/product/{slug}','ProductController@get_product_details');
Route::get('/page/{slug}','PageController@page_view');
Route::get('/news/{slug}','PageController@news_view');
Route::get('/page/{slug}','PageController@page_view');
Route::get('/news-list','PageController@news_list');
Route::get('/contact-us','UserController@contact_us');
Route::post('/send-message','UserController@send_message');

Route::post('/add-new-comment','UserController@add_comment');
Route::get('/get-review-list','UserController@get_comments');

Route::post('/order-product','ProductController@order_now');
Route::get('/order-product/{slug}','ProductController@order_product_view');

Route::group(['prefix' => 'admin'], function(){
  Route::group(['middleware' => 'admin'],function(){

    Route::get('/get-tab-suggestions','ProductController@get_tab_sugg');

    Route::post('/mark-order-as-seen','OrderController@mark_as_read');

    Route::get('/','AdminController@index');
    Route::view('/profile','admin.profile');
    Route::get('/get-notification','DataController@get_notification_for_admin');
    Route::get('/add-loan/{slug}','ProductController@add_loan_view');
    Route::post('/add-new-loan','ProductController@add_new_loan');
    Route::post('/update-loan/{id}','ProductController@add_new_loan');
    Route::get('/delete-loan-type/{id}','ProductController@delete_loan');
    Route::get('/comment-list','AdminController@comment_list');
    Route::post('/boost-table','ProductController@boost_product');
    // Route::get('/create-page','AdminController@create_page_view');

    Route::get('/brands-list','BrandController@brand_list');
    Route::post('/update-brand-image','BrandController@create_brand');
    Route::post('/update-brand-status','BrandController@brand_status');
    // product control
    Route::post('/change-images-order','ProductController@change_im_order');
    Route::get('/edit-product/{id}','ProductController@add_product_view');
    Route::post('/update-products-tabs','ProductController@update_product_tabs');
    Route::post('/update-product/{id}','ProductController@add_product');
    Route::get('/products-tabs/{slug}','ProductController@add_prod_tabs');
    Route::get('/get-prod-tabs-ajax','ProductController@get_prod_tabs_ajax');
    Route::delete('/delete-prod-tab','ProductController@delete_prod_tab');
    Route::post('/add-new-product','ProductController@add_product');
    Route::get('/add-product','ProductController@add_product_view');
    Route::get('/product-list','ProductController@get_product_list');


    // category control
    Route::get('/delete-category/{id}','AdminController@delete_category');
    Route::get('/change-subcategory/{id}','AdminController@change_subcats');
    Route::get('/change-image-order/{type}/{slug}','ProductController@change_im_order_view');
    Route::delete('/delete-image','Controller@delete_image');

    Route::post('/add-new-category','AdminController@add_category');
    Route::get('/add-category','AdminController@add_category_view');
    Route::get('/categories-list','AdminController@add_category_view');
    Route::post('/update-category-order','AdminController@update_cat_order');

    //page section
    Route::get('/create-page','PageController@create_page_vew');
    Route::post('/create-new-page','PageController@create_page');
    Route::view('/page-list','admin.list',['pages' => Pages::all()]);
    Route::delete('/delete-page','PageController@delete_page');
    Route::get('/page-edit/{id}','AdminController@edit_page_view');
    Route::post('/edit-page/{id}','AdminController@edit_page');
    Route::post('/update-pg-head-foot','PageController@update_head_foot');
    Route::get('/get-page-details-for-edit','PageController@get_page_details_edit');
    Route::post('/update-page','PageController@update_page');
    Route::get('/page-tabs/{slug}','PageController@page_tabs');
    Route::post('/update-page-tabs','PageController@update_page_tabs');
    Route::get('/get-page-tabs-ajax','PageController@get_page_tabs_ajax');
    Route::delete('/delete-page-tab','PageController@delete_page_tab');


    //new section
    Route::get('/add-news','PageController@add_news_view');
    Route::post('/add-new-news','PageController@add_news');
    Route::view('/news-list','admin.list',['news' => News::all()]);
    Route::get('/news-edit/{id}','PageController@edit_news_view');
    Route::get('/delete-news/{id}','PageController@delete_news');
    Route::post('/edit-news/{id}','PageController@add_news');
    Route::post('/update-news-status','PageController@update_news_status');

    //slide and poster
    Route::get('/slide-and-poster','SlideController@slide_and_poster_view');
    Route::get('/get-slide-type-id','SlideController@get_slide_type');
    Route::post('/create-poster','SlideController@add_new_poster');
    Route::post('/update-slide-status','SlideController@update_slide_status');
    Route::get('/delete-poster/{id}','SlideController@delete_poster');
    Route::post('/admin/update-poster/{id}','SlideController@add_new_poster');

    //configuration section
    Route::get('/configuration','AdminController@configuration');
    Route::delete('/delete-configuration','AdminController@delete_conf');
    Route::post('/update-configuration','AdminController@configuration');
    Route::get('/translation','AdminController@translation');
    Route::post('/save-tr-file','AdminController@save_tr_file');
  });
  Route::group(['middleware' => 'secondadmin'],function(){
    Route::get('/users-list','AdminController@user_list');
    Route::get('/delete-product/{id}','Controller@delete_product');
    Route::get('/compress/images','ProductController@compress_all_images');
  });
  Route::group(['middleware' => 'mainadmin'],function(){
    Route::get('/testing','DataController@testing');
    Route::get('/get-file-data','AdminController@get_file_data');
    Route::post('/update-css-js','AdminController@update_css_js');
    Route::get('/code-view/{file}','AdminController@code_view');
    Route::get('/development','AdminController@development_page');

    Route::get('/update-all-category-slugs','AdminController@update_all_category_slugs');
  });
});

Route::group(['middleware' => 'auth'],function(){
  Route::delete('/delete-comment','UserController@delete_comment');
  Route::get('/profile', 'HomeController@index')->name('home');
  Route::get('/wishlist', 'UserController@wishlist');
  Route::post('/update-profile-data','UserController@update_profile');
  Route::post('/update-user-password','UserController@update_user_password');
  Route::post('/add-to-wishlist','UserController@add_wishlist');
  Route::get('/get-wishlist','UserController@get_wishlist');
  Route::get('/delete-wishlist','UserController@delete_wishlist');
  Route::post('/change-user-profile','UserController@change_profile');
});

Route::get('/update-latest-currency','Controller@currency_update');
// Auth::routes();

// Authentication Routes...
// Route::get('login', 'Auth\RegisterController@account_page')->name('login');
// Route::get('register', 'Auth\RegisterController@account_page')->name('register');
Route::get('/account','Auth\RegisterController@account_page');
Route::redirect('/login','/account?action=login');
Route::redirect('/register','/account?action=register');


Route::post('/forgot-password', 'Controller@forgot_password');
Route::post('/check-otp-code-availability','Controller@check_otp_code');
Route::post('/enter-new-password','Controller@change_password');


Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('register', 'Auth\RegisterController@register')->name('register');
Route::get('/logout/user', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
