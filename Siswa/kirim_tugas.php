<?php
session_start();
include '../db.php';

// Pastikan siswa sudah login
if (!isset($_SESSION['nis_siswa'])) {
    header("Location: ../login.php");
    exit();
}

$nis_siswa = $_SESSION['nis_siswa'];
$tugas_id = $_POST['tugas_id'];
$topik_id = $_POST['topik_id'];
$kode_mapel = $_POST['kode_mapel'];
$id_kelas = $_POST['id_kelas'];
$jawaban = $_POST['jawaban'] ?? null;

// Jika tipe tugas adalah teks
if (isset($jawaban)) {
    // Query untuk menyimpan jawaban teks
    $query = "
        INSERT INTO pengumpulan_tugas (nis, id_tugas, tugas_text, topik_id, kode_mapel, id_kelas, tanggal_pengumpulan)
        VALUES (?, ?, ?, ?, ?, ?, NOW())
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sisisi', $nis_siswa, $tugas_id, $jawaban, $topik_id, $kode_mapel, $id_kelas);
    $stmt->execute();
}

// Jika tipe tugas adalah upload
if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] == UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['file_upload']['tmp_name'];
    $file_name = basename($_FILES['file_upload']['name']);
    $file_dest = '../uploads/tugas/' . $file_name;

    // Pindahkan file dari lokasi sementara ke folder tujuan
    if (move_uploaded_file($file_tmp, $file_dest)) {
        // Query untuk menyimpan informasi file
        $query = "
            INSERT INTO pengumpulan_tugas (nis, id_tugas, file_path, topik_id, kode_mapel, id_kelas, tanggal_pengumpulan)
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sisisi', $nis_siswa, $tugas_id, $file_name, $topik_id, $kode_mapel, $id_kelas);
        $stmt->execute();
    } else {
        echo "Gagal mengunggah file.";
    }
}

header("Location: detail_mapel.php?kode_mapel=" . urlencode($kode_mapel));
exit();
?>
