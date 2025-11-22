// Initial data (mocked from the React code)
const initialMedicines = [
  { id: "1", name: "Paracetamol 500mg", category: "Pain Relief", unitPrice: 0.50,
    stockQuantity: 1500, minStockLevel: 500, expirationDate: "2026-12-31",
    supplier: "PharmaCorp", batchNumber: "PC2024-001", lastUpdated: new Date().toISOString()
  },
  { id: "2", name: "Amoxicillin 250mg", category: "Antibiotics", unitPrice: 2.75,
    stockQuantity: 250, minStockLevel: 300, expirationDate: "2025-06-30",
    supplier: "MediSupply Inc", batchNumber: "MS2024-089", lastUpdated: new Date().toISOString()
  },
  // ... (rest of initialMedicines data) ...
  { id: "8", name: "Cetirizine 10mg", category: "Antihistamines", unitPrice: 0.60,
    stockQuantity: 650, minStockLevel: 300, expirationDate: "2026-04-30",
    supplier: "MediSupply Inc", batchNumber: "MS2024-091", lastUpdated: new Date().toISOString()
  }
];

// State variables
let medicines = [...initialMedicines];
let filteredMedicines = [...medicines];

// Currently selected item for editing/deleting/adjusting
let currentEditId = null;
let currentDeleteId = null;
let currentAdjustId = null;
let adjustType = "add"; // "add" or "subtract"

// References to DOM elements
const tableBody = document.getElementById("tableBody");
const countText = document.getElementById("countText");
const searchInput = document.getElementById("searchInput");
const filterCategory = document.getElementById("filterCategory");
const filterSupplier = document.getElementById("filterSupplier");
const filterStock = document.getElementById("filterStock");
const filterExpiration = document.getElementById("filterExpiration");

// Modals
const addModal = document.getElementById("addModal");
const editModal = document.getElementById("editModal");
const deleteModal = document.getElementById("deleteModal");
const adjustModal = document.getElementById("adjustModal");

// Forms and inputs
const addForm = document.getElementById("addForm");
const editForm = document.getElementById("editForm");
const adjustForm = document.getElementById("adjustForm");

// Populate category and supplier filter options
function populateFilters() {
  const categories = Array.from(new Set(medicines.map(m => m.category)));
  const suppliers = Array.from(new Set(medicines.map(m => m.supplier)));
  filterCategory.innerHTML = '<option value="all">All Categories</option>' +
    categories.map(cat => `<option value="${cat}">${cat}</option>`).join('');
  filterSupplier.innerHTML = '<option value="all">All Suppliers</option>' +
    suppliers.map(sup => `<option value="${sup}">${sup}</option>`).join('');
  // Also populate the add-medicine form selects
  document.getElementById("add-category").innerHTML =
    '<option value="">Select category</option>' +
    categories.map(cat => `<option value="${cat}">${cat}</option>`).join('');
  document.getElementById("add-supplier").innerHTML =
    '<option value="">Select supplier</option>' +
    suppliers.map(sup => `<option value="${sup}">${sup}</option>`).join('');
}

// Call initially
populateFilters();

// Helper: format currency
function formatCurrency(amount) {
  return new Intl.NumberFormat("en-US", {style: "currency", currency: "USD"})
    .format(amount);
}
// Helper: format date to "MMM DD, YYYY"
function formatDate(dateString) {
  const date = new Date(dateString);
  return date.toLocaleDateString("en-US", { year: "numeric", month: "short", day: "numeric" });
}

// Determine stock status label and style
function getStockStatus(medicine) {
  if (medicine.stockQuantity === 0) {
    return { label: "Out of Stock", class: "badge-destructive" };
  }
  if (medicine.stockQuantity < medicine.minStockLevel) {
    return { label: "Low Stock", class: "badge-secondary" };
  }
  return { label: "In Stock", class: "badge-default" };
}

// Determine expiration status label and style
function getExpirationStatus(dateStr) {
  const today = new Date();
  const expiry = new Date(dateStr);
  const diffDays = Math.floor((expiry - today) / (1000*60*60*24));
  if (diffDays < 0) {
    return { label: "Expired", class: "badge-destructive" };
  }
  if (diffDays <= 90) {
    return { label: `Expires in ${diffDays}d`, class: "badge-secondary" };
  }
  return null;
}

