<?php
include '../db.php'; // Menghubungkan ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $target = $_POST['target'];

    // Memperbarui pengumuman di database
    $query = "UPDATE pengumuman SET judul_pengumuman = '$judul', isi_pengumuman = '$isi', role = '$target' WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        echo "Pengumuman berhasil diperbarui.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn); // Menutup koneksi database

// Redirect kembali ke daftar pengumuman
header("Location: lihatPengumuman.php");
exit();
