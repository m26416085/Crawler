<?php
function http_request($url)
{
    // initialize curl
    $ch = curl_init();

    // set url 
    curl_setopt($ch, CURLOPT_URL, $url);

    // set user agent    
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

    // return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // $output contains the output string 
    $output = curl_exec($ch);

    // close curl 
    curl_close($ch);

    // return curl result
    return $output;
}

function find_tokopedia($search, $limit, $city_value_shopee, $city_value_tokopedia, $pmin, $pmaks)
{
    $data_arr = array();

    //link with price filter
    $url = "https://ace.tokopedia.com/search/product/v3?scheme=https&device=desktop&related=true&catalog_rows=5&source=search&ob=23&st=product&rows=" . $limit . "&item=" . $limit . "&start=0&fcity=" . $city_value_tokopedia . "&q=" . $search . "&pmin=" . $pmin . "&pmax=" . $pmaks . "&unique_id=a5e21c08aa434ccda179065dc7e41c73&safe_search=false";

    $profile = http_request($url);

    //replace JSON string to Array
    $profile = json_decode($profile, TRUE);

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

        $data_arr['data'][] = array('id' => $id, 'image_url' => $image_url, 'product_name' => $product_name, 'price_format' => $price_format, 'price' => $price, 'shop_name' => $shop_name, 'shop_location' => $shop_location, 'product_url' => $product_url, 'keyword' => $search, 'keyword_value_location_tokopedia' => $city_value_tokopedia, 'keyword_value_location_shopee' => $city_value_shopee, 'keyword_max' => $pmaks, 'keyword_min' => $pmin);
        $i++;
    }

    return $data_arr;
}

function find_shopee($search, $city_value_shopee, $city_value_tokopedia, $limit, $pmaks, $pmin)
{
    $dataShopee_arr = array();
    $urlShopee = "https://shopee.co.id/api/v2/search_items/?by=relevancy&keyword=" . $search . "&locations=" . $city_value_shopee . "&limit=" . $limit . "&newest=0&order=desc&page_type=search&price_max=" . $pmaks . "&price_min=" . $pmin;
    $profileShopee = http_request($urlShopee);

    $profileShopee = json_decode($profileShopee, TRUE);
    $x = 0;
    foreach ($profileShopee["items"] as $profil) {
        $product_id_Shopee = $profileShopee['items'][$x]['itemid'];
        $product_name_Shopee = $profileShopee["items"][$x]["name"];

        //start get product price
        $shopid_Shopee = $profileShopee["items"][$x]["shopid"];
        $itemid_Shopee = $profileShopee["items"][$x]["itemid"];

        $url_detail_Shopee = "https://shopee.co.id/api/v2/item/get?itemid=" . $itemid_Shopee . "&shopid=" . $shopid_Shopee;

        $data_detail_Shopee = http_request($url_detail_Shopee);
        $data_detail_Shopee = json_decode($data_detail_Shopee, TRUE);
        $price_Shopee = substr($data_detail_Shopee["item"]["price"], 0, -5);
        //end get product price

        $img_url_Shopee = 'https://cf.shopee.co.id/file/' . $data_detail_Shopee["item"]["image"];

        //get shop name
        $shop_detail_Shopee = 'https://shopee.co.id/api/v2/shop/get?is_brief=1&shopid=' . $data_detail_Shopee["item"]["shopid"];
        $shop_detail_Shopee = http_request($shop_detail_Shopee);
        $shop_detail_Shopee = json_decode($shop_detail_Shopee, TRUE);
        $shop_name_Shopee = $shop_detail_Shopee["data"]['name'];
        $shop_location_Shopee = $data_detail_Shopee["item"]["shop_location"];

        $link_detail_Shopee = 'https://shopee.co.id/' . str_replace(' ', '-', $profileShopee["items"][$x]["name"]) . '-i.' . $data_detail_Shopee["item"]["shopid"] . '.' . $data_detail_Shopee["item"]["itemid"];

        $product_url_Shopee =  $link_detail_Shopee;

        $dataShopee_arr['data'][] = array('id' => $product_id_Shopee, 'image_url' => $img_url_Shopee, 'product_name' => $product_name_Shopee, 'price_format' => $price_Shopee, 'price' => $price_Shopee, 'shop_name' => $shop_name_Shopee, 'shop_location' => $shop_location_Shopee, 'product_url' => $product_url_Shopee, 'keyword' => $search, 'keyword_value_location_tokopedia' => $city_value_tokopedia, 'keyword_value_location_shopee' => $city_value_shopee, 'keyword_max' => $pmaks, 'keyword_min' => $pmin);
        $x++;
    }

    return $dataShopee_arr;
}

