<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Materi Guru</title>
    <link rel="stylesheet" href="../css/detailMapel.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include '../navbar/navHeader.php'; 

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-primary text-black mt-4">' . htmlspecialchars($_SESSION['message']) . '</div>';
    unset($_SESSION['message']);
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

<div id="mainContent" class="container mt-4">
    <h2>Cek Materi</h2>
<div class="table-container">
<table id="example" class="table table-bordered">
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
                <td><a href="<?php echo htmlspecialchars($row['file']); ?>" download>Download File</a></td><td>
                <a href="edit_materi.php?materi_id=<?php echo $row['id_materi']; ?>&topik_id=<?php echo $row['topik_id']; ?>&kode_mapel=<?php echo $row['kode_mapel']; ?>&id_kelas=<?php echo $row['id_kelas']; ?>" class="btn btn-edit btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Edit">
                <i class="fa fa-edit"></i> Edit</a>

                <a href="proses_hapus_materi.php?materi_id=<?php echo $row['id_materi']; ?>&topik_id=<?php echo $row['topik_id']; ?>&kode_mapel=<?php echo $row['kode_mapel']; ?>&id_kelas=<?php echo $row['id_kelas']; ?>" class="btn btn-delete btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus materi ini?'); data-toggle="tooltip" data-placement="top" title="Delete">
                <i class="fa fa-trash"></i> Hapus</a>
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
<?php include '../navbar/tabelSeries.php'; ?>
</html>
