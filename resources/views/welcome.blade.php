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

      <button id="registerBtn">Register</button>
      <button id="loginBtn">Log in</button>
      </div>
    </div>
  </header>

  <div class="main">


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







        <!--  Products -->
    

<section class="products new-products" id="products">
                
            <div class="container">
                <h2 style="display:inline">Products</h2>

<div class="filter-bar" style="margin-left: 830px; display:inline; align-items:center; gap:15px;">
    <label for="categoryFilter" style="font-weight:700; font-size:22px;">Category :</label>

    <select id="categoryFilter" style="padding:8px 12px; border-radius:6px; border:1px solid #ccc;">
        <option value="all">All</option>
        @foreach ($categories as $cat)
            <option data-filter=".{{str_replace(' ', '', $cat->Category)}}" value="{{ $cat->Category }}">{{ $cat->Category }}</option>
        @endforeach
    </select>
</div>

                <div class="product-grid" style="margin: 10px">
        @foreach ($medicine as $item)
            <div class="{{str_replace(' ', '', $item->Category)}}">
                    <article class="product-card" >
                        <img src="../assets/images/foley.png" alt="Foley Catheter">
                        <h3 class="details">{{$item->Name}}</h3>
                        <p class="price">${{$item->Price}} </p>
                        <a href="/register" class="btn">Add to Cart</a>
                    </article>
            </div>
        @endforeach

                </div>

            </div>

        </section>

    <!-- Footer -->
        @include('Layout2.footer')

 </div>
 <script>
    //Home script
    document.getElementById("loginBtn").addEventListener("click", () => {
         window.location.href = "/login";
    });

    document.getElementById("registerBtn").addEventListener("click", () => {
        window.location.href = "/register";
    });

    
document.addEventListener("DOMContentLoaded", function () {

    // Buttons
    document.getElementById("loginBtn").addEventListener("click", () => {
         window.location.href = "/login";
    });

    document.getElementById("registerBtn").addEventListener("click", () => {
        window.location.href = "/register";
    });

    // Filtering
    const filterSelect = document.getElementById('categoryFilter');
    const productItems = document.querySelectorAll('.product-grid > div');

    filterSelect.addEventListener('change', function () {
        const selected = this.value.replace(/\s+/g, '');

        productItems.forEach(item => {
            let itemCat = item.classList[0];

            if (selected === "all") {
                item.style.display = "block";
            } else {
                if (itemCat === selected) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            }
        });
    });

});



 </script>
</body>
</html>
