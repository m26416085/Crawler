<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function searches(){
        return $this->hasOne(Search::class);
    }

    public function price__histories(){
        return $this->hasMany(Price_History::class);
    }
}
