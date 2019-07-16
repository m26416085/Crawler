@extends('layouts.app')

@section('content')
<?php
$data_arr = array();
if (isset($_POST['find'])) {
    

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
    // print "<pre>";
    // print_r($data_arr);
    // print "</pre>";
}
?>
<div class="container justify-content-center content">
    <!-- filter -->
    <h5 class="filter-title">Filter</h5>
    <form class="filter" method="POST">
        <label class="label-filter">Location</label>
        <div class="form-check form-check-inline">

            <select class="filter-kota">
                <option value=""></option>
                <option value=""></option>
                <option value=""></option>
                <option value=""></option>
            </select>

        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="text" id="harga-maks">
            <label class="form-check-label" for="harga-maks">Harga Maksimal</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="text" id="harga-min">
            <label class="form-check-label" for="harga-min">Harga Minimal</label>
        </div>
    </form>


    <!-- Tabs -->
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-name-tab" data-toggle="pill" href="#pills-name" role="tab">Nama</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-link-tab" data-toggle="pill" href="#pills-link" role="tab">Link</a>
        </li>
    </ul>

    <!-- Search -->
    <form action="/home" method="POST">
        @csrf
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-name" role="tabpanel" aria-labelledby="pills-name-tab">
                <div class="input-group search">
                    <input type="text" name="text_value" class="form-control input-search" placeholder="Nama Barang">
                    <button class="btn btn-default" name="find" type="submit"><img class="icon-search" src="./svg/magnifying-glass.svg"></button>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-link" role="tabpanel" aria-labelledby="pills-link-tab">
                <div class="input-group search">
                    <input type="text" class="form-control input-search" placeholder="Link Barang">
                    <button class="btn btn-default" type="button"><img class="icon-search" src="./svg/magnifying-glass.svg"></button>
                </div>
            </div>
        </div>
    </form>

    <!-- List-Items-Added -->
    <div class="item-container-add">
        <div class="row row-add">
            <div class="col-sm-4">
                <img class="item-add-img" src="./svg/person.svg">
            </div>
            <div class="col-sm-7">
                <p class="text-namabarang-add">Nama Barang</p>
                <p class="text-harga-add">50000000000</p>
                <p class="text-namatoko-add">Nama Toko</p>
                <p class="text-lokasitoko-add">Lokasi Toko</p>
            </div>
            <div class="col-sm-1">
                <a class="item-deletebtn" href="#"><img class="icon-delete" src="./svg/delete.svg"></a>
            </div>
        </div>
        <div class="row row-add">
            <div class="col-sm-4">
                <img class="item-add-img" src="./svg/person.svg">
            </div>
            <div class="col-sm-7">
                <p class="text-namabarang-add">Nama Barang</p>
                <p class="text-harga-add">50000000000</p>
                <p class="text-namatoko-add">Nama Toko</p>
                <p class="text-lokasitoko-add">Lokasi Toko</p>
            </div>
            <div class="col-sm-1">
                <a class="item-deletebtn" href="#"><img class="icon-delete" src="./svg/delete.svg"></a>
            </div>
        </div>
        <div class="row row-add">
            <div class="col-sm-4">
                <img class="item-add-img" src="./svg/person.svg">
            </div>
            <div class="col-sm-7">
                <p class="text-namabarang-add">Nama Barang</p>
                <p class="text-harga-add">50000000000</p>
                <p class="text-namatoko-add">Nama Toko</p>
                <p class="text-lokasitoko-add">Lokasi Toko</p>
            </div>
            <div class="col-sm-1">
                <a class="item-deletebtn" href="#"><img class="icon-delete" src="./svg/delete.svg"></a>
            </div>
        </div>
        <div class="row row-add">
            <div class="col-sm-4">
                <img class="item-add-img" src="./svg/person.svg">
            </div>
            <div class="col-sm-7">
                <p class="text-namabarang-add">Nama Barang</p>
                <p class="text-harga-add">50000000000</p>
                <p class="text-namatoko-add">Nama Toko</p>
                <p class="text-lokasitoko-add">Lokasi Toko</p>
            </div>
            <div class="col-sm-1">
                <a class="item-deletebtn" href="#"><img class="icon-delete" src="./svg/delete.svg"></a>
            </div>
        </div>
        <div class="row row-add">
            <div class="col-sm-4">
                <img class="item-add-img" src="./svg/person.svg">
            </div>
            <div class="col-sm-7">
                <p class="text-namabarang-add">Nama Barang</p>
                <p class="text-harga-add">50000000000</p>
                <p class="text-namatoko-add">Nama Toko</p>
                <p class="text-lokasitoko-add">Lokasi Toko</p>
            </div>
            <div class="col-sm-1">
                <a class="item-deletebtn" href="#"><img class="icon-delete" src="./svg/delete.svg"></a>
            </div>
        </div>

    </div>

    <!-- List-Items-Searched-Tokopedia -->
    <div class="item-container-search-Tokopedia">
        <h1 class="text-center mb-3">List Barang Tokopedia</h1>
        <div id="Item-list-Tokopedia" class="carousel slide" data-ride="carousel">

            <!-- Cards -->
            <div class="carousel-inner row mx-auto">
                <?php
                if ($data_arr != null) {
                    echo "<div class='carousel-item col-md-3 active'>
                        <a href='#' style='color: black;'>
                            <div class='card item'>";

                    echo "<img class='card-img-top img-fluid' src='".$data_arr['data'][0]['image_url']."'>";
                    echo "<h4 class='card-title' style='font-size: 20px;'>".$data_arr['data'][0]['product_name']."</h4>";
                    echo "<p class='card-text'>".$data_arr['data'][0]['price_format']."</p>";
                    echo "<p class='card-text'>".$data_arr['data'][0]['shop_name']."</p>";
                    echo "<p class='card-text'>".$data_arr['data'][0]['shop_location']."</p>";
                    
                    echo "</div>
                        </a>
                    </div>";
                }
                ?>
                <div class="carousel-item col-md-3 active">
                    <a href="#">
                        <div class="card item">
                            <img class="card-img-top img-fluid" src="http://placehold.it/800x600/f44242/fff">
                            <div class="card-body">
                                <h4 class="card-title">Card 1</h4>
                                <p class="card-text">This is a card content.</p>
                                <p class="card-text">This is a card content.</p>
                                <p class="card-text">This is a card content.</p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    </a>
                </div>


                <div class="carousel-item col-md-3">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="http://placehold.it/800x600/418cf4/fff">
                        <div class="card-body">
                            <h4 class="card-title">Card 2</h4>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>

            </div>
            <a class="carousel-control-prev" href="#Item-list-Tokopedia" role="button" data-slide="prev">
                <img class="icon-prev" src="./svg/chevron-left.svg">
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#Item-list-Tokopedia" role="button" data-slide="next">
                <img class="icon-next" src="./svg/chevron-right.svg">
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <!-- List-Items-Searched-Shopee -->
    <div class="item-container-search-Shopee">
        <h1 class="text-center mb-3">List Barang Shopee</h1>
        <div id="Item-list-Shopee" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner row mx-auto">

                <!-- Cards -->
                <div class="carousel-item col-md-3 active">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="http://placehold.it/800x600/f44242/fff">
                        <div class="card-body">
                            <h4 class="card-title">Card 1</h4>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>

                <div class="carousel-item col-md-3">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="http://placehold.it/800x600/418cf4/fff">
                        <div class="card-body">
                            <h4 class="card-title">Card 2</h4>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>

                <div class="carousel-item col-md-3">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="http://placehold.it/800x600/3ed846/fff">
                        <div class="card-body">
                            <h4 class="card-title">Card 3</h4>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>

                <div class="carousel-item col-md-3">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="http://placehold.it/800x600/42ebf4/fff">
                        <div class="card-body">
                            <h4 class="card-title">Card 4</h4>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>

                <div class="carousel-item col-md-3">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="http://placehold.it/800x600/f49b41/fff">
                        <div class="card-body">
                            <h4 class="card-title">Card 5</h4>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>

                <div class="carousel-item col-md-3">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="http://placehold.it/800x600/f4f141/fff">
                        <div class="card-body">
                            <h4 class="card-title">Card 6</h4>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>

                <div class="carousel-item col-md-3">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="http://placehold.it/800x600/8e41f4/fff">
                        <div class="card-body">
                            <h4 class="card-title">Card 7</h4>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>

            </div>
            <a class="carousel-control-prev left" href="#Item-list-Shopee" role="button" data-slide="prev">
                <img class="icon-next" src="./svg/chevron-left.svg">
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next right" href="#Item-list-Shopee" role="button" data-slide="next">
                <img class="icon-next" src="./svg/chevron-right.svg">
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
@endsection