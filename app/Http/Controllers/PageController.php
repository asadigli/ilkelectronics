<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pages;
use App\News;
use DB;
use Lang;
use Auth;
use Image;
use App\Images;
use App\Protab;
class PageController extends Controller
{
    public function page_view($slug){
      $page = Pages::where('slug',$slug)->first();
      if ($page) {
        return view('page',compact('page'));
      }else{
        return redirect('/error')->with(['error_message' => Lang::get('app.Page_you_looking_not_found')]);
      }
    }
    public function page_tabs($slug){
      $page = Pages::where('slug',$slug)->first();
      return view('admin.add_product',compact('page'));
    }
    public function update_page_tabs(Request $req){
      $arr = $req->list;
      for ($i=0; $i < count($arr); $i++) {
        $pt_check = Protab::find($arr[$i]["id"]);
        if (!isset($pt_check) | empty($pt_check)) {
          $pt = new Protab;
        }else{
          $pt = Protab::find($arr[$i]["id"]);
        }
        $pt->page_id = $req->main_id;
        if (!empty($arr[$i]["title"]) && !empty($arr[$i]["desc"])) {
          $pt->title = $arr[$i]["title"];
          $pt->description = $arr[$i]["desc"];
          $pt->order = $arr[$i]["index"];
          if (!isset($pt_check) | empty($pt_check)) {
            $pt->save();
          }else{
            $pt->update();
          }
        }
      }
      return response()->json(['message' => Lang::get('app.Tab_updated')]);
    }
    public function get_page_tabs_ajax(Request $req){
      $pts = Protab::where('page_id',$req->main_id)->orderBy('order','ASC')->get();
      return response()->json(['pts' => $pts]);
    }
    public function delete_page_tab(Request $req){
      $pt = Protab::find($req->id);
      if (!empty($pt)) {
        $pt->delete();
      }
      return response()->json(['message' => Lang::get('app.Tab_deleted')]);
    }
    public function get_page_details_edit(Request $req){
      $page = Pages::find($req->id);
      $pages = Pages::all();
      return response()->json(['page' => $page,'pages' => $pages]);
    }
    public function delete_page(Request $req){
      $page = Pages::find($req->id);
      $page->delete();
      return response()->json(['message' => Lang::get('app.Page_deleted')]);
    }
    public function update_page(Request $req){
      $this->validate($req,[
        'title' => 'min:2|required',
        'body' => 'min:2|required',
        'shortname' => 'min:2|required',
      ]);
      $pg = Pages::find($req->id);
      $pg->title = $req->title;
      $pg->parent_id = $req->parent_id;
      $pg->shortname = $req->shortname;
      $pg->body = $req->body;
      $pg->footer_type = $req->footer_type;
      if ($pg->slug !== $req->slug) {
        if (empty($req->slug)) {
          $pg->slug = make_slug($req->title);
        }else{
          $pg->slug = make_slug($req->slug);
        }
      }
      $pg->update();
      return response()->json(['success' =>Lang::get('app.Page_updated')]);
    }
    public function news_view($slug){
      $news_unique = News::where('slug',$slug)->first();
      if ($news_unique) {
        return view('news',compact('news_unique'));
      }else{
        return redirect('/error')->with(['error_message' => Lang::get('app.News_you_looking_not_found')]);
      }
    }
    public function news_list(){
      $news = News::where('status',1)->orderBy('created_at','desc')->paginate(6);
      return view('news',compact('news'));
    }
    public function add_news_view(){
      return view('admin.create');
    }
    public function add_news(Request $req,$id = null){
      $this->validate($req,[
        'title' => 'min:2|required',
        'body' => 'min:2|required',
        'status' => 'integer|min:0|max:1',
      ]);
      $ns = News::find($id);
      $ns_1 = $ns;
      if (!isset($ns) | empty($ns)) {
        $ns = new News;
      }
      $ns->creator = Auth::user()->id;
      $ns->title = $req->title;
      $ns->body = $req->body;
      if (!isset($ns) | empty($ns_1)) {
        if (empty($req->slug)) {
          $ns->slug = make_slug($req->title);
        }else{
          $ns->slug = make_slug($req->slug);
        }
      }else{
        if (!empty($req->slug) && $ns->slug !== $req->slug) {
          $ns->slug = make_slug($req->slug);
        }
      }
      $ns->status = $req->status;
      if (!isset($ns) | empty($ns_1)) {
        $ns->save();
        $mess = Lang::get('app.News_added');
      }else{
        $ns->update();
        $mess = Lang::get('app.News_updated');
      }
      if ($req->hasFile('images')) {
        $imgArr=[];
        $folder = 'uploads/news/';
        foreach ($req->images as $picture) {
            $ext=$picture->getClientOriginalExtension();
            if($ext=='jpg' || $ext=='png' || $ext=='jpeg' || $ext=='bmp')  {
                $filename=time()+random_int(1, 100000000).'.'.$picture->getClientOriginalExtension();
                $picture->move(public_path($folder),$filename);
                array_push($imgArr,$filename);
          }
        }
        for ($i=0; $i < count($imgArr); $i++) {
            $img_name = $imgArr[$i];
            resize($folder.$img_name, $folder.$img_name, 1200, 675);
            logo_on_image($folder.$img_name,'img/logo-transparent.png',$folder.$img_name);
            $img = new Images;
            $img->news_id = $ns->id;
            $img->image = $img_name;
            $img->save();
        }
      }
      update_sitemap();
      return redirect()->back()->with(['type'=>'success','message'=> $mess]);
    }
    public function update_news_status(Request $req){
      $this->validate($req,[
        'news' => 'required',
        'status' => 'required'
      ]);
      $ns = News::find($req->news);
      $ns->status = $req->status;
      $ns->update();
      return response()->json(['message' => Lang::get('app.News_status_updated')]);
    }
    public function edit_news_view($id){
      $news = News::find($id);
      return view('admin.create',compact('news'));
    }
    public function delete_news($id){
      $news = News::find($id);
      $news->delete();
      return redirect()->back()->with(['message' => Lang::get('app.News_deleted'),'type' => 'danger']);
    }
    // public function edit_news(Request $req,$id){
    //
    // }


