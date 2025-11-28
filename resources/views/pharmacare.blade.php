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




        <!--  Products -->

        <section class="products new-products" id="products">
                
            <div class="container">
                <h2 style="display:inline">Products</h2>

<div class="filter-bar" style="margin-left: 800px; display:inline; align-items:center; gap:15px;">
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
                        <p class="price">${{$item->Price}}  </p>
                        <a href="#" class="btn">Add to Cart</a>
                    </article>
            </div>
        @endforeach

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
    // Filter by Category
    // document.getElementById("categoryFilter").addEventListener("change", function () {
    //     const selected = this.value;

    //     if (selected === "all") {
    //         window.location.href = "/pharmacare"; 
    //     } else {
    //         window.location.href = `/pharmacare?category=${selected}`;
    //     }
    // });

    const filterSelect = document.getElementById('categoryFilter');
    const productItems = document.querySelectorAll('.product-grid > div');

    filterSelect.addEventListener('change', function () {
        const selected = this.value;

        productItems.forEach(item => {
            if (selected === "all") {
                item.style.display = "block"; 
            } else {
                let itemCat = item.classList[0];

                if (itemCat === selected.replace(/\s+/g, '')) {
                    item.style.display = "block"; 
                } else {
                    item.style.display = "none"; 
                }
            }
        });
    });

    </script>

@endsection