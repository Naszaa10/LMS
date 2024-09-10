<?php
include '../db.php'; // Koneksi ke database

$kelas = $_GET['kelas'];
$mata_pelajaran = $_GET['mata_pelajaran'];

$query = "SELECT siswa.nama_siswa, nilai.pengetahuan, nilai.keterampilan, nilai.predikat, nilai.nilai, nilai.tanggal_input, siswa.nis
          FROM siswa
          LEFT JOIN nilai ON siswa.nis = nilai.nis AND nilai.kode_mapel = ? AND nilai.id_kelas = ?
          WHERE siswa.id_kelas = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $mata_pelajaran, $kelas, $kelas);
$stmt->execute();
$result = $stmt->get_result();

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

header('Content-Type: application/json');
echo json_encode($students);
?>
