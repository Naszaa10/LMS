<?php
session_start();
include '../db.php';

$topik_id = $_POST['topik_id'] ?? '';
$kode_mapel = $_POST['kode_mapel'] ?? '';
$kelas_id = $_POST['kelas_id'] ?? '';
$judul_tugas = $_POST['judul_tugas'] ?? '';
$keterangan_tugas = $_POST['keterangan_tugas'] ?? '';
$opsi_tugas = $_POST['opsi_tugas'] ?? '';
$tanggal_tenggat = $_POST['tanggal_tenggat'] ?? '';

$sqlTugas = "INSERT INTO tugas (topik_id, judul, keterangan, opsi_tugas, tanggal_tenggat) VALUES (?, ?, ?, ?, ?)";
$stmtTugas = $conn->prepare($sqlTugas);
$stmtTugas->bind_param("sssss", $topik_id, $judul_tugas, $keterangan_tugas, $opsi_tugas, $tanggal_tenggat);
$stmtTugas->execute();

header("Location: materi_tugas.php?topik_id=$topik_id&kode_mapel=$kode_mapel&kelas_id=$kelas_id");
exit();
?>
