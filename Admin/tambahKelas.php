<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// // Pastikan admin sudah login
// if (!isset($_SESSION['admin'])) {
//     header("Location: ../login.php");
//     exit();
// }

// Menambah kelas
if (isset($_POST['submit_kelas'])) {
    $nama_kelas = $_POST['nama_kelas'];
    $tahun_ajaran = $_POST['tahun_ajaran'];
    $jurusan = $_POST['jurusan'];

    // Query untuk menambahkan kelas ke database
    $sql = "INSERT INTO kelas (nama_kelas, tahun_ajaran, jurusan) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nama_kelas, $tahun_ajaran, $jurusan);

    if ($stmt->execute()) {
        echo "<script>alert('Kelas berhasil ditambahkan!'); window.location.href='tambahKelas.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan kelas!');</script>";
    }
}

// Menghapus kelas
if (isset($_GET['hapus_kelas'])) {
    $id_kelas = $_GET['hapus_kelas'];

    // Query untuk menghapus kelas berdasarkan id
    $sql = "DELETE FROM kelas WHERE id_kelas = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_kelas);

    if ($stmt->execute()) {
        echo "<script>alert('Kelas berhasil dihapus!'); window.location.href='tambahKelas.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus kelas!');</script>";
    }
}

// Mendapatkan daftar kelas untuk ditampilkan
$sql = "SELECT kelas.*, tahun_ajaran.tahun_ajaran, jurusan.nama_jurusan
FROM kelas 
INNER JOIN tahun_ajaran ON kelas.id_tahun_ajaran = tahun_ajaran.id_tahun_ajaran 
INNER JOIN jurusan ON kelas.id_jurusan = jurusan.id_jurusan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kelas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/tambahmapel.css"> <!-- Path ke file CSS terpisah -->
</head>
<body>
    <?php include '../navbar/navAdmin.php'; ?>

    <div id="mainContent" class="container mt-5">
        <!-- Formulir Tambah Kelas -->
        <div id="guruForm" class="form-card">
            <h2>Formulir Tambah Kelas</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="nama_kelas">Nama Kelas:</label>
                    <input type="text" id="nama_kelas" name="nama_kelas" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="tahun_ajaran">Tahun Ajaran:</label>
                    <input type="text" id="tahun_ajaran" name="tahun_ajaran" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="jurusan">Jurusan:</label>
                    <input type="text" id="jurusan" name="jurusan" class="form-control" required>
                </div>

                <button type="submit" name="submit_kelas" class="btn btn-primary">Tambah Kelas</button>
            </form>
        </div>

        <!-- Tabel Data Kelas -->
        <div id="guruTable" class="table-container">
            <h2 class="text-center mt-5">Daftar Kelas</h2>
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
                                <a href="edit_kelas.php?id_kelas=<?php echo $row['id_kelas']; ?>" class="btn btn-edit btn-sm btn-warning">Edit</a>
                                <a href="tambahKelas.php?hapus_kelas=<?php echo $row['id_kelas']; ?>" class="btn btn-delete btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kelas ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>
