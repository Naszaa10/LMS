<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

$topik_id = $_GET['topik_id'];
$kode_mapel = $_GET['kode_mapel'];
$id_kelas = $_GET['id_kelas'];

// Contoh untuk menampilkan daftar materi dengan opsi edit dan hapus
$sql = "SELECT * FROM materi WHERE topik_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $topik_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Pengumpulan Tugas</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/detailMapel.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include '../navbar/navHeader.php'; ?>

<div id="mainContent" class="container mt-4">
    <h2>Cek Materi</h2>
<div class="table-container">
<table class="table">
    <thead>
        <tr>
            <th>Nama Materi</th>
            <th>File</th>
            <th>Opsi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['judul']); ?></td>
                <td><a href="../uploads/<?php echo htmlspecialchars($row['file']); ?>" target="_blank">Lihat File</a></td>
                <td>
                    <a href="edit_materi.php?materi_id=<?php echo $row['id']; ?>" class="btn btn-edit btn-sm btn-warning">Edit</a>
                    <a href="hapus_materi.php?materi_id=<?php echo $row['id']; ?>" class="btn btn-delete btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus materi ini?');">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<?php include '../navbar/navFooter.php'; ?>
</html>
