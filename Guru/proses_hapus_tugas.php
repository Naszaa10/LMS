<?php
session_start();
include '../db.php';

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
