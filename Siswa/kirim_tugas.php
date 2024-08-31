<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan siswa sudah login
if (!isset($_SESSION['student_nis'])) {
    header("Location: ../login.php");
    exit();
}

$nis = $_SESSION['student_nis'];
$topik_id = $_POST['topik_id'];
$kode_mapel = $_POST['kode_mapel'];
$id_kelas = $_POST['id_kelas'];
$jenis_tugas = $_POST['jenis_tugas'];

// Insert pengumpulan tugas
$sql = "INSERT INTO pengumpulan_tugas (nis, topik_id, kode_mapel, id_kelas, jenis_tugas) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siii", $nis, $topik_id, $kode_mapel, $id_kelas);
$stmt->execute();

// Jika jenis tugas adalah upload file
if ($jenis_tugas == 'upload' && isset($_FILES['file_tugas']) && $_FILES['file_tugas']['error'] == UPLOAD_ERR_OK) {
    $file_name = $_FILES['file_tugas']['name'];
    $file_tmp = $_FILES['file_tugas']['tmp_name'];
    $file_dest = "../uploads/" . $file_name;
    move_uploaded_file($file_tmp, $file_dest);

    // Update database dengan nama file
    $sql = "UPDATE pengumpulan_tugas SET file_tugas = ? WHERE nis = ? AND topik_id = ? AND kode_mapel = ? AND id_kelas = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiii", $file_name, $nis, $topik_id, $kode_mapel, $id_kelas);
    $stmt->execute();
}

header("Location: detail_mapel.php?kode_mapel=$kode_mapel&kelas_id=$id_kelas");
exit();
?>
