<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerjakan Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
</head>
<body>
<?php
include '../navbar/navSiswa.php';

// Ambil topik_id dan kode_mapel dari URL
$topik_id = $_GET['topik_id'];
$kode_mapel = $_GET['kode_mapel'];

// Pastikan nis_siswa didefinisikan
if (!isset($nis_siswa)) {
    echo "NIS siswa tidak ditemukan.";
    exit;
}

// Query untuk mengambil id_kelas berdasarkan nis_siswa
$query_kelas = "SELECT id_kelas FROM siswa WHERE nis = '$nis_siswa'";
$result_kelas = mysqli_query($conn, $query_kelas);

// Pastikan data id_kelas ditemukan
if ($result_kelas && mysqli_num_rows($result_kelas) > 0) {
    $row_kelas = mysqli_fetch_assoc($result_kelas);
    $id_kelas = $row_kelas['id_kelas'];
} else {
    echo "Kelas tidak ditemukan untuk siswa ini.";
    exit;
}

// Query untuk mendapatkan tugas berdasarkan topik_id
$query_tugas = "
    SELECT id_tugas, judul, deskripsi_tugas, tanggal_tenggat, opsi_tugas, file_tugas
    FROM tugas
    WHERE topik_id = '$topik_id' AND kode_mapel = '$kode_mapel'
";
$result_tugas = mysqli_query($conn, $query_tugas);
$tugas = mysqli_fetch_assoc($result_tugas);
?>

<div class="container mt-4">
    <h2>Mengerjakan Tugas</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($tugas['judul']); ?></h5>
            <p class="card-text">Deskripsi Tugas: <?php echo htmlspecialchars($tugas['deskripsi_tugas']); ?></p>
            <p class="card-text"><strong>Tanggal Tenggat:</strong> <?php echo htmlspecialchars($tugas['tanggal_tenggat']); ?></p>
            
            <!-- Link untuk download file tugas jika ada -->
            <?php if (!empty($tugas['file_tugas'])): ?>
                <?php $file_path = '' . htmlspecialchars($tugas['file_tugas']); ?>
                <?php if (file_exists($file_path)): ?>
                    <p>
                        <strong>Download File Tugas:</strong> 
                        <a href="<?php echo $file_path; ?>" class="btn btn-primary" download>Download</a>
                    </p>
                <?php else: ?>
                    <p class="text-danger">File tidak ditemukan.</p>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Form Mengerjakan Tugas -->
            <form action="kirim_tugas.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="tugas_id" value="<?php echo htmlspecialchars($tugas['id_tugas']); ?>">
                <input type="hidden" name="topik_id" value="<?php echo htmlspecialchars($topik_id); ?>">
                <input type="hidden" name="kode_mapel" value="<?php echo htmlspecialchars($kode_mapel); ?>">
                <input type="hidden" name="nis_siswa" value="<?php echo htmlspecialchars($nis_siswa); ?>">
                <input type="hidden" name="id_kelas" value="<?php echo htmlspecialchars($id_kelas); ?>">

                <!-- Opsi Tugas -->
                <?php if ($tugas['opsi_tugas'] == 'teks'): ?>
                    <div class="mb-3">
                        <label for="jawaban" class="form-label">Jawaban:</label>
                        <textarea class="form-control" id="jawaban" name="jawaban" rows="5"></textarea>
                    </div>
                    <script>
                        CKEDITOR.replace('jawaban');
                    </script>
                <?php elseif ($tugas['opsi_tugas'] == 'upload'): ?>
                    <div class="mb-3">
                        <label for="file_tugas" class="form-label">Unggah File Tugas:</label>
                        <input class="form-control" type="file" id="file_tugas" name="file_tugas">
                    </div>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary">Kirim Tugas</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include '../navbar/navFooterSiswa.php'; ?>
</body>
</html>
