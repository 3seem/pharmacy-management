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

    <main class="cart-page">
        <div class="cart-container">

            <h2 class="page-title">Shopping Cart</h2>

            <div class="cart-layout">

                <!-- Cart Items -->
                <div class="cart-items-section">

                    @if($cart->count() == 0)
                        <p style="font-size:20px; margin-top:20px;">Your cart is empty.</p>
                    @else
                        @foreach ($cart as $item)
                        <div class="cart-item-card">
                            <div class="item-main">
                                {{-- {{dd($item)}} --}}
                                <div class="item-image">
                                    <img style="width: 40px; height:40px;" src="{{asset($item->medicine->image_url)}}" alt="product">
                                </div>

                                <div class="item-details">
                                    <h3 class="item-name">{{ $item->medicine->Name }}</h3>
                                    <p class="item-description">${{ $item->medicine->Price }}</p>
                                </div>
                            </div>

                            <div class="item-actions">

                                <!-- Quantity Update Form -->
                                <form action="{{ route('cart.update') }}" method="POST" class="quantity-controls">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id }}">

                                    <button class="quantity-btn" name="quantity" value="{{ max(1, $item->quantity - 1) }}">−</button>

                                    <span class="quantity-value">{{ $item->quantity }}</span>

                                    <button class="quantity-btn" name="quantity" value="{{ $item->quantity + 1 }}">+</button>
                                </form>

                                <!-- Item Total -->
                                <div class="item-total">
                                    ${{ $item->quantity * $item->medicine->Price }}
                                </div>

                                <!-- Remove Button -->
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <button class="remove-btn">
                                        <img src="../assets/images/delete.png" alt="delete">
                                    </button>
                                </form>

                            </div>
                        </div>
                        @endforeach
                    @endif

                </div>

                <!-- Order Summary -->
                <div class="order-summary">

                    <h3 class="summary-title">Order Summary</h3>

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>${{ $cart->sum(fn($i) => $i->medicine->Price * $i->quantity) }}</span>
                    </div>

                    <div class="summary-row">
                        <span>Tax</span>
                        <span>${{ number_format($cart->sum(fn($i) => $i->medicine->Price * $i->quantity) * 0.08 ,2) }}</span>
                    </div>

                    <div class="summary-row">
                        <span>Shipping</span>
                        <span class="free-shipping">FREE</span>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-row summary-total">
                        <span>Total</span>
                        @php
                            $subtotal = $cart->sum(fn($i) => $i->medicine->Price * $i->quantity);
                            $total = $subtotal + ($subtotal * 0.08);
                        @endphp
                        <span>${{ number_format($total, 2) }}</span>
                    </div>

                    <form action="{{ route('checkout.cart') }}" method="POST">
    @csrf
    <button class="checkout-btn" {{ $cart->count() == 0 ? 'disabled' : '' }}>
        Proceed to Checkout
    </button>
</form>
    

<a href="/pharmacare" class="continue-shopping-btn-secondary"
style="
        display: inline-block;
        padding: 14px 90px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 8px;
   "
>
    Continue Shopping
</a>

                    <div class="payment-methods">
                        <p>We accept all major payment methods</p>
                    </div>

                </div>

            </div>

        </div>
    </main>

</div>

@endsection
