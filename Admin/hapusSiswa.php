<?php
include '../db.php';

// Mengecek apakah parameter 'nis' ada di URL
if (isset($_GET['nis'])) {
    $nis = $_GET['nis'];

    // Query untuk menghapus data siswa berdasarkan NIS
    $delete_query = "DELETE FROM siswa WHERE nis = '$nis'";

    // Mengeksekusi query
    if ($conn->query($delete_query)) {
        header('Location: dataSiswa.php'); // Kembali ke halaman data siswa setelah menghapus
    } else {
        echo "Gagal menghapus data siswa.";
    }
} else {
    echo "NIS tidak ditemukan.";
}

$conn->close();
?>
