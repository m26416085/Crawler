<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokopediaController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function search()
    {
    //     $image_url = "";
    //     $product_name = "";
    //     $price_format = "";
    //     $shop_name = "";
    //     $shop_location = "";
        
    //     return view('home', ['image_url' => $image_url, 'product_name' => "TEST", 'price_format' => $price_format, 'shop_name' => $shop_name, 'shop_location' => $shop_location]);
    }
}
