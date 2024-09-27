<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Menghapus kelas
if (isset($_GET['hapus_kelas'])) {
    $id_kelas = $_GET['hapus_kelas'];

    // Query untuk menghapus kelas berdasarkan id
    $sql = "DELETE FROM kelas WHERE id_kelas = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_kelas);

    if ($stmt->execute()) {
        echo "<script>alert('Kelas berhasil dihapus!'); window.location.href='dataKelas.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus kelas!');</script>";
    }
}

// Konfigurasi paginasi
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Pencarian
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Menghitung total data kelas berdasarkan pencarian
$total_query = "SELECT COUNT(*) AS total FROM kelas 
                INNER JOIN jurusan ON kelas.id_jurusan = jurusan.id_jurusan 
                WHERE nama_kelas LIKE ? OR jurusan.nama_jurusan LIKE ?";
$search_param = "%" . $search . "%";
$stmt_total = $conn->prepare($total_query);
$stmt_total->bind_param("ss", $search_param, $search_param);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_classes = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_classes / $limit);

// Mendapatkan daftar kelas untuk ditampilkan berdasarkan pencarian
$sql = "SELECT kelas.*, tahun_ajaran.tahun_ajaran, jurusan.nama_jurusan
        FROM kelas 
        INNER JOIN tahun_ajaran ON kelas.id_tahun_ajaran = tahun_ajaran.id_tahun_ajaran 
        INNER JOIN jurusan ON kelas.id_jurusan = jurusan.id_jurusan
        WHERE kelas.nama_kelas LIKE ? OR jurusan.nama_jurusan LIKE ?
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii", $search_param, $search_param, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kelas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="..\css\tambahMapel.css">
</head>
<body>
    <?php include '../navbar/navAdmin.php'; ?>

    <div class="container mt-4">
        <h1>Data Kelas</h1>
        <a href="tambahKelas.php" class="btn btn-primary mb-3">Tambah Kelas</a>

        <!-- Form Pencarian -->
        <form action="" method="post" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Cari berdasarkan nama kelas atau jurusan" value="<?php echo htmlspecialchars($search); ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Kelas</th>
                    <th>Tahun Ajaran</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nama_kelas']); ?></td>
                        <td><?php echo htmlspecialchars($row['tahun_ajaran']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_jurusan']); ?></td>
                        <td>
                            <a href="edit_kelas.php?id_kelas=<?php echo $row['id_kelas']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="dataKelas.php?hapus_kelas=<?php echo $row['id_kelas']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kelas ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Paginasi -->
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="dataKelas.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>
