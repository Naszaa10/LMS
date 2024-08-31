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
                    <a href="edit_materi.php?materi_id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="hapus_materi.php?materi_id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus materi ini?');">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
