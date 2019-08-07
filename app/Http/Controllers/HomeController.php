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

        //get city data
        $city_url = "https://api.myjson.com/bins/8cnk5";
        $city_data = http_request($city_url);
        $city_data = json_decode($city_data, TRUE);


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
                'keyword' => 'List Kosong',
                'product_url' => "////"
            )
        ));

        $cartCollection = \Cart::getContent();

        $cartCollection->toArray();

        //cek data empty
        if (empty($data_arr)) {
            $tokpedisempty = true;
        } else {
            $tokpedisempty = false;
        }
        if (empty($dataShopee_arr)) {
            $shopeeisempty = true;
        } else {
            $shopeeisempty = false;
        }

        return view::make('home', compact('cartCollection', 'city_data', 'tokpedisempty', 'shopeeisempty'));
    }
    public function find(Request $request)
    {

        if (isset($_POST['find'])) {
            $search = $_POST['text_value'];
            if (empty($_POST['limit'])) {
                $limit = 0;
            } else {
                $limit = $_POST['limit'];
            }
            if (empty($_POST['harga_min'])) {
                $pmin = 0;
            } else {
                $pmin = $_POST['harga_min'];
            }
            if (empty($_POST['harga_maks'])) {
                $pmaks = 0;
            } else {
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

            $dataShopee_arr = find_shopee($search, $city_value_shopee, $city_value[0], $limit, $pmaks, $pmin);
            //Shopee End


            //Tokopedia
            $data_arr = array();

            $search = $_POST['text_value'];

            $search = str_replace(' ', '%20', $search);

            $data_arr = find_tokopedia($search, $limit, $city_value_shopee, $city_value[0], $pmin, $pmaks);
            //Tokopedia End

            $countshopee = sizeof($dataShopee_arr['data']);
            $counttokped = sizeof($data_arr['data']);

            //cek data empty
            if (empty($data_arr)) {
                $tokpedisempty = true;
            } else {
                $tokpedisempty = false;
            }
            if (empty($dataShopee_arr)) {
                $shopeeisempty = true;
            } else {
                $shopeeisempty = false;
            }

            $cartCollection = \Cart::getContent();

            $cartCollection->toArray();
            return view::make('home', compact('dataShopee_arr', 'data_arr', 'countshopee', 'counttokped', 'cartCollection', 'city_data', 'tokpedisempty', 'shopeeisempty'));
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
            if (empty($_POST['limit'])) {
                $limit = 0;
            } else {
                $limit = $_POST['limit'];
            }
            if (empty($_POST['harga_min'])) {
                $pmin = 0;
            } else {
                $pmin = $_POST['harga_min'];
            }
            if (empty($_POST['harga_maks'])) {
                $pmaks = 0;
            } else {
                $pmaks = $_POST['harga_maks'];
            }

            $cekurl = explode(".", $search);

            //tokopedia   
            if ($cekurl[1] == "tokopedia") {
                $url = $search;
                include(app_path() . '\Library\simple_html_dom.php');
                $data_arr = find_link_tokopedia($search, $city_value_shopee, $city_value_tokopedia, $pmin, $pmaks, $url);

                //tokopedia
                $counttokped = 0;
                $countshopee = -1;
            } else {
                //shopee
                $search = $_POST['search_link'];
                
                $dataShopee_arr = find_link_shopee($search, $city_value_shopee, $city_value_tokopedia, $pmaks, $pmin);
                //shopee

                $countshopee = 0;
                $counttokped = -1;
            }
            $cartCollection = \Cart::getContent();

            $cartCollection->toArray();

            //cek data empty
            if (empty($data_arr)) {
                $tokpedisempty = true;
            } else {
                $tokpedisempty = false;
            }
            if (empty($dataShopee_arr)) {
                $shopeeisempty = true;
            } else {
                $shopeeisempty = false;
            }

            return view::make('home', compact('dataShopee_arr', 'data_arr', 'countshopee', 'counttokped', 'cartCollection', 'city_data', 'tokpedisempty', 'shopeeisempty'));
        }
    }

    public function post(Request $request)
    {

        \Cart::add(array(
            'id' => $request->id,
            'name' => $request->product_name,
            'price' => $request->price,
            'quantity' => 1,
            'attributes' => array(
                'image_url' => $request->image_url,
                'price_format' => $request->price_format,
                'shop_name' => $request->shop_name,
                'shop_location' => $request->shop_location,
                'keyword' => $request->text_value,
                'keyword_value_location_tokopedia' => $request->keyword_value_location_tokopedia,
                'keyword_value_location_shopee' => $request->keyword_value_location_shopee,
                'keyword_max' => $request->keyword_max,
                'keyword_min' => $request->keyword_min,
                'product_url' => $request->product_url
            )
        ));

        $cartCollection = \Cart::getContent();

        $cartCollection->toArray();

        return response()->json($cartCollection);
    }

    public function delete(Request $req)
    {
        $id = $req->id_delete;

        \Cart::remove($id);

        $cartCollection = \Cart::getContent();

        $cartCollection->toArray();

        return response()->json($cartCollection);
    }
}
