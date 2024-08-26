<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar with Profile and Sidebar Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
    include '../navbar/navSiswa.php';
    ?>

    
<div id="mainContent" class="container">
            <h2 class="mb-4">Jadwal Pelajaran</h2>
            <p>Kelas 12 IPA 6</p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <th>Hari</th>
                        <th>jam</th>
                        <th>Guru</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <!-- Data Jadwal Mengajar -->
                    <tr>
                        <td>Matematika</td>
                        <td>Senin</td>
                        <td>08:00 - 09:30</td>
                        <td>Budi</td>
                    </tr>
                    <tr>
                        <td>Fisika</td>
                        <td>Rabu</td>
                        <td>10:00 - 11:30</td>
                        <td>Cici</td>
                    </tr>
                    <tr>
                        <td>Bahasa Indonesia</td>
                        <td>Jumat</td>
                        <td>09:00 - 10:30</td>
                        <td>Nina</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php
include '../navbar/navFooter.php';
?>
</body>
</html>
