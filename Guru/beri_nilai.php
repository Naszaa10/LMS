<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

$nip = $_SESSION['teacher_nip'];
$nis = $_GET['nis'];
$topik_id = $_GET['topik_id'];
$kode_mapel = $_GET['kode_mapel'];
$id_kelas = $_GET['id_kelas'];

// Ambil data siswa
$sql = "
    SELECT s.nama_siswa 
    FROM siswa s
    WHERE s.nis = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nis);
$stmt->execute();
$siswa_result = $stmt->get_result();
$siswa = $siswa_result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nilai = $_POST['nilai'];
    
    // Ubah koma menjadi titik
    $nilai = str_replace(',', '.', $nilai);
    
    // Pastikan nilai adalah angka desimal
    if (filter_var($nilai, FILTER_VALIDATE_FLOAT) === false) {
        echo "<script>alert('Nilai tidak valid.');</script>";
    } else {
        // Simpan nilai ke database
        $sql = "
            INSERT INTO penilaian_tugas (nis_siswa, topik_id, kode_mapel, id_kelas, nilai, tanggal_penilaian)
            VALUES (?, ?, ?, ?, ?, NOW())
            ON DUPLICATE KEY UPDATE nilai = VALUES(nilai), tanggal_penilaian = NOW()
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdi", $nis, $topik_id, $kode_mapel, $id_kelas, $nilai);
        
        if ($stmt->execute()) {
            echo "<script>alert('Nilai berhasil disimpan.'); window.location.href = 'cek_pengumpulan_tugas.php?topik_id=$topik_id&kode_mapel=$kode_mapel&id_kelas=$id_kelas';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menyimpan nilai.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beri Nilai</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/detailMapel.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include '../navbar/navHeader.php'; ?>

    <div id="mainContent" class="container mt-4">
        <h2>Beri Nilai</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="nama_siswa">Nama Siswa:</label>
                <input type="text" id="nama_siswa" class="form-control" value="<?php echo htmlspecialchars($siswa['nama_siswa']); ?>" disabled>
            </div>
            <div class="form-group">
                <label for="nilai">Nilai:</label>
                <input type="text" id="nilai" name="nilai" class="form-control" placeholder="Masukkan nilai" required>
                <!-- Menggunakan type="text" untuk memungkinkan input dengan koma -->
            </div>
            <button type="submit" class="btn btn-primary">Simpan Nilai</button>
            <a href="cek_pengumpulan_tugas.php?topik_id=<?php echo htmlspecialchars($topik_id); ?>&kode_mapel=<?php echo htmlspecialchars($kode_mapel); ?>&id_kelas=<?php echo htmlspecialchars($id_kelas); ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<?php include '../navbar/navFooter.php'; ?>
</html>
