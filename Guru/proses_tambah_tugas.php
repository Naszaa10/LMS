<?php
session_start();
include '../db.php'; // Include database connection

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

// Ambil data dari form
$kode_mapel = $_POST['kode_mapel'];
$id_kelas = $_POST['id_kelas'];
$topik_id = $_POST['topik_id'];
$nama_tugas = $_POST['nama_tugas'];
$deskripsi_tugas = $_POST['deskripsi_tugas'];
$jenis_tugas = $_POST['jenis_tugas'];
$tenggat_waktu = $_POST['tenggat_waktu'];

// Handle file upload
$file_tugas = $_FILES['file_tugas'] ?? null;
$file_path = null;

if ($file_tugas && $file_tugas['error'] === UPLOAD_ERR_OK) {
    $upload_dir = '../uploads/tugasguru/';
    $file_name = basename($file_tugas['name']);
    $file_path = $upload_dir . $file_name;

    // Move the uploaded file to the target directory
    if (!move_uploaded_file($file_tugas['tmp_name'], $file_path)) {
        echo "Error uploading file.";
        exit();
    }
}

// Insert tugas into database
$sql = "
    INSERT INTO tugas (kode_mapel, id_kelas, topik_id, judul, deskripsi_tugas, opsi_tugas, file_tugas, tanggal_tenggat)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("siisssss", $kode_mapel, $id_kelas, $topik_id, $nama_tugas, $deskripsi_tugas, $jenis_tugas, $file_path, $tenggat_waktu);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Redirect back with success message
    header("Location: detail_mapel.php?kode_mapel=$kode_mapel&kelas_id=$id_kelas&success=1");
} else {
    // Redirect back with error message
    header("Location: detail_mapel.php?kode_mapel=$kode_mapel&kelas_id=$id_kelas&error=1");
}
?>
