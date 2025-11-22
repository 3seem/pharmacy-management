@extends('admin.admin_layouts.navbar-sidebar')
@section('content')

    @section('title')
        <title>DASHBOARD</title>
    @endsection
    @section('stylesheet')
        <link rel="stylesheet" href="../assets/CSS/dashboard.css">
    @endsection


    <div class="head-title">
        <h1>Dashboard</h1>
    </div>
    <!-- Page Content -->
    <main class="container main">
        <!-- Key Metrics -->
        <section class="card-flat section">
            <div class="key-container">
                <div class="dashboard-section">

                    <div class="section-header">
                        <h2 class="section-title">Key Metrics</h2>

                        <!-- Time Selector (Dynamic Part) -->
                        <div class="time-selector">
                            <button id="dailyBtn" class="time-btn active" data-period="daily"
                                onclick="updateSales('daily')">Daily</button>
                            <button id="weeklyBtn" class="time-btn" data-period="weekly"
                                onclick="updateSales('weekly')">Weekly</button>
                            <button id="monthlyBtn" class="time-btn" data-period="monthly"
                                onclick="updateSales('monthly')">Monthly</button>
                        </div>
                    </div>

                    <div class="metrics-grid">

                        <!-- Metric Card 1: Total Sales (Dynamic Content controlled by JS) -->
                        <div class="metric-card">
                            <p class="card-title">Total Sales</p>
                            <div class="card-body">
                                <!-- Sales Value (Dynamic Element) -->
                                <p id="salesValue" class="card-value">$2,845.50</p>
                                <!-- Icon Badge (Static) -->
                                <span class="icon-badge sales-badge">
                                    <!-- SVG is now the only content inside the badge for max centering -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 1 0 0 7h5a3.5 3.5 0 1 1 0 7H6"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="card-footer">
                                <!-- Growth Indicator (Dynamic Element) -->
                                <span id="growthIndicator" class="growth-indicator">
                                    <!-- Initial Indicator (Up Arrow SVG) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="12 17 12 3"></polyline>
                                        <path d="M18 9L12 3L6 9"></path>
                                    </svg>
                                    12.5% vs last period
                                </span>
                            </div>
                        </div>

                        <!-- Metric Card 2: Low Stock Items (Static Content) -->
                        <div class="metric-card">
                            <span class="alert-badge">Alert</span>
                            <p class="card-title">Low Stock Items</p>
                            <div class="card-body">
                                <p class="card-value">18</p>
                                <span class="icon-badge lowstock-badge">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M21 8.25c0-1.87-.82-3.69-2.31-4.95a5.52 5.52 0 0 0-4.52-1.3C12.92 2 12.46 2 12 2s-.92 0-2.17.1a5.52 5.52 0 0 0-4.52 1.3C3.82 4.56 3 6.38 3 8.25V19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2z">
                                        </path>
                                        <path d="M12 11h.01"></path>
                                        <path d="M9 11h6"></path>
                                        <path d="M11 15v3"></path>
                                        <path d="M13 15v3"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="card-footer">
                                <span class="low-stock-detail">Requires attention</span>
                            </div>
                        </div>

                        <!-- Metric Card 3: Pending Orders (Static Content) -->
                        <div class="metric-card">
                            <span class="alert-badge">Alert</span>
                            <p class="card-title">Pending Orders</p>
                            <div class="card-body">
                                <p class="card-value">24</p>

                                <span class="icon-badge pending-badge">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="9" cy="21" r="1"></circle>
                                        <circle cx="20" cy="21" r="1"></circle>
                                        <path d="M1 1h4l2.68 12.31A2 2 0 0 0 8.63 15h11.45a2 2 0 0 0 1.93-1.49L23 6H6">
                                        </path>
                                    </svg>
                                </span>
                            </div>

                            <div class="card-footer">
                                <span class="pending-detail">Awaiting processing</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="section">

            <div>
                <!-- Alerts column -->
                <div class="col">
                    <div class="card-flat alerts-card">
                        <!-- Alerts Panel -->
                        <div class="alerts-panel panel-card">

                            <div class="alerts-header-row">
                                <!-- Title and total count -->
                                <h2 class="alert-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" style="margin-right: 0.5rem; color: #f59e0b;">
                                        <path
                                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                                        </path>
                                        <line x1="12" y1="9" x2="12" y2="13"></line>
                                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                    </svg>
                                    Real-time Inventory Alerts
                                    <!-- Static Total Count -->
                                    <span id="alertCount" class="alert-count">6</span>
                                </h2>

                                <!-- Filter Buttons (JavaScript will handle the filtering logic) -->
                                <div class="filter-controls">
                                    <button class="filter-btn active" data-filter="all"
                                        onclick="filterAlerts('all', this)">All</button>
                                    <button class="filter-btn" data-filter="low-stock"
                                        onclick="filterAlerts('low-stock', this)">Low Stock</button>
                                    <button class="filter-btn" data-filter="expiring"
                                        onclick="filterAlerts('expiring', this)">Expiring Date</button>
                                </div>
                            </div>

                            <!-- Alerts List Container -->
                            <div id="alertsList" class="alerts-list">

                                <!-- Static Alert Items (Low Stock) -->
                                <div class="alert-item low-stock" data-type="low-stock">
                                    <div class="alert-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M21 8.25c0-1.87-.82-3.69-2.31-4.95a5.52 5.52 0 0 0-4.52-1.3C12.92 2 12.46 2 12 2s-.92 0-2.17.1a5.52 5.52 0 0 0-4.52 1.3C3.82 4.56 3 6.38 3 8.25V19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2z">
                                            </path>
                                            <path d="M12 11h.01"></path>
                                            <path d="M9 11h6"></path>
                                            <path d="M11 15v3"></path>
                                            <path d="M13 15v3"></path>
                                        </svg>
                                    </div>
                                    <div class="alert-content">
                                        <h4>Amoxicillin 500mg</h4>
                                        <p>Only 8 units remaining. Reorder urgently.</p>
                                        <span>5 minutes ago</span>
                                    </div>
                                </div>

                                <div class="alert-item low-stock" data-type="low-stock">
                                    <div class="alert-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M21 8.25c0-1.87-.82-3.69-2.31-4.95a5.52 5.52 0 0 0-4.52-1.3C12.92 2 12.46 2 12 2s-.92 0-2.17.1a5.52 5.52 0 0 0-4.52 1.3C3.82 4.56 3 6.38 3 8.25V19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2z">
                                            </path>
                                            <path d="M12 11h.01"></path>
                                            <path d="M9 11h6"></path>
                                            <path d="M11 15v3"></path>
                                            <path d="M13 15v3"></path>
                                        </svg>
                                    </div>
                                    <div class="alert-content">
                                        <h4>Paracetamol 500mg</h4>
                                        <p>Only 15 units remaining. Check demand history.</p>
                                        <span>1 hour ago</span>
                                    </div>
                                </div>

                                <div class="alert-item low-stock" data-type="low-stock">
                                    <div class="alert-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M21 8.25c0-1.87-.82-3.69-2.31-4.95a5.52 5.52 0 0 0-4.52-1.3C12.92 2 12.46 2 12 2s-.92 0-2.17.1a5.52 5.52 0 0 0-4.52 1.3C3.82 4.56 3 6.38 3 8.25V19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2z">
                                            </path>
                                            <path d="M12 11h.01"></path>
                                            <path d="M9 11h6"></path>
                                            <path d="M11 15v3"></path>
                                            <path d="M13 15v3"></path>
                                        </svg>
                                    </div>
                                    <div class="alert-content">
                                        <h4>Cough Syrup (Adult)</h4>
                                        <p>Only 5 units remaining. High priority restock.</p>
                                        <span>4 hours ago</span>
                                    </div>
                                </div>

                                <!-- Static Alert Items (Expiring) -->
                                <div class="alert-item expiring" data-type="expiring">
                                    <div class="alert-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                    </div>
                                    <div class="alert-content">
                                        <h4>Ibuprofen 400mg</h4>
                                        <p>Expires in 12 days. Consider a promotional discount.</p>
                                        <span>15 minutes ago</span>
                                    </div>
                                </div>

                                <div class="alert-item expiring" data-type="expiring">
                                    <div class="alert-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                    </div>
                                    <div class="alert-content">
                                        <h4>Aspirin 100mg</h4>
                                        <p>Expires in 7 days. Must be removed from primary shelf.</p>
                                        <span>2 hours ago</span>
                                    </div>
                                </div>

                                <div class="alert-item expiring" data-type="expiring">
                                    <div class="alert-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                    </div>
                                    <div class="alert-content">
                                        <h4>Betadine Solution</h4>
                                        <p>Expires in 30 days. High volume, use fast.</p>
                                        <span>1 day ago</span>
                                    </div>
                                </div>

                                <!-- This message is static and will be hidden/shown by JS if no results are found -->
                                <div id="noResults" class="no-alerts-message hidden">
                                    No active alerts found in this category.
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="../assets/JS/dashboard.js"></script>
</body>

</html>


    @endsection
