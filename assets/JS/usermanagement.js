 // Sidebar
        const sidebar = document.getElementById("sidebar");
        const openBtn = document.getElementById("openSidebar");
        const closeBtn = document.getElementById("closeSidebar");

        openBtn.addEventListener("click", () => {
            sidebar.classList.add("open");
        });

        closeBtn.addEventListener("click", () => {
            sidebar.classList.remove("open");
        });

        // --- Data Mockup ---
        let staffUsers = [
            // Note: Updated role to match the dropdown value for correct form population
            { id: 1, name: "Sarah Johnson", email: "sarah.johnson@pharmacy.com", phone: "+1 (555) 111-2222", initial: "SJ", role: "Admin", roleValue: "Admin - System Management", status: "Active", lastLogin: "2025-11-22 09:30 AM" },
            { id: 2, name: "John Smith", email: "john.smith@pharmacy.com", phone: "+1 (555) 333-4444", initial: "JS", role: "Cashier", roleValue: "Cashier - Sales & Billing", status: "Active", lastLogin: "2025-11-22 08:15 AM" },
            { id: 3, name: "Emily Davis", email: "emily.davis@pharmacy.com", phone: "+1 (555) 555-6666", initial: "ED", role: "Pharmacist", roleValue: "Pharmacist - Patient Care", status: "Active", lastLogin: "2025-11-21 04:20 PM" },
            { id: 4, name: "Michael Brown", email: "michael.brown@pharmacy.com", phone: "+1 (555) 777-8888", initial: "MB", role: "Cashier", roleValue: "Cashier - Sales & Billing", status: "Active", lastLogin: "2025-11-22 07:45 AM" },
            { id: 5, name: "Jessica Wilson", email: "jessica.wilson@pharmacy.com", phone: "+1 (555) 999-0000", initial: "JW", role: "Pharmacist", roleValue: "Pharmacist - Patient Care", status: "Active", lastLogin: "2025-11-22 10:00 AM" },
            { id: 6, name: "Laura Chen", email: "laura.chen@pharmacy.com", phone: "+1 (555) 454-5656", initial: "LC", role: "Cashier", roleValue: "Cashier - Sales & Billing", status: "Active", lastLogin: "2025-11-22 11:30 AM" }
        ];
        
        let customerAccounts = [
            { id: 101, name: "Steven Hall", email: "steven.hall@email.com", initial: "SH", phone: "+1 (555) 123-4568", registeredDate: "2025-09-12", totalOrders: 6, status: "Active" },
            { id: 102, name: "Jennifer Walker", email: "jennifer.walker@email.com", initial: "JW", phone: "+1 (555) 012-3456", registeredDate: "2025-08-05", totalOrders: 12, status: "Active" },
            { id: 103, name: "Christopher Lee", email: "chris.lee@email.com", initial: "CL", phone: "+1 (555) 567-8901", registeredDate: "2025-07-08", totalOrders: 8, status: "Active" },
            { id: 104, name: "Barbara Clark", email: "barbara.clark@email.com", initial: "BC", phone: "+1 (555) 890-1234", registeredDate: "2025-06-30", totalOrders: 19, status: "Active" },
            { id: 105, name: "David Miller", email: "david.miller@email.com", initial: "DM", phone: "+1 (555) 777-1111", registeredDate: "2025-10-15", totalOrders: 3, status: "Inactive" }
        ];
        
        let nextStaffId = Math.max(...staffUsers.map(u => u.id)) + 1;
        let currentModalMode = 'add'; // 'add' or 'edit'
        let currentUserId = null; // ID of the user being edited


        // --- DOM Elements ---
        const staffTableBody = document.getElementById('staff-table-body');
        const staffSearchInput = document.getElementById('staff-search-input');
        const roleFilter = document.getElementById('role-filter');
        const staffStatusFilter = document.getElementById('staff-status-filter');
        const userCountDisplay = document.getElementById('user-count-display');
        
        const customerTableBody = document.getElementById('customer-table-body');
        const customerSearchInput = document.getElementById('customer-search-input');
        const customerStatusFilter = document.getElementById('customer-status-filter');
        const customerSortFilter = document.getElementById('customer-sort-filter');
        const customerCountDisplay = document.getElementById('customer-count-display');

        // Tabs
        const tabs = document.querySelectorAll('.tab');
        const staffView = document.getElementById('staff-directory-view');
        const customerView = document.getElementById('customer-accounts-view');

        // Modal Elements (Unified for Add/Edit)
        const addUserBtn = document.getElementById('add-user-btn');
        const userModal = document.getElementById('userModal');
        const userForm = document.getElementById('user-form');
        const modalTitle = document.getElementById('modal-title');
        const submitButton = document.getElementById('submit-button');
        const closeModalBtns = [document.getElementById('close-modal-btn'), document.getElementById('cancel-modal-btn')];
        
        // Modal Fields
        const firstNameInput = document.getElementById('firstName');
        const lastNameInput = document.getElementById('lastName');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');
        const roleInput = document.getElementById('role');
        const accountActiveCheckbox = document.getElementById('accountActive');
        
        // Mode-Specific Fields
        const passwordFieldsDiv = document.getElementById('password-fields');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        const passwordResetDiv = document.getElementById('password-reset-field');
        const requireChangeCheckboxDiv = document.getElementById('require-change-checkbox');


        // --- Utility Functions ---

        /**
         * Simple hash function to generate a consistent color for a name.
         * @param {string} str
         * @returns {string} Hex color
         */
        function stringToColor(str) {
            let hash = 0;
            for (let i = 0; i < str.length; i++) {
                hash = str.charCodeAt(i) + ((hash << 5) - hash);
            }
            let color = '#';
            for (let i = 0; i < 3; i++) {
                const value = (hash >> (i * 8)) & 0xFF;
                const finalValue = (value * 1.6) % 256; 
                color += ('00' + Math.floor(finalValue).toString(16)).slice(-2);
            }
            return color;
        }

        /**
         * Determines the CSS class for the role tag (for staff).
         * @param {string} role
         * @returns {string}
         */
        function getRoleClass(role) {
            switch (role) {
                case 'Admin': return 'tag-admin';
                case 'Cashier': return 'tag-cashier';
                case 'Pharmacist': return 'tag-pharmacist';
                default: return '';
            }
        }

        /**
         * Determines the CSS class for the status tag (for both staff and customers).
         * @param {string} status
         * @returns {string}
         */
        function getStatusClass(status) {
            return status === 'Active' ? 'tag-active' : 'tag-inactive';
        }


        // --- Tab Switching Logic ---

        /**
         * Switches the active view and updates the tabs.
         * @param {string} viewId - The ID of the view to show ('staff-directory' or 'customer-accounts').
         */
        function switchView(viewId) {
            // Update Tab styles
            tabs.forEach(tab => {
                tab.classList.remove('tab-active');
                if (tab.getAttribute('data-view') === viewId) {
                    tab.classList.add('tab-active');
                }
            });

            // Update View content visibility
            staffView.style.display = 'none';
            customerView.style.display = 'none';

            if (viewId === 'staff-directory') {
                staffView.style.display = 'block';
                filterStaffUsers(); 
            } else if (viewId === 'customer-accounts') {
                customerView.style.display = 'block';
                filterCustomerAccounts(); 
            }
        }
        
        // Add event listeners for tab switching
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const viewId = tab.getAttribute('data-view');
                switchView(viewId);
            });
        });


        // --- Staff Directory Functions ---

        /**
         * Renders the staff table.
         * @param {Array<Object>} usersToRender
         */
        function renderStaffTable(usersToRender) {
            staffTableBody.innerHTML = '';
            
            usersToRender.forEach((user, index) => {
                const row = staffTableBody.insertRow();
                row.className = 'data-row';
                
                // 1. Name Column (with initials avatar)
                const nameCell = row.insertCell();
                nameCell.innerHTML = `
                    <div style="display: flex; align-items: center;">
                        <span class="initial-avatar" style="background-color: ${stringToColor(user.name)};">${user.initial}</span>
                        ${user.name}
                    </div>
                `;

                // 2. Email Column
                row.insertCell().textContent = user.email;

                // 3. Role Column (with colored tag)
                const roleCell = row.insertCell();
                roleCell.innerHTML = `<span class="tag ${getRoleClass(user.role)}">${user.role}</span>`;

                // 4. Status Column (with colored dot)
                const statusCell = row.insertCell();
                statusCell.innerHTML = `<span class="tag ${getStatusClass(user.status)}">${user.status}</span>`;

                // 5. Last Login Column
                row.insertCell().textContent = user.lastLogin;

                // 6. Actions Column
                const actionsCell = row.insertCell();
                actionsCell.className = 'actions';
                
                // Determine action button: Remove (for active) or Activate (for inactive/removed)
                const actionButton = user.status === 'Active' ? 
                    `<button class="remove-btn" data-id="${user.id}" data-type="staff" data-action="remove" title="Permanently Remove User"><i class="fas fa-trash"></i> Remove</button>` :
                    `<button class="activate-btn" data-id="${user.id}" data-type="staff" data-action="activate" title="Activate Account"><i class="fas fa-unlock"></i> Activate</button>`;
                
                // Edit button now includes the text "Edit" as requested.
                actionsCell.innerHTML = `
                    <button class="edit-btn" data-id="${user.id}" data-type="staff" data-action="edit" title="Edit User"><i class="fas fa-pencil-alt"></i> Edit</button>
                    ${actionButton}
                `;
            });
            
            // Add listeners for the new action buttons
            attachActionListeners();

            // Update active user count
            userCountDisplay.textContent = staffUsers.filter(u => u.status === 'Active').length;
        }

        /**
         * Filters the staff user list based on search term, role, and status filters.
         */
        function filterStaffUsers() {
            const searchTerm = staffSearchInput.value.toLowerCase();
            const selectedRole = roleFilter.value;
            const selectedStatus = staffStatusFilter.value;

            const filtered = staffUsers.filter(user => {
                // Search filter
                const nameMatch = user.name.toLowerCase().includes(searchTerm);
                const emailMatch = user.email.toLowerCase().includes(searchTerm);
                const searchPass = nameMatch || emailMatch;

                // Role filter
                const rolePass = !selectedRole || user.role === selectedRole;

                // Status filter
                const statusPass = !selectedStatus || user.status === selectedStatus;

                return searchPass && rolePass && statusPass;
            });

            renderStaffTable(filtered);
        }

        // Add Staff Filter/Search Listeners
        staffSearchInput.addEventListener('input', filterStaffUsers);
        roleFilter.addEventListener('change', filterStaffUsers);
        staffStatusFilter.addEventListener('change', filterStaffUsers);

        // --- Customer Accounts Functions (Unchanged) ---

        /**
         * Renders the customer table.
         * @param {Array<Object>} customersToRender
         */
        function renderCustomerTable(customersToRender) {
            customerTableBody.innerHTML = '';
            
            customersToRender.forEach((customer, index) => {
                const row = customerTableBody.insertRow();
                row.className = 'data-row';
                
                // 1. Customer Name (with initials avatar)
                const nameCell = row.insertCell();
                nameCell.innerHTML = `
                    <div style="display: flex; align-items: center;">
                        <span class="initial-avatar" style="background-color: ${stringToColor(customer.name)};">${customer.initial}</span>
                        ${customer.name}
                    </div>
                `;

                // 2. Email
                row.insertCell().textContent = customer.email;

                // 3. Phone
                row.insertCell().textContent = customer.phone;

                // 4. Registered Date
                row.insertCell().textContent = customer.registeredDate;

                // 5. Total Orders
                const ordersCell = row.insertCell();
                ordersCell.className = 'total-orders-cell';
                ordersCell.textContent = customer.totalOrders;

                // 6. Status
                const statusCell = row.insertCell();
                statusCell.innerHTML = `<span class="tag ${getStatusClass(customer.status)}">${customer.status}</span>`;

                // 7. Actions (Suspend/Activate button only)
                const actionsCell = row.insertCell();
                actionsCell.className = 'actions';
                
                // Determine suspend/activate button
                const actionButton = customer.status === 'Active' ? 
                    `<button class="suspend-btn" data-id="${customer.id}" data-type="customer" data-action="suspend" title="Suspend Account"><i class="fas fa-lock"></i> Suspend</button>` :
                    `<button class="activate-btn" data-id="${customer.id}" data-type="customer" data-action="activate" title="Activate Account"><i class="fas fa-unlock"></i> Activate</button>`;

                actionsCell.innerHTML = actionButton;
            });
            
            // Add listeners for the new action buttons
            attachActionListeners();

            // Update registered customer count
            customerCountDisplay.textContent = customerAccounts.length;
        }

        /**
         * Filters and sorts the customer list.
         */
        function filterCustomerAccounts() {
            const searchTerm = customerSearchInput.value.toLowerCase();
            const selectedStatus = customerStatusFilter.value;
            const sortKey = customerSortFilter.value;
            
            let filtered = customerAccounts.filter(customer => {
                // Search filter (Name, Email, Phone)
                const nameMatch = customer.name.toLowerCase().includes(searchTerm);
                const emailMatch = customer.email.toLowerCase().includes(searchTerm);
                const phoneMatch = customer.phone.includes(searchTerm);
                const searchPass = nameMatch || emailMatch || phoneMatch;

                // Status filter
                const statusPass = !selectedStatus || customer.status === selectedStatus;

                return searchPass && statusPass;
            });
            
            // Sorting Logic
            if (sortKey === 'Orders') {
                filtered.sort((a, b) => b.totalOrders - a.totalOrders);
            } else if (sortKey === 'Name') {
                filtered.sort((a, b) => a.name.localeCompare(b.name));
            } else { // Default to Recent (Registered Date)
                filtered.sort((a, b) => new Date(b.registeredDate) - new Date(a.registeredDate));
            }

            renderCustomerTable(filtered);
        }

        // Add Customer Filter/Search Listeners
        customerSearchInput.addEventListener('input', filterCustomerAccounts);
        customerStatusFilter.addEventListener('change', filterCustomerAccounts);
        customerSortFilter.addEventListener('change', filterCustomerAccounts);
        
        // --- Account Action Logic (Suspend/Activate/Remove) ---

        /**
         * Handles status change or removal of a staff or customer account.
         * @param {number} id - The ID of the account.
         * @param {string} type - 'staff' or 'customer'.
         * @param {string} action - 'suspend', 'activate', or 'remove'.
         */
        function toggleAccountStatus(id, type, action) {
            
            if (type === 'staff' && action === 'remove') {
                // Handle staff removal (deletion)
                staffUsers = staffUsers.filter(item => item.id !== id);
                console.log(`Staff account ${id} successfully REMOVED (Deleted).`);
                filterStaffUsers();
                return;
            }

            let dataArray;
            if (type === 'staff') {
                dataArray = staffUsers;
            } else if (type === 'customer') {
                dataArray = customerAccounts;
            } else {
                console.error("Invalid account type.");
                return;
            }
            
            const account = dataArray.find(item => item.id === id);
            
            if (account) {
                // For staff 'activate' or customer 'suspend/activate'
                const newStatus = action === 'suspend' ? 'Inactive' : 'Active';
                account.status = newStatus;
                
                console.log(`${type} account ${id} status set to: ${newStatus}`);
                
                // Re-render the correct table to reflect changes
                if (type === 'staff') {
                    filterStaffUsers();
                } else if (type === 'customer') {
                    filterCustomerAccounts();
                }
            } else {
                console.error(`Account with ID ${id} not found in ${type} list.`);
            }
        }

        /**
         * Attaches event listeners to all newly rendered action buttons.
         */
        function attachActionListeners() {
            document.querySelectorAll('.actions button[data-id]').forEach(button => {
                button.onclick = (e) => {
                    e.stopPropagation(); 
                    const id = parseInt(button.getAttribute('data-id'));
                    const type = button.getAttribute('data-type');
                    const action = button.getAttribute('data-action');
                    
                    if (action === 'edit' && type === 'staff') {
                        openUserModal('edit', id);
                    } else {
                        toggleAccountStatus(id, type, action);
                    }
                };
            });
        }


        // --- Modal Functions (Combined Add/Edit Logic) ---

        /**
         * Opens the user modal in 'add' or 'edit' mode.
         * @param {string} mode - 'add' or 'edit'.
         * @param {number} [userId=null] - The ID of the user to edit.
         */
        function openUserModal(mode, userId = null) {
            currentModalMode = mode;
            currentUserId = userId;
            userForm.reset();
            
            // Clear password validation messages
            passwordInput.setCustomValidity('');
            confirmPasswordInput.setCustomValidity('');

            if (mode === 'add') {
                // Setup for Add Mode
                modalTitle.textContent = 'Add New User';
                submitButton.textContent = 'Create User Account';
                passwordFieldsDiv.style.display = 'grid'; // Show password fields
                passwordInput.required = true;
                confirmPasswordInput.required = true;
                passwordResetDiv.style.display = 'none'; // Hide reset button
                requireChangeCheckboxDiv.style.display = 'block'; // Show require change checkbox

                // Default values for new user
                accountActiveCheckbox.checked = true;
                
            } else if (mode === 'edit') {
                // Setup for Edit Mode
                modalTitle.textContent = 'Edit User';
                submitButton.textContent = 'Save Changes';
                passwordFieldsDiv.style.display = 'none'; // Hide password fields
                passwordInput.required = false;
                confirmPasswordInput.required = false;
                passwordResetDiv.style.display = 'block'; // Show reset button
                requireChangeCheckboxDiv.style.display = 'none'; // Hide require change checkbox

                const user = staffUsers.find(u => u.id === userId);
                if (user) {
                    // Pre-populate fields
                    const [first, ...lastParts] = user.name.split(' ');
                    firstNameInput.value = first || '';
                    lastNameInput.value = lastParts.join(' ') || '';
                    emailInput.value = user.email;
                    phoneInput.value = user.phone || '';
                    roleInput.value = user.roleValue;
                    accountActiveCheckbox.checked = user.status === 'Active';
                }
            }

            userModal.classList.add('open');
        }

        /**
         * Closes the modal and resets the form.
         */
        function closeModal() {
            userModal.classList.remove('open');
            userForm.reset();
            currentUserId = null;
        }

        /**
         * Handles form submission for both adding and editing users.
         */
        function handleSubmitUser(event) {
            event.preventDefault();
            
            const firstName = firstNameInput.value.trim();
            const lastName = lastNameInput.value.trim();
            const email = emailInput.value.trim();
            const phone = phoneInput.value.trim();
            const roleText = roleInput.value;
            const role = roleText.split(' - ')[0]; // Extract role name (e.g., "Admin")
            const roleValue = roleText; // Full role description
            const status = accountActiveCheckbox.checked ? 'Active' : 'Inactive';
            
            // Password validation only for 'add' mode
            if (currentModalMode === 'add') {
                if (passwordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordInput.setCustomValidity("Passwords do not match.");
                    confirmPasswordInput.reportValidity();
                    return;
                } else {
                    confirmPasswordInput.setCustomValidity('');
                }
            }
            
            if (currentModalMode === 'add') {
                // Add New User Logic
                const newUser = {
                    id: nextStaffId++,
                    name: `${firstName} ${lastName}`,
                    email: email,
                    phone: phone,
                    initial: (firstName.charAt(0) + lastName.charAt(0)).toUpperCase(),
                    role: role, 
                    roleValue: roleValue,
                    status: status,
                    lastLogin: 'N/A'
                };

                staffUsers.push(newUser);
                console.log("New User Added:", newUser);
                
            } else if (currentModalMode === 'edit') {
                // Edit User Logic
                const index = staffUsers.findIndex(u => u.id === currentUserId);
                if (index !== -1) {
                    staffUsers[index].name = `${firstName} ${lastName}`;
                    staffUsers[index].email = email;
                    staffUsers[index].phone = phone;
                    staffUsers[index].initial = (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();
                    staffUsers[index].role = role;
                    staffUsers[index].roleValue = roleValue;
                    staffUsers[index].status = status;
                    // Note: lastLogin remains unchanged
                    
                    console.log(`User ID ${currentUserId} updated.`);
                }
            }

            filterStaffUsers(); 
            closeModal();
        }

        /**
         * Validates passwords in Add mode.
         */
        function validatePasswords() {
            if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordInput.setCustomValidity("Passwords do not match.");
            } else {
                confirmPasswordInput.setCustomValidity('');
            }
        }
        
        // --- Event Listeners and Initialization ---
        
        // Modal Listeners
        addUserBtn.addEventListener('click', () => openUserModal('add'));
        closeModalBtns.forEach(btn => btn.addEventListener('click', closeModal));
        userModal.addEventListener('click', (e) => {
            if (e.target === userModal) {
                closeModal();
            }
        });
        passwordInput.addEventListener('change', validatePasswords);
        confirmPasswordInput.addEventListener('keyup', validatePasswords);
        userForm.addEventListener('submit', handleSubmitUser);
        
        // Placeholder for Password Reset button logic
        document.getElementById('send-reset-email-btn').addEventListener('click', () => {
            const user = staffUsers.find(u => u.id === currentUserId);
            const userEmail = user ? user.email : 'the user';
            alert(`A password reset email has been sent to ${userEmail}.`);
        });

        // Initial render on load
        document.addEventListener('DOMContentLoaded', () => {
            // Start with the Staff Directory view active
            filterStaffUsers(); 
            // Pre-load customer data as well
            filterCustomerAccounts();
            // Ensure the initial view is set
            switchView('staff-directory'); 
        });