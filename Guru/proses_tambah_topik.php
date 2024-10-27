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
$id_tahun_ajaran = $_POST['id_tahun_ajaran']; // Ambil id_tahun_ajaran dari form

// Query untuk menambahkan topik
$sql = "INSERT INTO topik (nama_topik, kode_mapel, id_kelas, id_tahun_ajaran) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii", $nama_topik, $kode_mapel, $id_kelas, $id_tahun_ajaran);

if ($stmt->execute()) {
    // Redirect kembali ke halaman detail_mapel.php
    header("Location: detail_mapel.php?kode_mapel=$kode_mapel&kelas_id=$id_kelas&tahun_ajaran=$id_tahun_ajaran");
    exit();
} else {
    echo "Gagal menambahkan topik: " . $conn->error;
}

// Tutup koneksi database
$stmt->close();
$conn->close();
?>
