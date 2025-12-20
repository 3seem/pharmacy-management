@extends('layouts.testlayout')



<style>
.search-filter-box{display:flex;gap:15px;align-items:center;margin:30px 0;}
.input-dark{background:#0f0f0f;border:1px solid #1c1c1c;color:#eee;padding:10px 14px;border-radius:8px;outline:none;}
.input-dark::placeholder{color:#777;}
.select-dark{background:#0f0f0f;border:1px solid #1c1c1c;color:#eee;padding:10px;border-radius:8px;}

.btn-orange{background:#ff5c25;color:white;border-radius:6px;padding:10px 18px;}
.btn-orange:hover{opacity:.85;}

.table-wrapper{margin-top:40px;border:1px solid #1a1a1a;border-radius:10px;overflow:hidden;}
.table-dark{width:100%;border-collapse:collapse;font-size:15px;color:#ddd;}
.table-dark thead{background:#0d0d0d;}
.table-dark th,.table-dark td{padding:12px 14px;border-bottom:1px solid #1c1c1c;text-align:left;}
.table-dark tbody tr:hover{background:#151515;}

.card-row{display:flex;gap:20px;margin-top:60px;}
.metric-card{flex:1;background:#0d0d0d;border:1px solid #1c1c1c;padding:25px;border-radius:12px;color:white;}
.metric-label{font-size:14px;color:#ff8c00;}
.metric-value{font-size:34px;font-weight:700;margin-top:8px;}

.cart-box{margin-top:40px;background:#0d0d0d;border:1px solid #1a1a1a;padding:20px;border-radius:12px;color:#fff;}
.cart-table thead{background:#0f0f0f;}
.cart-table th, .cart-table td{padding:10px;border-bottom:1px solid #1c1c1c;}
.qty-input{width:60px;text-align:center;background:#191919;border:1px solid #333;color:white;border-radius:5px;}
.checkout-btn{background:#ff5c25;color:white;padding:12px;border-radius:8px;width:100%;margin-top:15px;font-size:17px;font-weight:bold;}
.checkout-btn:hover{opacity:.85;}
.remove-btn{background:#e74c3c;padding:6px 10px;border-radius:6px;}
</style>

<div class="wrapper">

{{-- ====== Summary Cards ====== --}}
<div class="card-row">
    <div class="metric-card">
        <div class="metric-label">Total Medicines</div>
        <div class="metric-value">{{ $totalMedicines ?? 120 }}</div>
    </div>

    <div class="metric-card">
        <div class="metric-label">Items in Cart</div>
        <div class="metric-value" id="itemsCount">{{ $cartCount ?? 0 }}</div>
    </div>

    <div class="metric-card">
        <div class="metric-label">Total Amount</div>
        <div class="metric-value" id="totalAmount">$0.00</div>
    </div>
</div>


{{-- ===== Search & Filter ===== --}}
<form method="GET" class="search-filter-box">
    <input type="text" name="search" class="input-dark" placeholder="Search medicine..." style="width:240px;">

    <select name="category" class="select-dark">
        <option value="">All Categories</option>
        <option>Tablet</option>
        <option>Syrup</option>
        <option>Injection</option>
    </select>

    <button class="btn-orange">Search</button>
</form>


{{-- ===== Medicine List ===== --}}
<div class="table-wrapper">
<table class="table-dark">
    <thead>
        <tr>
            <th>#</th>
            <th>Medicine</th>
            <th>Category</th>
            <th>Stock</th>
            <th>Price</th>
            <th>Add</th>
        </tr>
    </thead>

    <tbody>
        @forelse($medicines ?? [['id'=>1,'name'=>'Panadol','category'=>'Tablet','stock'=>140,'price'=>2.5],['id'=>2,'name'=>'Vitamin C','category'=>'Tablet','stock'=>60,'price'=>4]] as $m)
        <tr>
            <td>
                {{ $m['id'] }}</td>
            <td>{{ $m['name'] }}</td>
            <td>{{ $m['category'] }}</td>
            <td>{{ $m['stock'] }}</td>
            <td>${{ $m['price'] }}</td>
            <td>
                <button onclick="addToCart('{{ $m['name'] }}',{{ $m['price'] }})"
                    class="btn-orange btn-sm">Add +</button>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;color:#777;">No medicines found</td></tr>
        @endforelse
    </tbody>
</table>
</div>


{{-- ===== CART SECTION ===== --}}
<div class="cart-box">
<h4>🛒 Cart</h4>
<table class="cart-table" width="100%">
    <thead>
        <tr>
            <th>Medicine</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="cartBody"></tbody>
</table>

<button class="checkout-btn" onclick="checkout()">Checkout</button>
</div>

</div>

<script>
let cart=[];

function addToCart(name,price){
    let item=cart.find(i=>i.name===name);
    if(item) item.qty++;
    else cart.push({name,price,qty:1});
    updateCart();
}

function updateCart(){
    let body=document.getElementById("cartBody");
    body.innerHTML="";
    let total=0,count=0;

    cart.forEach((item,i)=>{
        let subtotal=item.qty*item.price;
        total+=subtotal;
        count+=item.qty;

        body.innerHTML+=`
        <tr>
            <td>${item.name}</td>
            <td>$${item.price}</td>
            <td><input type="number" min="1" value="${item.qty}" 
                class="qty-input" onchange="changeQty(${i},this.value)"></td>
            <td>$${subtotal.toFixed(2)}</td>
            <td><button class="remove-btn" onclick="removeItem(${i})">X</button></td>
        </tr>`;
    });

    document.getElementById("totalAmount").innerText="$"+total.toFixed(2);
    document.getElementById("itemsCount").innerText=count;
}

function changeQty(i,val){ cart[i].qty=Number(val); updateCart(); }
function removeItem(i){ cart.splice(i,1); updateCart(); }

function checkout(){
    if(cart.length==0) return alert("Cart is empty");

    alert("Order completed successfully!");
    cart=[]; updateCart();
}
</script>
