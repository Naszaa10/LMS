<?php
include '../db.php'; // Menghubungkan ke database

// Mendapatkan ID dari URL
$id = $_GET['id'];

// Mengambil data pengumuman berdasarkan ID
$query = "SELECT * FROM pengumuman WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$announcement = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengumuman</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<?php include '../navbar/navAdmin.php'; ?>

<div class="container mt-4">
    <h2>Edit Pengumuman</h2>
    <form action="updatePengumuman.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $announcement['id']; ?>">
        <div class="form-group">
            <label for="judul">Judul Pengumuman:</label>
            <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $announcement['judul_pengumuman']; ?>" required>
        </div>
        <div class="form-group">
            <label for="isi">Isi Pengumuman:</label>
            <textarea class="form-control" id="isi" name="isi" rows="4" required><?php echo $announcement['isi_pengumuman']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="target">Kepada:</label>
            <select class="form-control" id="target" name="target" required>
                <option value="semua" <?php echo $announcement['role'] == 'semua' ? 'selected' : ''; ?>>Semua</option>
                <option value="guru" <?php echo $announcement['role'] == 'guru' ? 'selected' : ''; ?>>Guru</option>
                <option value="siswa" <?php echo $announcement['role'] == 'siswa' ? 'selected' : ''; ?>>Siswa</option>
            </select>
        </div>
        <div style="grid-column: 2 / 3; text-align: right;">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>

<?php include '../navbar/navFooter.php'; ?>
</body>
</html>
