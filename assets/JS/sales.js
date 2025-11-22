
const products = [
  { id: '1', name: 'Paracetamol', barcode: '1234567890123', price: 3.99, stock: 150, category: 'Painkiller' },
  { id: '2', name: 'Ibuprofen', barcode: '2345678901234', price: 4.49, stock: 80, category: 'Painkiller' },
  { id: '3', name: 'Salbutamol', barcode: '3456789012345', price: 2.99, stock: 120, category: 'Respiratory' },
  { id: '4', name: 'Atorvastatin', barcode: '4567890123456', price: 5.99, stock: 90, category: 'Cholesterol' },
  { id: '5', name: 'Metformin', barcode: '5678901234567', price: 12.99, stock: 45, category: 'Diabetes' },
  { id: '6', name: 'Cetirizine', barcode: '6789012345678', price: 6.49, stock: 60, category: 'Antihistamine' },
  { id: '7', name: 'Omeprazole', barcode: '7890123456789', price: 2.49, stock: 200, category: 'Stomach' },
  { id: '8', name: 'Azithromycin', barcode: '8901234567890', price: 3.29, stock: 110, category: 'Antibiotic' },
  { id: '9', name: 'Aspirin', barcode: '9012345678901', price: 11.99, stock: 35, category: 'Painkiller' },
  { id: '10', name: 'Ferrotron', barcode: '0123456789012', price: 7.99, stock: 50, category: 'Supplements' }
];

// Application state
let cartItems = [];
let transactions = [];
let lastTransaction = null;

// Helper: find element by ID
const $ = (id) => document.getElementById(id);

// Initialize tab buttons
$('pos-tab').addEventListener('click', () => showTab('pos'));
$('refund-tab').addEventListener('click', () => showTab('refund'));

// Show POS or Refund section
function showTab(tab) {
  if (tab === 'pos') {
    $('pos-section').classList.add('active');
    $('refund-section').classList.remove('active');
    $('pos-tab').classList.add('active');
    $('refund-tab').classList.remove('active');
  } else {
    $('refund-section').classList.add('active');
    $('pos-section').classList.remove('active');
    $('refund-tab').classList.add('active');
    $('pos-tab').classList.remove('active');
  }
}

// Populate quick products buttons (first 8 products)
function loadQuickProducts() {
  const quickDiv = $('quick-products');
  products.slice(0, 8).forEach(product => {
    const btn = document.createElement('button');
    btn.textContent = `${product.name} ($${product.price.toFixed(2)})`;
    btn.addEventListener('click', () => addToCart(product));
    quickDiv.appendChild(btn);
  });
}

// Search products as the user types
$('product-search-input').addEventListener('input', (e) => {
  const term = e.target.value.trim().toLowerCase();
  const resultsDiv = $('product-search-results');
  resultsDiv.innerHTML = '';
  if (!term) return;
  const matches = products.filter(p =>
    p.name.toLowerCase().includes(term) || p.barcode.includes(term)
  );
  matches.forEach(product => {
    const item = document.createElement('div');
    item.className = 'search-item';
    item.textContent = `${product.name} – $${product.price.toFixed(2)} (Stock: ${product.stock})`;
    item.addEventListener('click', () => {
      addToCart(product);
      $('product-search-input').value = '';
      resultsDiv.innerHTML = '';
    });
    resultsDiv.appendChild(item);
  });
});

// Add a product to the cart (or increment quantity)
function addToCart(product) {
  const existing = cartItems.find(item => item.id === product.id);
  if (existing) {
    if (existing.quantity < product.stock) {
      existing.quantity++;
    } else {
      alert('Insufficient stock!');
      return;
    }
  } else {
    cartItems.push({ ...product, quantity: 1 });
  }
  updateCartUI();
}

// Update cart display and totals
function updateCartUI() {
  const cartDiv = $('cart-items');
  cartDiv.innerHTML = '';
  if (cartItems.length === 0) {
    cartDiv.innerHTML = '<p class="empty-cart">Cart is empty</p>';
  } else {
    cartItems.forEach((item, index) => {
      const div = document.createElement('div');
      div.className = 'cart-item';
      div.innerHTML = `
        <h3>${item.name}</h3>
        <div class="item-controls">
          <button onclick="changeQty(${index}, -1)">-</button>
          <input type="number" value="${item.quantity}" min="1" max="${item.stock}" onchange="setQty(${index}, this.value)" />
          <button onclick="changeQty(${index}, 1)">+</button>
          <button onclick="removeFromCart(${index})" class="btn-outline">Remove</button>
          <span style="margin-left:auto; font-weight:bold;">$${(item.price * item.quantity).toFixed(2)}</span>
        </div>
      `;
      cartDiv.appendChild(div);
    });
  }

  // Update counts and totals
  $('cart-count').textContent = cartItems.reduce((sum, i) => sum + i.quantity, 0);
  const subtotal = cartItems.reduce((sum, i) => sum + i.price * i.quantity, 0);
  const tax = parseFloat((subtotal * 0.08).toFixed(2));
  const total = parseFloat((subtotal + tax).toFixed(2));
  $('subtotal').textContent = subtotal.toFixed(2);
  $('tax').textContent = tax.toFixed(2);
  $('total').textContent = total.toFixed(2);

  // Enable/disable buttons
  $('checkout-button').disabled = cartItems.length === 0;
  $('clear-button').disabled = cartItems.length === 0;
}