function find_link_tokopedia($search, $city_value_shopee, $city_value_tokopedia, $pmin, $pmaks, $html)
{
    $data_arr = array();

    // find item image
    foreach ($html->find('div[id=content-container] div.container-product div.clearfix div.rvm-left-column div.rvm-pdp-product div.rvm-left-column--left div.product-detail__img-holder div.content-img ') as $e) {
        $tokped_link_img = $e->innertext;
        break;
    }
    $id = $search;
    $tokped_link_img = str_replace('<img', '', $tokped_link_img);
    $tokped_link_img = str_replace('src=', '', $tokped_link_img);
    $tokped_link_img = str_replace('"', '', $tokped_link_img);
    $tokped_link_img = str_replace('/>', '', $tokped_link_img);
    $tokped_link_img = str_replace(' ', '', $tokped_link_img);

    // find item title
    foreach ($html->find('div.rvm-left-column--right h1.rvm-product-title span') as $e) {
        $tokped_link_productname = $e->innertext;
    }

    // find item price
    foreach ($html->find('div.rvm-price-holder div.rvm-price span') as $e) {
        $tokped_link_productprice = $e->innertext;
    }
    $tokped_link_price = str_replace('.', '', $tokped_link_productprice);

    // find shop name
    foreach ($html->find('div.sticky-footer div.container div.pdp-shop div.pdp-shop__info div.pdp-shop__info__name-wrapper span') as $e) {
        $tokped_link_shopname = $e->innertext;
    }

    foreach ($html->find('div.sticky-footer div.container div.pdp-shop div.pdp-shop__info p.pdp-shop__info__stats span') as $e) {
        $tokped_link_shoplocation = $e->innertext;
        break;
    }

    $tokped_link_shoplocation = str_replace("Online", "", $tokped_link_shoplocation);
    $tokped_link_shoplocation = str_replace("Hari", "", $tokped_link_shoplocation);
    $tokped_link_shoplocation = str_replace("ini", "", $tokped_link_shoplocation);
    $data_arr['data'][] = array('id' => $id, 'image_url' => $tokped_link_img, 'product_name' => $tokped_link_productname, 'price_format' => $tokped_link_productprice, 'price' => $tokped_link_price, 'shop_name' => $tokped_link_shopname, 'shop_location' => $tokped_link_shoplocation, 'product_url' => $search, 'keyword' => $search, 'keyword_value_location_tokopedia' => $city_value_tokopedia, 'keyword_value_location_shopee' => $city_value_shopee, 'keyword_max' => $pmaks, 'keyword_min' => $pmin);

    return $data_arr;
}

function find_link_shopee($search, $city_value_shopee, $city_value_tokopedia, $pmaks, $pmin)
{
    $dataShopee_arr = array();

    $arrlinkdetailshopee = explode(".", $search);
    $shopeeshopid = $arrlinkdetailshopee[3];
    $shopeeitemid = $arrlinkdetailshopee[4];

    $url_detail = "https://shopee.co.id/api/v2/item/get?itemid=" . $shopeeitemid . "&shopid=" . $shopeeshopid;

    $data_detail = http_request($url_detail);
    $data_detail = json_decode($data_detail, TRUE);
    $price_Shopee = substr($data_detail["item"]["price"], 0, -5);
    //end get product price

    $img_url_Shopee = 'https://cf.shopee.co.id/file/' . $data_detail["item"]["image"];

    //get shop name
    $shop_detail = 'https://shopee.co.id/api/v2/shop/get?is_brief=1&shopid=' . $data_detail["item"]["shopid"];
    $shop_detail = http_request($shop_detail);
    $shop_detail = json_decode($shop_detail, TRUE);
    $shop_name_Shopee = $shop_detail["data"]['name'];

    $link_detail = 'https://shopee.co.id/' . str_replace(' ', '-', $data_detail["item"]["name"]) . '-i.' . $shopeeshopid . '.' . $shopeeitemid;
    $shop_location_Shopee = $shop_detail["data"]["shop_location"];
    $product_name_Shopee = $data_detail["item"]["name"];

    $product_url = $link_detail;

    $dataShopee_arr['data'][] = array('id' => $shopeeitemid, 'image_url' => $img_url_Shopee, 'product_name' => $product_name_Shopee, 'price_format' => $price_Shopee, 'price' => $price_Shopee, 'shop_name' => $shop_name_Shopee, 'shop_location' => $shop_location_Shopee, 'product_url' => $product_url, 'keyword' => $search, 'keyword_value_location_tokopedia' => $city_value_tokopedia, 'keyword_value_location_shopee' => $city_value_shopee, 'keyword_max' => $pmaks, 'keyword_min' => $pmin);

    return $dataShopee_arr;
}
