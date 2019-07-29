<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price_History extends Model
{
    public function products(){
        return $this->hasOne(Product::class);
    }
}