    public function create_page_vew(){
      $pages = Pages::whereNull('parent_id')->orWhere('parent_id',0)->get();
      return view('admin.create_page',compact('pages'));
    }
    public function update_head_foot(Request $req){
      $sql = "UPDATE pages SET ".$req->tp." = ".$req->tp_val." WHERE id = ".$req->page;
      $update = DB::select($sql);
      if ($update) {
        $mess = Lang::get('app.Page_updated');
      }else{
        $mess = "Failed";
      }
      return response()->json(['message' => $mess,'tp' => $update]);
    }
    public function create_page(Request $req){
      $pg = new Pages;
      $pg->parent_id = $req->parent_id;
      $pg->creator = Auth::user()->id;
      if (empty($req->slug)) {
        $pg->slug = make_slug($req->title);
      }else{
        $pg->slug = make_slug($req->slug);
      }
      $pg->shortname = $req->shortname;
      $pg->title = $req->title;
      $pg->body = $req->body;
      $pg->status = $req->status;
      $pg->footer = $req->footer;
      $pg->footer_type = $req->footer_type;
      $pg->header = $req->header;
      $pg->save();
      if ($req->hasFile('images')) {
        $imgArr=[];
        $folder = 'uploads/pages/';
        foreach ($req->images as $picture) {
            $ext=$picture->getClientOriginalExtension();
            if($ext=='jpg' || $ext=='png' || $ext=='jpeg' || $ext=='bmp')  {
                $filename=time()+random_int(1, 100000000).'.'.$picture->getClientOriginalExtension();
                $picture->move(public_path($folder),$filename);
                array_push($imgArr,$filename);
          }
        }
        for ($i=0; $i < count($imgArr); $i++) {
            $img_name = $imgArr[$i];
            resize($folder.$img_name, $folder.$img_name, 1200, 675);
            logo_on_image($folder.$img_name,'img/logo-transparent.png',$folder.$img_name);
            $img = new Images;
            $img->page_id = $pg->id;
            $img->image = $img_name;
            $img->save();
        }
      }
      update_sitemap();
      return redirect()->back()->with(['type' => 'success', 'message' => Lang::get('app.Page_created')]);
    }
    public function create_page_view(){return view('admin.create_page');}

}
