<?php
session_start();
include '../db.php'; // Koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_mapel = $_POST['kode_mapel'];
    $id_kelas = $_POST['id_kelas'];
    $topik_id = $_POST['topik_id'];
    $nama_tugas = $_POST['nama_tugas'];
    $deskripsi_tugas = $_POST['deskripsi_tugas'];
    $jenis_tugas = $_POST['jenis_tugas'];
    $tenggat_waktu = $_POST['tenggat_waktu'];
    
    // Proses upload file jika ada
    $file_tugas = null;
    if (isset($_FILES['file_tugas']) && $_FILES['file_tugas']['error'] == 0) {
        $upload_dir = 'uploads/tugasguru/'; // Ganti dengan direktori yang sesuai
        $file_tugas = basename($_FILES['file_tugas']['name']);
        $target_file = $upload_dir . $file_tugas;

        // Pastikan file diupload
        if (move_uploaded_file($_FILES['file_tugas']['tmp_name'], $target_file)) {
            // File berhasil diupload
        } else {
            // Handle error
        }
    }

    // Simpan tugas ke database
    $sql = "INSERT INTO tugas (kode_mapel, id_kelas, topik_id, nama_tugas, deskripsi_tugas, jenis_tugas, tenggat_waktu, file_tugas) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siissssss", $kode_mapel, $id_kelas, $topik_id, $nama_tugas, $deskripsi_tugas, $jenis_tugas, $tenggat_waktu, $file_tugas);
    
    if ($stmt->execute()) {
        header("Location: detail_mapel.php?kode_mapel=$kode_mapel&id_kelas=$id_kelas");
    } else {
        // Handle error
    }
}
?>
