<?php
include '../db.php';

$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $search = "%$search%";
    $sql = "SELECT jadwal.*, kelas.nama_kelas, kelas.jenjang FROM jadwal JOIN kelas ON jadwal.id_kelas = kelas.id_kelas WHERE nip LIKE ? OR kelas.nama_kelas LIKE ? OR kode_mapel LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $search, $search, $search);
} else {
    $sql = "SELECT jadwal.*, kelas.nama_kelas, kelas.jenjang FROM jadwal JOIN kelas ON jadwal.id_kelas = kelas.id_kelas";
    $stmt = $conn->prepare($sql);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jadwal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="..\css\jadwal.css"> -->
</head>
<body>
<?php include '../navbar/navAdmin.php'; ?>

<div class="container-fluid mt-4">
    <h1>Daftar Jadwal</h1>

    <!-- Tombol Tambah Jadwal -->
    <a href="tambahJadwal.php" class="btn btn-primary mb-3">Tambah Jadwal</a>

    <!-- Tabel Jadwal -->
    <table id="example" class="table table-bordered">
        <thead>
            <tr>
                <th>NIP Guru</th>
                <th>Kode Mapel</th>
                <th>Nama Kelas</th>
                <th>Hari</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['nip']); ?></td>
                <td><?php echo htmlspecialchars($row['kode_mapel']); ?></td>
                <td><?php echo htmlspecialchars($row['jenjang']) . ' ' . htmlspecialchars($row['nama_kelas']); ?></td>
                <td><?php echo htmlspecialchars($row['hari']); ?></td>
                <td><?php echo htmlspecialchars($row['waktu_mulai']); ?></td>
                <td><?php echo htmlspecialchars($row['waktu_selesai']); ?></td>
                <td>
                    <a href="editJadwal.php?id=<?php echo $row['id_jadwal']; ?>" class="btn btn-warning">Edit</a>
                    <a href="hapusJadwal.php?id=<?php echo $row['id_jadwal']; ?>" class="btn btn-danger" onclick="return confirm('Hapus jadwal ini?')">Hapus</a>
                    <a href="topik_guru.php?id_kelas=<?php echo $row['id_kelas']; ?>&kode_mapel=<?php echo $row['kode_mapel']; ?>" class="btn btn-info">Lihat Topik</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php if ($result->num_rows == 0) { ?>
        <p>Jadwal tidak ditemukan.</p>
    <?php } ?>
</div>

<?php include '../navbar/navFooter.php'; ?>
<?php include '../navbar/tabelSeries.php'; ?>
</body>
</html>
