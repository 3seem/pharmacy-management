@extends('Layout2.navbar')

@section('content')

    @section('title')
    <title>PharmaCare</title>
    @endsection
    @section('stylesheet')
    <link rel="stylesheet" href="../assets/CSS/list.css">
    @endsection
<body>


    <main>
        <!-- Hero Banner -->
        <section class="hero-banner">
            <div class="container hero-content">
                <div class="hero-text">
                    <h1>Your Prescription for Affordable Health Solutions!</h1>
                    <p>Welcome to PharmaCare, where we bring you trusted healthcare products and expert advice right to your door.</p>
                    <a href="#products" class="btn primary-btn">Shop Now</a>
                </div>
                <div class="hero-image">
                    <img src="../assets/images/medicine.png" alt="Doctor holding medication">
                </div>
            </div>
        </section>

        <!-- New Products -->
        <section class="products new-products" id="products">
            <div class="container">
                <h2>New Products</h2>
                <div class="product-grid">
                    <article class="product-card">
                        <img src="../assets/images/foley.png" alt="Foley Catheter">
                        <h3 class="details">Foley Catheter</h3>
                        <p class="price">$29.99 <span class="old-price">$39.99</span></p>
                        <a href="#" class="btn">Add to Cart</a>
                    </article>

                </div>
            </div>
        </section>

        <!-- Popular Products -->
        <section class="products popular-products">
            <div class="container">
                <h2>Popular Products</h2>
                <div class="product-grid">
                    <article class="product-card">
                        <img src="../assets/images/oxygen mask.png" alt="Oxygen Mask">
                        <h3 class="details">Oxygen Mask</h3>
                        <p class="price">$19.99 <span class="old-price">$29.99</span></p>
                        <a href="#" class="btn">Add to Cart</a>
                    </article>

                </div>
            </div>
        </section>

        <!-- Top Products -->
        <section class="products top-products">
            <div class="container">
                <h2>Top Products</h2>
                <div class="product-grid">
                    <article class="product-card">
                        <img src="https://via.placeholder.com/150" alt="Hospital Bed">
                        <h3 class="details">Hospital Bed</h3>
                        <p class="price">$120.00 <span class="old-price">$150.00</span></p>
                        <a href="#" class="btn">Add to Cart</a>
                    </article>

                </div>
            </div>
        </section>

        <!-- Stats -->
        <section class="stats">
            <div class="container stat-container">
                <div class="stat">
                    <h3>14K+</h3>
                    <p>Orders Completed</p>
                </div>
                <div class="stat">
                    <h3>250+</h3>
                    <p>Awards Achieved</p>
                </div>
                <div class="stat">
                    <h3>8K+</h3>
                    <p>Happy Customers</p>
                </div>
                <div class="stat">
                    <h3>12K+</h3>
                    <p>Product Reviews</p>
                </div>
            </div>
        </section>

        <!-- Medical Products -->
        <section class="products medical-products">
            <div class="container">
                <h2>Medical Products</h2>
                <div class="product-grid">
                    <article class="product-card">
                        <img src="../assets/images/Sphygmomanometer.png" alt="Sphygmomanometer">
                        <h3 class="details">Sphygmomanometer</h3>
                        <p class="price">$55.00 <span class="old-price">$70.00</span></p>
                        <a href="#" class="btn">Add to Cart</a>
                    </article>

                </div>
            </div>
        </section>

     <!-- Footer -->
    
        @include('Layout2.footer')


    <script>
        //Product script
        document.querySelectorAll('.details').forEach(item => {
            item.addEventListener("click", () => {
            // window.location.href = "../Customer/product_details.html";
            window.location.href = "/product_details";

        });
        });
    </script>
@endsection