<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pelajaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/jadwal.css">
</head>
<body>
<?php
    include '../navbar/navSiswa.php';

    // Ambil id_kelas siswa
    $queryKelas = "SELECT id_kelas,nama_siswa FROM siswa WHERE nis = '$nis_siswa'";
    $resultKelas = mysqli_query($conn, $queryKelas);
    $dataKelas = mysqli_fetch_assoc($resultKelas);
    $idKelas = $dataKelas['id_kelas'];

    // Ambil data jadwal berdasarkan id_kelas
    $queryJadwal = "SELECT mata_pelajaran.nama_mapel, jadwal.hari, jadwal.waktu_mulai, jadwal.waktu_selesai, guru.nama_guru 
                     FROM jadwal 
                     JOIN mata_pelajaran ON jadwal.kode_mapel = mata_pelajaran.kode_mapel 
                     JOIN guru ON jadwal.nip = guru.nip 
                     WHERE jadwal.id_kelas = '$idKelas'";
    $resultJadwal = mysqli_query($conn, $queryJadwal);
?>

<div id="mainContent" class="container mt-4">
    <h2 class="mb-4">Jadwal Pelajaran : <?php echo $dataKelas['nama_siswa']; ?></h2>
    <table id="example" class="table table-bordered">
        <thead>
            <tr>
                <th>Mata Pelajaran</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Guru</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($resultJadwal)): ?>
                <tr>
                    <td><?php echo $row['nama_mapel']; ?></td>
                    <td><?php echo $row['hari']; ?></td>
                    <td><?php echo $row['waktu_mulai'] . ' - ' . $row['waktu_selesai']; ?></td>
                    <td><?php echo $row['nama_guru']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php
include '../navbar/tabelSeries.php';

include '../navbar/navFooterSiswa.php';
?>
</body>
</html>
