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
                $product->created_at = date('Y-m-d');
                $product->save();

                $history = new Price_History();
                $history->url_product = $product->product_url;
                $history->price = $cart['price'];
                $history->id_user = auth()->user()->id;
                $history->id_search = $search->id;
                $history->created_at = date('Y-m-d');
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

            // delete price history
            Price_History::where('id_search', $delete_id)->delete();
            // delete product id
            Product::where('id_search', $delete_id)->delete();




            // delete search id
            Search::destroy($delete_id);

            $cartCollection = \Cart::getContent();

            $cartCollection->toArray();

            $sections= DB::table('searches')->get();
            $products = DB::table('products')->get();
            $price_histories = DB::table('price__histories')->get();
           
            return view::make('itemlist', compact('cartCollection','products','sections', 'price_histories'));

        }
        if(isset($_POST['edit_button'])){
            $id = $_POST['id_section'];
            $sections = DB::table('searches')->get();
            foreach($sections as $section){
                if($section->id == $id){
                    $keyword = $section->keyword;
                }
            }

            return view::make('editsection', compact('keyword', 'id'));
        }
    }
    public function sync(){
        $sections = DB::table('searches')->get();
        include(app_path() . '\Library\simple_html_dom.php');
        foreach($sections as $section){
            $products = DB::table('products')->where('id_search', $section->id)->get();
            foreach($products as $product){
                $cekurl = explode(".", $product->product_url);
                if ($cekurl[1] == "tokopedia") {
                    $data = find_link_tokopedia("test", 0, 0, 0, 0, $product->product_url);
    
                    $history = new Price_History();
                    $history->url_product = $product->product_url;
                    $history->price = $data['data'][0]['price']+(rand(2,20)*1000);
                    $history->id_user = auth()->user()->id;
                    $history->id_search = $section->id;
                    $history->created_at = date('Y-m-d');
                    $history->save();
    
                }
                else{
                    $data = find_link_shopee($product->$product_url, 0, 0, 0, 0);
                    $history = new Price_History();
                    $history->url_product = $product->product_url;
                    $history->price = $data['data'][0]['price']+(rand(2,20)*1000);
                    $history->id_user = auth()->user()->id;
                    $history->id_search = $section->id;
                    $history->created_at = date('Y-m-d');
                    $history->save();
                    
                }
            }
        }

        $sections= DB::table('searches')->get();
        $products = DB::table('products')->get();
        $price_histories = DB::table('price__histories')->get();

        return view::make('itemlist', compact('products','sections', 'price_histories'));
        
    }
}
