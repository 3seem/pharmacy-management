@extends('Layout2.navbar')

@section('content')
    @section('title')
    <title>Cart</title>
    @endsection
    @section('stylesheet')
    <link rel="stylesheet" href="../assets/CSS/cart.css">
    @endsection

<body>

<div class="pharmacy-container">

    <!-- Header -->


    <!-- Cart Page -->
    <main class="cart-page">
        <div class="cart-container">

            <h2 class="page-title">Shopping Cart</h2>

            <div class="cart-layout">

                <!-- Cart Items -->
                <div class="cart-items-section">

                    <!-- Cart Item 1 -->
                    <div class="cart-item-card">
                        <div class="item-main">
                            <div class="item-image">
                                <div class="item-icon"><img src="../assets/images/thermometer.png" alt="product image"></div>
                            </div>

                            <div class="item-details">
                                <div class="item-header-row">
                                    <h3 class="item-name">Digital thermometer</h3>
                                </div>

                                <p class="item-description">Digital thermometer offers quick accurate temperature readings with clear display</p>
                            </div>
                        </div>

                        <div class="item-actions">

                            <div class="quantity-controls">
                                <button class="quantity-btn">−</button>
                                <span class="quantity-value">2</span>
                                <button class="quantity-btn">+</button>
                            </div>

                            <div class="item-total">$17.98</div>

                            <button class="remove-btn"><img src="../assets/images/delete.png" alt="delete icon"></button>
                        </div>
                    </div>


                </div>

                <!-- Order Summary -->
                <div class="order-summary">

                    <h3 class="summary-title">Order Summary</h3>

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>$55.47</span>
                    </div>

                    <div class="summary-row">
                        <span>Tax</span>
                        <span>$4.43</span>
                    </div>

                    <div class="summary-row">
                        <span>Shipping</span>
                        <span class="free-shipping">FREE</span>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-row summary-total">
                        <span>Total</span>
                        <span>$59.90</span>
                    </div>

                    <button class="checkout-btn">Proceed to Checkout</button>
                    <button class="continue-shopping-btn-secondary">Continue Shopping</button>

                    <div class="payment-methods">
                        <p>We accept all major payment methods</p>
                    </div>

                </div>

            </div>

        </div>
    </main>

</div>

@endsection