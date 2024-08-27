<?php
session_start();
include '../db.php';

$topik_id = $_GET['topik_id'] ?? '';
$kode_mapel = $_GET['kode_mapel'] ?? '';
$kelas_id = $_GET['kelas_id'] ?? '';

// Hapus materi dan tugas yang terkait dengan topik ini
$sqlMateri = "DELETE FROM materi WHERE topik_id = ?";
$stmtMateri = $conn->prepare($sqlMateri);
$stmtMateri->bind_param("i", $topik_id);
$stmtMateri->execute();

$sqlTugas = "DELETE FROM tugas WHERE topik_id = ?";
$stmtTugas = $conn->prepare($sqlTugas);
$stmtTugas->bind_param("i", $topik_id);
$stmtTugas->execute();

// Hapus topik
$sqlTopik = "DELETE FROM topik WHERE id = ? AND kode_mapel = ? AND kelas_id = ?";
$stmtTopik = $conn->prepare($sqlTopik);
$stmtTopik->bind_param("isi", $topik_id, $kode_mapel, $kelas_id);
$stmtTopik->execute();

// Redirect ke halaman detail mata pelajaran
header("Location: detail_mapel.php?kode_mapel=$kode_mapel&kelas_id=$kelas_id");
exit();
?>