// Change quantity of a cart item
function changeQty(index, delta) {
  const item = cartItems[index];
  item.quantity = Math.max(1, Math.min(item.stock, item.quantity + delta));
  updateCartUI();
}

// Set quantity directly
function setQty(index, value) {
  const qty = parseInt(value, 10) || 1;
  const item = cartItems[index];
  item.quantity = Math.min(item.stock, Math.max(1, qty));
  updateCartUI();
}

// Remove an item from the cart
function removeFromCart(index) {
  cartItems.splice(index, 1);
  updateCartUI();
}

// Clear the cart
$('clear-button').addEventListener('click', () => {
  if (confirm('Are you sure you want to clear the cart?')) {
    cartItems = [];
    updateCartUI();
  }
});

// Checkout: create a transaction and show invoice
$('checkout-button').addEventListener('click', () => {
  if (cartItems.length === 0) {
    alert('Cart is empty!');
    return;
  }
  // Build transaction object
  const now = new Date();
  const transaction = {
    id: `TXN-${Date.now()}`,
    date: now.toLocaleDateString(),
    time: now.toLocaleTimeString(),
    items: [...cartItems],
    subtotal: parseFloat($('subtotal').textContent),
    tax: parseFloat($('tax').textContent),
    total: parseFloat($('total').textContent),
    cashier: 'John Doe',
    paymentMethod: $('payment-method').value,
    status: 'completed'
  };
  transactions.unshift(transaction);
  lastTransaction = transaction;
  showInvoice(transaction);
  cartItems = [];
  updateCartUI();
  updateRecentTransactions();
});

// Display the invoice modal with transaction details
function showInvoice(transaction) {
  const modal = $('invoice-modal');
  const content = $('invoice-content');
  modal.style.display = 'flex';
  content.innerHTML = `
    <p><strong>Invoice #:</strong> ${transaction.id}</p>
    <p><strong>Date:</strong> ${transaction.date} ${transaction.time}</p>
    <p><strong>Cashier:</strong> ${transaction.cashier}</p>
    <p><strong>Payment:</strong> ${transaction.paymentMethod}</p>
    <p><strong>Status:</strong> ${transaction.status}</p>
    <h3>Items Purchased:</h3>
    <table border="0" width="100%">
      <tr><th>Item</th><th>Price</th><th>Qty</th><th>Total</th></tr>
      ${transaction.items.map(item => `
        <tr>
          <td>${item.name}</td>
          <td style="text-align:right;">$${item.price.toFixed(2)}</td>
          <td style="text-align:right;">${item.quantity}</td>
          <td style="text-align:right;">$${(item.price * item.quantity).toFixed(2)}</td>
        </tr>`).join('')}
    </table>
    <p><strong>Subtotal:</strong> $${transaction.subtotal.toFixed(2)}</p>
    <p><strong>Tax (8%):</strong> $${transaction.tax.toFixed(2)}</p>
    <p><strong>Total:</strong> $${transaction.total.toFixed(2)}</p>
  `;
}

// Invoice modal actions
$('invoice-close').addEventListener('click', () => $('invoice-modal').style.display = 'none');
$('close-invoice').addEventListener('click', () => $('invoice-modal').style.display = 'none');
$('print-invoice').addEventListener('click', () => { window.print(); });
$('download-invoice').addEventListener('click', () => { alert('Invoice downloaded!'); });

/* === Refund Management === */

