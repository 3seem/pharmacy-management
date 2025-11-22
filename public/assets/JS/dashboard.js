

// Dynamic Sales Data (Mock Data)
const salesData = {
    daily: {
        value: "$2,845.50",
        change: "12.5% vs last period",
        isPositive: true
    },
    weekly: {
        value: "$18,930.25",
        change: "2.1% vs last period",
        isPositive: false
    },
    monthly: {
        value: "$75,120.99",
        change: "5.8% vs last period",
        isPositive: true
    }
};
//----------------- JavaScript Logic for Button Interaction----------------


const salesValueEl = document.getElementById('salesValue');
const growthIndicatorEl = document.getElementById('growthIndicator');
const timeButtons = document.querySelectorAll('.time-btn');

/**
 * Generates the SVG for the growth indicator arrow.
 * @param {boolean} isPositive - true for up arrow, false for down arrow.
 * @returns {string} The SVG HTML string.
 */
function getArrowSVG(isPositive) {
    // Up Arrow SVG
    const upSVG = `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="12 17 12 3"></polyline>
                    <path d="M18 9L12 3L6 9"></path>
                </svg>`;
    // Down Arrow SVG
    const downSVG = `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="12 7 12 21"></polyline>
                    <path d="M6 15L12 21L18 15"></path>
                </svg>`;

    return isPositive ? upSVG : downSVG;
}

/**
 * Updates the sales metric card based on the selected time period.
 * @param {string} period - 'daily', 'weekly', or 'monthly'.
 */
function updateSales(period) {
    const data = salesData[period];

    // 1. Update Sales Value
    salesValueEl.textContent = data.value;

    // 2. Update Growth Indicator Text and Color
    growthIndicatorEl.innerHTML = getArrowSVG(data.isPositive) + data.change;
    growthIndicatorEl.style.color = data.isPositive ? 'var(--text-green)' : 'var(--primary-red)';

    // 3. Update Active Button State
    timeButtons.forEach(btn => {
        btn.classList.remove('active');
        if (btn.getAttribute('data-period') === period) {
            btn.classList.add('active');
        }
    });
}

// Initial setup to ensure the dynamic elements are styled correctly on load
document.addEventListener('DOMContentLoaded', () => {
    // Re-run updateSales for the default 'daily' setting to ensure correct initial styling
    updateSales('daily');
});

// ---------- Alerts----------
function filterAlerts(filterType, clickedButton) {
    const alertsList = document.getElementById('alertsList');
    const alertItems = alertsList.querySelectorAll('.alert-item');
    const noResultsMessage = document.getElementById('noResults');
    let visibleCount = 0;

    // 1. Update active button state
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    clickedButton.classList.add('active');

    // 2. Iterate and toggle visibility
    alertItems.forEach(item => {
        const itemType = item.getAttribute('data-type');

        if (filterType === 'all' || itemType === filterType) {
            item.classList.remove('hidden');
            visibleCount++;
        } else {
            item.classList.add('hidden');
        }
    });

    // 3. Show/hide no results message
    if (visibleCount === 0) {
        noResultsMessage.classList.remove('hidden');
    } else {
        noResultsMessage.classList.add('hidden');
    }

    // 4. Update the displayed count (only for the 'All' filter for simplicity, 
    // but can be extended to show filtered count if needed)
    document.getElementById('alertCount').textContent = visibleCount;
}

// Initialize the app on load to show the correct total count (6 alerts initially)
document.addEventListener('DOMContentLoaded', () => {
    // Set initial count based on static content
    const initialCount = document.querySelectorAll('.alert-item').length;
    document.getElementById('alertCount').textContent = initialCount;
});

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
