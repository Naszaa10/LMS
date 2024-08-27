<?php
include '../db.php';

// Ambil kode_mapel dan kelas_id dari query string
$kode_mapel = $_GET['kode_mapel'];
$kelas_id = $_GET['kelas_id'];

// Proses form jika data dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_topik = $_POST['nama_topik'];

    // Validasi input
    if (!empty($nama_topik) && !empty($kode_mapel) && !empty($kelas_id)) {
        // Query untuk memasukkan data topik ke dalam database
        $sql = "INSERT INTO topik (nama_topik, kode_mapel, kelas_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $nama_topik, $kode_mapel, $kelas_id); // Perbaiki penempatan parameter
        $stmt->execute();

        // Redirect ke halaman detail_mapel setelah berhasil menambah topik
        header("Location: detail_mapel.php?kode_mapel=$kode_mapel&kelas_id=$kelas_id");
        exit();
    } else {
        $error_message = "Semua kolom harus diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Topik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../navbar/navHeader.php'; ?>
    <div id="mainContent" class="container mt-4">
        <h2>Tambah Topik Baru</h2>

        <!-- Tampilkan pesan error jika ada -->
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Form Tambah Topik -->
        <form action="tambah_topik.php?kode_mapel=<?php echo $kode_mapel; ?>&kelas_id=<?php echo $kelas_id; ?>" method="POST">
            <input type="hidden" name="kode_mapel" value="<?php echo htmlspecialchars($kode_mapel); ?>">
            <input type="hidden" name="kelas_id" value="<?php echo htmlspecialchars($kelas_id); ?>">

            <div class="mb-3">
                <label for="nama_topik" class="form-label">Nama Topik</label>
                <input type="text" name="nama_topik" id="nama_topik" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Topik</button>
        </form>

        <!-- Link kembali ke halaman sebelumnya -->
        <a href="detail_mapel.php?kode_mapel=<?php echo $kode_mapel; ?>&kelas_id=<?php echo $kelas_id; ?>" class="btn btn-secondary mt-3">Kembali</a>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>
