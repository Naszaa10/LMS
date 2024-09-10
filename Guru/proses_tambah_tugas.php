<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

$nip = $_SESSION['teacher_nip'];

// Ambil data dari form
$kode_mapel = $_POST['kode_mapel'];
$nama_tugas = $_POST['nama_tugas'];
$jenis_tugas = $_POST['jenis_tugas'];
$tenggat_waktu = $_POST['tenggat_waktu'];
$topik_id = $_POST['topik_id'];
$id_kelas = $_POST['id_kelas'];

// Insert tugas ke database
$sql = "INSERT INTO tugas (judul, opsi_tugas, tanggal_tenggat, topik_id, id_kelas, kode_mapel) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssiis", $nama_tugas, $jenis_tugas, $tenggat_waktu, $topik_id, $id_kelas, $kode_mapel);
$stmt->execute();

// Jika jenis tugas adalah upload file
if ($jenis_tugas == 'upload' && isset($_FILES['file_tugas']) && $_FILES['file_tugas']['error'] == UPLOAD_ERR_OK) {
    $file_name = $_FILES['file_tugas']['name'];
    $file_tmp = $_FILES['file_tugas']['tmp_name'];
    $file_dest = "../uploads/" . $file_name;
    move_uploaded_file($file_tmp, $file_dest);

    // Update database dengan nama file
    $sql = "UPDATE tugas SET file_tugas = ? WHERE topik_id = ? AND kode_mapel = ? AND id_kelas = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siii", $file_name, $topik_id, $kode_mapel, $id_kelas);
    $stmt->execute();
}

header("Location: detail_mapel.php?kode_mapel=$kode_mapel&kelas_id=$id_kelas");
exit();
?>
