<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
    
        $itemCount = $cartCollection->count();

        $counter=0;
        foreach($cartCollection as $cart){
            $keyword = $cart['attributes']['keyword'];
            if($counter==2){
                break;
            }
            $counter++;
        }
        
        $itemCount = $itemCount-1;
        return view::make('itemlist', compact('cartCollection','itemCount','keyword'));
    }
}