// Filter and display transactions as user types
$('refund-search-input').addEventListener('input', (e) => {
  const term = e.target.value.trim().toLowerCase();
  const resultsCard = $('refund-search-results-card');
  const resultsDiv = $('refund-search-results');
  resultsDiv.innerHTML = '';
  if (!term) {
    resultsCard.style.display = 'none';
    return;
  }
  resultsCard.style.display = 'block';
  const matches = transactions.filter(t =>
    t.id.toLowerCase().includes(term) || t.date.includes(term)
  );
  if (matches.length === 0) {
    resultsDiv.innerHTML = `<p class="empty-list">No transactions found.</p>`;
  } else {
    matches.forEach(t => {
      const itemDiv = document.createElement('div');
      itemDiv.className = 'transaction-item';
      itemDiv.innerHTML = `
        <div class="transaction-header">
          <div>
            <strong>${t.id}</strong><br>
            <small>${t.date} at ${t.time}</small>
          </div>
          <div>
            <span class="badge ${t.status}">${t.status}</span><br>
            <strong>$${t.total.toFixed(2)}</strong>
          </div>
        </div>
        <button onclick="selectTransaction('${t.id}')" ${t.status === 'refunded' ? 'disabled' : ''}>
          ${t.status === 'refunded' ? 'Already Refunded' : 'Process Refund'}
        </button>
      `;
      resultsDiv.appendChild(itemDiv);
    });
  }
});

// Update recent transactions list
function updateRecentTransactions() {
  const recentDiv = $('recent-transactions');
  recentDiv.innerHTML = '';
  if (transactions.length === 0) {
    recentDiv.innerHTML = '<p class="empty-list">No transactions yet</p>';
    return;
  }
  const list = document.createElement('div');
  transactions.slice(0,5).forEach(t => {
    const itemDiv = document.createElement('div');
    itemDiv.className = 'transaction-item';
    itemDiv.innerHTML = `
      <div class="transaction-header">
        <div>
          <strong>${t.id}</strong><br>
          <small>${t.date} at ${t.time}</small>
        </div>
        <div>
          <span class="badge ${t.status}">${t.status}</span><br>
          <strong>$${t.total.toFixed(2)}</strong>
        </div>
      </div>
    `;
    list.appendChild(itemDiv);
  });
  recentDiv.appendChild(list);
}

// When user clicks "Process Refund", populate refund dialog
function selectTransaction(id) {
  const transaction = transactions.find(t => t.id === id);
  if (!transaction) return;
  const contentDiv = $('refund-content');
  contentDiv.innerHTML = `
    <p><strong>Invoice #:</strong> ${transaction.id}</p>
    <p><strong>Date:</strong> ${transaction.date}</p>
    <h3>Select Items to Refund:</h3>
  `;
  transaction.items.forEach((item, index) => {
    const div = document.createElement('div');
    div.className = 'cart-item';
    div.innerHTML = `
      <label>
        <input type="checkbox" id="refund-item-${index}" />
        ${item.name} - $${item.price.toFixed(2)} x ${item.quantity} = $${(item.price*item.quantity).toFixed(2)}
      </label>
      <div id="refund-qty-${index}" style="display:none;">
        <label>Quantity to Refund: 
          <input type="number" min="1" max="${item.quantity}" value="${item.quantity}" id="qty-${index}" />
        </label>
      </div>
    `;
    contentDiv.appendChild(div);
    // Toggle quantity input when checkbox changes
    div.querySelector('input').addEventListener('change', (e) => {
      const qtyDiv = $('refund-qty-' + index);
      qtyDiv.style.display = e.target.checked ? 'block' : 'none';
    });
  });
  $('refund-modal').style.display = 'flex';

  // On confirm refund
  $('confirm-refund').onclick = () => {
    const toRefund = [];
    transaction.items.forEach((item, i) => {
      const checkbox = $(`refund-item-${i}`);
      if (checkbox.checked) {
        const qty = parseInt($(`qty-${i}`).value, 10) || 0;
        if (qty > 0) {
          toRefund.push({ ...item, quantity: qty });
        }
      }
    });
    if (toRefund.length === 0) {
      alert('Select at least one item.');
      return;
    }
    if (confirm('Process refund?')) {
      // Update transaction items and status
      toRefund.forEach(ref => {
        const original = transaction.items.find(x => x.id === ref.id);
        original.quantity -= ref.quantity;
      });
      // Remove items with 0 quantity
      transaction.items = transaction.items.filter(item => item.quantity > 0);
      transaction.status = transaction.items.length === 0 ? 'refunded' : 'partial-refund';
      alert('Refund processed.');
      $('refund-modal').style.display = 'none';
      updateRecentTransactions();
      $('refund-search-input').dispatchEvent(new Event('input'));
    }
  };
}

// Cancel refund
$('cancel-refund').addEventListener('click', () => {
  $('refund-modal').style.display = 'none';
});
$('refund-close').addEventListener('click', () => {
  $('refund-modal').style.display = 'none';
});

// Initialize
loadQuickProducts();
updateCartUI();
updateRecentTransactions();
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
