<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Lang;
use Hash;
use App\Comments;
use App\Wishlist;
use App\Products;
use DB;
use Image;use File;
use App\Contact;
class UserController extends Controller
{
    public function change_profile(Request $req){
      $this->validate($req, [
        'user_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);
      $mess = "Failed";
      if ($req->hasFile('user_image')) {
        $us = Auth::user();
        $folder = 'uploads/avatars/';
        $picture = $req->user_image;
        $ext=$picture->getClientOriginalExtension();
        if($ext=='jpg' || $ext=='png' || $ext=='jpeg' || $ext=='bmp')  {
           $filename=time()+random_int(1, 100000000).'.'.$picture->getClientOriginalExtension();
           $picture->move(public_path($folder),$filename);
        }
        resize($folder.$filename, $folder.$filename, 128, 128);
        if(File::exists($folder.$us->avatar)) {File::delete($folder.$us->avatar);}
        $us->avatar = $filename;
        $us->update();
        $mess = Lang::get('app.Profile_image_updated');
      }
      return response()->json(['success' => $mess,'image' => '/'.$folder.$filename]);
    }
    public function contact_us(){
      return view('contact_us');
    }
    public function send_message(Request $req){
      $this->validate($req,[
        'body' => 'required|min:2',
        'name' => 'required|min:2',
        'email' => 'required|min:2',
      ]);
      $cn = new Contact;
      if (Auth::check()) {
        $cn->user_id = Auth::user()->id;
      }else{
        $cn->name = $req->name;
        $cn->email = $req->email;
      }
      $cn->body = $req->body;
      $cn->token = md5(microtime().rand(10000,99999));
      $cn->save();
      return response()->json(['success' => Lang::get('app.You_message_sent')]);
    }
    public function add_comment(Request $req){
      $com = new Comments;
      if (Auth::check()) {
        $com->user_id = Auth::user()->id;
      }else{
        $com->name = $req->name;
        $com->surname = "0";
        $com->email = $req->email;
      }
      if (!in_array($req->type, ['news','prod'])) {
        exit();
      }
      if ($req->type === "prod") {
        $com->prod_id = $req->id;
      }else{
        $com->news_id = $req->id;
      }
      if (isset($req->rating) && !empty($req->rating)) {
        $com->rating = $req->rating;
      }else{$com->rating = 0;}
      $com->comment = $req->comment;
      $com->save();
      $res = Lang::get('app.Your_comment_added');
      if (config("settings.comment_verification") == 1) {
        $res = Lang::get('app.Your_comment_will_shared_after_verification');
      }
      return response()->json(['success' => $res]);
    }
    public function get_comments(Request $req){
      $stars = "";$id = 0;
      if (Auth::check()) {
        $id = Auth::user()->id;
      }
      if (isset($req->prod_id)) {
        $cm  = DB::select("SELECT
                              IF(c.user_id=".$id.", c.id, 0) as id,
                              c.rating,c.comment,c.created_at as time,
                              COALESCE(NULLIF(c.name, ''), u.name) AS `name`,
                              IF(c.user_id=".$id.", ".$id.", 0) as owner
                          FROM
                              `comments` c
                          LEFT JOIN `users` u ON u.id = c.user_id
                          WHERE c.prod_id = ".$req->prod_id."
                          ORDER BY `time` DESC");
        $stars = round(Comments::where('prod_id',$req->prod_id)->avg('rating'));
      }else{
        $sql = "SELECT
                    IF(c.user_id=".$id.", c.id, 0) as id,
                    c.rating,c.comment,c.created_at as time,
                    COALESCE(NULLIF(c.name, ''), u.name) AS `name`,
                    IF(c.user_id=".$id.", ".$id.", 0) as owner
                FROM
                    `comments` c
                LEFT JOIN `users` u ON u.id = c.user_id
                WHERE c.news_id = ".$req->news_id."
                ORDER BY `time` DESC";
        $cm = DB::select($sql);
      }
      $count = count($cm);
      $page = $req->view_page;
      $max = $count >= 6 ? ($page * 6) : 6;
      $min =  $max >= 6 ? ($max - 6) : 0;
      $cm = $count >= 6 ? array_slice($cm, $min, 6) : $cm;
      return response()->json(['comments' => $cm,'rating' => $stars,'count' => $count,'page' => $page,'range_min'=>$min,'range_max' => $max]);
    }
    public function delete_comment(Request $req){
      $this->validate($req,[
        'id' => 'required|integer'
      ]);
      $cm = Comments::find($req->id);
      if (Auth::check()) {
        if (!empty($cm) && $cm->user_id == Auth::user()->id) {
          $cm->delete();
        }
      }
      return response()->json(['mess' => Lang::get('app.Your_comment_deleted')]);
    }
    public function add_wishlist(Request $req){
      $pro = Products::find($req->prod_id);
      if (!empty($pro) && isset($pro)) {
        $ws = Wishlist::where('user_id',Auth::user()->id)->where('prod_id',$req->prod_id)->first();
        if (!isset($ws) && empty($ws)) {
          $ws = new Wishlist;
          $ws->prod_id = $req->prod_id;
          $ws->user_id = Auth::user()->id;
          if (!empty($req->quantity)) {
            $ws->quantity = $req->quantity;
          }
          $ws->save();
          $mess = Lang::get('app.Product_add_to_wishlist');
        }else{
          $ws->quantity = $req->quantity;
          $ws->update();
          $mess = Lang::get('app.Wishlist_updated');
        }
      }
      return response()->json(['success' => $mess]);
    }
    public function get_wishlist(Request $req){
      $limit = "";
      if ($req->type == 0) {
        $limit = " LIMIT ".config("settings.show_wishlist_max_header")." ";
      }
      $ws = DB::select("SELECT
                          w.id,
                          w.quantity as wquantity,
                          w.created_at as wtime,
                          p.prod_id,
                          p.id as pid,
                          p.productname,
                          p.price/".currency(0)." as price,
                          p.old_price/".currency(0)." as old_price,
                          p.slug,
                          p.category,
                          p.quantity as pquantity,
                          COALESCE((SELECT
                              image
                          FROM
                              images
                          WHERE
                              prod_id = w.prod_id
                          ORDER BY
                              `order` ASC
                          LIMIT 1),'default.png') AS image
                      FROM
                          wishlist w
                      LEFT JOIN products p ON
                          w.prod_id = p.id
                      WHERE
                          w.user_id = ".Auth::user()->id.$limit);
      $count = Wishlist::where('user_id',Auth::user()->id)->count();
      $currency = currency();
      $sum = DB::select("SELECT SUM(p.price)*w.quantity as sum FROM wishlist w LEFT JOIN products p ON p.id = w.prod_id");
      $tot = number_format(($sum[0]->sum)/currency(0),0);
      if ($sum[0]->sum === null) {
        $tot = 0;
      }
      return response()->json(['list' => $ws,'count' => $count,'currency' => $currency,'total' => $tot]);
    }
    public function delete_wishlist(Request $req){
      $ws = Wishlist::findOrFail($req->id);
      if ($ws->user_if = Auth::user()->id) {
        $ws->delete();
      }
      return response()->json(['success' => Lang::get('app.Wishlist_removed')]);
    }
    public function wishlist(){
      return view('wishlist');
    }
    public function update_profile(Request $req){
      $us = Auth::user();
      $us->name = $req->name;
      $us->surname = $req->surname;
      $us->email = $req->email;
      $us->birthdate = $req->birthdate;
      $us->phone = $req->phone;
      $us->update();
      return redirect()->back()->with(['type' => 'success','message' => Lang::get('app.User_data_updated')]);
    }
    public function update_user_password(Request $req){
      $this->validate($req, [
          'password' => 'required',
          'new_password' => 'confirmed|min:6|different:password',
      ]);
      $user = Auth::user();
      if (isAdmin()) {
        $rd = "/admin/profile#change_password";
      }else{
        $rd ="/profile?action=password-change";
      }
      // $req->new_password === $req->password_confirmation &&
      if ( Hash::check($req->password,$user->password)) {
          $user->password = Hash::make($req->new_password);
          $user->update();
          return redirect($rd)->with(['type' => 'success', 'message' => Lang::get('app.Password_changed')]);
      } else {
        return redirect($rd)->with(['type' => 'danger', 'message' => Lang::get('app.Password_didnt_change')]);
      }
    }
    public function add_prod_comment(Request $req){
      $com = new Comments;
      if (Auth::check()) {
        $com->user_id = Auth::user()->id;
      }else{
        $com->name = $req->name;
        $com->surname = $req->surname;
        $com->email = $req->email;
      }
      $com->prod_id = $req->product_id;
      $com->comment = $req->comment;
      $com->rating = $req->rating;
      $com-save();
      return redirect()->json(['success' => Lang::get('app.Comment_added_successfully')]);
    }
}
