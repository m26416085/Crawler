<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function searches(){
        return $this->hasOne(Search::class);
    }
}
