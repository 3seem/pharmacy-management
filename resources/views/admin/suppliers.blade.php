

@extends('admin.admin_layouts.navbar-sidebar')
@section('content')

    @section('title')
        <title>Suppliers</title>
    @endsection
    @section('stylesheet')
        <link rel="stylesheet" href="../assets/CSS/suppliers.css">
    @endsection

    
    <!-- Page Content -->
    <main class="container main">
        <div class="suppliers-management">
            <div class="head-title">
                <h1>Suppliers Management</h1>
            </div>
            <div class="tab-container">
                <input type="radio" name="tabs" id="tab-directory" checked>
                <input type="radio" name="tabs" id="tab-add">
                <input type="radio" name="tabs" id="tab-details">
                <nav class="tab-nav">
                    <label for="tab-directory" class="tab-label active">Supplier Directory</label>
                    <label for="tab-add" class="tab-label "> Add Supplier</label>
                    <label for="tab-details" class="tab-label ">Supplier Details</label>
                </nav>

                <!-- Supplier Directory Tab -->
                <div class="tab-content" id="content-directory">
                    <div class="content-card">
                        <div class="card-header">
                            <h2>Supplier Directory</h2>
                            <div class="search-box">
                                <input type="search" id="supplier-search" placeholder="Search suppliers...">
                            </div>
                        </div>

                        <div class="table-container">
                            <table class="suppliers-table">
                                <thead>
                                    <tr>
                                        <th>Supplier ID</th>
                                        <th>Company Name</th>
                                        <th>Contact Person</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="Supplier ID">SUP-001</td>
                                        <td data-label="Company Name"><strong>MediPharm Distributors</strong></td>
                                        <td data-label="Contact Person">John Smith</td>
                                        <td data-label="Phone Number">(555) 123-4567</td>
                                        <td data-label="Email">john.smith@medipharm.com</td>
                                        <td data-label="Address">123 Medical Plaza, NY 10001</td>
                                        <td data-label="Status"><span class="status-badge active">Active</span></td>
                                        <td data-label="Actions">
                                            <div class="action-buttons">
                                                <label for="tab-details" class="btn btn-view">View</label>
                                                <label for="tab-add" class="btn btn-edit">Edit</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td data-label="Supplier ID">SUP-002</td>
                                        <td data-label="Company Name"><strong>HealthCare Supplies Inc.</strong></td>
                                        <td data-label="Contact Person">Sarah Johnson</td>
                                        <td data-label="Phone Number">(555) 234-5678</td>
                                        <td data-label="Email">s.johnson@healthcare.com</td>
                                        <td data-label="Address">456 Wellness Ave, CA 90210</td>
                                        <td data-label="Status"><span class="status-badge active">Active</span></td>
                                        <td data-label="Actions">
                                            <div class="action-buttons">
                                                <label for="tab-details" class="btn btn-view">View</label>
                                                <label for="tab-add" class="btn btn-edit">Edit</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td data-label="Supplier ID">SUP-003</td>
                                        <td data-label="Company Name"><strong>Global Pharma Solutions</strong></td>
                                        <td data-label="Contact Person">Michael Chen</td>
                                        <td data-label="Phone Number">(555) 345-6789</td>
                                        <td data-label="Email">m.chen@globalpharma.com</td>
                                        <td data-label="Address">789 Commerce St, TX 75001</td>
                                        <td data-label="Status"><span class="status-badge active">Active</span></td>
                                        <td data-label="Actions">
                                            <div class="action-buttons">
                                                <label for="tab-details" class="btn btn-view">View</label>
                                                <label for="tab-add" class="btn btn-edit">Edit</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td data-label="Supplier ID">SUP-004</td>
                                        <td data-label="Company Name"><strong>BioMed Partners</strong></td>
                                        <td data-label="Contact Person">Emily Rodriguez</td>
                                        <td data-label="Phone Number">(555) 456-7890</td>
                                        <td data-label="Email">e.rodriguez@biomedpartners.com</td>
                                        <td data-label="Address">321 Healthcare Blvd, FL 33101</td>
                                        <td data-label="Status"><span class="status-badge active">Active</span></td>
                                        <td data-label="Actions">
                                            <div class="action-buttons">
                                                <label for="tab-details" class="btn btn-view">View</label>
                                                <label for="tab-add" class="btn btn-edit">Edit</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td data-label="Supplier ID">SUP-005</td>
                                        <td data-label="Company Name"><strong>Premier Medical Wholesale</strong></td>
                                        <td data-label="Contact Person">David Williams</td>
                                        <td data-label="Phone Number">(555) 567-8901</td>
                                        <td data-label="Email">d.williams@premiermed.com</td>
                                        <td data-label="Address">654 Distribution Dr, IL 60601</td>
                                        <td data-label="Status"><span class="status-badge inactive">Inactive</span></td>
                                        <td data-label="Actions">
                                            <div class="action-buttons">
                                                <label for="tab-details" class="btn btn-view">View</label>
                                                <label for="tab-add" class="btn btn-edit">Edit</label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-footer">
                            <p>Showing 5 of 5 suppliers</p>
                            <div class="pagination">
                                <button class="page-btn">Previous</button>
                                <button class="page-btn active">1</button>
                                <button class="page-btn">2</button>
                                <button class="page-btn">3</button>
                                <button class="page-btn">Next</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add/Edit Supplier Tab -->
                <div class="tab-content" id="content-add">
                    <div class="content-card">
                        <div class="card-header">
                            <h2>Add New Supplier</h2>
                            <p class="card-description">Fill in the supplier information below</p>
                        </div>
                        <form class="supplier-form">
                            <div class="form-section">
                                <h3>Company Information</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="company-name">Company Name *</label>
                                        <input type="text" id="company-name" placeholder="Enter company name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="supplier-id">Supplier ID</label>
                                        <input type="text" id="supplier-id" placeholder="Auto-generated" disabled>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="email">Email Address *</label>
                                        <input type="email" id="email" placeholder="supplier@example.com" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="website">Website</label>
                                        <input type="url" id="website" placeholder="https://www.example.com">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="tax-id">Tax ID / VAT Number</label>
                                        <input type="text" id="tax-id" placeholder="Enter tax identification number">
                                    </div>
                                    <div class="form-group">
                                        <label for="license-number">License Number</label>
                                        <input type="text" id="license-number"
                                            placeholder="Enter supplier license number">
                                    </div>
                                </div>
                            </div>
                            <div class="form-section">
                                <h3>Contact Person</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="contact-name">Full Name *</label>
                                        <input type="text" id="contact-name" placeholder="Enter contact person name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact-title">Job Title</label>
                                        <input type="text" id="contact-title" placeholder="e.g., Sales Manager">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="phone">Phone Number *</label>
                                        <input type="tel" id="phone" placeholder="(555) 123-4567" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Mobile Number</label>
                                        <input type="tel" id="mobile" placeholder="(555) 123-4567">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="fax">Fax Number</label>
                                        <input type="tel" id="fax" placeholder="(555) 123-4567">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact-email">Contact Email</label>
                                        <input type="email" id="contact-email" placeholder="contact@example.com">
                                    </div>
                                </div>
                            </div>
                            <div class="form-section">
                                <h3>Address Details</h3>
                                <div class="form-row">
                                    <div class="form-group full-width">
                                        <label for="street-address">Street Address *</label>
                                        <input type="text" id="street-address" placeholder="Enter street address"
                                            required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="city">City *</label>
                                        <input type="text" id="city" placeholder="Enter city" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="state">State / Province *</label>
                                        <input type="text" id="state" placeholder="Enter state" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="zip">ZIP / Postal Code *</label>
                                        <input type="text" id="zip" placeholder="Enter ZIP code" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="country">Country *</label>
                                        <select id="country" required>
                                            <option value="">Select country</option>
                                            <option value="us">United States</option>
                                            <option value="ca">Canada</option>
                                            <option value="uk">United Kingdom</option>
                                            <option value="au">Australia</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-section">
                                <h3>Additional Information</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="payment-terms">Payment Terms</label>
                                        <select id="payment-terms">
                                            <option value="">Select payment terms</option>
                                            <option value="net15">Net 15</option>
                                            <option value="net30">Net 30</option>
                                            <option value="net60">Net 60</option>
                                            <option value="due-on-receipt">Due on Receipt</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="credit-limit">Credit Limit ($)</label>
                                        <input type="number" id="credit-limit" placeholder="0.00" step="0.01">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="delivery-time">Average Delivery Time (days)</label>
                                        <input type="number" id="delivery-time" placeholder="e.g., 5">
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Supplier Status *</label>
                                        <select id="status" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                            <option value="pending">Pending Approval</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group full-width">
                                        <label for="notes">Notes / Comments</label>
                                        <textarea id="notes" rows="4"
                                            placeholder="Add any additional notes about this supplier..."></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group checkbox-group">
                                        <input type="checkbox" id="preferred">
                                        <label for="preferred">Mark as Preferred Supplier</label>
                                    </div>
                                    <div class="form-group checkbox-group">
                                        <input type="checkbox" id="notify">
                                        <label for="notify">Enable Email Notifications</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <label for="tab-directory" class="btn btn-secondary">Cancel</label>
                                <button type="reset" class="btn btn-secondary">Reset Form</button>
                                <button type="submit" class="btn btn-primary">Save Supplier</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Supplier Details Tab -->
                <div class="tab-content" id="content-details">
                    <div class="content-card">
                        <div class="card-header">
                            <div>
                                <h2>Supplier Details</h2>
                                <p class="supplier-id-badge">SUP-001</p>
                            </div>
                            <div class="header-actions">
                                <label for="tab-add" class="btn btn-edit">Edit Supplier</label>
                                <label for="tab-directory" class="btn btn-secondary">Back to Directory</label>
                            </div>
                        </div>

                        <div class="details-grid">
                            <div class="details-section">
                                <h3>Company Information</h3>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <span class="info-label">Company Name:</span>
                                        <span class="info-value">MediPharm Distributors</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Status:</span>
                                        <span class="status-badge active">Active</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Email:</span>
                                        <span class="info-value">john.smith@medipharm.com</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Website:</span>
                                        <span class="info-value">www.medipharm.com</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Tax ID:</span>
                                        <span class="info-value">12-3456789</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">License Number:</span>
                                        <span class="info-value">LIC-987654</span>
                                    </div>
                                </div>
                            </div>
                            <div class="details-section">
                                <h3>Contact Person</h3>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <span class="info-label">Name:</span>
                                        <span class="info-value">John Smith</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Title:</span>
                                        <span class="info-value">Sales Manager</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Phone:</span>
                                        <span class="info-value">(555) 123-4567</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Mobile:</span>
                                        <span class="info-value">(555) 987-6543</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Fax:</span>
                                        <span class="info-value">(555) 123-4568</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Contact Email:</span>
                                        <span class="info-value">john.smith@medipharm.com</span>
                                    </div>
                                </div>
                            </div>
                            <div class="details-section">
                                <h3>Address</h3>
                                <div class="info-grid">
                                    <div class="info-item full-width">
                                        <span class="info-label">Street:</span>
                                        <span class="info-value">123 Medical Plaza</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">City:</span>
                                        <span class="info-value">New York</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">State:</span>
                                        <span class="info-value">NY</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">ZIP Code:</span>
                                        <span class="info-value">10001</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Country:</span>
                                        <span class="info-value">United States</span>
                                    </div>
                                </div>
                            </div>
                            <div class="details-section">
                                <h3>Business Terms</h3>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <span class="info-label">Payment Terms:</span>
                                        <span class="info-value">Net 30</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Credit Limit:</span>
                                        <span class="info-value">$50,000.00</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Delivery Time:</span>
                                        <span class="info-value">3-5 days</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Preferred Supplier:</span>
                                        <span class="info-value">✓ Yes</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="order-history-section">
                            <h3>Order History</h3>
                            <div class="stats-cards">
                                <div class="stat-card">
                                    <div class="stat-value">127</div>
                                    <div class="stat-label">Total Orders</div>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-value">$284,560</div>
                                    <div class="stat-label">Total Purchased</div>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-value">$12,340</div>
                                    <div class="stat-label">Outstanding</div>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-value">Nov 18, 2025</div>
                                    <div class="stat-label">Last Order</div>
                                </div>
                            </div>
                            <table class="orders-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Products</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="Order ID">PO-2025-0534</td>
                                        <td data-label="Date">Nov 18, 2025</td>
                                        <td data-label="Products">12 items</td>
                                        <td data-label="Total Amount">$4,250.00</td>
                                        <td data-label="Status"><span class="status-badge delivered">Delivered</span>
                                        </td>
                                        <td data-label="Payment"><span class="status-badge pending">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td data-label="Order ID">PO-2025-0498</td>
                                        <td data-label="Date">Nov 10, 2025</td>
                                        <td data-label="Products">8 items</td>
                                        <td data-label="Total Amount">$2,890.00</td>
                                        <td data-label="Status"><span class="status-badge delivered">Delivered</span>
                                        </td>
                                        <td data-label="Payment"><span class="status-badge paid">Paid</span></td>
                                    </tr>
                                    <tr>
                                        <td data-label="Order ID">PO-2025-0467</td>
                                        <td data-label="Date">Nov 3, 2025</td>
                                        <td data-label="Products">15 items</td>
                                        <td data-label="Total Amount">$6,120.00</td>
                                        <td data-label="Status"><span class="status-badge delivered">Delivered</span>
                                        </td>
                                        <td data-label="Payment"><span class="status-badge paid">Paid</span></td>
                                    </tr>
                                    <tr>
                                        <td data-label="Order ID">PO-2025-0432</td>
                                        <td data-label="Date">Oct 27, 2025</td>
                                        <td data-label="Products">10 items</td>
                                        <td data-label="Total Amount">$3,780.00</td>
                                        <td data-label="Status"><span class="status-badge delivered">Delivered</span>
                                        </td>
                                        <td data-label="Payment"><span class="status-badge paid">Paid</span></td>
                                    </tr>
                                    <tr>
                                        <td data-label="Order ID">PO-2025-0401</td>
                                        <td data-label="Date">Oct 19, 2025</td>
                                        <td data-label="Products">20 items</td>
                                        <td data-label="Total Amount">$8,560.00</td>
                                        <td data-label="Status"><span class="status-badge delivered">Delivered</span>
                                        </td>
                                        <td data-label="Payment"><span class="status-badge paid">Paid</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../assets/JS/suppliers.js"></script>
</body>

</html>

@endsection
