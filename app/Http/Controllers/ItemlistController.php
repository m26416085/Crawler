<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Product;
use App\Search;
use View;
use App\Price_History;
date_default_timezone_set('Asia/Jakarta');

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
        $count= sizeof($cartCollection);
        foreach($cartCollection as $cart){
            if($counter==$count-1){
                $keyword = $cart['attributes']['keyword'];
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
            if($cart['attributes']['keyword'] != "List Kosong"){
                $search = new Search();
                $search->keyword = $keyword;
                $search->id_user = auth()->user()->id;
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
                $product->id_user = auth()->user()->id;
                $product->save();

                $history = new Price_History();
                $history->url_product = $product->product_url;
                $history->price = $cart['price'];
                $history->id_user = auth()->user()->id;
                $history->save();
            }
        }
        
        //get from db
        $products = DB::table('products')->get();
        $sections= DB::table('searches')->get();
        $price_histories = DB::table('price__histories')->get();

        // clear cart item after save to db
        \Cart::clear();

        // add default cart item so cart wouldn't get any error 
        \Cart::add(array(
            'id' => 9999,
            'name' => "asdfghjklkjgfds123890ythbnvdkodetokopediafwgheu3yr2t3r64ortfg",
            'price' => 100000,
            'quantity' => 1,
            'attributes' => array(
                'image_url' => "////",
                'price_format' => "Rp. 100000",
                'shop_name' => "ertertrtrgv",
                'shop_location' => "ghrtyrghjnvfg",
                'keyword_max' => 0,
                'keyword_min' => 0,
                'keyword_value_location_tokopedia' => '175',
                'keyword_value_location_shopee' => 'DKI Jakarta',
                'keyword' => 'List Kosong',
                'product_url' => "////"
            )
        ));

            $cartCollection = \Cart::getContent();

            $cartCollection->toArray();

            return view::make('itemlist', compact('cartCollection','keyword','products','sections', 'price_histories'));
        }

        if(isset($_POST['delete_button'])){

            $sections= DB::table('searches')->get();
            $products = DB::table('products')->get();
            $price_histories = DB::table('price__histories')->get();

            $delete_id = $_POST['delete_id'];

            foreach($products as $product){
                if($product->id_search == $delete_id){
                    // delete product id
                    //Product::find($product->id)->delete();
                    
                    foreach($price_histories as $history){
                        if ($product->created_at == $history->created_at){
                            // delete price history
                            //Price_History::find($history->id)->delete();
                            Price_History::where('created_at', $history->created_at)->delete();
                        }
                    }
                    Product::where('id_search', $product->id_search)->delete();
                }
            }



            // delete search id
            Search::destroy($delete_id);

            $cartCollection = \Cart::getContent();

            $cartCollection->toArray();

            $sections= DB::table('searches')->get();
            $products = DB::table('products')->get();
            $price_histories = DB::table('price__histories')->get();
           
            return view::make('itemlist', compact('cartCollection','products','sections', 'price_histories'));

        }
        if(isset($_POST['update_keyword'])){
            $sections= DB::table('searches')->get();
            $products = DB::table('products')->get();
            $price_histories = DB::table('price__histories')->get();


            return view::make('itemlist', compact('cartCollection','products','sections', 'price_histories'));
        }
    }
}
