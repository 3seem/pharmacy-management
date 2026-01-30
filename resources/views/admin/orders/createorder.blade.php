@extends('layouts.testlayout')

@section('content')
<style>
/* Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.create-order-container {
    padding: 20px;
    max-width: 1600px;
    margin: 0 auto;
    padding-top: 100px;
}

.page-header {
    color: white;
    font-size: 2rem;
    margin-bottom: 20px;
    text-align: center;
}

/* Alert Messages */
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    font-size: 14px;
}

.alert-error {
    background-color: rgba(244, 67, 54, 0.1);
    border: 1px solid #f44336;
    color: #f44336;
}

.alert-success {
    background-color: rgba(76, 175, 80, 0.1);
    border: 1px solid #4caf50;
    color: #4caf50;
}

.alert ul {
    list-style: none;
    padding-left: 0;
}

/* Filter Section */
.filters-container {
    display: flex;
    gap: 15px;
    margin-bottom: 25px;
    flex-wrap: wrap;
}

.input-dark, .select-dark {
    background: #111;
    border: 1px solid #333;
    color: #eee;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s;
    flex: 1;
    min-width: 200px;
}

.input-dark:focus, .select-dark:focus {
    outline: none;
    border-color: #4caf50;
    box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
}

/* Main Layout */
.main-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 25px;
    align-items: start;
}

/* Medicines Grid */
.medicines-section {
    overflow: hidden;
}

.medicines-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}

.medicine-card {
    background: #0f0f0f;
    border: 2px solid #222;
    border-radius: 12px;
    padding: 20px;
    transition: all 0.3s;
    cursor: pointer;
}

.medicine-card:hover {
    border-color: #333;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.medicine-card.selected {
    border-color: #4caf50;
    background: #152815;
}

.medicine-name {
    color: white;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 8px;
}

.medicine-category {
    color: #aaa;
    font-size: 12px;
    margin-bottom: 10px;
}

.medicine-price {
    color: #4caf50;
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 8px;
}

.medicine-stock {
    color: #888;
    font-size: 13px;
    margin-bottom: 15px;
}

.quantity-controls {
    display: flex;
    gap: 12px;
    align-items: center;
    justify-content: center;
}

.qty-btn {
    background: #222;
    color: #fff;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 16px;
    font-weight: bold;
}

.qty-btn:hover:not(:disabled) {
    background: #333;
}

.qty-btn:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.qty-display {
    color: white;
    font-size: 18px;
    font-weight: bold;
    min-width: 30px;
    text-align: center;
}

.empty-message {
    color: #aaa;
    text-align: center;
    padding: 40px;
    font-size: 16px;
}

/* Order Summary */
.order-summary {
    background: #0f0f0f;
    border: 2px solid #222;
    padding: 25px;
    border-radius: 12px;
    position: sticky;
    top: 20px;
}

.summary-title {
    color: white;
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    color: white;
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
    font-weight: 500;
}

.order-items-list {
    color: #ccc;
    font-size: 14px;
    margin-bottom: 20px;
    max-height: 300px;
    overflow-y: auto;
    padding-right: 5px;
}

.order-items-list::-webkit-scrollbar {
    width: 6px;
}

.order-items-list::-webkit-scrollbar-track {
    background: #111;
    border-radius: 3px;
}

.order-items-list::-webkit-scrollbar-thumb {
    background: #333;
    border-radius: 3px;
}

.order-item {
    padding: 8px 0;
    border-bottom: 1px solid #222;
}

.order-item:last-child {
    border-bottom: none;
}

.empty-cart {
    color: #777;
    font-style: italic;
}

.order-total {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid #222;
    color: white;
    font-weight: bold;
    font-size: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.total-amount {
    color: #4caf50;
}

.submit-btn {
    width: 100%;
    background: #4caf50;
    color: white;
    border: none;
    padding: 15px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s;
    margin-top: 20px;
}

.submit-btn:hover:not(:disabled) {
    background: #45a049;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
}

.submit-btn:disabled {
    background: #333;
    cursor: not-allowed;
    opacity: 0.5;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .main-layout {
        grid-template-columns: 1fr 280px;
    }
    
    .medicines-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    }
}

@media (max-width: 992px) {
    .main-layout {
        grid-template-columns: 1fr;
    }
    
    .order-summary {
        position: relative;
        top: 0;
        order: -1;
        margin-bottom: 25px;
    }
    
    .medicines-grid {
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    }
}

@media (max-width: 768px) {
    .create-order-container {
        padding: 15px;
        padding-top: 80px;
    }
    
    .page-header {
        font-size: 1.5rem;
    }
    
    .filters-container {
        flex-direction: column;
    }
    
    .input-dark, .select-dark {
        width: 100%;
        min-width: 100%;
    }
    
    .medicines-grid {
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 15px;
    }
    
    .medicine-card {
        padding: 15px;
    }
    
    .order-summary {
        padding: 20px;
    }
}

@media (max-width: 576px) {
    .medicines-grid {
        grid-template-columns: 1fr;
    }
    
    .medicine-card {
        max-width: 100%;
    }
    
    .qty-btn {
        padding: 6px 12px;
    }
    
    .order-summary {
        padding: 15px;
    }
    
    .summary-title {
        font-size: 18px;
    }
}

/* Loading State */
.loading {
    text-align: center;
    padding: 40px;
    color: #888;
}

