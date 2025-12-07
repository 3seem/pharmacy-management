@extends('Layout2.navbar')

@section('title')
    <title>Account</title>
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="../assets/CSS/account.css">
@endsection

@section('content')
<body>

    <div class="user-container">
        <div class="tabs">
            <div class="tab active" data-tab="overview">Overview</div>
            <div class="tab" data-tab="orders">Orders</div>
        </div>

        <!-- Overview Tab Content -->
        <div id="overview" class="tab-content active">
            <h2>Profile Information</h2>
            <div class="form-group">
                <label for="fullName">Full Name</label>
                <input type="text" id="fullName" value="{{ Auth::user()->name }}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" value="{{ Auth::user()->email }}">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" value="{{ Auth::user()->phone }}">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" value="{{ Auth::user()->address }}">
            </div>
            <button class="update-btn" id="redeemBtn">Update information</button>
            <div class="loyalty">
                <p><strong>Member since:</strong> {{ Auth::user()->created_at->format('F Y') }}</p>
            </div>
        </div>

        <!-- Orders Tab Content -->
        <div id="orders" class="tab-content">
            <div class="order-history">
                <h2>Order History</h2>
                    <div class="order-list">
                            @forelse(Auth::user()->orders ?? [] as $order)
                        <div class="order-entry">
                            <div class="order-card">
                                <div class="order-header">
                                    <div>
                                        <strong>{{ $order->order_number }}</strong><br>
                                        <span class="order-date">{{ $order->created_at->format('F d, Y') }}</span>
                                    </div>
                                    <span class="status {{ strtolower($order->status) }}">{{ $order->status }}</span>
                                </div>

                                <div class="order-body">
                                    <div class="order-total">
                                        <span>Total</span>
                                        <strong>${{ $order->total }}</strong>
                                    </div>
                                    <div class="tracking">
                                        <span>Tracking Number</span>
                                        <strong>{{ $order->tracking_number }}</strong>
                                    </div>
                                </div>

                                <button class="view-details">View Details ▼</button>
                            </div>

                            <div class="order-details">
                                <p><strong>Order items:</strong></p>
                                @foreach($order->items as $item)
                                <div class="history">
                                    <div class="main-details">
                                        <h4>{{ $item->product->name }}</h4>
                                        <h3>${{ $item->price }}</h3>
                                    </div>
                                    <h4>Quantity: <span>{{ $item->quantity }}</span></h4>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @empty
                            <p>No orders found.</p>
                        @endforelse
                    </div>


            </div>
        </div>
    </div>

    <script>
        // Tab switching logic
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.getAttribute('data-tab');
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                tabContents.forEach(tc => {
                    tc.classList.toggle('active', tc.id === target);
                });
            });
        });

        // Order details toggle
        document.addEventListener("DOMContentLoaded", () => {
            const buttons = document.querySelectorAll(".view-details");
            buttons.forEach(button => {
                button.addEventListener("click", () => {
                    const orderCard = button.closest(".order-entry");
                    const details = orderCard.querySelector(".order-details");
                    details.classList.toggle("active");
                    button.textContent = details.classList.contains("active") ? "Hide Details ▲" : "View Details ▼";
                });
            });
        });
    </script>

</body>
@endsection
