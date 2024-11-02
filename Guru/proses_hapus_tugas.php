<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

$tugas_id = $_GET['tugas_id'] ?? '';
$topik_id = $_GET['topik_id'] ?? '';

// Hapus tugas
$sqlTugas = "DELETE FROM tugas WHERE id = ?";
$stmtTugas = $conn->prepare($sqlTugas);
$stmtTugas->bind_param("i", $tugas_id);
$stmtTugas->execute();

// Redirect kembali ke halaman materi
header("Location: materi_tugas.php?topik_id=$topik_id");
exit();
?>