/* Animations */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.medicine-card {
    animation: slideIn 0.3s ease-out;
}
</style>

<div class="create-order-container">
    <h1 class="page-header">Create Order</h1>

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Filters -->
    <div class="filters-container">
        <input 
            id="searchInput" 
            type="text"
            placeholder="Search medicine by name..." 
            class="input-dark"
        >
        
        <select id="categoryFilter" class="select-dark">
            <option value="all">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ str_replace(' ', '', $category) }}">{{ $category }}</option>
            @endforeach
        </select>
    </div>

    <!-- Main Layout -->
    <div class="main-layout">
        <!-- Order Summary (shown first on mobile) -->
        <div class="order-summary">
            <h3 class="summary-title">Order Summary</h3>

            <div class="form-group">
                <label class="form-label">Customer *</label>
                <select id="customer-select" class="select-dark">
                    <option value="">-- Select Customer --</option>
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}">{{ $c->user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Delivery Type</label>
                <select id="delivery-type" class="select-dark">
                    <option value="pickup">Pickup</option>
                    <option value="delivery">Delivery</option>
                </select>
            </div>

            <div class="order-items-list" id="order-items">
                <div class="empty-cart">No items yet</div>
            </div>

            <div class="order-total">
                <span>Total:</span>
                <span class="total-amount" id="order-total">$0.00</span>
            </div>

            <button id="submit-order" class="submit-btn" disabled>
                Submit Order
            </button>
        </div>

        <!-- Medicines Grid -->
        <div class="medicines-section">
            <div class="medicines-grid">
                @forelse ($medicines as $medicine)
                    <div class="medicine-card" 
                         data-id="{{ $medicine->medicine_id }}" 
                         data-name="{{ strtolower($medicine->Name) }}"
                         data-category="{{ str_replace(' ', '', $medicine->Category) }}"
                         data-price="{{ $medicine->Price }}"
                         data-stock="{{ $medicine->Stock }}">
                        <div class="medicine-name">{{ $medicine->Name }}</div>
                        <div class="medicine-category">{{ $medicine->Category }}</div>
                        <div class="medicine-price">${{ number_format($medicine->Price, 2) }}</div>
                        <div class="medicine-stock">Stock: {{ $medicine->Stock }}</div>
                        <div class="quantity-controls">
                            <button class="qty-btn qty-minus" disabled>-</button>
                            <span class="qty-display">0</span>
                            <button class="qty-btn qty-plus">+</button>
                        </div>
                    </div>
                @empty
                    <div class="empty-message">
                        <p>No medicines available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
// ===== CART LOGIC =====
const cart = {};
const medicines = @json($medicines).reduce((acc, m) => { 
    acc[m.medicine_id] = m; 
    return acc; 
}, {});

// Initialize quantity controls
document.querySelectorAll('.medicine-card').forEach(card => {
    const id = card.dataset.id;
    const minus = card.querySelector('.qty-minus');
    const plus = card.querySelector('.qty-plus');
    const display = card.querySelector('.qty-display');
    const stock = parseInt(card.dataset.stock);

    plus.onclick = (e) => {
        e.stopPropagation();
        let qty = cart[id] ?? 0;
        if (qty < stock) {
            qty++;
            cart[id] = qty;
            display.textContent = qty;
            minus.disabled = false;
            plus.disabled = qty >= stock;
            card.classList.add('selected');
            updateSummary();
        }
    };

    minus.onclick = (e) => {
        e.stopPropagation();
        let qty = cart[id] ?? 0;
        if (qty > 0) {
            qty--;
            if (qty === 0) {
                delete cart[id];
                card.classList.remove('selected');
            } else {
                cart[id] = qty;
            }
            display.textContent = qty;
            minus.disabled = qty === 0;
            plus.disabled = false;
            updateSummary();
        }
    };
});

function updateSummary() {
    const div = document.getElementById("order-items");
    let total = 0;
    let html = "";

    if (Object.keys(cart).length === 0) {
        div.innerHTML = "<div class='empty-cart'>No items yet</div>";
    } else {
        for (let id in cart) {
            const med = medicines[id];
            const qty = cart[id];
            const subtotal = qty * parseFloat(med.Price);
            total += subtotal;
            html += `<div class="order-item">
                        <div style="display:flex; justify-content:space-between;">
                            <span>${med.Name}</span>
                            <span style="color:#4caf50;">$${subtotal.toFixed(2)}</span>
                        </div>
                        <div style="font-size:12px; color:#888; margin-top:4px;">
                            ${qty} × $${parseFloat(med.Price).toFixed(2)}
                        </div>
                    </div>`;
        }
        div.innerHTML = html;
    }

    document.getElementById("order-total").textContent = "$" + total.toFixed(2);
    
    const customer = document.getElementById("customer-select").value;
    document.getElementById("submit-order").disabled = !customer || Object.keys(cart).length === 0;
}

// Customer select change event
document.getElementById("customer-select").addEventListener('change', updateSummary);

// Submit order
document.getElementById("submit-order").onclick = () => {
    const customer = document.getElementById("customer-select").value;
    const delivery = document.getElementById("delivery-type").value;

    if (!customer) {
        alert('Please select a customer');
        return;
    }

    if (Object.keys(cart).length === 0) {
        alert('Please add at least one item to the order');
        return;
    }

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
            <input type="hidden" name="items[${i}][Quantity]" value="${cart[id]}">`;
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

// Initialize
updateSummary();
</script>

@endsection