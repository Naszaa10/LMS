<?php
include '../db.php';

// Dapatkan nilai kode_mapel, kelas_id, dan topik_id dari query parameter
$kode_mapel = $_GET['kode_mapel'];
$kelas_id = $_GET['id_kelas'];
$topik_id = $_GET['topik_id'];

// Cek apakah kode_mapel ada di tabel mata_pelajaran
$query_mapel = "SELECT * FROM mata_pelajaran WHERE kode_mapel = ?";
$stmt_mapel = $conn->prepare($query_mapel);
$stmt_mapel->bind_param('s', $kode_mapel);
$stmt_mapel->execute();
$result_mapel = $stmt_mapel->get_result();
if ($result_mapel->num_rows == 0) {
    die("Kode mapel tidak valid.");
}

$row_mapel = $result_mapel->fetch_assoc();
$nama_mapel = $row_mapel['nama_mapel'];

// Cek apakah kelas_id ada di tabel kelas
$query_kelas = "SELECT * FROM kelas WHERE id_kelas = ?";
$stmt_kelas = $conn->prepare($query_kelas);
$stmt_kelas->bind_param('i', $kelas_id);
$stmt_kelas->execute();
$result_kelas = $stmt_kelas->get_result();
if ($result_kelas->num_rows == 0) {
    die("Kelas ID tidak valid.");
}

$row_kelas = $result_kelas->fetch_assoc();
$nama_kelas = $row_kelas['jenjang'] . ' ' . $row_kelas['nama_kelas'];

// Validasi apakah kelas_id dan topik_id merupakan integer
if (!is_numeric($kelas_id) || !is_numeric($topik_id)) {
    die("ID kelas atau topik tidak valid.");
}

// Query untuk mendapatkan nama topik berdasarkan topik_id
$sql_topik = "SELECT nama_topik FROM topik WHERE topik_id = ?";
$stmt_topik = $conn->prepare($sql_topik);
$stmt_topik->bind_param('i', $topik_id);
$stmt_topik->execute();
$result_topik = $stmt_topik->get_result();

if ($result_topik->num_rows > 0) {
    $row_topik = $result_topik->fetch_assoc();
    $nama_topik = $row_topik['nama_topik'];
} else {
    die("Topik tidak ditemukan.");
}

// Proses form untuk menambah materi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $file = $_FILES['file'];

    // Validasi judul dan file
    if (empty($judul)) {
        echo "<div class='alert alert-danger'>Judul materi tidak boleh kosong.</div>";
    } elseif ($file['error'] != 0) {
        echo "<div class='alert alert-danger'>Terjadi kesalahan saat mengupload file.</div>";
    } else {
        // Tentukan lokasi untuk menyimpan file
        $upload_dir = '../uploads/materi/';
        
        // Ganti nama file menjadi format "topik_nama_materi.extension"
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_file_name = strtolower(str_replace(" ", "_", $nama_topik)) . "_" . strtolower(str_replace(" ", "_", $judul)) . "." . $file_extension;
        $upload_file = $upload_dir . $new_file_name;

        // Validasi apakah file yang diupload adalah file yang diizinkan (misalnya PDF, DOCX, atau PPTX)
        $allowed_extensions = ['pdf', 'docx', 'pptx'];

        if (!in_array($file_extension, $allowed_extensions)) {
            echo "<div class='alert alert-danger'>Format file tidak valid. Hanya PDF, DOCX, atau PPTX yang diperbolehkan.</div>";
        } else {
            // Pindahkan file ke direktori uploads
            if (move_uploaded_file($file['tmp_name'], $upload_file)) {
                // Query untuk menyimpan materi ke database
                $sql_insert = "INSERT INTO materi (judul, file, tanggal_unggah, kode_mapel, topik_id, id_kelas) VALUES (?, ?, CURDATE(), ?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param('ssiii', $judul, $new_file_name, $kode_mapel, $topik_id, $kelas_id);

                if ($stmt_insert->execute()) {
                    echo "<div class='alert alert-success'>Materi berhasil ditambahkan.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Gagal menambahkan materi: " . $stmt_insert->error . "</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Gagal mengupload file.</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Materi - <?php echo htmlspecialchars($nama_mapel); ?> - Kelas <?php echo htmlspecialchars($nama_kelas); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include '../navbar/navAdmin.php'; ?>

<div class="container mt-4">
<h1>Daftar Topik untuk <?php echo htmlspecialchars($nama_mapel); ?> - <?php echo htmlspecialchars($nama_kelas); ?></h1>

    <!-- Form untuk Menambah Materi -->
    <form method="post" enctype="multipart/form-data" class="mb-4">
        <div class="form-group">
            <label for="judul">Judul Materi:</label>
            <input type="text" class="form-control" id="judul" name="judul" required>
        </div>

        <div class="form-group">
            <label for="file">File Materi:</label>
            <input type="file" class="form-control-file" id="file" name="file" required>
        </div>

        <!-- Hidden Input Fields -->
        <input type="hidden" name="kode_mapel" value="<?php echo htmlspecialchars($kode_mapel); ?>">
        <input type="hidden" name="id_kelas" value="<?php echo htmlspecialchars($kelas_id); ?>">
        <input type="hidden" name="id_tahun_ajaran" value="<?php echo htmlspecialchars($id_tahun_ajaran); ?>"> <!-- Added hidden input -->
        <input type="hidden" name="topik_id" value="<?php echo htmlspecialchars($topik_id); ?>">

        <div>
            <button type="submit" class="btn btn-primary">Tambah Materi</button>
        </div>
    </form>
</div>

<?php include '../navbar/navFooter.php'; ?>
</body>
</html>
