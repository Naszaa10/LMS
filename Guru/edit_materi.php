<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

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

// Jika form di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $file_lama = $materi['file'];

    // Cek apakah ada file baru yang diunggah
    if ($_FILES['file']['name']) {
        $file_name = $_FILES['file']['name'];
        $target_directory = "../uploads/materi/";
        $file_path = $target_directory . basename($file_name);

        // Pindahkan file yang diunggah ke direktori tujuan
        if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
            // Jika ada file lama, hapus
            if (file_exists($file_lama)) {
                unlink($file_lama);
            }
            $file = $file_path; // Simpan nama file dengan path lengkap
        } else {
            echo "<script>alert('Gagal mengunggah file baru.');</script>";
            exit();
        }
    } else {
        $file = $file_lama; // Gunakan file lama jika tidak ada file baru
    }

    // Update data materi
    $sql = "UPDATE materi SET judul = ?, file = ? WHERE id_materi = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $judul, $file, $materi_id);

    if ($stmt->execute()) {
        echo "<script>alert('Materi berhasil diperbarui!'); window.location.href='cek_materi.php?topik_id=$topik_id&kode_mapel=$kode_mapel&id_kelas=$id_kelas';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui materi!');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Materi</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/detailMapel.css">
</head>
<?php include '../navbar/navHeader.php'; ?>

<div id="mainContent" class="container mt-4">
    <h2>Edit Materi</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="judul">Judul Materi</label>
            <input type="text" class="form-control" name="judul" value="<?php echo htmlspecialchars($materi['judul']); ?>" required>
        </div>
        <div class="form-group">
            <label for="file">Unggah File Baru (opsional)</label>
            <input type="file" class="form-control" name="file">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
<?php include '../navbar/navFooter.php'; ?>
</html>
