<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');

            sidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('show'); // Toggle sidebar visibility
            });
        });
    </script>