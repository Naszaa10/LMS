<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Materi</title>
    <link rel="stylesheet" href="../css/detailMapel.css">
</head>
<body>
<?php include '../navbar/navHeader.php';

// Dapatkan ID materi dan parameter lainnya dari URL
$materi_id = $_GET['materi_id'];
$topik_id = $_GET['topik_id'];
$kode_mapel = $_GET['kode_mapel'];
$id_kelas = $_GET['id_kelas'];

// Ambil data materi berdasarkan ID
$sql = "SELECT * FROM materi WHERE id_materi = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $materi_id);
$stmt->execute();
$result = $stmt->get_result();
$materi = $result->fetch_assoc();

// Ambil nama topik berdasarkan topik_id
$sql_topik = "SELECT nama_topik FROM topik WHERE topik_id = ?";
$stmt_topik = $conn->prepare($sql_topik);
$stmt_topik->bind_param("i", $topik_id);
$stmt_topik->execute();
$result_topik = $stmt_topik->get_result();
$topik = $result_topik->fetch_assoc();
$nama_topik = $topik['nama_topik'];

// Ambil daftar tahun ajaran dari database
$sql_tahun = "SELECT id_tahun_ajaran, tahun_ajaran FROM tahun_ajaran";
$result_tahun = $conn->query($sql_tahun);

// Jika form di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $tahun_ajaran_id = $_POST['tahun_ajaran'];
    $file_lama = $materi['file'];
    $hapus_file = isset($_POST['hapus_file']);

    // Format nama file: nama_topik_nama_materi
    $nama_materi = $judul;
    $nama_file_baru = str_replace(' ', '_', $nama_topik . '_' . $nama_materi);

    // Cek apakah ada file baru yang diunggah atau jika file dihapus
    if ($_FILES['file']['name']) {
        $file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $file_name = $nama_file_baru . '.' . $file_extension;
        $target_directory = "../uploads/materi/";
        $file_path = $target_directory . basename($file_name);

        // Pindahkan file yang diunggah ke direktori tujuan
        if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
            // Hapus file lama jika ada
            if (file_exists($file_lama)) {
                unlink($file_lama);
            }
            $file = $file_path; // Simpan nama file dengan path lengkap
        } else {
            echo "<script>alert('Gagal mengunggah file baru.');</script>";
            exit();
        }
    } elseif ($hapus_file) {
        // Hapus file jika tombol "Hapus File" dipilih
        if (file_exists($file_lama)) {
            unlink($file_lama);
        }
        $file = null; // Kosongkan nilai file
    } else {
        $file = $file_lama; // Gunakan file lama jika tidak ada file baru atau penghapusan
    }

    // Update data materi
    $sql = "UPDATE materi SET judul = ?, file = ?, id_tahun_ajaran = ? WHERE id_materi = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $judul, $file, $tahun_ajaran_id, $materi_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Tugas berhasil diperbarui.";
        header("Location: cek_materi.php?topik_id=$topik_id&kode_mapel=$kode_mapel&id_kelas=$id_kelas");
        exit;
    } else {
        $_SESSION['message'] = "Terjadi kesalahan saat memperbarui tugas.";
    }

}
?>

<div id="mainContent" class="container mt-1">
    <h2>Edit Materi</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="judul">Judul Materi</label>
            <input type="text" class="form-control" name="judul" value="<?php echo htmlspecialchars($materi['judul']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="tahun_ajaran">Tahun Ajaran</label>
            <select name="tahun_ajaran" class="form-control" required>
                <?php while ($row_tahun = $result_tahun->fetch_assoc()): ?>
                    <option value="<?php echo $row_tahun['id_tahun_ajaran']; ?>" <?php if ($materi['id_tahun_ajaran'] == $row_tahun['id_tahun_ajaran']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($row_tahun['tahun_ajaran']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="file">File Tugas</label><br>
            <input type="file" class="form-control-file" id="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip">
            <br><small>File saat ini: <?php echo htmlspecialchars($materi['file']); ?></small>
        </div>
        
        <button type="submit" class="btn btn-primary mt-2">Simpan Perubahan</button>
    </form>
</div>

<?php include '../navbar/navFooter.php'; ?>
</body>
</html>
