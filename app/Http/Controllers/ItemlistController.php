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
        //get from cart   
        $cartCollection = \Cart::getContent();
        $counter=0;
        //take the first keyword
        foreach($cartCollection as $cart){
            $keyword = $cart['attributes']['keyword'];
            if($counter==1){
                break;
            }
            $counter++;
        }
        
        //get from db
        $products = DB::table('products')->get();
        $sections= DB::table('searches')->get();

        return view::make('itemlist', compact('cartCollection','keyword','products','sections'));
    }
    public function insert()
    {   
        if(isset($_POST['save'])){
        //get from cart   
        $cartCollection = \Cart::getContent();
        $counter=0;
        
        //insert to search
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
    
        //insert to product
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
        
        //get from db
        $products = DB::table('products')->get();
        $sections= DB::table('searches')->get();

        return view::make('itemlist', compact('cartCollection','keyword','products','sections'));
        }
    }
}
