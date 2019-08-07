@extends('layouts.app')

@section('content')

<div class="container justify-content-center content">
    <h3>List Pencarian</h3>
    <!-- data from cart -->
    <div class="item-container-cart">
        
        <!-- data from database -->

        @foreach ($sections as $section)
       
            @if (auth()->user()->id == $section->id_user)
            <div class="item-container">

                <h1 class="text-center mb-3">{{str_replace('%20', ' ', $section->keyword)}}</h1>
                <a href="/graph/{{$section->id}}"><button class="btn btn-default btn-graph">Graph</button></a>
                <form action="/itemlist" method="POST" id="list_tokopedia_form">
                <button class="btn btn-default btn-delete-list" type="submit" name="delete_button">Delete</button>
               
                <div id="Item-list-{{$section->id}}" class="carousel slide" data-interval="false" data-ride="carousel">
                    <?php $counter = 0; ?>
                    <!-- Cards -->
                    <div class="carousel-inner row mx-auto">
                        @foreach ($products as $product)
                        @if ($section->id == $product->id_search)
                        @if ($product->product_name != 'asdfghjklkjgfds123890ythbnvdkodetokopediafwgheu3yr2t3r64ortfg')
                        @if ($counter==0)
                        <div class="carousel-item carousel-item-list col-md-3 active">
                            <?php $counter = 1; ?>
                            @elseif ($counter==1)
                            <div class="carousel-item carousel-item-list col-md-3">
                                @endif
                                <a target="_blank" href="{{$product->product_url}}">
                                    <div class="card item">
                                        @csrf
                                        <input type="text" hidden name="delete_id" value="{{ $section->id }}">
                                        <img class="card-img-top img-fluid" src="{{$product->image_url}}">
                                        <div class="card-body">
                                            <h4 class="card-title">{{$product->product_name}}</h4>
                                            <h4 class="card-text">{{$product->shop_name}}</h4>
                                            <h4 class="card-text">{{$product->shop_location}}</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endif
                            @endif
        </form>
        @endforeach

    </div>
    <a class="carousel-control-prev" href="#Item-list-{{$section->id}}" role="button" data-slide="prev">
        <img class="icon-prev" src="./svg/chevron-left.svg">
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#Item-list-{{$section->id}}" role="button" data-slide="next">
        <img class="icon-next" src="./svg/chevron-right.svg">
        <span class="sr-only">Next</span>
    </a>
</div>
</div>
@endif
@endforeach
</div>


@endsection