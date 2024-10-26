<?php
include '../db.php';

// Pagination setup
$limit = 10; // Menampilkan 10 data per halaman
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ambil data mata pelajaran dengan pagination
$sql = "SELECT * FROM mata_pelajaran LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Pelajaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="..\css\tambahmapel.css">
</head>
<body>
<?php include '../navbar/navAdmin.php'; ?>
<div class="container mt-3">
    <h1>Daftar Mata Pelajaran</h1>
    <a href="tambah_matapelajaran.php" class="btn btn-primary mb-3">Tambah Mata Pelajaran</a>
    <table id="example" class="table table-bordered">
        <thead>
            <tr>
                <th>Kode Mapel</th>
                <th>Nama Mapel</th>
                <th>Deskripsi</th>
                <th>Jenis</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['kode_mapel']; ?></td>
                <td><?php echo $row['nama_mapel']; ?></td>
                <td><?php echo $row['deskripsi']; ?></td>
                <td><?php echo $row['jenis']; ?></td>
                <td><img src="<?php echo $row['gambar']; ?>" alt="Gambar" style="width: 100px;"></td>
                <td>
                    <a href="editMapel.php?kode_mapel=<?php echo $row['kode_mapel']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="dataMapel.php?hapus_mapel=<?php echo $row['kode_mapel']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus mata pelajaran ini?');">Hapus</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <?php
    // Pagination count
    $sql_total = "SELECT COUNT(*) AS total FROM mata_pelajaran";
    $result_total = $conn->query($sql_total);
    $total = $result_total->fetch_assoc()['total'];
    $total_pages = ceil($total / $limit);
    ?>

    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="dataMapel.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>

<?php
// Menghapus mata pelajaran berdasarkan kode_mapel
if (isset($_GET['hapus_mapel'])) {
    $kode_mapel = $_GET['hapus_mapel'];

    // Query untuk menghapus data
    $sql = "DELETE FROM mata_pelajaran WHERE kode_mapel = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $kode_mapel);

    if ($stmt->execute()) {
        header("Location: dataMapel.php");
    } else {
        echo "Gagal menghapus data kelas.";
    }
}

// Menutup koneksi
$conn->close();
?>

<?php include '../navbar/navFooter.php'; ?>
<?php include '../navbar/tabelSeries.php'; ?>

</body>
</html>
