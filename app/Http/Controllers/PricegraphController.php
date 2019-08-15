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
   
        $data_arr = array();
        $productcount=0;
        $created_at=array();
       
        $pricecount=0; 
        //data without avearging
        // foreach ($products as $product){   
        //     $histories = Price_History::where('url_product',$product->product_url)->get();
        //     foreach($histories as $history){
        //         if($history->id_search==$section_id){
        //             $data_arr[$productcount][] = array('namabarang'=>$product->product_name,'x' =>strtotime($history->created_at->format('m/d/Y'))*1000, 'y' => $price_arr[]=$history->price);
        //         }
        //     }
        //     $shop_name_array[$productcount]=$product->shop_name;
        //     $productcount++;
        // }
        
        $hargatotal=0;

        foreach ($products as $product){   
            $histories = Price_History::where('url_product',$product->product_url)->get();
            if($hargatotal==0){
                $date=$product->created_at;
            }
            foreach ($histories as $history){
                if($history->id_search==$section_id){
                    if($history->created_at==$date){
                        $hargatotal=$hargatotal+$history->price;
                        $pricecount++;
                    }
                    else{
                        $data_arr[$productcount][] = array('namabarang'=>$product->product_name,'x' =>strtotime($date->format('m/d/Y'))*1000, 'y' => $price_arr[$productcount]=round($hargatotal/$pricecount));
                        $date=$history->created_at;
                        $pricecount=1;
                        $hargatotal=$history->price;
                    }
                }
            }
            $data_arr[$productcount][] = array('namabarang'=>$product->product_name,'x' =>strtotime($date->format('m/d/Y'))*1000, 'y' => $price_arr[$productcount]=round($hargatotal/$pricecount));
            $pricecount=0;
            $hargatotal=0;
            $shop_name_array[$productcount]=$product->shop_name;
            $productcount++;
            $filter=0;
        }

        $dataPoints = $data_arr;
        
        $average = array_sum($price_arr)/count($price_arr);
        $average = round($average);
        $modder = $average%1000;
        $average= $average-$modder;
        return view('pricegraphic', compact('dataPoints','shop_name_array','productcount','average','section_id','filter'));
    }
    public function filter($section)
    {   
        $section_id = $section;
        $search=Search::find($section_id);
        $products = Product::where('id_search',$section_id)->get();
   
        $data_arr = array();
        $productcount=0;
        $created_at=array();
       
        $pricecount=0; 
        $hargatotal=0;
        $time= $_POST['time'];

        if($time=='hari')
        {
            foreach ($products as $product){   
                $histories = Price_History::where('url_product',$product->product_url)->get();
                if($hargatotal==0){
                    $date=$product->created_at;
                }
                foreach ($histories as $history){
                    if($history->id_search==$section_id){
                        if($history->created_at==$date){
                            $hargatotal=$hargatotal+$history->price;
                            $pricecount++;
                        }
                        else{
                            $data_arr[$productcount][] = array('namabarang'=>$product->product_name,'x' =>strtotime($date->format('m/d/Y'))*1000, 'y' => $price_arr[$productcount]=round($hargatotal/$pricecount));
                            $date=$history->created_at;
                            $pricecount=1;
                            $hargatotal=$history->price;
                        }
                    }
                }
                $data_arr[$productcount][] = array('namabarang'=>$product->product_name,'x' =>strtotime($date->format('m/d/Y'))*1000, 'y' => $price_arr[$productcount]=round($hargatotal/$pricecount));
                $pricecount=0;
                $hargatotal=0;
                $shop_name_array[$productcount]=$product->shop_name;
                $productcount++;
                $filter=0;
            }
        }
        else if($time=='bulan')
        {   
            foreach ($products as $product){   
                $histories = Price_History::where('url_product',$product->product_url)->get();
                if($hargatotal==0){
                    $date=$product->created_at;  
                    $date=explode(" ",$date);
                    $date=explode("-",$date[0]);
                    
                }
                foreach ($histories as $history){
                    if($history->id_search==$section_id){
                        $history_date=$history->created_at;
                        $history_date=explode(" ",$history_date);
                        $history_date=explode("-",$history_date[0]);
                        
                        if($history_date[0]==$date[0] && $history_date[1]==$date[1]){
                            $hargatotal=$hargatotal+$history->price;
                            $pricecount++;
                        }
                        else{
                            $date=implode("-",$date);
                            $data_arr[$productcount][] = array('namabarang'=>$product->product_name,'x' =>strtotime($date)*1000, 'y' => $price_arr[$productcount]=round($hargatotal/$pricecount));
                            $date=$history->created_at;
                            $date=explode(" ",$date);
                            $date=explode("-",$date[0]);
                            
                            $pricecount=1;
                            $hargatotal=$history->price;
                        }
                    }
                }
                $date=implode("-",$date);
                $data_arr[$productcount][] = array('namabarang'=>$product->product_name,'x' =>strtotime($date)*1000, 'y' => $price_arr[$productcount]=round($hargatotal/$pricecount));
                $pricecount=0;
                $hargatotal=0;
                $shop_name_array[$productcount]=$product->shop_name;
                $productcount++;
                $filter=1;
            }
        }

        $dataPoints = $data_arr;
        
        $average = array_sum($price_arr)/count($price_arr);
        $average = round($average);
        $modder = $average%1000;
        $average= $average-$modder;
        return view('pricegraphic', compact('dataPoints','shop_name_array','productcount','average','section_id','filter'));
    }
}
