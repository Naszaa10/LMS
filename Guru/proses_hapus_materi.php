<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

// Dapatkan ID materi dan parameter lainnya dari URL
$materi_id = $_GET['materi_id'];
$topik_id = $_GET['topik_id'];
$kode_mapel = $_GET['kode_mapel'];
$id_kelas = $_GET['id_kelas'];

// Ambil data materi untuk mendapatkan nama file
$sql = "SELECT file FROM materi WHERE id_materi = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $materi_id);
$stmt->execute();
$result = $stmt->get_result();
$materi = $result->fetch_assoc();

// Hapus file fisik dari server
$file_path = $materi['file'];
if (file_exists($file_path)) {
    unlink($file_path); // Menghapus file dari direktori
}

// Hapus data materi dari database
$sql = "DELETE FROM materi WHERE id_materi = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $materi_id);

if ($stmt->execute()) {
    echo "<script>alert('Materi berhasil dihapus!'); window.location.href='cek_materi.php?topik_id=$topik_id&kode_mapel=$kode_mapel&id_kelas=$id_kelas';</script>";
} else {
    echo "<script>alert('Gagal menghapus materi!');</script>";
}
?>
