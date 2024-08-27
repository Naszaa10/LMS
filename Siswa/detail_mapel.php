<?php
include '../db.php';

// Ambil mapel_id dan kelas_id dari query string
$kode_mapel = $_GET['kode_mapel'];
$kelas_id = $_GET['kelas_id'];

// Query untuk mendapatkan topik berdasarkan mata pelajaran dan kelas
$sql = "SELECT * FROM topik WHERE kode_mapel = ? AND kelas_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $kode_mapel, $kelas_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mata Pelajaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../navbar/navSiswa.php'; ?>
    <div id="mainContent" class="container mt-4">
        <h2>Detail Mata Pelajaran</h2>
        
        <?php while ($topik = $result->fetch_assoc()): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($topik['nama_topik']); ?></h5>
                    <a href="detail_topik.php?topik_id=<?php echo $topik['id']; ?>" class="btn btn-primary">Lihat Topik</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>

<?php
$conn->close();
?>