// Render the medicines table based on filteredMedicines
function renderTable() {
  tableBody.innerHTML = "";
  if (filteredMedicines.length === 0) {
    const noDataRow = document.createElement("tr");
    noDataRow.innerHTML = `
      <td colspan="9" class="text-center py-8 text-gray-500">
        No medicines found matching your filters
      </td>`;
    tableBody.appendChild(noDataRow);
  } else {
    filteredMedicines.forEach(med => {
      const row = document.createElement("tr");
      // Status badges
      const stockStatus = getStockStatus(med);
      const expStatus = getExpirationStatus(med.expirationDate);
      row.innerHTML = `
        <td class="border px-4 py-2">
          <div>${med.name}</div>
          ${expStatus ? `<span class="badge ${expStatus.class} mt-1">${expStatus.label}</span>` : ''}
        </td>
        <td class="border px-4 py-2">${med.category}</td>
        <td class="border px-4 py-2 text-sm text-gray-600">${med.batchNumber}</td>
        <td class="border px-4 py-2">${med.supplier}</td>
        <td class="border px-4 py-2">${formatCurrency(med.unitPrice)}</td>
        <td class="border px-4 py-2">
          <div>${med.stockQuantity}</div>
          <div class="text-xs text-gray-500">Min: ${med.minStockLevel}</div>
        </td>
        <td class="border px-4 py-2">
          <span class="badge ${stockStatus.class}">${stockStatus.label}</span>
        </td>
        <td class="border px-4 py-2">${formatDate(med.expirationDate)}</td>
        <td class="border px-4 py-2 text-right space-x-2">
          <button class="px-2 py-1 bg-green-100 rounded text-green-700 action-adjust" data-id="${med.id}" title="Adjust Stock">
            🏷+ 
          </button>
          <button class="px-2 py-1 bg-blue-100 rounded text-blue-700 action-edit" data-id="${med.id}" title="Edit Medicine">
            ✏️
          </button>
          <button class="px-2 py-1 bg-red-100 rounded text-red-700 action-delete" data-id="${med.id}" title="Delete Medicine">
            🗑️
          </button>
        </td>`;
      tableBody.appendChild(row);
    });
  }
  // Update count text
  countText.textContent = `Showing ${filteredMedicines.length} of ${medicines.length} medicines`;
}

// Apply all filters and search
function applyFilters() {
  const query = searchInput.value.trim().toLowerCase();
  const categoryVal = filterCategory.value;
  const supplierVal = filterSupplier.value;
  const stockVal = filterStock.value;
  const expVal = filterExpiration.value;

  filteredMedicines = medicines.filter(med => {
    // Search by name or batch number
    if (query) {
      const inName = med.name.toLowerCase().includes(query);
      const inBatch = med.batchNumber.toLowerCase().includes(query);
      if (!inName && !inBatch) return false;
    }
    // Category filter
    if (categoryVal !== "all" && med.category !== categoryVal) return false;
    // Supplier filter
    if (supplierVal !== "all" && med.supplier !== supplierVal) return false;
    // Stock filter
    if (stockVal === "low" && med.stockQuantity >= med.minStockLevel) return false;
    if (stockVal === "out" && med.stockQuantity > 0) return false;
    // Expiration filter
    if (expVal === "expired" || expVal === "soon") {
      const diffDays = Math.floor((new Date(med.expirationDate) - new Date())/(1000*60*60*24));
      if (expVal === "expired" && diffDays >= 0) return false;
      if (expVal === "soon" && (diffDays < 0 || diffDays > 90)) return false;
    }
    return true;
  });
  renderTable();
}

// Event listeners for filtering
searchInput.addEventListener("input", applyFilters);
filterCategory.addEventListener("change", applyFilters);
filterSupplier.addEventListener("change", applyFilters);
filterStock.addEventListener("change", applyFilters);
filterExpiration.addEventListener("change", applyFilters);

// Add Medicine Modal
document.getElementById("btnAdd").addEventListener("click", () => {
  document.getElementById("addForm").reset();
  showModal("addModal");
});

addForm.addEventListener("submit", function(e) {
  e.preventDefault();
  // Gather form data
  const newMed = {
    id: Date.now().toString(),
    name: document.getElementById("add-name").value.trim(),
    category: document.getElementById("add-category").value,
    supplier: document.getElementById("add-supplier").value,
    unitPrice: parseFloat(document.getElementById("add-unitPrice").value),
    batchNumber: document.getElementById("add-batchNumber").value.trim(),
    stockQuantity: parseInt(document.getElementById("add-stockQuantity").value),
    minStockLevel: parseInt(document.getElementById("add-minStockLevel").value),
    expirationDate: document.getElementById("add-expirationDate").value,
    lastUpdated: new Date().toISOString()
  };
  medicines.push(newMed);
  populateFilters();
  applyFilters();
  closeModal("addModal");
});

// Edit Medicine
tableBody.addEventListener("click", function(e) {
  if (e.target.classList.contains("action-edit")) {
    const id = e.target.getAttribute("data-id");
    const med = medicines.find(m => m.id === id);
    if (!med) return;
    currentEditId = id;
    // Populate edit form fields
    document.getElementById("edit-name").value = med.name;
    document.getElementById("edit-category").value = med.category;
    document.getElementById("edit-supplier").value = med.supplier;
    document.getElementById("edit-unitPrice").value = med.unitPrice;
    document.getElementById("edit-batchNumber").value = med.batchNumber;
    document.getElementById("edit-stockQuantity").value = med.stockQuantity;
    document.getElementById("edit-minStockLevel").value = med.minStockLevel;
    document.getElementById("edit-expirationDate").value = med.expirationDate;
    showModal("editModal");
  }
});
editForm.addEventListener("submit", function(e) {
  e.preventDefault();
  // Find and update medicine
  const med = medicines.find(m => m.id === currentEditId);
  if (!med) return;
  med.name = document.getElementById("edit-name").value.trim();
  med.category = document.getElementById("edit-category").value.trim();
  med.supplier = document.getElementById("edit-supplier").value.trim();
  med.unitPrice = parseFloat(document.getElementById("edit-unitPrice").value);
  med.batchNumber = document.getElementById("edit-batchNumber").value.trim();
  med.stockQuantity = parseInt(document.getElementById("edit-stockQuantity").value);
  med.minStockLevel = parseInt(document.getElementById("edit-minStockLevel").value);
  med.expirationDate = document.getElementById("edit-expirationDate").value;
  med.lastUpdated = new Date().toISOString();
  applyFilters();
  closeModal("editModal");
});

