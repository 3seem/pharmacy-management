@extends('Layout2.navbar')

@section('content')
    @section('title')
    <title>product details</title>
    @endsection
    @section('stylesheet')
    <link rel="stylesheet" href="..\assets\CSS\details.css"/>
    @endsection

<body>


    <main class="product-page">
        <div class="product-image">
            <img src="../assets/images/thermometer.png" alt="product image">
        </div>
        <div class="product-details">
            <h1>{{$medicine->Name}}</h1>
            {{-- <div class="rating">
                <!-- Five star icons for rating -->
                <span class="star">&#9733;</span>
                <span class="star">&#9733;</span>
                <span class="star">&#9733;</span>
                <span class="star">&#9733;</span>
                <span class="star">&#9733;</span>
                <span class="rating-value">5.0</span>
                <span class="reviews">(2.8k Reviews)</span>
            </div> --}}
            <hr>
            <div class="price">
                <span class="current-price">${{$medicine->Price}}</span>
            </div>
            <div class="description">
                <p>{{$medicine->Description}}</p>
            </div>
            <div class="quantity">
                <label for="qty">Quantity:</label>
                <div class="quantity-selector">
                    <button class="quantity-btn">-</button>
                    <input type="text" id="qty" value="1" readonly>
                    <button class="quantity-btn">+</button>
                </div>
            </div>
            <button class="add-to-cart">Add to Cart</button>
            <div class="payment">
                {{-- <div class="payment-icons">
                    <!-- Payment logos; these link to Wikimedia Commons images -->
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Mastercard_2019_logo.svg/1024px-Mastercard_2019_logo.svg.png" alt="Mastercard">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/American_Express_logo.svg/1024px-American_Express_logo.svg.png" alt="American Express">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/ec/Klarna_logo_blue.png" alt="Klarna">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/Font_Awesome_5_brands_cc-discover.svg/540px-Font_Awesome_5_brands_cc-discover.svg.png" alt="Discover">
                </div> --}}
                {{-- <p>Guaranteed Safe Checkout</p> --}}
            </div>
        </div>
    </main>

@endsection