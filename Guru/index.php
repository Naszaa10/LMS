<?php
session_start(); // Pastikan sesi dimulai

include '../db.php'; // Sertakan koneksi database

// Ambil teacher_nip dari sesi
$teacher_nip = $_SESSION['teacher_nip']; // Pastikan ini adalah ID yang benar dari sesi

// Ambil data mata pelajaran yang diajarkan oleh guru
$sql = "SELECT s.id, s.subject_name 
        FROM teacher_subjects ts
        JOIN subjects s ON ts.subject_id = s.id
        WHERE ts.teacher_nip = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $teacher_nip); // Bind teacher_nip secara dinamis
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
        <!-- Seksi Tugas yang Akan Datang -->
        <section class="tasks mb-4">
            <h3>Tugas yang Akan Datang</h3>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Tugas 1
                    <span class="badge bg-primary rounded-pill">Segera</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Tugas 2
                    <span class="badge bg-warning rounded-pill">Sedang Proses</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Tugas 3
                    <span class="badge bg-success rounded-pill">Selesai</span>
                </li>
            </ul>
        </section>

        <!-- Seksi Tambah Card -->
        <div class="btn-card mb-4">
            <p>Tambah Card</p>
            <button type="button" class="btn btn-primary btn-sm">Tambah</button>
            <button type="button" class="btn btn-secondary btn-sm">Hapus</button>
        </div>

        <!-- Seksi Menampilkan Card Mata Pelajaran -->
        <div class="row justify-content-center">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-6 mb-3">
                    <a href="detail_card.php?id=<?php echo $row['id']; ?>" class="card-link text-decoration-none">
                        <div class="card custom-card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Gambar Placeholder">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['subject_name']); ?></h5>
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
