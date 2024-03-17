<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Orders extends Model
{
    protected $table = 'orders';

    function product(){
      return $this->belongsTo(Products::class,'prod_id');
    }
    function loan(){
      return $this->belongsTo(Loans::class,'loan_type');
    }
}
