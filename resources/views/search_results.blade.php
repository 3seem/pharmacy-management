@extends('Layout2.navbar')

@section('title')
    <title>Search Results</title>
@endsection

@section('stylesheet')
<link rel="stylesheet" href="../assets/CSS/list.css">
@endsection


@section('content')
<main>
    <section class="products new-products" id="products">
        <div class="container">
            <h2>Search Results for "{{ $search }}"</h2>

            <div class="product-grid" style="margin: 10px">
                @forelse ($medicine as $item)
                    <div>
                        <article class="product-card">
                            {{-- <img src="../assets/images/foley.png" alt="{{ $item->Name }}"> --}}
                            <div style="display:flex; justify-content:center; align-items:center;">
                                <img src="../assets/images/foley.png" alt="{{ $item->Name }}">
                            </div>

                            <h3>{{ $item->Name }}</h3>
                            <p class="price">${{ $item->Price }}</p>
                            <a href="{{route('product_details',$item->medicine_id)}}" class="btn">  View  </a>

                            <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="id" value="{{ $item->medicine_id }}">
                                <button class="btn" type="submit">Add to Cart</button>
                            </form>
                        </article>
                    </div>
                @empty
                    <p>No medicines found.</p>
                @endforelse
            </div>
        </div>
    </section>

    @include('Layout2.footer')
</main>
@endsection
