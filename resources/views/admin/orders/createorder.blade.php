@extends('layouts.testlayout')

<style>
/* Simple styling */
.input-dark, .select-dark {
    background:#111; border:1px solid #222; color:#eee;
    padding:8px 12px; border-radius:6px;
}
.medicines-grid { 
    display:grid; grid-template-columns:repeat(auto-fill, minmax(250px, 1fr)); gap:15px; 
}
.medicine-card {
    background:#0f0f0f; border:1px solid #222; border-radius:10px;
    padding:15px; transition:.2s;
}
.medicine-card.selected { border-color:#4caf50; background:#152815; }
.qty-btn {
    background:#222; color:#fff; border:none;
    padding:5px 10px; border-radius:5px;
}
.order-summary {
    position:fixed; right:20px; top:100px; width:280px;
    background:#0f0f0f; border:1px solid #222; padding:20px; border-radius:10px;
}
</style>

<br><br><br><br><br>
<h1 style="color:white">Create Order</h1>

@if(session('error'))
    <div style="color:red; margin-bottom:15px;">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div style="color:green; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <ul style="color:red; margin-bottom:15px;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif


<!-- Search + Category Filter -->
<div style="display:flex; gap:10px; margin:20px 0;">
    <input id="searchInput" placeholder="Search medicine" class="input-dark" style="width:200px;">
    
    <select id="categoryFilter" class="select-dark">
        <option value="all">All Categories</option>
        @foreach($categories as $category)
            <option value="{{ str_replace(' ', '', $category) }}">{{ $category }}</option>
        @endforeach
    </select>
</div>

<!-- Medicines Grid -->
<div class="medicines-grid">
@forelse ($medicines as $medicine)
    <div class="medicine-card" 
         data-id="{{ $medicine->medicine_id }}" 
         data-name="{{ strtolower($medicine->Name) }}"
         data-category="{{ str_replace(' ', '', $medicine->Category) }}">
        <div style="color:white; font-size:18px; font-weight:bold;">
            {{ $medicine->Name }}
        </div>
        <div style="color:#aaa; font-size:12px;">{{ $medicine->Category }}</div>
        <div style="color:#4caf50; font-size:20px; font-weight:bold;">
            ${{ number_format($medicine->Price,2) }}
        </div>
        <div style="color:#888; margin-bottom:8px;">Stock: {{ $medicine->Stock }}</div>
        <div style="display:flex; gap:8px; align-items:center;">
            <button class="qty-btn qty-minus" disabled>-</button>
            <span class="qty-display">0</span>
            <button class="qty-btn qty-plus">+</button>
        </div>
    </div>
@empty
    <p style="color:#aaa;">No medicines found.</p>
@endforelse
</div>

<!-- ORDER SUMMARY -->
<div class="order-summary">
    <h3 style="color:white; margin-bottom:10px;">Order Summary</h3>

    <label style="color:white;">Customer</label>
    <select id="customer-select" class="select-dark" style="width:100%; margin-bottom:10px;">
        <option value="">-- Select --</option>
        @foreach($customers as $c)
            <option value="{{ $c->id }}">{{ $c->user->name }}</option>
        @endforeach
    </select>

    <label style="color:white;">Delivery</label>
    <select id="delivery-type" class="select-dark" style="width:100%; margin-bottom:15px;">
        <option value="pickup">Pickup</option>
        <option value="delivery">Delivery</option>
    </select>

    <div id="order-items" style="color:#ccc; font-size:14px;">
        <i style="color:#777;">No items yet</i>
    </div>

    <div style="margin-top:15px; color:white; font-weight:bold; font-size:18px;">
        Total: <span id="order-total">$0.00</span>
    </div>

    <button id="submit-order" class="qty-btn" style="width:100%; background:#4caf50; margin-top:10px;" disabled>
        Submit Order
    </button>
</div>

<script>
// ===== CART LOGIC =====
const cart = {};
const medicines = @json($medicines).reduce((acc, m) => { acc[m.medicine_id] = m; return acc; }, {});

document.querySelectorAll('.medicine-card').forEach(card => {
    const id = card.dataset.id;
    const minus = card.querySelector('.qty-minus');
    const plus = card.querySelector('.qty-plus');
    const display = card.querySelector('.qty-display');

    plus.onclick = () => {
        let qty = cart[id] ?? 0;
        if (qty < medicines[id].Stock) qty++;
        cart[id] = qty;

        display.textContent = qty;
        minus.disabled = qty === 0;
        plus.disabled = qty >= medicines[id].Stock;
        card.classList.toggle("selected", qty > 0);
        updateSummary();
    };

    minus.onclick = () => {
        let qty = cart[id] ?? 0;
        qty--;
        if (qty <= 0) delete cart[id];

        display.textContent = qty || 0;
        minus.disabled = qty === 0;
        plus.disabled = false;
        card.classList.toggle("selected", qty > 0);
        updateSummary();
    };
});

function updateSummary() {
    const div = document.getElementById("order-items");
    let total = 0;
    let html = "";

    if (Object.keys(cart).length === 0) {
        div.innerHTML = "<i style='color:#777;'>No items yet</i>";
    } else {
        for (let id in cart) {
            const med = medicines[id];
            const qty = cart[id];
            const subtotal = qty * med.Price;
            total += subtotal;
            html += `<div>${med.Name} — ${qty} × $${med.Price} = $${subtotal.toFixed(2)}</div>`;
        }
        div.innerHTML = html;
    }

    document.getElementById("order-total").textContent = "$" + total.toFixed(2);
    const customer = document.getElementById("customer-select").value;
    document.getElementById("submit-order").disabled = !customer || Object.keys(cart).length === 0;
}

// Submit order
document.getElementById("submit-order").onclick = () => {
    const customer = document.getElementById("customer-select").value;
    const delivery = document.getElementById("delivery-type").value;

    const form = document.createElement("form");
    form.method = "POST";
    form.action = "{{ route('orders.store') }}";
    form.innerHTML = `@csrf
        <input type="hidden" name="customer_id" value="${customer}">
        <input type="hidden" name="delivery_type" value="${delivery}">`;

    let i = 0;
    for (let id in cart) {
        form.innerHTML += `
            <input type="hidden" name="items[${i}][medicine_id]" value="${id}">
            <input type="hidden" name="items[${i}][Quantity]" value="${cart[id]}">
            <input type="hidden" name="items[${i}][unit_price]" value="${medicines[id].Price}">`;
        i++;
    }

    document.body.appendChild(form);
    form.submit();
};

// ===== SEARCH + CATEGORY FILTER =====
const searchInput = document.getElementById('searchInput');
const categorySelect = document.getElementById('categoryFilter');
const medicineCards = document.querySelectorAll('.medicine-card');

function filterMedicines() {
    const searchTerm = searchInput.value.toLowerCase();
    const selectedCategory = categorySelect.value;

    medicineCards.forEach(card => {
        const name = card.dataset.name;
        const category = card.dataset.category;

        const matchSearch = name.includes(searchTerm);
        const matchCategory = selectedCategory === "all" || category === selectedCategory;

        card.style.display = (matchSearch && matchCategory) ? "block" : "none";
    });
}

searchInput.addEventListener('input', filterMedicines);
categorySelect.addEventListener('change', filterMedicines);

</script>
