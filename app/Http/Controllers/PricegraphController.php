<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Search;
use View;
use App\Price_History;

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
        foreach($products as $product){
            $prices[$product->id] = Price_History::where('url_product',$product->product_url)->get();
        }
      
        return view('pricegraphic');
    }
}
