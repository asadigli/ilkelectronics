<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Lang;
use App\Brand;
use Auth;
use File;
class BrandController extends Controller
{
  public function brand_list(){
    $brands = DB::select("SELECT
                                  p.brand,
                                  IFNULL(b.id, 0) as id,
                                  IFNULL(b.status, 0) as status,
                                  b.image as image
                          FROM
                              products p LEFT JOIN brands b ON b.brand = p.brand
                          GROUP BY brand ORDER BY brand ASC");
    return view('admin.brand_list',compact('brands'));
  }
  // public function brand_list_store(){
  //   $brands = Brand::where('status',1)->get();
  //   return view('brand_list',compact('brands'));
  // }
  public function brand_view($brand){
    $brand = Brand::where('brand',$brand)->first();
    return view('brand_list');
  }
  public function brand_status(Request $req){
    $br = Brand::find($req->id);
    if (!empty($br)) {
      $br->status = $req->status;
      $br->update();
    }
    return response()->json(['mess' => 'success']);
  }
  public function create_brand(Request $req){
    $this->validate($req, [
      'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);
    $br_exist = Brand::where('brand',$req->brand)->first();
    if (empty($br_exist)) {
      $br = new Brand;
    }else{
      if (empty($br_exist)) {
        $br = Brand::find($req->id);
      }else{
        $br = $br_exist;
      }
    }
    if ($req->hasFile('file')) {
      $folder = 'uploads/brands/';
      $picture = $req->file;
      $ext=$picture->getClientOriginalExtension();
      if($ext=='jpg' || $ext=='png' || $ext=='jpeg' || $ext=='bmp')  {
         $filename=time()+random_int(1, 100000000).'.'.$picture->getClientOriginalExtension();
         $picture->move(public_path($folder),$filename);
      }
      resize($folder.$filename, $folder.$filename, 120, 120);
      $br->status = $req->status;
      $br->brand = trim($req->brand);
      if (empty($br_exist)) {
        $br->image = $filename;
        $br->save();
      }else{
        if(File::exists($folder.$br->image)) {File::delete($folder.$br->image);}
        $br->image = $filename;
        $br->update();
      }
    }
    return response()->json(['mess' => 'Success','brand' => $req->brand]);
  }
}
