// siderbar.js

document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebarMenu');
    const sidebarBtn = document.getElementById('sidebarBtn');

    sidebarBtn.addEventListener('click', function () {
        sidebar.classList.toggle('show'); // Toggle visibility of sidebar
        // Tidak ada perubahan pada mainContent
    });
});
