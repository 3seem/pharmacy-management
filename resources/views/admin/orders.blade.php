
@extends('admin.admin_layouts.navbar-sidebar')
@section('content')

    @section('title')
        <title>Orders</title>
    @endsection
    @section('stylesheet')
        <link rel="stylesheet" href="../assets/CSS/order.css">
    @endsection



    <!-- Page Content -->
    <main class="container main">
        <div id="app" class="min-h-screen pt-8">
            <div id="message-box" class="hidden">
                <p id="message-text" class="font-medium"></p>
            </div>

            <!-- Order List View - Static Structure -->
            <div id="list-view-container" class="order-container">
                <div class="head-title">
                    <h1>Order Management System</h1>
                </div>
                <!-- 1. Metric Cards Structure (Static) -->
                <div id="metrics-container" class="metrics-grid">

                    <!-- Total Orders Card -->
                    <div class="metric-card ">
                        <p class="text-sm font-medium text-gray-500">Total Orders</p>
                        <p id="metric-Total Orders" class="mt-1 text-2xl font-extrabold metric-text-gray">0</p>
                    </div>

                    <!-- Pending Card -->
                    <div class="metric-card">
                        <p class="text-sm font-medium text-gray-500">Pending</p>
                        <p id="metric-Pending" class="mt-1 text-2xl font-extrabold metric-text-yellow">0</p>
                    </div>

                    <!-- Processing Card -->
                    <div class="metric-card">
                        <p class="text-sm font-medium text-gray-500">Processing</p>
                        <p id="metric-Processing" class="mt-1 text-2xl font-extrabold metric-text-blue">0</p>
                    </div>

                    <!-- Shipped Card -->
                    <div class="metric-card">
                        <p class="text-sm font-medium text-gray-500">Shipped</p>
                        <p id="metric-Shipped" class="mt-1 text-2xl font-extrabold metric-text-purple">0</p>
                    </div>

                    <!-- Delivered Card -->
                    <div class="metric-card">
                        <p class="text-sm font-medium text-gray-500">Delivered</p>
                        <p id="metric-Delivered" class="mt-1 text-2xl font-extrabold metric-text-green">0</p>
                    </div>
                </div>

                <!-- 2. All Orders Table Card Structure (Static) -->
                <div class="card">
                    <!-- Table Header Section (Static) -->
                    <div class="card-content border-b">
                        <h2 class="text-gray-900 text-xl font-bold">All Orders</h2>
                    </div>

                    <!-- Table Content Structure (Static) -->
                    <div class="table-wrapper">
                        <table class="table-base">
                            <!-- Table Head (Static) -->
                            <thead>
                                <tr class="text-left text-xs font-semibold uppercase">
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Total Amount</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="relative">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <!-- Table Body (Dynamic Data Injection) -->
                            <tbody id="orders-table-body" class="bg-white">
                                <!-- Rows will be dynamically injected here by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Order Details View (Static Structure) -->
            <div id="details-view-container" class="hidden min-h-screen">
                <!-- Header (Static) -->
                <header class="details-header">
                    <div class="container py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-gray-900 text-2xl font-bold">Order Details</h1>
                                <p id="details-order-id" class="text-gray-600 mt-1 text-sm">Order #</p>
                            </div>
                            <button id="backButton" class="btn-back">
                                &larr; Back to Orders
                            </button>
                        </div>
                    </div>
                </header>

                <!-- Main Content Area (Static Layout) -->
                <main class="container py-8">
                    <div class="details-grid">
                        <!-- Left Column (Order Information & Items) -->
                        <div class="col-main space-y-6">

                            <!-- Order Information Card (Static Structure) -->
                            <div class="card card-content">
                                <div class="flex items-start justify-between border-b pb-4 mb-4">
                                    <h2 class="text-gray-900 text-xl font-semibold">Order Information</h2>
                                    <div id="details-status-badge" class="text-xs font-semibold"></div>
                                </div>

                                <div class="text-sm text-gray-500 mb-4">Placed on <span id="details-placed-date"
                                        class="detail-value text-gray-900"></span></div>

                                <div class="order-info-grid">
                                    <div class="detail-label">Customer Name</div>
                                    <div class="detail-label">Email</div>
                                    <div class="detail-label">Total Amount</div>
                                    <div id="details-customer-name" class="detail-value"></div>
                                    <div id="details-customer-email" class="detail-value"></div>
                                    <div id="details-total-amount" class="detail-value"></div>
                                </div>
                            </div>

                            <!-- Order Items Card (Static Structure) -->
                            <div class="card card-content">
                                <h2 class="text-gray-900 text-xl font-semibold mb-4 border-b pb-4" style="padding-bottom: 20px;">Order Items</h2>

                                <!-- Dynamic Item List Container -->
                                <div id="details-order-items" class="item-list-container">
                                    <!-- Items will be injected here -->
                                </div>

                                <!-- Summary/Totals Section (Static Structure) -->
                                <div class="summary-container">
                                    <div class="summary-row">
                                        <span class="detail-label">Subtotal</span>
                                        <span id="summary-subtotal" class="detail-value"></span>
                                    </div>
                                    <div class="summary-row">
                                        <span class="detail-label">Tax (<span id="summary-tax-rate">0%</span>)</span>
                                        <span id="summary-tax-amount" class="detail-value"></span>
                                    </div>
                                    <div class="summary-row">
                                        <span class="detail-label">Shipping</span>
                                        <span id="summary-shipping" class="detail-value"></span>
                                    </div>
                                    <div class="summary-total summary-row">
                                        <span class="font-bold">Total</span>
                                        <span id="summary-total" class="detail-value text-indigo-600"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column (Payment & Addresses) -->
                        <div class="space-y-6">

                            <!-- Payment Method Card (Static Structure) -->
                            <div class="card card-content">
                                <h2 class="text-gray-900 text-xl font-semibold mb-4 border-b pb-4" style="padding-bottom: 20px;">Payment Method</h2>
                                <div id="payment-method-details" class="payment-details">
                                    <!-- Payment details will be injected here -->
                                </div>
                            </div>

                            <!-- Billing Address Card (Static Structure) -->
                            <div class="card card-content">
                                <h2 class="text-gray-900 text-xl font-semibold mb-4 border-b pb-4" style="padding-bottom: 20px;">Billing Address</h2>
                                <div id="billing-address-content" class="address-details">
                                    <!-- Address details will be injected here -->
                                </div>
                            </div>

                            <!-- Shipping Address Card (Static Structure) -->
                            <div class="card card-content">
                                <h2 class="text-gray-900 text-xl font-semibold mb-6 border-b pb-4" style="padding-bottom: 20px;">Shipping Address</h2>
                                <div id="shipping-address-content" class="address-details">
                                    <!-- Address details will be injected here -->
                                </div>
                            </div>

                        </div>
                    </div>
                </main>
            </div>
        </div>


    </main>

    <script src="../assets/JS/order.js"></script>
</body>

</html>
@endsection
