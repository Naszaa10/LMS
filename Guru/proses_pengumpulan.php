<?php
session_start();
include '../db.php';

$topik_id = $_POST['topik_id'] ?? '';
$tugas_text = $_POST['tugas_text'] ?? '';
$tugas_file = $_FILES['tugas_file'] ?? null;
$nis_siswa = $_SESSION['student_nis'] ?? '';

// Verifikasi apakah siswa sudah mengumpulkan tugas
$sqlCheck = "SELECT * FROM pengumpulan_tugas WHERE topik_id = ? AND nis_siswa = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("is", $topik_id, $nis_siswa);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    die('Anda sudah mengumpulkan tugas ini.');
}

// Proses pengumpulan tugas
if ($tugas_file && $tugas_file['error'] == 0) {
    $targetDir = '../uploads/';
    $targetFile = $targetDir . basename($tugas_file['name']);
    move_uploaded_file($tugas_file['tmp_name'], $targetFile);
    $file_path = $targetFile;
} else {
    $file_path = null;
}

$sqlInsert = "INSERT INTO pengumpulan_tugas (topik_id, nis_siswa, tugas_text, file_path) VALUES (?, ?, ?, ?)";
$stmtInsert = $conn->prepare($sqlInsert);
$stmtInsert->bind_param("isss", $topik_id, $nis_siswa, $tugas_text, $file_path);
$stmtInsert->execute();

header('Location: detail_mapel.php?kode_mapel=' . urlencode($_GET['kode_mapel']));
exit();
