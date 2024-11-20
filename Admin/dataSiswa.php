<?php
include '../db.php';

// Konfigurasi paginasi untuk data siswa
$limit = 15;
$page_siswa = isset($_GET['page_siswa']) ? $_GET['page_siswa'] : 1;
$offset_siswa = ($page_siswa - 1) * $limit;

// Ambil kata kunci pencarian jika ada
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Mengambil total data siswa berdasarkan pencarian
$total_siswa_query = "SELECT COUNT(*) AS total FROM siswa
                       JOIN kelas ON siswa.id_kelas = kelas.id_kelas
                       JOIN jurusan ON siswa.id_jurusan = jurusan.id_jurusan
                       WHERE siswa.nama_siswa LIKE '%$search%' OR kelas.jenjang LIKE '%$search%' OR siswa.nis LIKE '%$search%'";
$total_siswa_result = $conn->query($total_siswa_query);
$total_siswa = $total_siswa_result->fetch_assoc()['total'];
$total_pages_siswa = ceil($total_siswa / $limit);

// Mengambil data siswa dengan limit dan offset dan pencarian
$sql_siswa = "SELECT siswa.nis, siswa.nama_siswa, siswa.email, kelas.nama_kelas, kelas.jenjang, siswa.nama_wali_kelas, jurusan.nama_jurusan, siswa.angkatan
              FROM siswa
              JOIN kelas ON siswa.id_kelas = kelas.id_kelas
              JOIN jurusan ON siswa.id_jurusan = jurusan.id_jurusan
              WHERE siswa.nama_siswa LIKE '%$search%' OR kelas.nama_kelas LIKE '%$search%' OR kelas.jenjang LIKE '%$search%' OR siswa.nis LIKE '%$search%'
              LIMIT $limit OFFSET $offset_siswa";
$result_siswa = $conn->query($sql_siswa);

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="..\css\jadwal.css"> -->
    <style>
        .btn-warning, .btn-danger {
            width: 60px;
            height:32px;
            margin: 2px;

        }
    </style>

</head>
<body>
    <?php include '../navbar/navAdmin.php'; ?>

    <div class="container mt-4">
        <h1>Data Siswa</h1>
        <a href="tambahSiswa.php" class="btn btn-primary mb-3">Tambah Siswa</a>
        <table id="example" class="table table-bordered">
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Email</th>
                    <th>Kelas</th>
                    <th>Wali Kelas</th>
                    <th>Jurusan</th>
                    <th>Angkatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_siswa->num_rows > 0) {
                    while ($row = $result_siswa->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['nis']) . "</td>
                                <td>" . htmlspecialchars($row['nama_siswa']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['jenjang']) . ' ' . htmlspecialchars($row['nama_kelas']) . "</td>
                                <td>" . htmlspecialchars($row['nama_wali_kelas']) . "</td>
                                <td>" . htmlspecialchars($row['nama_jurusan']) . "</td>
                                <td>" . htmlspecialchars($row['angkatan']) . "</td>
                                <td>
                                    <a href='editSiswa.php?nis=" . $row['nis'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='hapusSiswa.php?nis=" . $row['nis'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?');\">Hapus</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Data Siswa Tidak Tersedia.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Paginasi untuk Siswa -->
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages_siswa; $i++) { ?>
                    <li class="page-item <?php if ($i == $page_siswa) echo 'active'; ?>">
                        <a class="page-link" href="?page_siswa=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
    <?php include '../navbar/tabelSeries.php'; ?>
</body>
</html>
