
@extends('admin.admin_layouts.navbar-sidebar')
@section('content')

    @section('title')
        <title>SALES&TRANSACTIONS</title>
    @endsection
    @section('stylesheet')
        <link rel="stylesheet" href="../assets/CSS/sales.css">
    @endsection


    <div class="head-title">
        <h1>Sales & transactions</h1>
    </div>
    <!-- Page Content -->
     <main class="container main">
         <!-- Navigation Tabs -->
    <nav class="tabs">
        <button id="pos-tab" class="tab-button active">Point of Sale</button>
        <button id="refund-tab" class="tab-button">Refund Management</button>
    </nav>

    <!-- POS Interface Section -->
    <section id="pos-section" class="tab-section active">
        <div class="pos-container">
            <!-- Left: Product Search and Quick Access -->
            <div class="pos-left">
                <!-- Product Search Card -->
                <div class="card">
                    <h3>Product Search</h3>
                    <div class="search-box">
                        <span class="icon-left"><img src="../assets/images/search.png" alt="search icon"
                                width="25px"></span>
                        <input id="product-search-input" type="text"
                            placeholder="Search by product name or scan barcode..." />
                    </div>
                    <!-- Search results container -->
                    <div id="product-search-results" class="search-results"></div>
                    <p class="helper"> You can search by product name or scan barcode
                        directly into the search field</p>
                </div>

                <!-- Quick Access Products Card -->
                <div class="card">
                    <h3>Quick Access Products</h3>
                    <div id="quick-products" class="grid-4"></div>
                </div>
            </div>

            <!-- Right: Shopping Cart and Checkout -->
            <div class="pos-right">
                <div class="card" style="background-color: #DBECFE;"> 
                    <div id="cart">
                        <div class="cart-head">
                        <h3>Shopping Cart</h3>
                        <p>
                            <span id="cart-count"> 0 </span> items
                        </p>
                        </div>
                        <div id="cart-items" class="cart-items">
                            <p class="empty-cart">Cart is empty</p>
                        </div>
                        <!-- Cart Totals -->
                        <div id="cart-summary" class="cart-summary">
                            <section >
                                <div><p>Subtotal:</p>    <p>$ <span id="subtotal">0.00</span></p></div>
                                <div><p>Tax (8%):</p>    <p>$ <span id="tax">0.00</span></p></div>
                            </section>
                            <div><p><strong>Total:</strong></p>    <p class="strong">$ <strong id="total">0.00</strong></p></div>
                        </div>
                        <!-- Payment Method -->
                        <div class="payment-method">
                            <label for="payment-method">Payment Method:</label>
                            <select id="payment-method">
                                <option value="cash">Cash</option>
                                <option value="card">Credit/Debit Card</option>
                                <option value="mobile">Mobile Payment</option>
                            </select>
                        </div>
                        <!-- Action Buttons -->
                        <div class="cart-actions">
                            <button id="checkout-button" class="btn primary" disabled>Complete Transaction</button>
                            <button id="clear-button" class="btn outline" disabled>Clear Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Refund Management Section -->
    <section id="refund-section" class="tab-section">
        <div class="refund-container">
            <!-- Search Invoice -->
            <div class="card">
                <h3>Search Invoice</h3>
                <div class="search-box">
                        <span class="icon-left"><img src="../assets/images/search.png" alt="search icon"
                                width="25px"></span>
                        <input id="refund-search-input" type="text"
                            placeholder="Enter invoice number or date (MM/DD/YYYY)" />
                </div>
            </div>

            <!-- Search Results -->
            <div class="card" id="refund-search-results-card" style="display:none">
                <h3>Search Results</h3>
                <div id="refund-search-results"></div>
            </div>

            <!-- Recent Transactions -->
            <div class="card">
                <h3>Recent Transactions</h3>
                <div id="recent-transactions">
                    <p class="empty-list">No transactions yet</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Invoice Modal (hidden by default) -->
    <div id="invoice-modal" class="modal" style="display:none;">
        <div class="modal-content">
            <span id="invoice-close" class="modal-close">&times;</span>
            <h2>Transaction Completed Successfully</h2>
            <div id="invoice-content">
                <!-- Invoice details filled by JavaScript -->
            </div>
            <div class="modal-actions">
                <button id="print-invoice" class="btn outline">Print</button>
                <button id="download-invoice" class="btn outline">Download PDF</button>
                <button id="close-invoice" class="btn primary">Close</button>
            </div>
        </div>
    </div>

    <!-- Refund Dialog Modal (hidden by default) -->
    <div id="refund-modal" class="modal" style="display:none;">
        <div class="modal-content">
            <span id="refund-close" class="modal-close">&times;</span>
            <h2>Process Refund</h2>
            <div id="refund-content">
                <!-- Refund form filled by JavaScript -->
            </div>
            <div class="modal-actions">
                <button id="cancel-refund" class="btn outline">Cancel</button>
                <button id="confirm-refund" class="btn danger">Process Refund</button>
            </div>
        </div>
    </div>
     </main>
   
    <script src="../assets/JS/sales.js"></script>
</body>

</html>
@endsection
