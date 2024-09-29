<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengumuman</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="..\css\jadwal.css">
</head>
<body>

<?php include '../navbar/navAdmin.php'; ?>
<div class="container mt-4">
    <h2>Daftar Pengumuman</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Isi</th>
                <th>Kepada</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../db.php'; // Menghubungkan ke database

            // Mengambil data pengumuman dari database
            $query = "SELECT id, judul_pengumuman, isi_pengumuman, role, tanggal FROM pengumuman ORDER BY tanggal DESC";
            $result = mysqli_query($conn, $query);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['judul_pengumuman']}</td>
                        <td>{$row['isi_pengumuman']}</td>
                        <td>{$row['role']}</td>
                        <td>{$row['tanggal']}</td>
                        <td>
                            <a href='editPengumuman.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <form action='hapusPengumuman.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <button type='submit' class='btn btn-danger btn-sm'>Hapus</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Tidak ada pengumuman ditemukan.</td></tr>";
            }

            mysqli_close($conn); // Menutup koneksi database
            ?>
        </tbody>
    </table>
</div>

<?php include '../navbar/navFooter.php'; ?>
</body>
</html>
