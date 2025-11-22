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


        document.addEventListener('DOMContentLoaded', function() {
  var searchInput = document.getElementById('supplier-search');
  if (searchInput) {
    searchInput.addEventListener('input', function() {
      var filter = searchInput.value.toLowerCase();
      var rows = document.querySelectorAll('.suppliers-table tbody tr');
      rows.forEach(function(row) {
        var text = row.textContent.toLowerCase();
        row.style.display = text.indexOf(filter) > -1 ? '' : 'none';
      });
    });
  }

  var form = document.querySelector('.supplier-form');
  if (form) {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      alert('Supplier has been saved (form submission is simulated).');
      form.reset();
      document.getElementById('tab-directory').checked = true;
    });
  }
});

// Select all tab labels
const tabLabels = document.querySelectorAll(".tab-nav .tab-label");

// Loop through each label
tabLabels.forEach(label => {
    label.addEventListener("click", () => {
        // Remove active class from all labels
        tabLabels.forEach(l => l.classList.remove("active"));

        // Add active class to the clicked one
        label.classList.add("active");
    });
});
