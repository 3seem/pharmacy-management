<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link rel="stylesheet" href="..\assets\CSS\homestyle.css"/>
</head>
<body>
  <!-- HEADER -->
  <header class="header">
    <div class="container nav">
      <div class="logo">PharmaCare</div>
      <div class="btn-primary">
      <button id="registerBtn">Get in Touch</button>
      <button id="loginBtn">Log in</button>
      </div>
    </div>
  </header>

  <div class="main">
  <!-- HERO SECTION -->
  <section class="hero">
    <div class="container hero-content">
      <h1>PharmaCare</h1>
      <img src="..\assets\images\headerphoto.png" alt="PharmaCare">
      <p>Operational bottlenecks, frequent billing errors, and mismanaged schedules can lead to revenue loss and frustrated patients.</p>
      <button class="btn-secondary" id="register">Get in Touch</button>
    </div>
  </section>

  <!-- PROBLEMS GRID -->
  <section class="problems container">
    <div class="grid">
      <div class="card yellow">
        <img src="..\assets\images\price-offer.png" alt="price">
        <h3>Get 25% OFF</h3>
      </div>
      <div class="card green">
        <img src="..\assets\images\delivery.png" alt="delivery">
        <h3>Free Home Delivery</h3>
      </div>
      <div class="card pink">
        <img src="..\assets\images\doctor.png" alt="doctor">
        <h3>Doctor's Appointment</h3>
      </div>
      <div class="card blue">
        <img src="..\assets\images\health.png" alt="health">
        <h3>Health Advice</h3>
      </div>
    </div>
  </section>

  <!-- New Products -->
        <section class="products new-products">
            <div class="container">
                <h2>New Products</h2>
                <div class="product-grid">
                    <article class="product-card">
                        <img src="..\assets\images\foley.png" alt="Foley Catheter">
                        <h3>Foley Catheter</h3>
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
                        <img src="..\assets\images\oxygen mask.png" alt="Oxygen Mask">
                        <h3>Oxygen Mask</h3>
                        <p class="price">$19.99 <span class="old-price">$29.99</span></p>
                        <a href="#" class="btn">Add to Cart</a>
                    </article>

                </div>
            </div>
        </section>
        <!-- Medical Products -->
        <section class="products medical-products">
            <div class="container">
                <h2>Medical Products</h2>
                <div class="product-grid">
                    <article class="product-card">
                        <img src="..\assets\images\Sphygmomanometer.png" alt="Sphygmomanometer">
                        <h3>Sphygmomanometer</h3>
                        <p class="price">$55.00 <span class="old-price">$70.00</span></p>
                        <a href="#" class="btn">Add to Cart</a>
                    </article>

                </div>
            </div>
        </section>

        <!-- Hot Offer Banner -->
        <section class="hot-offer">
            <div class="container hot-offer-content">
                <div class="offer-text">
                    <h2>Today's Hot Offer</h2>
                    <h3>Unlock 50% Off on Essential Medicines!</h3>
                    <p>Don't miss out on our limited-time offer to save on essential healthcare products.</p>
                </div>
                    <img src="..\assets\images\essential medicines.png" alt="Prescription medicine bottles">
            </div>
        </section>

    <!-- Footer -->
        @include('Layout2.footer')

 </div>
 <script>
    //Home script
    document.getElementById("loginBtn").addEventListener("click", () => {
         window.location.href = "../Customer/login.html";
    });

    document.getElementById("registerBtn").addEventListener("click", () => {
        window.location.href = "../Customer/register.html";
    });

    document.getElementById("register").addEventListener("click", () => {
        window.location.href = "../Customer/register.html";
    });
 </script>
</body>
</html>
