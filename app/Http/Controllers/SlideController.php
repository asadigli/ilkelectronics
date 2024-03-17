<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posters;
use Lang;
// use App\Products;
// use App\News;
// use App\Pages;
use DB;
use Auth;
use File;
class SlideController extends Controller
{
    public function slide_and_poster_view(){
      $tp = 0;
      if (isset($_GET['page']) && isset($_GET['tp'])) {
        $tp = $_GET['tp'] === 'posters' ? 1 : 0;
      }
      $posters = Posters::where('type',$tp)->orderBy('order','asc')->get();
      return view('admin.slide',compact('posters'));
    }
    public function delete_poster($id){
      $ps = Posters::find($id);
      if(File::exists('uploads/posters/'.$ps->image)) {File::delete('uploads/posters/'.$ps->image);}
      $ps->delete();
      return redirect()->back()->with(['message' => Lang::get('app.Poster_deleted'),'type' => 'danger']);
    }
    public function update_slide_status(Request $req){
      if (!isset($req->array)) {
        $ps = Posters::find($req->id);
        if ($ps->status == 1) {
          $ps->status = 0;
        }else{
          $ps->status = 1;
        }
        $ps->update();
      }else{
        $cnt = count($req->array);
        for ($i=0; $i < $cnt; $i++) {
          $pss = Posters::find($req->array[$i]['value']);
          if (!empty($pss)) {
            $pss->order = $req->array[$i]['key'];
            $pss->update();
          }
        }
      }
      return response()->json(['mess' => Lang::get('app.Poster_status_updated'),'array' => $req->array[0]['value']]);
    }
    public function get_slide_type(Request $req){
      if ($req->type == 0) {
        $data = DB::select("SELECT id,productname as name,prod_id FROM products");
      }else if ($req->type == 1) {
        $data = DB::select("SELECT id,shortname as name FROM pages");
      }else{
        $data = DB::select("SELECT id,SUBSTRING(title,1,20) as name FROM news");
      }
      return response()->json(['data' => $data]);
    }
    public function add_new_poster(Request $req,$id = null){
      $ps_s = Posters::find($id);
      if (!isset($ps_s) || empty($ps_s)) {
        $ps = new Posters;
      }else{
        $ps = Posters::find($id);
      }
      $ps->author = Auth::user()->id;
      if (in_array($req->page_type,["slide","poster"])) {
        if ($req->page_type === "slide") {
          $ps->type = 0;
          $a = 1200;$b = 400;
        }else{
          $ps->type = 1;
          $a = 420;$b = 700;
        }
      }else{exit();}
      if (isset($req->page_id) && !empty($req->page_id)) {
        $ps->page_id = $req->page_id;
      }elseif(isset($req->news_id) && !empty($req->news_id)){
        $ps->news_id = $req->news_id;
      }elseif(isset($req->prod_id) && !empty($req->prod_id)){
        $ps->prod_id = $req->prod_id;
      }
      $ps->title = $req->title;
      $ps->details = $req->details;
      $ps->status = $req->status;
      $ps->start_date = $req->start_date;
      $ps->end_date = $req->end_date;
      if (!empty($req->button) && !empty($req->button_type) && !empty($req->button_href)) {
        $ps->button = $req->button;
        $ps->button_type = $req->button_type;
        $ps->button_href = $req->button_href;
      }
      if ($req->hasFile('image')) {
        $folder = 'uploads/posters/';
        $picture = $req->image;
        $ext=$picture->getClientOriginalExtension();
        if($ext=='jpg' || $ext=='png' || $ext=='jpeg' || $ext=='bmp')  {
           $filename=time()+random_int(1, 100000000).'.'.$picture->getClientOriginalExtension();
           $picture->move(public_path($folder),$filename);
        }
        resize($folder.$filename, $folder.$filename, $a, $b);
        $ps->image = $filename;
      }
      if (!isset($ps_s) || empty($ps_s)) {
        $ps->save();
        $url = '/admin/slide-and-poster?type='.$req->page_type;
      }else{
        $ps->update();
        $url = '/admin/slide-and-poster?type='.$req->page_type."&poster".$id;
      }
      return redirect($url)->with(['type' => 'success', 'message' => Lang::get('app.Poster_added')]);
    }
}
