<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

// Ambil data dari form
$nama_topik = $_POST['nama_topik'];
$kode_mapel = $_POST['kode_mapel'];
$id_kelas = $_POST['id_kelas'];

// Query untuk menambahkan topik
$sql = "INSERT INTO topik (nama_topik, kode_mapel, id_kelas) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $nama_topik, $kode_mapel, $id_kelas);

if ($stmt->execute()) {
    // Redirect kembali ke halaman detail_mapel.php
    header("Location: detail_mapel.php?kode_mapel=$kode_mapel&kelas_id=$id_kelas");
    exit();
} else {
    echo "Gagal menambahkan topik: " . $conn->error;
}

// Tutup koneksi database
$stmt->close();
$conn->close();
?>
