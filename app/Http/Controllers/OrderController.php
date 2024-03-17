<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use Lang;
class OrderController extends Controller
{
  public function mark_as_read(Request $req){
    $or = Orders::find($req->id);
    $or_st = 0;
    if ($or->status == 0) {
      $or_st = 1;
      $or->status = 1;
    }else{
      $or_st = 0;
      $or->status = 0;
    }
    $or->update();
    return response()->json(['message' => Lang::get('app.Order_marked_as_read'),'st' => $or_st]);
  }
}
