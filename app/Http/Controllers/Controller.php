<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use DB;
use App\Images;
use File;
use Lang;
use Session;
use Mail;
use App\OTP;
use App\User;
use Hash;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function forgot_password(Request $req){
      $email = $req->email;$code = rand(1111111,99999999);
      $user = User::where('email',$email)->first();
      if (!empty($user)) {
        $otp = new OTP;
        $otp->email = $email;
        $otp->user_id = $user->id;
        $otp->otp_code = $code;
        $otp->token = md5(microtime().rand(1000,9999));
        $otp->save();
        Mail::send('auth.email', ['subject' => Lang::get('app.Password_reset_email_subject'),'name' => Lang::get('app.Email_greeting',['surname' => $user->surname]),'text' => Lang::get('app.In_order_to_reset_use_the_code',['code' => $code])], function ($mess) use ($email){
              $mess->from('support@ilkelectronics.az', 'Ilk Electronics Support');
              $mess->subject(Lang::get('app.Reset_email_title'));
              $mess->to($email);
        });
        return redirect('/account?action=password-reset&email='.$email)->with(['message' => Lang::get('app.Code_sent_for_resetting'),'type' => 'success']);
      }else{
        return redirect()->back()->with(['type' => 'danger','message' => Lang::get('app.User_not_found')]);
      }
    }
    public function get_langs(Request $req){
      $arr = ['Home' => 'Home page'];
      return $arr;
    }
    public function check_otp_code(Request $req){
      $otp = $req->code;
      $email = $req->email;
      $otp = OTP::where('otp_code',$otp)->where('email',$email)->where('status',0)->first();
      if (!empty($otp)) {
        $token = $otp->token;
        return redirect('/account?action=password-reset&email='.$email.'&access_token='.$token)->with(['message' => Lang::get('app.Code_is_correct'),'type' => 'success']);
      }else{
        return redirect()->back()->with(['type'=>'danger','message'=>Lang::get('app.Wrong_code')]);
      }
    }
    public function change_password(Request $req){
      $email = $req->email;
      $token = $req->access_token;
      $otp = OTP::where('token',$token)->where('email',$email)->where('status',0)->first();
      if (!empty($otp)) {
        $this->validate($req, [
            'password' => 'confirmed|min:6',
        ]);
        $user = User::where('email',$email)->first();
        $user->password = Hash::make($req->password);
        $user->update();
        $otp->status = 1;
        $otp->update();
        return redirect('/account?action=login')->with(['type' => 'success','message' => Lang::get('app.You_password_changed_successfully')]);
      }else{
        return redirect()->back()->with(['type' => 'danger', 'message' => Lang::get('app.Could_not_change_password')]);
      }
    }


    public function delete_product($id){
      $imgs = Images::where('prod_id',$id)->get();
      foreach ($imgs as $k => $im) {
        $image = "uploads/pro/".$im->image;
        if(File::exists($image) && $im->image !== 'default.png') {File::delete($image);}
        $image_small = "uploads/pro/small/".$im->image;
        if(File::exists($image_small) && $im->image !== 'default.png') {File::delete($image_small);}
        DB::select("DELETE FROM images WHERE id = ".$im->id);
      }
      DB::select("DELETE FROM boostedpros WHERE prod_id = ".$id);
      DB::select("DELETE FROM protab WHERE prod_id = ".$id);
      DB::select("DELETE FROM products WHERE id = ".$id);
      return redirect()->back()->with(['type' => 'success','message' => Lang::get('app.Product_deteled')]);
    }

    public function delete_image(Request $req){
      $img = Images::find($req->id);
      $image = "uploads/pro/".$img->image;
      if(File::exists($image) && $img->image !== 'default.png') {File::delete($image);}
      $image_small = "uploads/pro/small/".$img->image;
      if(File::exists($image_small) && $img->image !== 'default.png') {File::delete($image_small);}
      if (!empty($img)) {
        $img->delete();
      }
      return response()->json(['mess'=>Lang::get('app.Image_deleted')]);
    }
    public function change_currency($currency){
      $val = file_get_contents(burl().'/public/currency.json');
      $val = json_decode($val,true);
      if (in_array($currency,['AZN','RUB','TRY','USD'])) {
        Session::put('currency',$currency);
        Session::put('currency_value',$val[$currency]);
      }
      return redirect()->back();
    }
    public function top_prods(){
      return DB::select("SELECT
                              COALESCE((SELECT image FROM `images` i WHERE i.prod_id = p.id ORDER BY `order` ASC LIMIT 1), 'default.png') AS image,
                              (SELECT AVG(c.rating) FROM `comments` c WHERE c.prod_id = p.id) AS rating,
                          p.slug,
                          p.productname,
                          p.price,
                          p.old_price
                          FROM
                              `products` p
                          WHERE
                              p.quantity > 0
                          ORDER BY
                              `rating`
                          DESC LIMIT 3");
    }
    public function currency_update(){
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://sade.store/currency.json",
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "accept: application/json"
        ),
      ));
      curl_setopt($curl, CURLOPT_VERBOSE, TRUE);
      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      $res = curl_exec($curl);
      $rt = json_decode($res,TRUE);
      $err = curl_error($curl);
      curl_close($curl);
      if ($err) {
        echo "Error: " . $err;
      } else {
        $ips = file_get_contents(burl().'/public/ips.txt');
        $ips = json_decode($ips, TRUE);
        $ips[] = ['date' => date('Y-m-d H:i:s'), 'ip' => $_SERVER['REMOTE_ADDR']];
        $json = json_encode($ips);

        // $rt = $response['rates'];
        $arr = array("AZN" => 1,"RUB" => $rt["RUB"],"TRY" => $rt["TRY"],"USD" => $rt["USD"],);
        file_put_contents(burl().'/public/currency.json',json_encode($arr,true));
        file_put_contents(burl().'/public/ips.txt',$json);
        $r = file_get_contents(burl().'/public/currency.json');
        if (isJson($r)) {
          echo "success";
        }else{
          echo "not json";
        }
      }
    }
    public function consistent_url(Request $req){
      $array = [];
      for ($i=0; $i < count($req->imgs); $i++) {
        if (!empty($req->imgs[$i])) {
          $val = $req->imgs[$i];
          $key = $req->imgs[$i];
          if ($i != 0) {
            $md5image1 = md5(file_get_contents($req->imgs[$i]));
            for ($k=0; $k < count($array); $k++) {
              $md5image2 = md5(file_get_contents($array[$k]));
              if ($md5image1 == $md5image2) {
                $val = '';
              }
            }
          }
          $array[] = [$key => $val];
        }
      }
      return $array;
    }
    public function error_page($type = null){
      $type = $type || "default";
      return view('error',compact('type'));
    }
    function error_five_hundred(){
      return view('error_500');
    }
}
