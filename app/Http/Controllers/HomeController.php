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

        $city_url = "https://api.myjson.com/bins/8cnk5";
        $city_data = http_request($city_url);
        $city_data = json_decode($city_data, TRUE);
        
        //Shopee
        $dataShopee_arr = array();
        $urlShopee ="https://shopee.co.id/api/v2/search_items/?by=relevancy&keyword=mouse&limit=10&newest=0&order=desc&page_type=search&price_max=0&price_min=0";
        $profileShopee = http_request($urlShopee);
        $profileShopee = json_decode($profileShopee, TRUE);
        $x = 0;
        foreach ($profileShopee["items"] as $profil){
            $product_id_Shopee = $profileShopee['items'][$x]['itemid'];
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
            
            $search = "mouse";
            
            $product_url_Shopee = $link_detail_Shopee;

            $city_value_tokopedia = "174,175,176,177,178,179";
            $city_value_shopee = "DKI Jakarta";

            $keyword_max = 0;
            $keyword_min = 0;

            $dataShopee_arr['data'][] = array('id' => $product_id_Shopee, 'image_url' => $img_url_Shopee, 'product_name' => $product_name_Shopee, 'price_format' => $price_Shopee, 'price' => $price_Shopee, 'shop_name' => $shop_name_Shopee, 'shop_location' => $shop_location_Shopee, 'product_url' => $product_url_Shopee, 'keyword' => $search, 'keyword_value_location_tokopedia' => $city_value_tokopedia, 'keyword_value_location_shopee' => $city_value_shopee, 'keyword_max' => $keyword_max, 'keyword_min' => $keyword_min);
            $x++;
            
        }
        // // list all available city in shopee

        // $shopee_city_url = "https://shopee.co.id/api/v2/location_filter/get_all";
        // $data_city_shopee = http_request($shopee_city_url);
        // $data_city_shopee = json_decode($data_city_shopee, TRUE);

        //Shopee End


        //Tokopedia
        $data_arr = array();
        //link with price filter
        $url = "https://ace.tokopedia.com/search/product/v3?scheme=https&device=desktop&related=true&catalog_rows=5&source=search&ob=23&st=product&rows=200&start=0&q=mouse&unique_id=a5e21c08aa434ccda179065dc7e41c73&safe_search=false";
        

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
                'keyword_max' => 0,
                'keyword_min' => 0,
                'keyword_value_location_tokopedia' => '175',
                'keyword_value_location_shopee' => 'DKI Jakarta',
                'product_url' => "////"
            )
        ));

        $cartCollection = \Cart::getContent();

        $cartCollection->toArray();

        // //list all available city in tokopedia
        // $city_url = "https://ace.tokopedia.com/v4/dynamic_attributes?scheme=https&device=desktop&related=true&page=9&ob=23&st=product&fcity=0&source=search&q=&unique_id=c8c1be17273f45f9b5d1c5346b116570&safe_search=false";
        // $data_city = http_request($city_url);
        // $data_city = json_decode($data_city, TRUE);

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

            $city_value_shopee = "DKI Jakarta";
            $city_value_tokopedia = "174,175,176,177,178,179";

            $keyword_max = 0;
            $keyword_min = 0;
            
            $data_arr['data'][] = array('id' => $id, 'image_url' => $image_url, 'product_name' => $product_name, 'price_format' => $price_format, 'price' => $price, 'shop_name' => $shop_name, 'shop_location' => $shop_location, 'product_url' => $product_url, 'keyword' => $search, 'keyword_value_location_tokopedia' => $city_value_tokopedia, 'keyword_value_location_shopee' => $city_value_shopee, 'keyword_max' => $keyword_max, 'keyword_min' => $keyword_min);
            $i++;
            
        }
   
        //Tokopedia End
        $countshopee= $x;
        $counttokped= $i;
    
        return view::make('home', compact('dataShopee_arr','data_arr','countshopee','counttokped','cartCollection', 'city_data'));


    }
    public function find()
    {
        if (isset($_POST['find'])) {
            $search = $_POST['text_value'];
            if(empty($_POST['limit'])){
                $limit = 0;
            }
            else{
                $limit = $_POST['limit'];
            }  
            if(empty($_POST['harga_min'])){
                $pmin = 0;
            }
            else{
                $pmin = $_POST['harga_min'];
            }
            if(empty($_POST['harga_maks'])){
                $pmaks = 0;
            }
            else{
                $pmaks = $_POST['harga_maks'];
            }
           
            $search = str_replace(' ', '%20', $search);

            // list all city
            $city_url = "https://api.myjson.com/bins/8cnk5";
            $city_data = http_request($city_url);
            $city_data = json_decode($city_data, TRUE);

            // get city value from home
            $city_value = explode('|', $_POST['location']);

            // change space into %2520 for shopee location
            $city_value_shopee = str_replace(' ', '%2520', $city_value[1]);

            //Shopee
            $dataShopee_arr = array();
            $urlShopee ="https://shopee.co.id/api/v2/search_items/?by=relevancy&keyword=".$search."&locations=".$city_value_shopee."&limit=".$limit."&newest=0&order=desc&page_type=search&price_max=".$pmaks."&price_min=".$pmin;
            $profileShopee = http_request($urlShopee);
            
            $profileShopee = json_decode($profileShopee, TRUE);
            $x = 0;
            foreach ($profileShopee["items"] as $profil){
                $product_id_Shopee = $profileShopee['items'][$x]['itemid'];
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
            
                $product_url_Shopee =  $link_detail_Shopee;
               
                $dataShopee_arr['data'][] = array('id' => $product_id_Shopee, 'image_url' => $img_url_Shopee, 'product_name' => $product_name_Shopee, 'price_format' => $price_Shopee, 'price' => $price_Shopee, 'shop_name' => $shop_name_Shopee, 'shop_location' => $shop_location_Shopee, 'product_url' => $product_url_Shopee, 'keyword' => $search, 'keyword_value_location_tokopedia' => $city_value[0], 'keyword_value_location_shopee' => $city_value[1], 'keyword_max' => $pmaks, 'keyword_min' => $pmin);
                $x++;
                
            }
            //Shopee End


            //Tokopedia
            $data_arr = array();

            // //list all available city in tokopedia
            // $city_url = "https://ace.tokopedia.com/v4/dynamic_attributes?scheme=https&device=desktop&related=true&page=9&ob=23&st=product&fcity=0&source=search&q=&unique_id=c8c1be17273f45f9b5d1c5346b116570&safe_search=false";
            // $data_city = http_request($city_url);
            // $data_city = json_decode($data_city, TRUE);
            

            //tokopedia
            $search = $_POST['text_value'];
            //$location = $_POST['location'];
        
            $search = str_replace(' ', '%20', $search);
            //link with price filter
            $url = "https://ace.tokopedia.com/search/product/v3?scheme=https&device=desktop&related=true&catalog_rows=5&source=search&ob=23&st=product&rows=200&item=".$limit."&start=0&fcity=".$city_value[0]."&q=" .$search. "&pmin=".$pmin."&pmax=".$pmaks."&unique_id=a5e21c08aa434ccda179065dc7e41c73&safe_search=false";
            
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

            foreach ($profile["data"]['products'] as $profil) {
                $id = $profil['id'];
                $image_url = $profil['image_url'];
                $product_name = $profil['name'];
                $price_format = $profil['price'];
                $price = $profil['price_int'];
                $shop_name = $profil['shop']['name'];
                $shop_location = $profil['shop']['location'];
                $product_url = $profil['url'];

                // ads item
                // $id = $profile['data'][$i]['product']['id'];
                // $image_url = $profile['data'][$i]['product']['image']['m_url'];
                // $product_name = $profile['data'][$i]['product']['name'];
                // $price_format = $profile['data'][$i]['product']['price_format'];
                // $price = $profile['data'][$i]['product']['price'];
                // $shop_name = $profile['data'][$i]['shop']['name'];
                // $shop_location = $profile['data'][$i]['shop']['location'];
                
                $data_arr['data'][] = array('id' => $id, 'image_url' => $image_url, 'product_name' => $product_name, 'price_format' => $price_format, 'price' => $price, 'shop_name' => $shop_name, 'shop_location' => $shop_location, 'product_url' => $product_url, 'keyword' => $search, 'keyword_value_location_tokopedia' => $city_value[0], 'keyword_value_location_shopee' => $city_value[1], 'keyword_max' => $pmaks, 'keyword_min' => $pmin);
                $i++;
               
            }

            //Tokopedia End

            $countshopee= $x;
            $counttokped= $i;
            

            
            $cartCollection = \Cart::getContent();

            $cartCollection->toArray();
            return view::make('home', compact('dataShopee_arr','data_arr','countshopee','counttokped','cartCollection','city_data'));


        }


        //search by link
        if (isset($_POST['find_link'])) {
             
         // list all city
         $city_url = "https://api.myjson.com/bins/8cnk5";
         $city_data = http_request($city_url);
         $city_data = json_decode($city_data, TRUE);

         // get city value from home
         $city_value = explode('|', $_POST['location']);
         $city_value_tokopedia = $city_value[0];
         // change space into %2520 for shopee location
         $city_value_shopee = str_replace(' ', '%2520', $city_value[1]);

           // get max and min price from home
           $keyword_max = $_POST['harga_maks'];
           $keyword_min = $_POST['harga_min'];

            
            $data_arr = array();
            $search = $_POST['search_link'];
            if(empty($_POST['limit'])){
                $limit = 0;
            }
            else{
                $limit = $_POST['limit'];
            }  
            if(empty($_POST['harga_min'])){
                $pmin = 0;
            }
            else{
                $pmin = $_POST['harga_min'];
            }
            if(empty($_POST['harga_maks'])){
                $pmaks = 0;
            }
            else{
                $pmaks = $_POST['harga_maks'];
            }
            
            $cekurl = explode(".",$search);

            //tokopedia   
            if($cekurl[1]=="tokopedia"){
                include(app_path() . '\Library\simple_html_dom.php');
            
                $html = file_get_html($search);
            
                // find item image
                foreach($html->find('div[id=content-container] div.container-product div.clearfix div.rvm-left-column div.rvm-pdp-product div.rvm-left-column--left div.product-detail__img-holder div.content-img ') as $e)
                {
                    $tokped_link_img= $e->innertext;
                    break;
                }
                $id = $search;
                $tokped_link_img = str_replace('<img', '', $tokped_link_img);
                $tokped_link_img = str_replace('src=', '', $tokped_link_img);
                $tokped_link_img = str_replace('"', '', $tokped_link_img);
                $tokped_link_img = str_replace('/>', '', $tokped_link_img);
                $tokped_link_img = str_replace(' ', '', $tokped_link_img);
                    
                // find item title
                foreach($html->find('div.rvm-left-column--right h1.rvm-product-title span') as $e){
                    $tokped_link_productname= $e->innertext;
                }
            
                // find item price
                foreach($html->find('div.rvm-price-holder div.rvm-price span') as $e){
                    $tokped_link_productprice=$e->innertext;
                }
                $tokped_link_price = str_replace('.', '', $tokped_link_productprice);
                
                // find shop name
                foreach($html->find('div.sticky-footer div.container div.pdp-shop div.pdp-shop__info div.pdp-shop__info__name-wrapper span') as $e){
                    $tokped_link_shopname= $e->innertext;
                }
                    
                foreach($html->find('div.sticky-footer div.container div.pdp-shop div.pdp-shop__info p.pdp-shop__info__stats span') as $e){
                    $tokped_link_shoplocation= $e->innertext;
                    break;
                }
            
                $tokped_link_shoplocation= str_replace("Online", "", $tokped_link_shoplocation);
                $tokped_link_shoplocation= str_replace("Hari", "", $tokped_link_shoplocation);
                $tokped_link_shoplocation= str_replace("ini", "", $tokped_link_shoplocation);
                $data_arr['data'][] = array('id' => $id, 'image_url' => $tokped_link_img, 'product_name' => $tokped_link_productname, 'price_format' => $tokped_link_productprice, 'price' => $tokped_link_price, 'shop_name' => $tokped_link_shopname, 'shop_location' => $tokped_link_shoplocation, 'product_url' => $search, 'keyword' => $search, 'keyword_value_location_tokopedia' => $city_value_tokopedia, 'keyword_value_location_shopee' => $city_value_shopee, 'keyword_max' => $keyword_max, 'keyword_min' => $keyword_min);
                //tokopedia
                $counttokped=0;
                $countshopee=-1;
            }
            else{
                //shopee
                $search = $_POST['search_link'];
                $arrlinkdetailshopee = explode(".",$search);
                $shopeeshopid=$arrlinkdetailshopee[3];
                $shopeeitemid=$arrlinkdetailshopee[4];

                $url_detail = "https://shopee.co.id/api/v2/item/get?itemid=".$shopeeitemid."&shopid=".$shopeeshopid;

                $data_detail = http_request($url_detail);
                $data_detail = json_decode($data_detail, TRUE);
                $price_Shopee = substr($data_detail["item"]["price"], 0, -5);
                //end get product price

                $img_url_Shopee = 'https://cf.shopee.co.id/file/'.$data_detail["item"]["image"];

                //get shop name
                $shop_detail = 'https://shopee.co.id/api/v2/shop/get?is_brief=1&shopid='.$data_detail["item"]["shopid"];
                $shop_detail = http_request($shop_detail);
                $shop_detail = json_decode($shop_detail, TRUE);
                $shop_name_Shopee = $shop_detail["data"]['name'];

                $link_detail = 'https://shopee.co.id/'.str_replace(' ', '-', $data_detail["item"]["name"]).'-i.'.$shopeeshopid.'.'.$shopeeitemid;
                $shop_location_Shopee =$shop_detail["data"]["shop_location"];
                $product_name_Shopee = $data_detail["item"]["name"];

                $product_url = $link_detail;
          
                $dataShopee_arr['data'][] = array('id' =>$shopeeitemid, 'image_url' => $img_url_Shopee, 'product_name' => $product_name_Shopee, 'price_format' => $price_Shopee, 'price' => $price_Shopee, 'shop_name' => $shop_name_Shopee, 'shop_location' => $shop_location_Shopee, 'product_url' => $product_url, 'keyword' => $search, 'keyword_value_location_tokopedia' => $city_value_tokopedia, 'keyword_value_location_shopee' => $city_value_shopee, 'keyword_max' => $keyword_max, 'keyword_min' => $keyword_min);
                //shopee
                
                $countshopee=0;
                $counttokped=-1;
            }
            $cartCollection = \Cart::getContent();
       
            $cartCollection->toArray();

            return view::make('home', compact('dataShopee_arr','data_arr','countshopee','counttokped','cartCollection','city_data'));
        }

        if (isset($_POST['add_button'])){

              // list all city
              $city_url = "https://api.myjson.com/bins/8cnk5";
              $city_data = http_request($city_url);
              $city_data = json_decode($city_data, TRUE);
              // get city value from home
              //$city_value = explode('|', $_POST['location']);
              $city_value_tokopedia = $_POST['keyword_value_location_tokopedia'];
              $city_value_shopee = $_POST['keyword_value_location_shopee'];

              // change space into %2520 for shopee location
              $city_value_shopee = str_replace(' ', '%2520', $city_value_shopee);

              // get max and min price from home
              $keyword_max = $_POST['keyword_max'];
              $keyword_min = $_POST['keyword_min'];
    
              $data_arr = array();
              

              if(empty($_POST['limit'])){
                    $limit = 0;
                }
                else{
                    $limit = $_POST['limit'];
                }  
                if(empty($_POST['harga_min'])){
                    $pmin = 0;
                }
                else{
                    $pmin = $_POST['harga_min'];
                }
                if(empty($_POST['harga_maks'])){
                    $pmaks = 0;
                }
                else{
                    $pmaks = $_POST['harga_maks'];
                }
                $search = $_POST['text_value'];
    
                $search = str_replace(' ', '%20', $search);

            if (filter_var($search, FILTER_VALIDATE_URL)) {

                $cekurl = explode(".",$search);
                //tokopedia   
                if($cekurl[1]=="tokopedia"){
                    include(app_path() . '\Library\simple_html_dom.php');
                
                    $html = file_get_html($search);
                
                    // find item image
                    foreach($html->find('div[id=content-container] div.container-product div.clearfix div.rvm-left-column div.rvm-pdp-product div.rvm-left-column--left div.product-detail__img-holder div.content-img ') as $e)
                    {
                        $tokped_link_img= $e->innertext;
                        break;
                    }
                    $id = $search;
                    $tokped_link_img = str_replace('<img', '', $tokped_link_img);
                    $tokped_link_img = str_replace('src=', '', $tokped_link_img);
                    $tokped_link_img = str_replace('"', '', $tokped_link_img);
                    $tokped_link_img = str_replace('/>', '', $tokped_link_img);
                    $tokped_link_img = str_replace(' ', '', $tokped_link_img);
                        
                    // find item title
                    foreach($html->find('div.rvm-left-column--right h1.rvm-product-title span') as $e){
                        $tokped_link_productname= $e->innertext;
                    }
                
                    // find item price
                    foreach($html->find('div.rvm-price-holder div.rvm-price span') as $e){
                        $tokped_link_productprice=$e->innertext;
                    }
                    $tokped_link_price = str_replace('.', '', $tokped_link_productprice);
                    
                    // find shop name
                    foreach($html->find('div.sticky-footer div.container div.pdp-shop div.pdp-shop__info div.pdp-shop__info__name-wrapper span') as $e){
                        $tokped_link_shopname= $e->innertext;
                    }
                        
                    foreach($html->find('div.sticky-footer div.container div.pdp-shop div.pdp-shop__info p.pdp-shop__info__stats span') as $e){
                        $tokped_link_shoplocation= $e->innertext;
                        break;
                    }
                
                    $tokped_link_shoplocation= str_replace("Online", "", $tokped_link_shoplocation);
                    $tokped_link_shoplocation= str_replace("Hari", "", $tokped_link_shoplocation);
                    $tokped_link_shoplocation= str_replace("ini", "", $tokped_link_shoplocation);
                    $data_arr['data'][] = array('id' => $id, 'image_url' => $tokped_link_img, 'product_name' => $tokped_link_productname, 'price_format' => $tokped_link_productprice, 'price' => $tokped_link_price, 'shop_name' => $tokped_link_shopname, 'shop_location' => $tokped_link_shoplocation, 'product_url' => $search, 'keyword' => $search, 'keyword_value_location_tokopedia' => $city_value_tokopedia, 'keyword_value_location_shopee' => $city_value_shopee, 'keyword_max' => $keyword_max, 'keyword_min' => $keyword_min);
                    //tokopedia
                    $counttokped=0;
                    $countshopee=-1;
                }
                else{
                    //shopee
                    $arrlinkdetailshopee = explode(".",$search);
                    $shopeeshopid=$arrlinkdetailshopee[3];
                    $shopeeitemid=$arrlinkdetailshopee[4];

                    $url_detail = "https://shopee.co.id/api/v2/item/get?itemid=".$shopeeitemid."&shopid=".$shopeeshopid;

                    $data_detail = http_request($url_detail);
                    $data_detail = json_decode($data_detail, TRUE);
                    $price_Shopee = substr($data_detail["item"]["price"], 0, -5);
                    //end get product price

                    $img_url_Shopee = 'https://cf.shopee.co.id/file/'.$data_detail["item"]["image"];

                    //get shop name
                    $shop_detail = 'https://shopee.co.id/api/v2/shop/get?is_brief=1&shopid='.$data_detail["item"]["shopid"];
                    $shop_detail = http_request($shop_detail);
                    $shop_detail = json_decode($shop_detail, TRUE);
                    $shop_name_Shopee = $shop_detail["data"]['name'];

                    $link_detail = 'https://shopee.co.id/'.str_replace(' ', '-', $data_detail["item"]["name"]).'-i.'.$shopeeshopid.'.'.$shopeeitemid;
                    $shop_location_Shopee =$shop_detail["data"]["shop_location"];
                    $product_name_Shopee = $data_detail["item"]["name"];

                    $product_url = $link_detail;
            
                    $dataShopee_arr['data'][] = array('id' =>$shopeeitemid, 'image_url' => $img_url_Shopee, 'product_name' => $product_name_Shopee, 'price_format' => $price_Shopee, 'price' => $price_Shopee, 'shop_name' => $shop_name_Shopee, 'shop_location' => $shop_location_Shopee, 'product_url' => $product_url, 'keyword' => $search, 'keyword_value_location_tokopedia' => $city_value_tokopedia, 'keyword_value_location_shopee' => $city_value_shopee, 'keyword_max' => $keyword_max, 'keyword_min' => $keyword_min);
                    //shopee
                    
                    $countshopee=0;
                    $counttokped=-1;
                }
            }
            else{
    
                //tokopedia
                $url = "https://ace.tokopedia.com/search/product/v3?scheme=https&device=desktop&related=true&catalog_rows=5&source=search&ob=23&st=product&rows=200&start=0&fcity=".$city_value_tokopedia."&q=" .$search. "&pmin=".$keyword_min."&pmax=".$keyword_max."&unique_id=a5e21c08aa434ccda179065dc7e41c73&safe_search=false";
                
                // ads url
                // $url = "https://ta.tokopedia.com/promo/v1/display/ads?user_id=0&ep=product&item=10&src=search&device=desktop&page=2&q=" . $search . "&fshop=1";
            
                $profile = http_request($url);
            
                //replace JSON string to Array
                $profile = json_decode($profile, TRUE);
    
                $i = 0;
                foreach ($profile["data"]["products"] as $profil) {
                    $id = $profil['id'];
                    $image_url = $profil['image_url'];
                    $product_name = $profil['name'];
                    $price_format = $profil['price'];
                    $price = $profil['price_int'];
                    $shop_name = $profil['shop']['name'];
                    $shop_location = $profil['shop']['location'];
                    $product_url = $profil['url'];
    
    
                    // ads item
                    // $id = $profile['data'][$i]['product']['id'];
                    // $image_url = $profile['data'][$i]['product']['image']['m_url'];
                    // $product_name = $profile['data'][$i]['product']['name'];
                    // $price_format = $profile['data'][$i]['product']['price_format'];
                    // $price = $profile['data'][$i]['product']['price'];
                    // $shop_name = $profile['data'][$i]['shop']['name'];
                    // $shop_location = $profile['data'][$i]['shop']['location'];
                    
                    $data_arr['data'][] = array('id' => $id, 'image_url' => $image_url, 'product_name' => $product_name, 'price_format' => $price_format, 'price' => $price, 'shop_name' => $shop_name, 'shop_location' => $shop_location, 'product_url' => $product_url, 'keyword' => $search, 'keyword_value_location_tokopedia' => $city_value_tokopedia, 'keyword_value_location_shopee' => $city_value_shopee, 'keyword_max' => $keyword_max, 'keyword_min' => $keyword_min);
                    $i++;
                }
    
                //Shopee
                $dataShopee_arr = array();
                $urlShopee ="https://shopee.co.id/api/v2/search_items/?by=relevancy&keyword=".$search."&locations=".$city_value_shopee."&limit=".$limit."&newest=0&order=desc&page_type=search&price_max=".$keyword_max."&price_min=".$keyword_min;
                $profileShopee = http_request($urlShopee);
                
                
                $profileShopee = json_decode($profileShopee, TRUE);
                $x = 0;
    
                foreach ($profileShopee["items"] as $profil){
                    $product_id_Shopee = $profileShopee['items'][$x]['itemid'];
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
                
                    $product_url_Shopee = "#";
    
                    $dataShopee_arr['data'][] = array('id' =>$product_id_Shopee, 'image_url' => $img_url_Shopee, 'product_name' => $product_name_Shopee, 'price_format' => $price_Shopee, 'price' => $price_Shopee, 'shop_name' => $shop_name_Shopee, 'shop_location' => $shop_location_Shopee, 'product_url' => $product_url, 'keyword' => $search, 'keyword_value_location_tokopedia' => $city_value_tokopedia, 'keyword_value_location_shopee' => $city_value_shopee, 'keyword_max' => $keyword_max, 'keyword_min' => $keyword_min);
                    $x++;
                    
                }
                //Shopee End
                $counttokped = $i;
                $countshopee = $x;
            }
           

            //cart
            $id = $_POST['id'];
            $image_url = $_POST['image_url'];
            $product_name = $_POST['product_name'];
            $price_format = $_POST['price_format'];
            $price = $_POST['price'];
            $shop_name = $_POST['shop_name'];
            $shop_location = $_POST['shop_location'];
            $product_url = $_POST['product_url'];

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
                    'keyword_value_location_tokopedia' => $city_value_tokopedia,
                    'keyword_value_location_shopee' => $city_value_shopee,
                    'keyword_max' => $keyword_max,
                    'keyword_min' => $keyword_min,
                    'product_url' => $product_url
                )
            ));
    
            $cartCollection = \Cart::getContent();
           
            $cartCollection->toArray();
           
            return view::make('home', compact('dataShopee_arr','data_arr','countshopee','counttokped','cartCollection','city_data'));
        }
        if (isset($_POST['delete_button'])){

            // list all city
            $city_url = "https://api.myjson.com/bins/8cnk5";
            $city_data = http_request($city_url);
            $city_data = json_decode($city_data, TRUE);
            // get city value from home
            //$city_value = explode('|', $_POST['location']);
            $city_value_tokopedia = $_POST['keyword_value_location_tokopedia'];
            $city_value_shopee = $_POST['keyword_value_location_shopee'];

            // change space into %2520 for shopee location
            $city_value_shopee = str_replace(' ', '%2520', $city_value_shopee);

            // get max and min price from home
            $keyword_max = $_POST['keyword_max'];
            $keyword_min = $_POST['keyword_min'];
  
            $data_arr = array();
            

            if(empty($_POST['limit'])){
                  $limit = 0;
              }
              else{
                  $limit = $_POST['limit'];
              }  
              if(empty($_POST['harga_min'])){
                  $pmin = 0;
              }
              else{
                  $pmin = $_POST['harga_min'];
              }
              if(empty($_POST['harga_maks'])){
                  $pmaks = 0;
              }
              else{
                  $pmaks = $_POST['harga_maks'];
              }
              $search = $_POST['text_value'];
  
              $search = str_replace(' ', '%20', $search);

            if (filter_var($search, FILTER_VALIDATE_URL)) {

                $cekurl = explode(".",$search);
                //tokopedia   
                if($cekurl[1]=="tokopedia"){
                    include(app_path() . '\Library\simple_html_dom.php');
                
                    $html = file_get_html($search);
                
                    // find item image
                    foreach($html->find('div[id=content-container] div.container-product div.clearfix div.rvm-left-column div.rvm-pdp-product div.rvm-left-column--left div.product-detail__img-holder div.content-img ') as $e)
                    {
                        $tokped_link_img= $e->innertext;
                        break;
                    }
                    $id = $search;
                    $tokped_link_img = str_replace('<img', '', $tokped_link_img);
                    $tokped_link_img = str_replace('src=', '', $tokped_link_img);
                    $tokped_link_img = str_replace('"', '', $tokped_link_img);
                    $tokped_link_img = str_replace('/>', '', $tokped_link_img);
                    $tokped_link_img = str_replace(' ', '', $tokped_link_img);
                        
                    // find item title
                    foreach($html->find('div.rvm-left-column--right h1.rvm-product-title span') as $e){
                        $tokped_link_productname= $e->innertext;
                    }
                
                    // find item price
                    foreach($html->find('div.rvm-price-holder div.rvm-price span') as $e){
                        $tokped_link_productprice=$e->innertext;
                    }
                    $tokped_link_price = str_replace('.', '', $tokped_link_productprice);
                    
                    // find shop name
                    foreach($html->find('div.sticky-footer div.container div.pdp-shop div.pdp-shop__info div.pdp-shop__info__name-wrapper span') as $e){
                        $tokped_link_shopname= $e->innertext;
                    }
                        
                    foreach($html->find('div.sticky-footer div.container div.pdp-shop div.pdp-shop__info p.pdp-shop__info__stats span') as $e){
                        $tokped_link_shoplocation= $e->innertext;
                        break;
                    }
                
                    $tokped_link_shoplocation= str_replace("Online", "", $tokped_link_shoplocation);
                    $tokped_link_shoplocation= str_replace("Hari", "", $tokped_link_shoplocation);
                    $tokped_link_shoplocation= str_replace("ini", "", $tokped_link_shoplocation);
                    $data_arr['data'][] = array('id' => $id, 'image_url' => $tokped_link_img, 'product_name' => $tokped_link_productname, 'price_format' => $tokped_link_productprice, 'price' => $tokped_link_price, 'shop_name' => $tokped_link_shopname, 'shop_location' => $tokped_link_shoplocation, 'product_url' => $search, 'keyword' => $search, 'keyword_value_location_tokopedia' => $city_value_tokopedia, 'keyword_value_location_shopee' => $city_value_shopee, 'keyword_max' => $keyword_max, 'keyword_min' => $keyword_min);
                    //tokopedia
                    $counttokped=0;
                    $countshopee=-1;
                }
                else{
                    //shopee
                    $arrlinkdetailshopee = explode(".",$search);
                    $shopeeshopid=$arrlinkdetailshopee[3];
                    $shopeeitemid=$arrlinkdetailshopee[4];

                    $url_detail = "https://shopee.co.id/api/v2/item/get?itemid=".$shopeeitemid."&shopid=".$shopeeshopid;

                    $data_detail = http_request($url_detail);
                    $data_detail = json_decode($data_detail, TRUE);
                    $price_Shopee = substr($data_detail["item"]["price"], 0, -5);
                    //end get product price

                    $img_url_Shopee = 'https://cf.shopee.co.id/file/'.$data_detail["item"]["image"];

                    //get shop name
                    $shop_detail = 'https://shopee.co.id/api/v2/shop/get?is_brief=1&shopid='.$data_detail["item"]["shopid"];
                    $shop_detail = http_request($shop_detail);
                    $shop_detail = json_decode($shop_detail, TRUE);
                    $shop_name_Shopee = $shop_detail["data"]['name'];

                    $link_detail = 'https://shopee.co.id/'.str_replace(' ', '-', $data_detail["item"]["name"]).'-i.'.$shopeeshopid.'.'.$shopeeitemid;
                    $shop_location_Shopee =$shop_detail["data"]["shop_location"];
                    $product_name_Shopee = $data_detail["item"]["name"];

                    $product_url = $link_detail;
            
                    $dataShopee_arr['data'][] = array('id' =>$shopeeitemid, 'image_url' => $img_url_Shopee, 'product_name' => $product_name_Shopee, 'price_format' => $price_Shopee, 'price' => $price_Shopee, 'shop_name' => $shop_name_Shopee, 'shop_location' => $shop_location_Shopee, 'product_url' => $product_url, 'keyword' => $search, 'keyword_value_location_tokopedia' => $city_value_tokopedia, 'keyword_value_location_shopee' => $city_value_shopee, 'keyword_max' => $keyword_max, 'keyword_min' => $keyword_min);
                    //shopee
                    
                    $countshopee=0;
                    $counttokped=-1;
                }
            }
            else{
    
                //tokopedia
                $url = "https://ace.tokopedia.com/search/product/v3?scheme=https&device=desktop&related=true&catalog_rows=5&source=search&ob=23&st=product&rows=200&start=0&fcity=".$city_value_tokopedia."&q=" .$search. "&pmin=".$keyword_min."&pmax=".$keyword_max."&unique_id=a5e21c08aa434ccda179065dc7e41c73&safe_search=false";
                
                // ads url
                // $url = "https://ta.tokopedia.com/promo/v1/display/ads?user_id=0&ep=product&item=10&src=search&device=desktop&page=2&q=" . $search . "&fshop=1";
            
                $profile = http_request($url);
            
                //replace JSON string to Array
                $profile = json_decode($profile, TRUE);
    
                $i = 0;
                foreach ($profile["data"]["products"] as $profil) {
                    $id = $profil['id'];
                    $image_url = $profil['image_url'];
                    $product_name = $profil['name'];
                    $price_format = $profil['price'];
                    $price = $profil['price_int'];
                    $shop_name = $profil['shop']['name'];
                    $shop_location = $profil['shop']['location'];
                    $product_url = $profil['url'];
    
    
                    // ads item
                    // $id = $profile['data'][$i]['product']['id'];
                    // $image_url = $profile['data'][$i]['product']['image']['m_url'];
                    // $product_name = $profile['data'][$i]['product']['name'];
                    // $price_format = $profile['data'][$i]['product']['price_format'];
                    // $price = $profile['data'][$i]['product']['price'];
                    // $shop_name = $profile['data'][$i]['shop']['name'];
                    // $shop_location = $profile['data'][$i]['shop']['location'];
                    
                    $data_arr['data'][] = array('id' => $id, 'image_url' => $image_url, 'product_name' => $product_name, 'price_format' => $price_format, 'price' => $price, 'shop_name' => $shop_name, 'shop_location' => $shop_location, 'product_url' => $product_url, 'keyword' => $search, 'keyword_value_location_tokopedia' => $city_value_tokopedia, 'keyword_value_location_shopee' => $city_value_shopee, 'keyword_max' => $keyword_max, 'keyword_min' => $keyword_min);
                    $i++;
                }
    
                //Shopee
                $dataShopee_arr = array();
                $urlShopee ="https://shopee.co.id/api/v2/search_items/?by=relevancy&keyword=".$search."&locations=".$city_value_shopee."&limit=".$limit."&newest=0&order=desc&page_type=search&price_max=".$keyword_max."&price_min=".$keyword_min;
                $profileShopee = http_request($urlShopee);
                
                
                $profileShopee = json_decode($profileShopee, TRUE);
                $x = 0;
    
                foreach ($profileShopee["items"] as $profil){
                    $product_id_Shopee = $profileShopee['items'][$x]['itemid'];
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
                
                    $product_url_Shopee = "#";
    
                    $dataShopee_arr['data'][] = array('id' =>$product_id_Shopee, 'image_url' => $img_url_Shopee, 'product_name' => $product_name_Shopee, 'price_format' => $price_Shopee, 'price' => $price_Shopee, 'shop_name' => $shop_name_Shopee, 'shop_location' => $shop_location_Shopee, 'product_url' => $product_url, 'keyword' => $search, 'keyword_value_location_tokopedia' => $city_value_tokopedia, 'keyword_value_location_shopee' => $city_value_shopee, 'keyword_max' => $keyword_max, 'keyword_min' => $keyword_min);
                    $x++;
                    
                }
                //Shopee End
                $counttokped = $i;
                $countshopee = $x;
            }

            $delete_id = $_POST['id_delete'];

            \Cart::remove($delete_id);
            
            $cartCollection = \Cart::getContent();
            $cartCollection->toArray();
            return view::make('home', compact('dataShopee_arr','data_arr','countshopee','counttokped','cartCollection','city_data'));

        }
    }
}
