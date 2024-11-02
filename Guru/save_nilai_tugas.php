<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kelas = $_POST['kelas'];
    $mataPelajaran = $_POST['mataPelajaran'];
    $nilai = $_POST['nilai']; // Array of nilai keyed by NIS and ID tugas

    foreach ($nilai as $nis => $tugasData) {
        foreach ($tugasData as $id_tugas => $nilai_tugas) {
            // Check if this entry already exists
            $query = "SELECT COUNT(*) FROM penilaian_tugas WHERE nis = ? AND id_tugas = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $nis, $id_tugas);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();

            if ($count > 0) {
                // Update existing record
                $query = "UPDATE penilaian_tugas SET nilai_tugas = ?, tanggal_penilaian = NOW() WHERE nis = ? AND id_tugas = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sss", $nilai_tugas, $nis, $id_tugas);
                $stmt->execute();
            } else {
                // Insert new record
                $query = "INSERT INTO penilaian_tugas (nis, id_tugas, kode_mapel, id_kelas, nilai_tugas, tanggal_penilaian)
                          VALUES (?, ?, ?, ?, ?, NOW())";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sssss", $nis, $id_tugas, $mataPelajaran, $kelas, $nilai_tugas);
                $stmt->execute();
            }
        }
    }

    header("Location: nilaiTugasGuru.php"); // Redirect ke halaman sukses atau yang sesuai
    exit();
}
?>
