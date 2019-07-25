<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Product;
use App\Search;
use View;

class ItemlistController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cartCollection = \Cart::getContent();
        
        $counter=0;
        foreach($cartCollection as $cart){
            $keyword = $cart['attributes']['keyword'];
           
            if($counter==2){
                $search = new Search();
                $search->keyword = $keyword;
                $search->save();
                break;
            }
            $counter++;
        }
        foreach($cartCollection as $cart){
            if($cart['name']!='asdfghjklkjgfds123890ythbnvdkodetokopediafwgheu3yr2t3r64ortfg'){
                $product = new Product();
                $product->product_name = $cart['name'];
                $product->image_url = $cart['attributes']['image_url'];
                $product->shop_name = $cart['attributes']['shop_name'];
                $product->shop_location = $cart['attributes']['shop_location'];
                $product->product_url = $cart['attributes']['product_url'];
                $product->id_search = $search->id;
                $product->save();
            }
        }
        $products = DB::table('products')->get();
        
        return view::make('itemlist', compact('cartCollection','itemCount','keyword','products'));
    }
}
