
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebarMenu');
        
        // Add the 'show' class to the sidebar to display it immediately
        sidebar.classList.add('show');
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        // Toggle Sidebar
        document.getElementById("menu-toggle").addEventListener("click", function () {
            document.getElementById("wrapper").classList.toggle("toggled");
        });
    </script>


