<?php
session_start();
include '../db.php';

$topik_id = $_POST['topik_id'] ?? '';
$kode_mapel = $_POST['kode_mapel'] ?? '';
$kelas_id = $_POST['kelas_id'] ?? '';
$judul_materi = $_POST['judul_materi'] ?? '';
$keterangan_materi = $_POST['keterangan_materi'] ?? '';

$file_materi = $_FILES['file_materi'] ?? null;
$file_path = '';

if ($file_materi && $file_materi['error'] === UPLOAD_ERR_OK) {
    $file_path = 'uploads/' . basename($file_materi['name']);
    move_uploaded_file($file_materi['tmp_name'], $file_path);
}

$sqlMateri = "INSERT INTO materi (topik_id, judul, keterangan, file_path) VALUES (?, ?, ?, ?)";
$stmtMateri = $conn->prepare($sqlMateri);
$stmtMateri->bind_param("isss", $topik_id, $judul_materi, $keterangan_materi, $file_path);
$stmtMateri->execute();

header("Location: materi_tugas.php?topik_id=$topik_id&kode_mapel=$kode_mapel&kelas_id=$kelas_id");
exit();
?>
