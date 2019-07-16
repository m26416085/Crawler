<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
class HomeController extends Controller
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
        $data_arr = array();
            
        //tokopedia
    
        $url = "https://ta.tokopedia.com/promo/v1/display/ads?user_id=0&ep=product&item=10&src=search&device=desktop&page=2&q=mouse&fshop=1";
    
        $profile = http_request($url);
        $profile = json_decode($profile, TRUE);
    
        $i = 0;
        foreach ($profile["data"] as $profil) {
            $image_url = $profile['data'][$i]['product']['image']['m_url'];
            $product_name = $profile['data'][$i]['product']['name'];
            $price_format = $profile['data'][$i]['product']['price_format'];
            $shop_name = $profile['data'][$i]['shop']['name'];
            $shop_location = $profile['data'][$i]['shop']['location'];
            
            $data_arr['data'][] = array('image_url' => $image_url, 'product_name' => $product_name, 'price_format' => $price_format, 'shop_name' => $shop_name, 'shop_location' => $shop_location);
            $i++;
        }
        return View::make('home', array('data_arr'=>$data_arr));

    }
    public function find()
    {
        if (isset($_POST['find'])) {
            $data_arr = array();
            
            //tokopedia
            $search = $_POST['text_value'];
        
            $search = str_replace(' ', '%20', $search);
        
            $url = "https://ta.tokopedia.com/promo/v1/display/ads?user_id=0&ep=product&item=10&src=search&device=desktop&page=2&q=" . $search . "&fshop=1";
        
            $profile = http_request($url);
        
            //replace JSON string to Array
            $profile = json_decode($profile, TRUE);
        
            #echo $profile["data"][0]["product"]["name"];
        
            //old loop
            // $i = 0;
            // foreach ($profile["data"] as $profil) {
            //     echo '<img src=' . $profile["data"][$i]["product"]["image"]["m_url"] . '><br>';
            //     echo $profile["data"][$i]["product"]["name"] . '<br>';
            //     echo $profile["data"][$i]["product"]["price_format"] . '<br>';
            //     echo $profile["data"][$i]["shop"]["name"] . '<br>';
            //     echo $profile["data"][$i]["shop"]["location"] . '<br>';
            //     echo '<a href=' . $profile["data"][$i]["product"]["uri"] . '>Link</a>' . '<br>';
            //     echo '<button type="submit" id="add" name="add">Add to Cart</button><br><br>';
            //     $i = $i + 1;
            // }
        
            //new loop
            $i = 0;
            foreach ($profile["data"] as $profil) {
                $image_url = $profile['data'][$i]['product']['image']['m_url'];
                $product_name = $profile['data'][$i]['product']['name'];
                $price_format = $profile['data'][$i]['product']['price_format'];
                $shop_name = $profile['data'][$i]['shop']['name'];
                $shop_location = $profile['data'][$i]['shop']['location'];
                
                $data_arr['data'][] = array('image_url' => $image_url, 'product_name' => $product_name, 'price_format' => $price_format, 'shop_name' => $shop_name, 'shop_location' => $shop_location);
                $i++;
            }
            return View::make('home', array('data_arr'=>$data_arr));
            // print "<pre>";
            // print_r($data_arr);
            // print "</pre>";
        }
    }
}
