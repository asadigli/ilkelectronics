<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $table = 'pages';

    public function childs(){
      return $this->hasMany(Pages::class,'parent_id');
    }
}
