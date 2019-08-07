<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Darryldecode\Cart\Cart;

class Checkout extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $cartCollection = \Cart::getContent();

        return view::make('checkout', compact('cartCollection'));
    }

    public function post(){

    }
}