// Delete Medicine
tableBody.addEventListener("click", function(e) {
  if (e.target.classList.contains("action-delete")) {
    const id = e.target.getAttribute("data-id");
    const med = medicines.find(m => m.id === id);
    if (!med) return;
    currentDeleteId = id;
    document.getElementById("deleteName").textContent = med.name;
    showModal("deleteModal");
  }
});
document.getElementById("confirmDeleteBtn").addEventListener("click", function() {
  medicines = medicines.filter(m => m.id !== currentDeleteId);
  populateFilters();
  applyFilters();
  closeModal("deleteModal");
});

// Stock Adjustment
tableBody.addEventListener("click", function(e) {
  if (e.target.classList.contains("action-adjust")) {
    const id = e.target.getAttribute("data-id");
    const med = medicines.find(m => m.id === id);
    if (!med) return;
    currentAdjustId = id;
    adjustType = "add"; // default
    // Setup dialog initial values
    document.getElementById("adjustQuantity").value = "";
    document.getElementById("currentStock").textContent = med.stockQuantity + " units";
    document.getElementById("adjustName").textContent = med.name;
    // Highlight 'Add Stock' by default
    document.getElementById("btnAddStock").classList.add("active-button");
    document.getElementById("btnRemoveStock").classList.remove("active-button");
    // Set up reason options
    const reasonSelect = document.getElementById("reasonType");
    reasonSelect.innerHTML = '<option value="">Select reason</option>' +
      [
        "Supplier Order Received",
        "Stock Return",
        "Physical Count Correction",
        "Transfer from Another Location",
        "Other"
      ].map(opt => `<option value="${opt}">${opt}</option>`).join('');
    document.getElementById("otherReasonDiv").style.display = "none";
    document.getElementById("newStockPreview").style.display = "none";
    showModal("adjustModal");
  }
});

// Adjustment type buttons
document.getElementById("btnAddStock").addEventListener("click", () => {
  adjustType = "add";
  document.getElementById("btnAddStock").classList.add("active-button");
  document.getElementById("btnRemoveStock").classList.remove("active-button");
  updateNewStockPreview();
});
document.getElementById("btnRemoveStock").addEventListener("click", () => {
  adjustType = "subtract";
  document.getElementById("btnRemoveStock").classList.add("active-button");
  document.getElementById("btnAddStock").classList.remove("active-button");
  updateNewStockPreview();
});

// Show/hide additional notes if 'Other' is selected
document.getElementById("reasonType").addEventListener("change", function() {
  if (this.value === "Other") {
    document.getElementById("otherReasonDiv").style.display = "block";
  } else {
    document.getElementById("otherReasonDiv").style.display = "none";
  }
});

// Update stock preview when quantity changes
document.getElementById("adjustQuantity").addEventListener("input", updateNewStockPreview);

function updateNewStockPreview() {
  const med = medicines.find(m => m.id === currentAdjustId);
  if (!med) return;
  const qty = parseInt(document.getElementById("adjustQuantity").value) || 0;
  let newQty = adjustType === "add" ? med.stockQuantity + qty : med.stockQuantity - qty;
  document.getElementById("newStockLevel").textContent = Math.max(newQty, 0) + " units";
  document.getElementById("newStockPreview").style.display = qty ? "block" : "none";
  document.getElementById("belowZeroNote").style.display = (newQty < 0) ? "block" : "none";
}

// Handle adjust form submit
adjustForm.addEventListener("submit", function(e) {
  e.preventDefault();
  const med = medicines.find(m => m.id === currentAdjustId);
  if (!med) return;
  const qty = parseInt(document.getElementById("adjustQuantity").value);
  const reasonType = document.getElementById("reasonType").value;
  const otherReason = document.getElementById("otherReason").value.trim();
  const fullReason = (reasonType === "Other" ? otherReason : reasonType);
  const adjustment = (adjustType === "add" ? qty : -qty);
  med.stockQuantity = Math.max(0, med.stockQuantity + adjustment);
  med.lastUpdated = new Date().toISOString();
  // (Here you might log or process the reason)
  applyFilters();
  closeModal("adjustModal");
});

// Helper to show/hide modals
function showModal(id) {
  document.getElementById(id).classList.add("show");
}
function closeModal(id) {
  document.getElementById(id).classList.remove("show");
}

// Initial render
applyFilters();

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