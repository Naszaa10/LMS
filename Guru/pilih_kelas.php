<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

$nip = $_SESSION['teacher_nip'];
$mapel_id = $_GET['mapel_id'];

// Query untuk mendapatkan daftar kelas yang diajar oleh guru berdasarkan mapel dan NIP
$sql = "
    SELECT DISTINCT kelas.id, kelas.nama_kelas 
    FROM guru_mapel_kelas 
    JOIN kelas ON guru_mapel_kelas.kelas_id = kelas.id 
    JOIN guru ON guru_mapel_kelas.guru_id = guru.id 
    WHERE guru.nip = ? AND guru_mapel_kelas.mata_pelajaran_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $nip, $mapel_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../navbar/navHeader.php'; ?>
    <div id="mainContent" class="container mt-4">
        <h2>Pilih Kelas untuk Mata Pelajaran</h2>
        <!-- Seksi Menampilkan Card Kelas -->
        <div class="row justify-content-center">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-6 mb-3">
                    <a href="detail_mapel.php?mapel_id=<?php echo $mapel_id; ?>&kelas_id=<?php echo $row['id']; ?>" class="card-link text-decoration-none">
                        <div class="card custom-card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['nama_kelas']); ?></h5>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>

<?php
// Tutup koneksi database
$conn->close();
?>
