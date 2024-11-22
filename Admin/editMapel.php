<?php
include '../db.php';

if (isset($_GET['kode_mapel'])) {
    $kode_mapel = $_GET['kode_mapel'];

    // Ambil data mata pelajaran berdasarkan kode_mapel
    $sql = "SELECT * FROM mata_pelajaran WHERE kode_mapel = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $kode_mapel);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
}

// Menangani update data mata pelajaran
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_mapel = $_POST['kode_mapel'];
    $nama_mapel = $_POST['nama_mapel'];
    $deskripsi = $_POST['deskripsi'];
    $jenis = $_POST['jenis'];

    // Menangani unggahan gambar baru (opsional)
    $gambar_mapel = $_FILES['gambar_mapel']['name'];
    if ($gambar_mapel) {
        $target_dir = "../uploads/gambar_mapel/";
        $target_file = $target_dir . basename($gambar_mapel);
        move_uploaded_file($_FILES["gambar_mapel"]["tmp_name"], $target_file);
    } else {
        $target_file = $data['gambar']; // Gunakan gambar yang sudah ada
    }

    // Update data ke database
    $sql_update = "UPDATE mata_pelajaran SET nama_mapel = ?, deskripsi = ?, jenis = ?, gambar = ? WHERE kode_mapel = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssss", $nama_mapel, $deskripsi, $jenis, $target_file, $kode_mapel);

    if ($stmt_update->execute()) {
        header("Location: dataMapel.php");
        exit();
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt_update->close();
}

// Menutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mata Pelajaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/mapel.css">
</head>
<body>
<?php include '../navbar/navAdmin.php'; ?>
<div class="container mt-4">
        <div class="card mb-2">
        <div class="card-header">
            <h2>Edit Mata Pelajaran</h2>
        </div>
    <div class="form-card">
        
    <form action="editMapel.php?kode_mapel=<?php echo $kode_mapel; ?>" method="post" enctype="multipart/form-data">
        <div>
            <label for="gambar_mapel" class="form-label">Gambar Mata Pelajaran:</label>
            <input type="file" class="form-control" id="gambar_mapel" name="gambar_mapel">
            <img src="<?php echo $data['gambar']; ?>" alt="Gambar Mapel" style="width: 100px; margin-top: 10px;">
        </div>

        <div>
            <label for="kode_mapel" class="form-label">Kode Mata Pelajaran:</label>
            <input type="text" class="form-control" id="kode_mapel" name="kode_mapel" value="<?php echo $data['kode_mapel']; ?>" readonly>
        </div>

        <div>
            <label for="nama_mapel" class="form-label">Nama Mata Pelajaran:</label>
            <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" value="<?php echo $data['nama_mapel']; ?>" required>
        </div>


        <div>
            <label for="jenis" class="form-label">Jenis Mata Pelajaran:</label>
            <select class="form-control" id="jenis" name="jenis" required>
                <option value="">Pilih Jenis</option>
                <option value="Teknik Komputer" <?php if ($data['jenis'] == 'Teknik Komputer') echo 'selected'; ?>>Teknik Komputer</option>
                <option value="Teknik Mesin" <?php if ($data['jenis'] == 'Teknik Mesin') echo 'selected'; ?>>Teknik Mesin</option>
                <option value="Teknik Otomotif" <?php if ($data['jenis'] == 'Teknik Otomotif') echo 'selected'; ?>>Teknik Otomotif</option>
                <option value="Teknik Listrik" <?php if ($data['jenis'] == 'Teknik Listrik') echo 'selected'; ?>>Teknik Listrik</option>
                <option value="Umum" <?php if ($data['jenis'] == 'Umum') echo 'selected'; ?>>Umum</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi:</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?php echo $data['deskripsi']; ?></textarea>
        </div>


        <div style="grid-column: 2 / 3; text-align: right;">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
    </div>
</div>
<?php include '../navbar/navFooter.php'; ?>
</body>
</html>
