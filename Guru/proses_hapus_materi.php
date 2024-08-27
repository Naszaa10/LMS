<?php
session_start();
include '../db.php';

$materi_id = $_GET['materi_id'] ?? '';
$topik_id = $_GET['topik_id'] ?? '';

// Hapus materi
$sqlMateri = "DELETE FROM materi WHERE id = ?";
$stmtMateri = $conn->prepare($sqlMateri);
$stmtMateri->bind_param("i", $materi_id);
$stmtMateri->execute();

// Redirect kembali ke halaman materi
header("Location: materi_tugas.php?topik_id=$topik_id");
exit();
?>
