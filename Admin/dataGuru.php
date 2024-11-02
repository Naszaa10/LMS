<?php
include '../db.php';

// Konfigurasi paginasi untuk data guru
$limit = 15;
$page_guru = isset($_GET['page_guru']) ? $_GET['page_guru'] : 1;
$offset_guru = ($page_guru - 1) * $limit;

// Ambil kata kunci pencarian jika ada
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Mengambil total data guru berdasarkan pencarian
$total_guru_query = "SELECT COUNT(*) AS total FROM guru
                     JOIN jurusan ON guru.id_jurusan = jurusan.id_jurusan
                     WHERE guru.nama_guru LIKE '%$search%' OR jurusan.nama_jurusan LIKE '%$search%'";
$total_guru_result = $conn->query($total_guru_query);
$total_guru = $total_guru_result->fetch_assoc()['total'];
$total_pages_guru = ceil($total_guru / $limit);

// Mengambil data guru dengan limit dan offset dan pencarian
$sql_guru = "
    SELECT guru.nip, guru.nama_guru, guru.email, jurusan.nama_jurusan 
    FROM guru 
    JOIN jurusan ON guru.id_jurusan = jurusan.id_jurusan 
    WHERE guru.nama_guru LIKE '%$search%' OR jurusan.nama_jurusan LIKE '%$search%'
    LIMIT $limit OFFSET $offset_guru";
$result_guru = $conn->query($sql_guru);

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="..\css\jadwal.css"> -->
</head>
<body>
    <?php include '../navbar/navAdmin.php'; ?>

    <div class="container mt-4">
        <h1>Data Guru</h1>
        <a href="tambahGuru.php" class="btn btn-primary mb-3">Tambah Guru</a>
        <table id="example" class="table table-bordered">
            <thead>
                <tr>
                    <th>NIP</th>
                    <th>Nama Guru</th>
                    <th>Email</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_guru->num_rows > 0) {
                    while ($row = $result_guru->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['nip']) . "</td>
                                <td>" . htmlspecialchars($row['nama_guru']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['nama_jurusan']) . "</td>
                                <td>
                                    <a href='editGuru.php?nip=" . $row['nip'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='hapusGuru.php?nip=" . $row['nip'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?');\">Hapus</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Data Guru Tidak Tersedia.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Paginasi untuk Guru -->
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages_guru; $i++) { ?>
                    <li class="page-item <?php if ($i == $page_guru) echo 'active'; ?>">
                        <a class="page-link" href="?page_guru=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
    <?php include '../navbar/tabelSeries.php'; ?>
</body>
</html>
