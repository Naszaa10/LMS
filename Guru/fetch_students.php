<?php
include '../db.php'; // Koneksi ke database

if (isset($_GET['kelas']) && isset($_GET['mata_pelajaran'])) {
    $kelas = $_GET['kelas'];
    $kode_mapel = $_GET['mata_pelajaran'];

    $query = "SELECT siswa.nis, siswa.nama_siswa, nilai.nilai 
              FROM siswa 
              LEFT JOIN nilai ON siswa.nis = nilai.nis AND nilai.kode_mapel = ? 
              WHERE siswa.id_kelas = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $kode_mapel, $kelas);
    $stmt->execute();
    $result = $stmt->get_result();

    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    echo json_encode($students);
}
?>
