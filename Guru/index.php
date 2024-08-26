<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

$nip = $_SESSION['teacher_nip'];

// Query untuk mendapatkan daftar mata pelajaran yang diajar oleh guru berdasarkan NIP
$sql = "
    SELECT DISTINCT mata_pelajaran.id, mata_pelajaran.nama_mapel
    FROM guru_mapel_kelas 
    JOIN mata_pelajaran ON guru_mapel_kelas.mata_pelajaran_id = mata_pelajaran.id 
    JOIN guru ON guru_mapel_kelas.guru_id = guru.id 
    WHERE guru.nip = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nip);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Mata Pelajaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../navbar/navHeader.php'; ?>
    <div id="mainContent" class="container mt-4">
        <h2>Daftar Mata Pelajaran yang Diajar</h2>
        <!-- Seksi Menampilkan Card Mata Pelajaran -->
        <div class="row justify-content-center">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-6 mb-3">
                    <a href="detail_mapel.php?mapel_id=<?php echo $row['id']; ?>" class="card-link text-decoration-none">
                        <div class="card custom-card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Gambar Placeholder">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['nama_mapel']); ?></h5>
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
