<?php
include '../db.php';

// Konfigurasi paginasi untuk data guru
$limit = 15; // Jumlah data per halaman
$page_guru = isset($_GET['page_guru']) ? $_GET['page_guru'] : 1; // Halaman saat ini untuk data guru
$offset_guru = ($page_guru - 1) * $limit; // Offset data guru

// Mengambil total data guru
$total_guru_query = "SELECT COUNT(*) AS total FROM guru";
$total_guru_result = $conn->query($total_guru_query);
$total_guru = $total_guru_result->fetch_assoc()['total'];
$total_pages_guru = ceil($total_guru / $limit); // Total halaman guru

// Mengambil data guru dengan limit dan offset
$sql_guru = "SELECT nip, nama_guru, email, jurusan FROM guru LIMIT $limit OFFSET $offset_guru";
$result_guru = $conn->query($sql_guru);

// Konfigurasi paginasi untuk data siswa
$page_siswa = isset($_GET['page_siswa']) ? $_GET['page_siswa'] : 1; // Halaman saat ini untuk data siswa
$offset_siswa = ($page_siswa - 1) * $limit; // Offset data siswa

// Mengambil total data siswa
$total_siswa_query = "SELECT COUNT(*) AS total FROM siswa";
$total_siswa_result = $conn->query($total_siswa_query);
$total_siswa = $total_siswa_result->fetch_assoc()['total'];
$total_pages_siswa = ceil($total_siswa / $limit); // Total halaman siswa

// Mengambil data siswa dengan limit dan offset
$sql_siswa = "SELECT nis, nama_siswa, email, id_kelas, nama_wali_kelas, jurusan, angkatan FROM siswa LIMIT $limit OFFSET $offset_siswa";
$result_siswa = $conn->query($sql_siswa);

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru dan Siswa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include '../navbar/navAdmin.php'; ?>

    <div class="container mt-4">
        <h2>Data Guru</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>NIP</th>
                    <th>Nama Guru</th>
                    <th>Email</th>
                    <th>Jurusan</th>
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
                                <td>" . htmlspecialchars($row['jurusan']) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada data guru tersedia.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <!-- Paginasi untuk Guru -->
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages_guru; $i++) { ?>
                    <li class="page-item <?php if ($i == $page_guru) echo 'active'; ?>">
                        <a class="page-link" href="?page_guru=<?php echo $i; ?>&page_siswa=<?php echo $page_siswa; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>

        <h2>Data Siswa</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Email</th>
                    <th>Kelas</th>
                    <th>Nama Wali Kelas</th>
                    <th>Jurusan</th>
                    <th>Angkatan</th>
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
                                <td>" . htmlspecialchars($row['id_kelas']) . "</td>
                                <td>" . htmlspecialchars($row['nama_wali_kelas']) . "</td>
                                <td>" . htmlspecialchars($row['jurusan']) . "</td>
                                <td>" . htmlspecialchars($row['angkatan']) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Tidak ada data siswa tersedia.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <!-- Paginasi untuk Siswa -->
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages_siswa; $i++) { ?>
                    <li class="page-item <?php if ($i == $page_siswa) echo 'active'; ?>">
                        <a class="page-link" href="?page_guru=<?php echo $page_guru; ?>&page_siswa=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>
