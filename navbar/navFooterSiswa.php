<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const wrapper = document.getElementById('wrapper');

    sidebarToggle.addEventListener('click', function() {
        wrapper.classList.toggle('toggled');
    });
});

</script>

<script>

document.addEventListener("DOMContentLoaded", function () {
    const currentPage = window.location.pathname; // Get the current page's path
    const sidebarLinks = document.querySelectorAll('.sidebar-item'); // Select all sidebar items

    sidebarLinks.forEach(link => {
        // Check if the href attribute of the link matches the current page path
        if (currentPage.includes(link.getAttribute('href'))) {
            link.classList.add('active'); // Add the 'active' class to the current link
        } else {
            link.classList.remove('active'); // Remove 'active' class from other links
        }
    });
});

</script>



