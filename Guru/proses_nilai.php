<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login_guru.php");
    exit();
}

// Ambil data dari form
$topik_id = $_POST['topik_id'];
$kode_mapel = $_POST['kode_mapel'];
$id_kelas = $_POST['id_kelas'];
$nilai = $_POST['nilai'];
$id_tugas = $_POST['id_tugas'];

// Mulai transaksi
$conn->begin_transaction();

try {
    foreach ($nilai as $nis => $nilai_tugas) {
        $id_tugas_siswa = $id_tugas[$nis];
        
        // Periksa apakah nilai sudah ada
        $sql = "
            SELECT COUNT(*) as count 
            FROM penilaian_tugas 
            WHERE nis = ? 
              AND id_tugas = ? 
              AND kode_mapel = ? 
              AND id_kelas = ?
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisi", $nis, $id_tugas_siswa, $kode_mapel, $id_kelas);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            // Update nilai jika sudah ada
            $sql = "
                UPDATE penilaian_tugas 
                SET nilai_tugas = ? 
                WHERE nis = ? 
                  AND id_tugas = ? 
                  AND kode_mapel = ? 
                  AND id_kelas = ?
            ";
        } else {
            // Insert nilai jika belum ada
            $sql = "
                INSERT INTO penilaian_tugas (nis, id_tugas, kode_mapel, id_kelas, nilai_tugas) 
                VALUES (?, ?, ?, ?, ?)
            ";
        }

        $stmt = $conn->prepare($sql);
        if ($row['count'] > 0) {
            $stmt->bind_param("isisi", $nilai_tugas, $nis, $id_tugas_siswa, $kode_mapel, $id_kelas);
        } else {
            $stmt->bind_param("sisii", $nis, $id_tugas_siswa, $kode_mapel, $id_kelas, $nilai_tugas);
        }

        $stmt->execute();
    }

    // Commit transaksi
    $conn->commit();
    header("Location: cek_pengumpulan_tugas.php?topik_id=" . urlencode($topik_id) . "&kode_mapel=" . urlencode($kode_mapel) . "&id_kelas=" . urlencode($id_kelas));
    exit();

} catch (Exception $e) {
    // Rollback transaksi jika terjadi kesalahan
    $conn->rollback();
    die('Terjadi kesalahan: ' . htmlspecialchars($e->getMessage()));
}
