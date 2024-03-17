<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    public function subcats(){
      return $this->hasMany(Category::class,'parent_id');
    }
}
