<?php
session_start();
include '../db.php'; // Menghubungkan ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data dari request
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $target = $_POST['target'];
    $tanggal = $_POST['tanggal'];

    // Menyimpan ke database
    $query = "INSERT INTO pengumuman (judul_pengumuman, isi_pengumuman, role, tanggal) VALUES ('$judul', '$isi', '$target', '$tanggal')";
    
    if (mysqli_query($conn, $query)) {
        echo "Pengumuman berhasil disimpan.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn); // Menutup koneksi database
?>
