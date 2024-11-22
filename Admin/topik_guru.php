<?php
include '../db.php';

// Dapatkan nilai kode_mapel dan kelas dari query parameter
$kode_mapel = $_GET['kode_mapel'];
$kelas_id = $_GET['id_kelas'];

// Validasi apakah kelas_id merupakan integer
if (!is_numeric($kelas_id)) {
    die("Kelas ID tidak valid.");
}

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


// Jika formulir ditambahkan topik disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_topik = $_POST['nama_topik'];

    // Validasi nama topik tidak boleh kosong
    if (empty($nama_topik)) {
        echo "<div class='alert alert-danger'>Nama topik tidak boleh kosong.</div>";
    } else {
        // Query untuk menambah topik baru
        $sql_insert = "INSERT INTO topik (nama_topik, kode_mapel, id_kelas) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param('ssi', $nama_topik, $kode_mapel, $kelas_id);
        if ($stmt_insert->execute()) {
            echo "<div class='alert alert-success'>Topik berhasil ditambahkan.</div>";
        } else {
            echo "<div class='alert alert-danger'>Gagal menambahkan topik: " . $stmt_insert->error . "</div>";
        }
    }
}

// Fetch topics berdasarkan kode_mapel dan kelas_id
$sql = "SELECT * FROM topik WHERE kode_mapel = ? AND id_kelas = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $kode_mapel, $kelas_id);
$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Topik Guru</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/jadwal.css">
</head>
<body>
<?php include '../navbar/navAdmin.php'; ?>

<div class="container mt-4">
    <h1>Daftar Topik untuk <?php echo htmlspecialchars($nama_mapel); ?> - <?php echo htmlspecialchars($nama_kelas); ?></h1>

    <!-- Form untuk Menambahkan Topik Baru -->
    <form method="post" class="mb-4">
        <div class="form-group">
            <label for="nama_topik">Nama Topik:</label>
            <input type="text" class="form-control" id="nama_topik" name="nama_topik" required>
        </div>
        <div>
        <button type="submit" class="btn btn-primary">Tambah Topik</button>
        </div>
    </form>

    <table id="example" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Topik</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = $result->fetch_assoc()):
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['nama_topik']); ?></td>
                    <td>
                        <a href="lihat_materi.php?id_kelas=<?php echo $row['id_kelas']; ?>&kode_mapel=<?php echo $row['kode_mapel']; ?>&topik_id=<?php echo $row['topik_id']; ?>" class="btn btn-sm btn-primary">Lihat Materi</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../navbar/navFooter.php'; ?>
<?php include '../navbar/tabelSeries.php'; ?>
</body>
</html>
