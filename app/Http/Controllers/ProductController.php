<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Products;
use App\Protab;
use App\News;
use App\Pages;
use Lang;
use DB;
use App\Images;
use Image;
use App\Orders;
use App\Loans;
use File;
use App\Boostedpros;
use Auth;
use App\Brand;
// use Request;

class ProductController extends Controller
{
    public function index(){
        $pros = DB::select("SELECT p.*,FORMAT(p.price/".currency(0).",0) as price,FORMAT(p.old_price/".currency(0).",0) as old_price,(SELECT AVG(rating) FROM `comments` c WHERE prod_id = p.id) as rating FROM products p ORDER BY created_at DESC LIMIT 20");
        $brands = Brand::where('status',1)->orderBy('views','desc')->take(6)->get();
        $bpro = DB::select("SELECT
                                p.id,b.end_date,p.slug,
                                (SELECT image FROM `images` i WHERE i.prod_id = b.prod_id ORDER BY `order` ASC LIMIT 1) as image,
                                b.start_date,
                                FORMAT(p.price/".currency(0).",0) as price,
                                p.productname,p.prod_id,
                                FORMAT(p.old_price/".currency(0).",0) as old_price,
                                p.created_at as date,
                                (SELECT AVG(rating) FROM `comments` c WHERE c.prod_id = b.prod_id) as rating
                            FROM
                                `boostedpros` b
                            LEFT JOIN `products` p ON p.id = b.prod_id
                            WHERE end_date >= '".date("Y-m-d H:i:s")."' AND start_date <= '".date("Y-m-d H:i:s")."'
                            ORDER BY end_date limit 3");
        $mv_pros = DB::select("SELECT p.*,FORMAT(p.price/".currency(0).",0) as price,FORMAT(p.old_price/".currency(0).",0) as old_price,(SELECT AVG(rating) FROM `comments` c WHERE prod_id = p.id) as rating FROM products p ORDER BY views DESC LIMIT 4");
        return view('index',compact('pros','mv_pros','bpro','brands'));
    }
    public function order_product_view($slug){
      $pro = Products::where('slug',$slug)->first();
      return view('contact_us',compact('pro'));
    }
    public function add_loan_view($slug){
      $product = Products::where('slug',$slug)->first();
      $pro_loans = Loans::where('prod_id',$product->id)->get();
      return view('admin.add_product',compact('product','pro_loans'));
    }
    public function add_new_loan(Request $req,$id = null){
      $this->validate($req,[
        'duration' => 'required|integer',
        'rate' => 'required'
      ]);
      $pro = Products::find($req->prod_id);
      if (!empty($id) && $id !== null) {
        $ln = Loans::find($id);
      }else{
        $ln = new Loans;
      }
      $ln->prod_id = $req->prod_id;
      $ln->duration = $req->duration;
      $ln->rate = $req->rate;
      $ln->price = $pro->price;
      if ($req->hasFile('images')) {
        $ln->type = 1;
        $folder = 'uploads/icon/';
        $picture = $req->images;
        $ext=$picture->getClientOriginalExtension();
        if($ext=='jpg' || $ext=='png' || $ext=='jpeg' || $ext=='bmp')  {
            $filename=time()+random_int(1, 100000000).'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path($folder),$filename);
            resize($folder.$filename, $folder.$filename, 80, 89);
        }
        $ln->card_icon = $filename;
      }else{
        $ln->type = 0;
      }
      if (!empty($id) && $id !== null) {
        $ln->update();
      }else{
        $ln->save();
      }
      return redirect()->back()->with(['message' => Lang::get('app.Loan_added'),'type' => 'success']);
    }
    public function delete_loan($id){
      $ln = Loans::find($id);
      if(File::exists('uploads/icon/'.$ln->card_icon)) {File::delete('uploads/icon/'.$ln->card_icon);}
      $ln->delete();
      return redirect()->back()->with(['message' => Lang::get('app.Loan_deleted'),'type' => 'danger']);
    }
    public function boost_product(Request $req){
      $pro = Products::find($req->prod_id);
      if (!empty($pro)) {
        $bp = new Boostedpros;
        $bp->prod_id = $pro->id;
        $bp->old_price = $pro->price;
        $bp->start_date = $req->start_date;
        $bp->end_date = $req->end_date;
        $pro->price = $pro->price - $req->discount_amount;
        $bp->save();
        $pro->update();
      }
      return redirect()->back()->with(['message' => Lang::get('app.Product_boosted'),'type' => 'success']);
    }
    public function order_now(Request $req){
      $this->validate($req,[
        'email' => 'required|email',
        'name' => 'required|string|min:2',
        'surname' => 'required|string|min:2',
        'birthdate' => 'required|date',
        'father_name' => 'required|string|min:2',
        'gender' => 'required|integer',
        'quantity' => 'required|integer',
        'address' => 'required|string',
        'city' => 'required|string',
      ]);
      $pro = Products::where('prod_id',$req->product_id)->first();
      $loan = Loans::find($req->loan_id);
      if (!empty($pro)) {
        $o = new Orders;
        $o->prod_id = $pro->id;
        if(Auth::check()){
          $o->user_id = Auth::user()->id;
          $o->name = Auth::user()->name;
          $o->email = Auth::user()->email;
          $o->surname = Auth::user()->surname;
          $o->birthdate = Auth::user()->birthdate;
          $o->gender = Auth::user()->gender;
        }else{
          $o->name = $req->name;
          $o->birthdate = $req->birthdate;
          $o->email = $req->email;
          $o->gender = $req->gender;
          $o->surname = $req->surname;
        }
        $o->father_name = $req->father_name;
        $o->quantity = $req->quantity;
        $o->contact_number = $req->contact_number;
        $o->address = $req->address;
        $o->city = $req->city;
        if (!empty($loan)) {
          $o->loan_type = $loan->id;
        }else{$o->loan_type = 0;}
        $o->save();
      }
      // return redirect()->back()->with(['message' => 'MEssage here','type'=>'success']);
      return response()->json(['mess' => Lang::get('app.We_will_contact_you_for_order')]);

    }
    public function get_product_details($slug){
      $pro = Products::select(DB::raw("*,FORMAT(price/".currency(0).",0) as price,FORMAT(old_price/".currency(0).",0) as old_price"))->where('slug',$slug)->first();
      if (!empty($pro)) {
        $pro->views += 1;
        $pro->update();
        $pros = DB::select("SELECT p.*,FORMAT(p.price/".currency(0).",0) as price,FORMAT(p.old_price/".currency(0).",0) as old_price,(SELECT AVG(c.rating) FROM `comments` c WHERE prod_id = p.id) as rating FROM products p WHERE category = ".$pro->category." AND id != ".$pro->id." LIMIT 4");
        $prod_tabs = Protab::where('prod_id',$pro->id)->orderBy('order','ASC')->get();
        $loans = Loans::where('prod_id',$pro->id)->where('type',0)->orderBy('duration','ASC')->get();
        $lns = Loans::where('prod_id',$pro->id)->where('type',1)->orderBy('duration','ASC')->get();
        return view('product',compact('pro','pros','prod_tabs','loans','lns'));
      }else{
        return redirect('/error')->with(['error_message' => Lang::get('app.Product_you_looking_not_found')]);
      }
    }
    public function get_product_list(Request $req){
      if ($req->category) {
        $pros = Products::where('category',$req->category)->orderBy('created_at','desc')->get();
      }else{
        $pros = Products::orderBy('created_at','desc')->get();
      }
      $cats = DB::select("SELECT name,id,(SELECT COUNT(*) FROM products WHERE category = c.id) as products FROM category c WHERE parent_id IS NOT NULL ORDER BY name ASC");
      return view('admin.list',compact('pros','cats'));
    }
    public function add_product_view(Request $req,$id = null){
      if (!is_null($id)) {
        $pro = Products::find($id);
        return view('admin.add_product',compact('pro'));
      }else{
        return view('admin.add_product');
      }
    }
    public function add_prod_tabs($slug){
      $pro = Products::where('slug',$slug)->first();
      $pro_tabs = Protab::where('prod_id',$pro->id)->get();
      return view('admin.add_product',compact('pro','pro_tabs'));
    }
    public function get_prod_tabs_ajax(Request $req){
      $pts = Protab::where('prod_id',$req->main_id)->orderBy('order','ASC')->get();
      return response()->json(['pts' => $pts]);
    }
    public function delete_prod_tab(Request $req){
      $pt = Protab::find($req->id);
      if (!empty($pt)) {
        $pt->delete();
      }
      return response()->json(['message' => Lang::get('app.Tab_deleted')]);
    }
    public function update_product_tabs(Request $req){
      $arr = $req->list;
      for ($i=0; $i < count($arr); $i++) {
        $pt_check = Protab::find($arr[$i]["id"]);
        if (!isset($pt_check) | empty($pt_check)) {
          $pt = new Protab;
        }else{
          $pt = Protab::find($arr[$i]["id"]);
        }
        $pt->prod_id = $req->main_id;
        if (!empty($arr[$i]["title"]) && !empty($arr[$i]["desc"])) {
          $pt->title = trim($arr[$i]["title"]);
          $pt->description = $arr[$i]["desc"];
          $pt->order = $arr[$i]["index"];
          if (!isset($pt_check) | empty($pt_check)) {
            $pt->save();
          }else{
            $pt->update();
          }
        }
      }

      return response()->json(['message' => Lang::get('app.Product_tabs_updated'),'list' => $req->list,'product' => $req->prod]);
    }
    public function add_product(Request $req,$id = null){
      // $this->validate($req,[
      //   'prod_id' => 'required|unique:products'
      // ]);
      if (is_null($id)) {
        $pro = new Products;
      }else{
        $pro = Products::find($id);
      }
      // echo "string";exit();

      $pro->productname = $req->productname;
      if (empty($req->slug)) {
        $pro->slug = make_slug($req->productname);
      }else{
        $pro->slug = str_slug($req->slug);
      }
      $pro->category = $req->category;
      $pro->prod_id = $req->prod_id;
      $pro->quantity = $req->quantity;
      $pro->price = $req->price;
      $pro->old_price = $req->old_price;
      $pro->description = $req->description;
      $pro->description_title = $req->description_title;
      $pro->brand = $req->brand;
      $pro->condition = $req->condition;
      $pro->token = md5(microtime());
      if (is_null($id)) {
        $mess = Lang::get('app.Product_added');
        $pro->save();
      }else{
        $mess = Lang::get('app.Product_updated');
        $pro->update();
      }
      // if (isset($req->images) && !empty($req->images)) {
      if ($req->hasFile('images')) {
        $imgArr=[];
        $sm_folder = 'uploads/pro/small/';
        $folder = 'uploads/pro/';
        foreach ($req->images as $picture) {
            $ext=$picture->getClientOriginalExtension();
            if($ext=='jpg' || $ext=='png' || $ext=='jpeg' || $ext=='bmp')  {
                $filename=time()+random_int(1, 100000000).'.'.$picture->getClientOriginalExtension();
                Image::make($picture)->save($sm_folder.$filename);
                $picture->move(public_path($folder),$filename);
                array_push($imgArr,$filename);
          }
        }
        for ($i=0; $i < count($imgArr); $i++) {
            $img_name = $imgArr[$i];
            resize($sm_folder.$img_name, $sm_folder.$img_name, 262.5, 350);
            compress($sm_folder.$img_name, $sm_folder.$img_name,300);
            resize($folder.$img_name, $folder.$img_name, 1200, 1200);
            logo_on_image($folder.$img_name,'img/logo-transparent.png',$folder.$img_name);
            $img = new Images;
            $img->prod_id = $pro->id;
            $img->image = $img_name;
            $img->save();
        }
      }
      update_sitemap();
      return redirect()->back()->with(['type' => 'success','message' => $mess]);
    }
    // if (!file_exists($sm_folder)) {
    //     mkdir($folder, 666, true);
    // }
    // if (!file_exists($save_path)) {
    //     mkdir($folder, 666, true);
    // }

    // public function edit_product(Request $req){
    //
    // }
    public function compress_all_images(){
      $sm_folder = 'uploads/pro/small/';
      for ($i=0; $i < count(scandir($sm_folder)); $i++) {
        $img = scandir($sm_folder)[$i];
        if (!in_array($img,array('.','..','default.png','.DS_Store'))) {
          compress($sm_folder.$img, $sm_folder.$img,65);
          // echo scandir($sm_folder)[$i].'<br>';
        }
      }
      // die;
      return "ok";
    }
    public function add_tab(Request $req){

    }
    public function change_im_order_view($type,$slug){
      if ($type === "product") {
        $pro = Products::where('slug',$slug)->first();
        $images = Images::where('prod_id',$pro->id)->orderBy('order','asc')->get();
        $url = "/uploads/pro/small/";
      }elseif($type === "page"){
        $page = Pages::where('slug',$slug)->first();
        $images = Images::where('page_id',$page->id)->orderBy('order','asc')->get();
        $url = "/uploads/pages/";
      }else{
        $ns = News::where('slug',$slug)->first();
        $images = Images::where('news_id',$ns->id)->orderBy('order','asc')->get();
        $url = "/uploads/news/";
      }
      return view('admin.add_product',compact('images','url'));
    }
    public function change_im_order(Request $req){
      $data = $req->list;
      for ($i=0; $i < count($data); $i++) {
        $img = Images::find($data[$i]);
        $img->order = $i;
        $img->update();
      }
      return response()->json(['success' => Lang::get('app.Images_reordered')]);
    }

    public function get_tab_sugg(){
      $names = DB::select("SELECT DISTINCT(title) FROM protab");
      return $names;
    }
}
