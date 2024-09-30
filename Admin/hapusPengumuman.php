<?php
include '../db.php'; // Menghubungkan ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Menghapus pengumuman dari database
    $query = "DELETE FROM pengumuman WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        echo "Pengumuman berhasil dihapus.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn); // Menutup koneksi database

// Redirect kembali ke daftar pengumuman
header("Location: lihatPengumuman.php");
exit();
