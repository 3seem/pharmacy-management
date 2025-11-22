
    
@extends('admin.admin_layouts.navbar-sidebar')
@section('content')

    @section('title')
        <title>User Management</title>
    @endsection
    @section('stylesheet')
        <link rel="stylesheet" href="../assets/CSS/usermanagement.css">
    @endsection


    <!-- Page Content -->
    <main class="container main">
         {{-- <div class="head-title">
                <h1>Sales & transactions</h1>
            </div> --}}
        <div class="user-container">
           
            <!-- Header/Tabs -->
            <div class="header-tabs" id="main-tabs">
                <div class="tab tab-active" data-view="staff-directory">
                    <i class="fas fa-users"></i>
                    Staff Directory
                </div>
                <div class="tab" data-view="customer-accounts">
                    <i class="fas fa-user-circle"></i>
                    Customer Accounts
                </div>
            </div>

            <!-- Dynamic View Content -->
            <div id="content-container">
                <!-- Staff Directory View -->
                <div id="staff-directory-view" class="view-content active">
                    <div class="controls">
                        <div class="user-info">
                            <span class="count-display" id="user-count-display"></span>
                            <span class="label-badge">Active Users</span>
                        </div>
                        <div class="filters">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="staff-search-input" placeholder="Search by name, email...">
                            </div>
                            <div class="filter-dropdown">
                                <select id="role-filter">
                                    <option value="">All Roles</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Pharmacist">Pharmacist</option>
                                    <option value="Cashier">Cashier</option>
                                </select>
                            </div>
                            <div class="filter-dropdown">
                                <select id="staff-status-filter">
                                    <option value="">All Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <button class="add-button" id="add-user-btn">
                            <i class="fas fa-plus"></i>
                            Add New User
                        </button>
                    </div>

                    <!-- Data Table for Staff -->
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Last Login</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="staff-table-body">
                                <!-- Staff rows will be inserted here by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div> <!-- End Staff Directory View -->


                <!-- Customer Accounts View -->
                <div id="customer-accounts-view" class="view-content" style="display:none;">
                    <div class="controls">
                        <div class="customer-info">
                            <span class="count-display" id="customer-count-display"></span>
                            <span class="label-badge">Registered</span>
                        </div>
                        <div class="filters">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="customer-search-input"
                                    placeholder="Search customers by name, email, phone...">
                            </div>
                            <div class="filter-dropdown">
                                <select id="customer-status-filter">
                                    <option value="">All Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="filter-dropdown">
                                <select id="customer-sort-filter">
                                    <option value="Recent">Sort by: Recent</option>
                                    <option value="Orders">Sort by: Total Orders</option>
                                    <option value="Name">Sort by: Name</option>
                                </select>
                            </div>
                        </div>
                        <!-- No "Add New User" button on this view, as per the image -->
                    </div>

                    <!-- Data Table for Customers -->
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Registered Date</th>
                                    <th>Total Orders</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="customer-table-body">
                                <!-- Customer rows will be inserted here by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div> <!-- End Customer Accounts View -->

            </div>
        </div>

        <!-- Add/Edit User Modal (Now handles both) -->
        <div id="userModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 id="modal-title">Add New User</h2>
                    <button class="close-button" id="close-modal-btn">&times;</button>
                </div>
                <form id="user-form">
                    <div class="form-grid">
                        <div class="form-group two-col">
                            <label for="firstName">First Name *</label>
                            <input type="text" id="firstName" placeholder="Enter first name" required>
                        </div>
                        <div class="form-group two-col">
                            <label for="lastName">Last Name *</label>
                            <input type="text" id="lastName" placeholder="Enter last name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" placeholder="user@example.com" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" placeholder="+1 (555) 000-0000">
                        </div>
                        <div class="form-group">
                            <label for="role">Assigned Role *</label>
                            <select id="role" required>
                                <!-- Note: The Edit screenshot shows "Admin - Full System Access" which I'll add to reflect the image -->
                                <option value="Cashier - Sales & Billing">Cashier - Sales & Billing</option>
                                <option value="Pharmacist - Patient Care">Pharmacist - Patient Care</option>
                                <option value="Admin - System Management">Admin - System Management</option>
                            </select>
                        </div>

                        <!-- Password Fields for ADD Mode -->
                        <div id="password-fields"
                            style="display: block; grid-column: span 2; display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                            <div class="form-group">
                                <label for="password">Initial Password *</label>
                                <input type="password" id="password" placeholder="Min. 8 characters" required
                                    minlength="8">
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password *</label>
                                <input type="password" id="confirmPassword" placeholder="Re-enter password" required>
                            </div>
                        </div>

                        <!-- Password Reset Button for EDIT Mode -->
                        <div id="password-reset-field" style="display:none; grid-column: span 2;">
                            <button type="button" class="reset-button" id="send-reset-email-btn">
                                <i class="fas fa-envelope"></i> Send Password Reset Email
                            </button>
                        </div>
                    </div>

                    <div class="checkbox-group">
                        <input type="checkbox" id="accountActive" checked>
                        <label for="accountActive">Account Active (User can log in immediately)</label>
                    </div>

                    <!-- Require Change Checkbox for ADD Mode -->
                    <div class="checkbox-group" id="require-change-checkbox" style="display: block;">
                        <input type="checkbox" id="requireChange">
                        <label for="requireChange">Require password change on first login</label>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" id="cancel-modal-btn">Cancel</button>
                        <button type="submit" class="btn-primary-action" id="submit-button">Create User Account</button>
                    </div>
                </form>
            </div>
        </div>

    </main>
    <script src="../assets/JS/usermanagement.js"></script>
</body>

</html>

    @endsection
