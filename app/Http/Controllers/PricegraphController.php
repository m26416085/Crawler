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
   
        $shop_name_array = array();
        $product_name_array = array();
        $data_arr = array();
        $productcount=0;
        $price_arr = array();

        foreach($products as $product){   
            $price_histories = Price_History::where('url_product',$product->product_url)->get();
            foreach($price_histories as $history){
                if($history->id_search==$section_id){
                    $data_arr[$productcount][] = array('namabarang'=>$product->product_name,'x' =>strtotime($history->created_at->format('m/d/Y'))*1000, 'y' => $history->price);
                    $price_arr[]=$history->price;
                }   
            }
            $shop_name_array[$productcount]=$product->shop_name;
            $productcount++;
        }
        $x = array();
        for($i=0;$i<$productcount;$i++){
            array_push($x, $i);
        }
        $dataPoints = $data_arr;
        
        $average = array_sum($price_arr)/count($price_arr);
        $average = round($average);
        $modder = $average%1000;
        $average= $average-$modder;
        return view('pricegraphic', compact('dataPoints','shop_name_array','productcount','x','average'));
    }
}
