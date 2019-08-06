<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Search;
use View;
use App\Price_History;
date_default_timezone_set('Asia/Jakarta');

class PricegraphController extends Controller
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
    public function index($section)
    {   
        
        $section_id = $section;
        $search=Search::find($section_id);
        $products = Product::where('id_search',$section_id)->get();
        //put data to array
   
        $product_name_array = array();
        $data_arr = array();
        $productcount=0;

        foreach($products as $product){   
            $price_histories = Price_History::where('url_product',$product->product_url)->get();
            foreach($price_histories as $history){
                $data_arr[$productcount][] = array('label'=>$product->shop_name ,'x' =>$history->created_at->timestamp , 'y' => $history->price);
            }
            $product_name_array[$productcount]=$product->product_name;
            $productcount++;
        }
        $x = array();
        for($i=0;$i<$productcount;$i++){
            array_push($x, $i);
        }
        $dataPoints = $data_arr;
        return view('pricegraphic', compact('dataPoints','product_name_array','productcount','x'));
    }
}
