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
        //Shopee
        $dataShopee_arr = array();
        $urlShopee ="https://shopee.co.id/api/v2/search_items/?by=relevancy&keyword=gundam&limit=10&newest=0&order=desc&page_type=search&price_max=0&price_min=0";
        $profileShopee = http_request($urlShopee);
        $profileShopee = json_decode($profileShopee, TRUE);
        $x = 0;
        foreach ($profileShopee["items"] as $profil){
            $product_name_Shopee = $profileShopee["items"][$x]["name"];

            //start get product price
            $shopid_Shopee = $profileShopee["items"][$x]["shopid"];
            $itemid_Shopee = $profileShopee["items"][$x]["itemid"];
            
            $url_detail_Shopee = "https://shopee.co.id/api/v2/item/get?itemid=".$itemid_Shopee."&shopid=".$shopid_Shopee;

            $data_detail_Shopee = http_request($url_detail_Shopee);
            $data_detail_Shopee = json_decode($data_detail_Shopee, TRUE);

            
            $price_Shopee = substr($data_detail_Shopee["item"]["price"], 0, -5);
            //end get product price

            $img_url_Shopee = 'https://cf.shopee.co.id/file/'.$data_detail_Shopee["item"]["image"];

            //get shop name
            $shop_detail_Shopee = 'https://shopee.co.id/api/v2/shop/get?is_brief=1&shopid='.$data_detail_Shopee["item"]["shopid"];
            $shop_detail_Shopee = http_request($shop_detail_Shopee);
            $shop_detail_Shopee = json_decode($shop_detail_Shopee, TRUE);
            $shop_name_Shopee = $shop_detail_Shopee["data"]['name'];
            $shop_location_Shopee = $data_detail_Shopee["item"]["shop_location"];

            $link_detail_Shopee = 'https://shopee.co.id/'.str_replace(' ', '-', $profileShopee["items"][$x]["name"]).'-i.'.$data_detail_Shopee["item"]["shopid"].'.'.$data_detail_Shopee["item"]["itemid"];
            $dataShopee_arr['data'][] = array('image_url' => $img_url_Shopee, 'product_name' => $product_name_Shopee, 'price_format' => $price_Shopee, 'shop_name' => $shop_name_Shopee, 'shop_location' => $shop_location_Shopee);
            $x++;
        }
        //Shopee End

        //Tokopedia
        $data_arr = array();
        //link with price filter
        $url = "https://ta.tokopedia.com/promo/v1/display/ads?user_id=0&ep=product&item=10&src=search&device=desktop&page=2&pmin=0&pmax=0&q=mouse&fshop=1";
        
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
        //Tokopedia End

        return view::make('home', compact('dataShopee_arr','data_arr'));

    }
    public function find()
    {
        if (isset($_POST['find'])) {
            $search = $_POST['text_value'];
            $search = str_replace(' ', '%20', $search);

            //Shopee
            $dataShopee_arr = array();
            $urlShopee ="https://shopee.co.id/api/v2/search_items/?by=relevancy&keyword=".$search."&limit=10&newest=0&order=desc&page_type=search&price_max=0&price_min=0";
            $profileShopee = http_request($urlShopee);
            $profileShopee = json_decode($profileShopee, TRUE);
            $x = 0;
            foreach ($profileShopee["items"] as $profil){
                $product_name_Shopee = $profileShopee["items"][$x]["name"];

                //start get product price
                $shopid_Shopee = $profileShopee["items"][$x]["shopid"];
                $itemid_Shopee = $profileShopee["items"][$x]["itemid"];
                
                $url_detail_Shopee = "https://shopee.co.id/api/v2/item/get?itemid=".$itemid_Shopee."&shopid=".$shopid_Shopee;

                $data_detail_Shopee = http_request($url_detail_Shopee);
                $data_detail_Shopee = json_decode($data_detail_Shopee, TRUE);

                
                $price_Shopee = substr($data_detail_Shopee["item"]["price"], 0, -5);
                //end get product price

                $img_url_Shopee = 'https://cf.shopee.co.id/file/'.$data_detail_Shopee["item"]["image"];

                //get shop name
                $shop_detail_Shopee = 'https://shopee.co.id/api/v2/shop/get?is_brief=1&shopid='.$data_detail_Shopee["item"]["shopid"];
                $shop_detail_Shopee = http_request($shop_detail_Shopee);
                $shop_detail_Shopee = json_decode($shop_detail_Shopee, TRUE);
                $shop_name_Shopee = $shop_detail_Shopee["data"]['name'];
                $shop_location_Shopee = $data_detail_Shopee["item"]["shop_location"];

                $link_detail_Shopee = 'https://shopee.co.id/'.str_replace(' ', '-', $profileShopee["items"][$x]["name"]).'-i.'.$data_detail_Shopee["item"]["shopid"].'.'.$data_detail_Shopee["item"]["itemid"];
                $dataShopee_arr['data'][] = array('image_url' => $img_url_Shopee, 'product_name' => $product_name_Shopee, 'price_format' => $price_Shopee, 'shop_name' => $shop_name_Shopee, 'shop_location' => $shop_location_Shopee);
                $x++;
            }
            //Shopee End


            //Tokopedia
            $data_arr = array();
            
            //link with price filter
            $url = "https://ta.tokopedia.com/promo/v1/display/ads?user_id=0&ep=product&item=10&src=search&device=desktop&page=2&pmin=0&pmax=0&q=" . $search . "&fshop=1";
        
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
            //Tokopedia End

            return view::make('home', compact('dataShopee_arr','data_arr'));

        }
    }
}
