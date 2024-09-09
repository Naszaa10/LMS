<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar with Profile and Sidebar Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    include '../navbar/navSiswa.php';
    ?>

        <div id="mainContent" class="maincontent">
        <section class="mt-4">
            <h2>Announcements</h2>
            <div class="d-flex justify-content-between align-items-center">
                <p class="add-topic">Tambah pengumuman</p>
                <div>
                    <button type="button" class="btn btn-tambah custom-btn me-2">Tambah</button>
                    <button type="button" class="btn btn-hapus custom-btn">Hapus</button>
                </div>
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    Announcement 1
                </li>
                <li class="list-group-item">
                    Announcement 2
                </li>
                <!-- Repeat for additional announcements -->
            </ul>
        </section>
    </div>

    <?php
    include 'navbar/navFooter.php';
    ?>
</body>
</html>
