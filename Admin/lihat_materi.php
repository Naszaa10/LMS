<?php
include '../db.php';

// Dapatkan nilai kode_mapel, kelas_id, dan topik_id dari query parameter
$kode_mapel = $_GET['kode_mapel'];
$kelas_id = $_GET['id_kelas'];
$topik_id = $_GET['topik_id'];

// Cek apakah kode_mapel ada di tabel mata_pelajaran
$query_mapel = "SELECT * FROM mata_pelajaran WHERE kode_mapel = ?";
$stmt_mapel = $conn->prepare($query_mapel);
$stmt_mapel->bind_param('s', $kode_mapel);
$stmt_mapel->execute();
$result_mapel = $stmt_mapel->get_result();
if ($result_mapel->num_rows == 0) {
    die("Kode mapel tidak valid.");
}

$row_mapel = $result_mapel->fetch_assoc();
$nama_mapel = $row_mapel['nama_mapel'];

// Cek apakah kelas_id ada di tabel kelas
$query_kelas = "SELECT * FROM kelas WHERE id_kelas = ?";
$stmt_kelas = $conn->prepare($query_kelas);
$stmt_kelas->bind_param('i', $kelas_id);
$stmt_kelas->execute();
$result_kelas = $stmt_kelas->get_result();
if ($result_kelas->num_rows == 0) {
    die("Kelas ID tidak valid.");
}

$row_kelas = $result_kelas->fetch_assoc();
$nama_kelas = $row_kelas['jenjang'] . ' ' . $row_kelas['nama_kelas'];

// Validasi apakah kelas_id dan topik_id merupakan integer
if (!is_numeric($kelas_id) || !is_numeric($topik_id)) {
    die("ID kelas atau topik tidak valid.");
}

// Query untuk mendapatkan materi berdasarkan kode_mapel, kelas_id, dan topik_id
$sql = "SELECT * FROM materi WHERE kode_mapel = ? AND id_kelas = ? AND topik_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sii', $kode_mapel, $kelas_id, $topik_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Materi - <?php echo htmlspecialchars($nama_mapel); ?> - Kelas <?php echo htmlspecialchars($nama_kelas); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include '../navbar/navAdmin.php'; ?>

<div class="container mt-4">
<h1>Daftar Topik untuk <?php echo htmlspecialchars($nama_mapel); ?> - <?php echo htmlspecialchars($nama_kelas); ?></h1>

    <!-- Button untuk Tambah Materi -->
    <a href="tambah_materi.php?kode_mapel=<?php echo urlencode($kode_mapel); ?>&id_kelas=<?php echo urlencode($kelas_id); ?>&topik_id=<?php echo urlencode($topik_id); ?>" class="btn btn-primary mb-3">Tambah Materi</a>

    <!-- Tabel untuk Menampilkan Materi -->
    <table id="example" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Materi</th>
                <th>File</th>
                <th>Tanggal Unggah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row['judul']); ?></td>
                        <td>
                            <a href="../uploads/<?php echo htmlspecialchars($row['file']); ?>" download>Download</a>
                        </td>
                        <td><?php echo htmlspecialchars($row['tanggal_unggah']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php } else { ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada materi untuk topik ini.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include '../navbar/navFooter.php'; ?>
<?php include '../navbar/tabelSeries.php'; ?>
</body>
</html>
