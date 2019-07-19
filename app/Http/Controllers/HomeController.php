<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Darryldecode\Cart\Cart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $item_count = 0;

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
        //default cart item
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
                'product_url' => "////"
            )
        ));

        $cartCollection = \Cart::getContent();

        $cartCollection->toArray();

        //list all available city in tokopedia
        $city_url = "https://ace.tokopedia.com/v4/dynamic_attributes?scheme=https&device=desktop&related=true&page=9&ob=23&st=product&fcity=0&source=search&q=&unique_id=c8c1be17273f45f9b5d1c5346b116570&safe_search=false";
        $data_city = http_request($city_url);
        $data_city = json_decode($data_city, TRUE);

        $data_arr = array();
            
        //tokopedia
    
        $url = "https://ace.tokopedia.com/search/product/v3?scheme=https&device=desktop&related=true&catalog_rows=5&source=search&ob=23&st=product&rows=200&start=0&q=mouse&unique_id=a5e21c08aa434ccda179065dc7e41c73&safe_search=false";

        $profile = http_request($url);
        $profile = json_decode($profile, TRUE);
    
        $i = 0;
        foreach ($profile["data"] as $profil) {
            $id = $profile['data']['products'][$i]['id'];
            $image_url = $profile['data']['products'][$i]['image_url'];
            $product_name = $profile['data']['products'][$i]['name'];
            $price_format = $profile['data']['products'][$i]['price'];
            $price = $profile['data']['products'][$i]['price_int'];
            $shop_name = $profile['data']['products'][$i]['shop']['name'];
            $shop_location = $profile['data']['products'][$i]['shop']['location'];
            $product_url = $profile['data']['products'][$i]['url'];

            // ads item
            // $id = $profile['data'][$i]['product']['id'];
            // $image_url = $profile['data'][$i]['product']['image']['m_url'];
            // $product_name = $profile['data'][$i]['product']['name'];
            // $price_format = $profile['data'][$i]['product']['price_format'];
            // $price = $profile['data'][$i]['product']['price'];
            // $shop_name = $profile['data'][$i]['shop']['name'];
            // $shop_location = $profile['data'][$i]['shop']['location'];

            $search = "mouse";

            $data_arr['data'][] = array('id' => $id, 'image_url' => $image_url, 'product_name' => $product_name, 'price_format' => $price_format, 'price' => $price, 'shop_name' => $shop_name, 'shop_location' => $shop_location, 'product_url' => $product_url, 'keyword' => $search);
            $i++;
        }
        return View::make('home', array('data_arr' => $data_arr, 'cart_data' => $cartCollection, 'data_city' => $data_city));

    }
    public function find()
    {
        if (isset($_POST['find'])) {
            $data_arr = array();

            //list all available city in tokopedia
            $city_url = "https://ace.tokopedia.com/v4/dynamic_attributes?scheme=https&device=desktop&related=true&page=9&ob=23&st=product&fcity=0&source=search&q=&unique_id=c8c1be17273f45f9b5d1c5346b116570&safe_search=false";
            $data_city = http_request($city_url);
            $data_city = json_decode($data_city, TRUE);
            
            //tokopedia
            $search = $_POST['text_value'];
            $location = $_POST['location'];
        
            $search = str_replace(' ', '%20', $search);
        
            $url = "https://ace.tokopedia.com/search/product/v3?scheme=https&device=desktop&related=true&catalog_rows=5&source=search&ob=23&st=product&rows=200&start=0&fcity=".$location."&q=" .$search. "&unique_id=a5e21c08aa434ccda179065dc7e41c73&safe_search=false";
            
            // ads url
            // $url = "https://ta.tokopedia.com/promo/v1/display/ads?user_id=0&ep=product&item=10&src=search&device=desktop&page=2&q=" . $search . "&fshop=1";
        
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
                $id = $profile['data']['products'][$i]['id'];
                $image_url = $profile['data']['products'][$i]['image_url'];
                $product_name = $profile['data']['products'][$i]['name'];
                $price_format = $profile['data']['products'][$i]['price'];
                $price = $profile['data']['products'][$i]['price_int'];
                $shop_name = $profile['data']['products'][$i]['shop']['name'];
                $shop_location = $profile['data']['products'][$i]['shop']['location'];
                $product_url = $profile['data']['products'][$i]['url'];

                // ads item
                // $id = $profile['data'][$i]['product']['id'];
                // $image_url = $profile['data'][$i]['product']['image']['m_url'];
                // $product_name = $profile['data'][$i]['product']['name'];
                // $price_format = $profile['data'][$i]['product']['price_format'];
                // $price = $profile['data'][$i]['product']['price'];
                // $shop_name = $profile['data'][$i]['shop']['name'];
                // $shop_location = $profile['data'][$i]['shop']['location'];
                
                $data_arr['data'][] = array('id' => $id, 'image_url' => $image_url, 'product_name' => $product_name, 'price_format' => $price_format, 'price' => $price, 'shop_name' => $shop_name, 'shop_location' => $shop_location, 'product_url' => $product_url, 'keyword' => $search);
                $i++;
            }
            
            $cartCollection = \Cart::getContent();

            $cartCollection->toArray();

            return View::make('home', array('data_arr'=>$data_arr, 'cart_data' => $cartCollection, 'data_city' => $data_city));
            //dd($data_arr);
            // print "<pre>";
            // print_r($data_arr);
            // print "</pre>";
        }
        if (isset($_POST['add_button'])){

            $data_arr = array();

            //list all available city in tokopedia
            $city_url = "https://ace.tokopedia.com/v4/dynamic_attributes?scheme=https&device=desktop&related=true&page=9&ob=23&st=product&fcity=0&source=search&q=&unique_id=c8c1be17273f45f9b5d1c5346b116570&safe_search=false";
            $data_city = http_request($city_url);
            $data_city = json_decode($data_city, TRUE);
            
            foreach($data_city['data']['filter'][0]['options'] as $city){
                if (strpos($city['name'], $_POST['shop_location']) !== false){
                    $city_code = $city['value'];
                    break;
                } 
            }

            //tokopedia
            $search = $_POST['text_value'];
            $location = $city_code;

            $search = str_replace(' ', '%20', $search);
        
            $url = "https://ace.tokopedia.com/search/product/v3?scheme=https&device=desktop&related=true&catalog_rows=5&source=search&ob=23&st=product&rows=200&start=0&fcity=".$location."&q=" .$search. "&unique_id=a5e21c08aa434ccda179065dc7e41c73&safe_search=false";
            
            // ads url
            // $url = "https://ta.tokopedia.com/promo/v1/display/ads?user_id=0&ep=product&item=10&src=search&device=desktop&page=2&q=" . $search . "&fshop=1";
        
            $profile = http_request($url);
        
            //replace JSON string to Array
            $profile = json_decode($profile, TRUE);

            $i = 0;
            foreach ($profile["data"] as $profil) {

                $id = $profile['data']['products'][$i]['id'];
                $image_url = $profile['data']['products'][$i]['image_url'];
                $product_name = $profile['data']['products'][$i]['name'];
                $price_format = $profile['data']['products'][$i]['price'];
                $price = $profile['data']['products'][$i]['price_int'];
                $shop_name = $profile['data']['products'][$i]['shop']['name'];
                $shop_location = $profile['data']['products'][$i]['shop']['location'];
                $product_url = $profile['data']['products'][$i]['url'];

                // ads item
                // $id = $profile['data'][$i]['product']['id'];
                // $image_url = $profile['data'][$i]['product']['image']['m_url'];
                // $product_name = $profile['data'][$i]['product']['name'];
                // $price_format = $profile['data'][$i]['product']['price_format'];
                // $price = $profile['data'][$i]['product']['price'];
                // $shop_name = $profile['data'][$i]['shop']['name'];
                // $shop_location = $profile['data'][$i]['shop']['location'];
                
                $data_arr['data'][] = array('id' => $id, 'image_url' => $image_url, 'product_name' => $product_name, 'price_format' => $price_format, 'price' => $price, 'shop_name' => $shop_name, 'shop_location' => $shop_location, 'product_url' => $product_url, 'keyword' => $search);
                $i++;
            }

            //cart
            $id = $_POST['id'];
            $image_url = $_POST['image_url'];
            $product_name = $_POST['product_name'];
            $price_format = $_POST['price_format'];
            $price = $_POST['price'];
            $shop_name = $_POST['shop_name'];
            $shop_location = $_POST['shop_location'];

            \Cart::add(array(
                'id' => $id,
                'name' => $product_name,
                'price' => $price,
                'quantity' => 1,
                'attributes' => array(
                    'image_url' => $image_url,
                    'price_format' => $price_format,
                    'shop_name' => $shop_name,
                    'shop_location' => $shop_location,
                    'keyword' => $search,
                    'product_url' => $product_url
                )
            ));
    
            $cartCollection = \Cart::getContent();
    
            $cartCollection->toArray();

            return View::make('home', array('cart_data' => $cartCollection, 'data_arr' => $data_arr, 'data_city' => $data_city));
        }
        if (isset($_POST['delete_button'])){

            $data_arr = array();

            //list all available city in tokopedia
            $city_url = "https://ace.tokopedia.com/v4/dynamic_attributes?scheme=https&device=desktop&related=true&page=9&ob=23&st=product&fcity=0&source=search&q=&unique_id=c8c1be17273f45f9b5d1c5346b116570&safe_search=false";
            $data_city = http_request($city_url);
            $data_city = json_decode($data_city, TRUE);

            foreach($data_city['data']['filter'][0]['options'] as $city){
                if (strpos($city['name'], $_POST['shop_location']) !== false){
                    $city_code = $city['value'];
                    break;
                } 
            }
            
            //tokopedia
            $search = $_POST['text_value'];
            $location = $city_code;
        
            $search = str_replace(' ', '%20', $search);
        
            $url = "https://ace.tokopedia.com/search/product/v3?scheme=https&device=desktop&related=true&catalog_rows=5&source=search&ob=23&st=product&rows=200&start=0&fcity=".$location."&q=" .$search. "&unique_id=a5e21c08aa434ccda179065dc7e41c73&safe_search=false";
            
            // ads url
            // $url = "https://ta.tokopedia.com/promo/v1/display/ads?user_id=0&ep=product&item=10&src=search&device=desktop&page=2&q=" . $search . "&fshop=1";
        
            $profile = http_request($url);
        
            //replace JSON string to Array
            $profile = json_decode($profile, TRUE);

            $i = 0;
            foreach ($profile["data"] as $profil) {

                $id = $profile['data']['products'][$i]['id'];
                $image_url = $profile['data']['products'][$i]['image_url'];
                $product_name = $profile['data']['products'][$i]['name'];
                $price_format = $profile['data']['products'][$i]['price'];
                $price = $profile['data']['products'][$i]['price_int'];
                $shop_name = $profile['data']['products'][$i]['shop']['name'];
                $shop_location = $profile['data']['products'][$i]['shop']['location'];
                $product_url = $profile['data']['products'][$i]['url'];


                // ads item
                // $id = $profile['data'][$i]['product']['id'];
                // $image_url = $profile['data'][$i]['product']['image']['m_url'];
                // $product_name = $profile['data'][$i]['product']['name'];
                // $price_format = $profile['data'][$i]['product']['price_format'];
                // $price = $profile['data'][$i]['product']['price'];
                // $shop_name = $profile['data'][$i]['shop']['name'];
                // $shop_location = $profile['data'][$i]['shop']['location'];
                
                $data_arr['data'][] = array('id' => $id, 'image_url' => $image_url, 'product_name' => $product_name, 'price_format' => $price_format, 'price' => $price, 'shop_name' => $shop_name, 'shop_location' => $shop_location, 'product_url' => $product_url, 'keyword' => $search);
                $i++;
            }

            $delete_id = $_POST['id_delete'];

            \Cart::remove($delete_id);

            $cartCollection = \Cart::getContent();
            $cartCollection->toArray();

            return View::make('home', array('data_arr' => $data_arr, 'cart_data' => $cartCollection, 'data_city' => $data_city));

        }
    }
}
