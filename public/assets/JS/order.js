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

        const STATUS_OPTIONS = ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'];
        const TAX_RATE = 0.08; // 8% tax rate for calculation
        const SHIPPING_COST = 15.00; // Fixed shipping cost

        // Application State
        const state = {
            currentView: 'list', // 'list' or 'details'
            selectedOrderId: null,
            orders: [
                { 
                    id: 'ORD-001', 
                    date: new Date(Date.now() - 86400000 * 5).toISOString(), 
                    status: 'Delivered', 
                    customerName: 'John Smith', 
                    customerEmail: 'john.s@example.com', 
                    totalAmount: 299.99, 
                    paymentMethod: { name: 'Credit Card', details: '**** 4532' },
                    billingAddress: { street: '123 Main St', city: 'New York', state: 'NY', zipCode: '10001', country: 'USA' },
                    shippingAddress: { street: '123 Main St', city: 'New York', state: 'NY', zipCode: '10001', country: 'USA' },
                    items: [
                        { productName: 'Wireless Headphones', quantity: 1, price: 149.99 },
                        { productName: 'Phone Case', quantity: 2, price: 37.50 }
                    ]
                },
                { 
                    id: 'ORD-002', 
                    date: new Date(Date.now() - 86400000 * 3).toISOString(), 
                    status: 'Shipped', 
                    customerName: 'Sarah Johnson', 
                    customerEmail: 'sarah.j@example.com', 
                    totalAmount: 599.50, 
                    paymentMethod: { name: 'Cash on Delivery', details: 'Confirmed' },
                    billingAddress: { street: '45 Nile View', city: 'Alexandria', state: 'Alexandria', zipCode: '21500', country: 'Egypt' },
                    shippingAddress: { street: '45 Nile View', city: 'Alexandria', state: 'Alexandria', zipCode: '21500', country: 'Egypt' },
                    items: [
                        { productName: 'Blood Pressure Monitor', quantity: 1, price: 500.00 },
                        { productName: 'First Aid Kit', quantity: 1, price: 75.00 }
                    ]
                },
                { 
                    id: 'ORD-003', 
                    date: new Date(Date.now() - 86400000 * 4).toISOString(), 
                    status: 'Delivered', 
                    customerName: 'Michael Chen', 
                    customerEmail: 'michael.c@example.com', 
                    totalAmount: 1249.00, 
                    paymentMethod: { name: 'PayPal', details: 'michael.c@...' },
                    billingAddress: { street: '10th Street, Heliopolis', city: 'Cairo', state: 'Cairo', zipCode: '11341', country: 'Egypt' },
                    shippingAddress: { street: '10th Street, Heliopolis', city: 'Cairo', state: 'Cairo', zipCode: '11341', country: 'Egypt' },
                    items: [
                        { productName: 'Hand Sanitizer Gel (500ml)', quantity: 10, price: 85.00 },
                        { productName: 'N95 Masks (Pack of 50)', quantity: 2, price: 400.00 }
                    ]
                },
                { 
                    id: 'ORD-004', 
                    date: new Date(Date.now() - 86400000 * 1).toISOString(), 
                    status: 'Pending', 
                    customerName: 'Emily Brown', 
                    customerEmail: 'emily.b@example.com', 
                    totalAmount: 89.99, 
                    paymentMethod: { name: 'Credit Card', details: '**** 1001' },
                    billingAddress: { street: 'City Stars Mall', city: 'Nasr City', state: 'Cairo', zipCode: '11765', country: 'Egypt' },
                    shippingAddress: { street: 'City Stars Mall', city: 'Nasr City', state: 'Cairo', zipCode: '11765', country: 'Egypt' },
                    items: [
                        { productName: 'Children\'s Pain Reliever', quantity: 1, price: 89.99 }
                    ]
                },
                { 
                    id: 'ORD-005', 
                    date: new Date(Date.now() - 86400000 * 7).toISOString(), 
                    status: 'Cancelled', 
                    customerName: 'David Wilson', 
                    customerEmail: 'david.w@example.com', 
                    totalAmount: 449.99, 
                    paymentMethod: { name: 'Credit Card', details: '**** 1001' },
                    billingAddress: { street: 'City Stars Mall', city: 'Nasr City', state: 'Cairo', zipCode: '11765', country: 'Egypt' },
                    shippingAddress: { street: 'City Stars Mall', city: 'Nasr City', state: 'Cairo', zipCode: '11765', country: 'Egypt' },
                    items: [
                        { productName: 'Vitamin C Tablets', quantity: 5, price: 449.99 }
                    ]
                }
            ]
        };

        // --- UTILITY FUNCTIONS ---
        
        // UPDATED: Now returns pure CSS classes
        function getStatusColor(status) {
            switch (status) {
                case 'Pending': return 'status-Pending';
                case 'Processing': return 'status-Processing';
                case 'Shipped': return 'status-Shipped';
                case 'Delivered': return 'status-Delivered';
                case 'Cancelled': return 'status-Cancelled';
                default: return 'status-default';
            }
        }
        
        // UPDATED: Now returns pure CSS classes
        function getMetricColor(status) {
             switch (status) {
                case 'Pending': return 'metric-text-yellow';
                case 'Processing': return 'metric-text-blue';
                case 'Shipped': return 'metric-text-purple';
                case 'Delivered': return 'metric-text-green';
                case 'Total Orders': return 'metric-text-gray';
                default: return 'metric-text-gray';
            }
        }

        function showMessage(message) {
            const msgBox = document.getElementById('message-box');
            const msgText = document.getElementById('message-text');
            if (msgBox && msgText) {
                msgText.textContent = message;
                msgBox.classList.remove('hidden', 'opacity-0');
                msgBox.classList.add('opacity-100');
                setTimeout(() => {
                    msgBox.classList.remove('opacity-100');
                    msgBox.classList.add('opacity-0');
                    setTimeout(() => { msgBox.classList.add('hidden'); }, 300);
                }, 3000);
            }
        }

        function calculateMetrics() {
            const metrics = {
                'Total Orders': state.orders.length,
                'Pending': 0,
                'Processing': 0,
                'Shipped': 0,
                'Delivered': 0,
            };

            state.orders.forEach(order => {
                if (metrics.hasOwnProperty(order.status)) {
                    metrics[order.status]++;
                }
            });
            return metrics;
        }

        // --- STATE MODIFICATION ---

        function updateOrderStatus(orderId, newStatus) {
            const order = state.orders.find(o => o.id === orderId);
            if (order) {
                order.status = newStatus;
                showMessage(`Order ${orderId} status updated to ${newStatus}.`);
                if (state.currentView === 'list') {
                    updateDashboardContent();
                } else if (state.currentView === 'details' && state.selectedOrderId === orderId) {
                    updateDetailsContent(order);
                }
            }
        }

        // --- NAVIGATION & VIEW MANAGEMENT ---

        function switchToDetails(orderId) {
            state.currentView = 'details';
            state.selectedOrderId = orderId;
            const order = state.orders.find(o => o.id === orderId);

            document.getElementById('list-view-container').classList.add('hidden');
            document.getElementById('details-view-container').classList.remove('hidden');
            
            updateDetailsContent(order);
            attachEventListeners();
        }

        function switchToHome() {
            state.currentView = 'list';
            state.selectedOrderId = null;

            document.getElementById('list-view-container').classList.remove('hidden');
            document.getElementById('details-view-container').classList.add('hidden');
            
            updateDashboardContent();
            attachEventListeners();
        }


        // --- DYNAMIC CONTENT RENDERING FUNCTIONS ---

        function updateMetricCardsContent() {
            const metrics = calculateMetrics();
            for (const key in metrics) {
                const element = document.getElementById(`metric-${key}`);
                if (element) {
                    element.textContent = metrics[key];
                    // Also update color class for metrics (though static colors are set in HTML for now)
                    element.className = `mt-1 text-2xl font-extrabold ${getMetricColor(key)}`;
                }
            }
        }

        function renderStatusDropdown(currentStatus, orderId) {
            const badgeClasses = getStatusColor(currentStatus);
            const optionsHtml = STATUS_OPTIONS.map(opt => `
                <option value="${opt}" ${currentStatus === opt ? 'selected' : ''}>
                    ${opt}
                </option>
            `).join('');

            return `
                <div class="status-select-container ${badgeClasses}">
                    <select
                        data-order-id="${orderId}"
                        class="status-select ${badgeClasses}"
                    >
                        ${optionsHtml}
                    </select>
                </div>
            `;
        }

        function renderOrderTableRows() {
            return state.orders.map(order => {
                const formattedDate = new Date(order.date).toLocaleDateString('en-US', { year: 'numeric', month: '2-digit', day: '2-digit' });
                
                return `
                    <tr>
                        <td class="text-sm font-medium text-gray-900">${order.id}</td>
                        <td class="text-sm text-gray-700">${order.customerName}</td>
                        <td class="text-sm font-medium text-gray-700">$${order.totalAmount.toFixed(2)}</td>
                        <td class="text-sm text-gray-500">${formattedDate}</td>
                        <td class="">
                            ${renderStatusDropdown(order.status, order.id)}
                        </td>
                        <td class="text-right text-sm font-medium">
                            <button
                                data-order-id="${order.id}"
                                class="view-details-btn btn-details"
                            >
                                View Details
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }
        
        /**
         * Fills the static details view structure with dynamic order data.
         */
        function updateDetailsContent(order) {
            if (!order) {
                document.getElementById('details-order-id').textContent = 'Error: Order not found.';
                return;
            }

            // --- CALCULATIONS ---
            let subtotal = 0;
            order.items.forEach(item => {
                subtotal += item.price * item.quantity;
            });
            
            const taxAmount = subtotal * TAX_RATE;
            const shipping = SHIPPING_COST;
            const calculatedTotal = subtotal + taxAmount + shipping;


            // --- 1. Order Information Card ---
            document.getElementById('details-order-id').textContent = `Order #${order.id}`;

            const statusBadge = document.getElementById('details-status-badge');
            statusBadge.textContent = order.status;
            // Use the new CSS status classes
            statusBadge.className = getStatusColor(order.status) + ' rounded-full px-3 py-1 text-xs font-semibold';

            const placedDate = new Date(order.date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
            document.getElementById('details-placed-date').textContent = placedDate;

            document.getElementById('details-customer-name').textContent = order.customerName;
            document.getElementById('details-customer-email').textContent = order.customerEmail;
            document.getElementById('details-total-amount').textContent = `$${order.totalAmount.toFixed(2)}`;


            // --- 2. Order Items Card ---
            const itemsHtml = order.items.map(item => `
                <div class="item-row">
                    <div>
                        <p class="item-name">${item.productName}</p>
                        <p class="item-qty">Quantity: ${item.quantity}</p>
                    </div>
                    <span class="item-name">$${(item.price * item.quantity).toFixed(2)}</span>
                </div>
            `).join('');

            document.getElementById('details-order-items').innerHTML = itemsHtml;
            
            // --- 3. Summary/Totals Section ---
            document.getElementById('summary-subtotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('summary-tax-rate').textContent = `${(TAX_RATE * 100).toFixed(0)}%`;
            document.getElementById('summary-tax-amount').textContent = `$${taxAmount.toFixed(2)}`;
            document.getElementById('summary-shipping').textContent = `$${shipping.toFixed(2)}`;
            document.getElementById('summary-total').textContent = `$${calculatedTotal.toFixed(2)}`;


            // --- 4. Payment Method Card (Simple SVG for Card Icon) ---
            const paymentDetailsHtml = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M3 5m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"></path>
                    <path d="M3 10l18 0"></path>
                    <path d="M7 15l.01 0"></path>
                    <path d="M11 15l2 0"></path>
                </svg>
                <span class="font-semibold">${order.paymentMethod.name}</span>
                <span class="text-gray-500">(${order.paymentMethod.details})</span>
            `;
            document.getElementById('payment-method-details').innerHTML = paymentDetailsHtml;


            // --- 5. Address Cards ---
            const renderAddress = (addr) => {
                if (!addr) return '<p class="text-gray-500">Address not provided.</p>';
                return `
                    <p class="font-medium">${addr.street}</p>
                    <p>${addr.city}, ${addr.state} ${addr.zipCode}</p>
                    <p>${addr.country}</p>
                `;
            }

            document.getElementById('billing-address-content').innerHTML = renderAddress(order.billingAddress);
            document.getElementById('shipping-address-content').innerHTML = renderAddress(order.shippingAddress);

            attachEventListeners();
        }

        function updateDashboardContent() {
            updateMetricCardsContent();
            const tableBody = document.getElementById('orders-table-body');
            tableBody.innerHTML = renderOrderTableRows();
            attachEventListeners();
        }

        function attachEventListeners() {
            if (state.currentView === 'list') {
                document.querySelectorAll('.view-details-btn').forEach(button => {
                    button.removeEventListener('click', handleDetailsClick); 
                    button.addEventListener('click', handleDetailsClick);
                });

                document.querySelectorAll('.status-select').forEach(select => {
                    select.removeEventListener('change', handleStatusChange);
                    select.addEventListener('change', handleStatusChange);
                });
            } else if (state.currentView === 'details') {
                const backButton = document.getElementById('backButton');
                if (backButton) {
                    backButton.removeEventListener('click', switchToHome);
                    backButton.addEventListener('click', switchToHome);
                }
            }
        }
        
        function handleDetailsClick(e) {
            const orderId = e.currentTarget.getAttribute('data-order-id');
            switchToDetails(orderId);
        }

        function handleStatusChange(e) {
            const orderId = e.target.getAttribute('data-order-id');
            const newStatus = e.target.value;
            updateOrderStatus(orderId, newStatus); 
        }

        // --- INITIALIZATION ---
        window.onload = function() {
            updateDashboardContent();
            document.getElementById('details-view-container').classList.add('hidden');
        };