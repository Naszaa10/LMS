<?php
include '../db.php';

$nis = $_GET['nis'];
$kelas_id = $_GET['kelas_id'];

// Query untuk mengambil data nilai berdasarkan nis dan id kelas
$query = "SELECT kode_mapel, nilai, tahun_ajaran, tanggal_input 
          FROM nilai 
          WHERE nis = '$nis' AND id_kelas = '$kelas_id'";

$result = mysqli_query($conn, $query);
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>
