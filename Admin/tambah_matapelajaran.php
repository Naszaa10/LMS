<?php
include '../db.php';

// Menangani data formulir jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari formulir
    $kode_mapel = $_POST['kode_mapel'];
    $nama_mapel = $_POST['nama_mapel'];
    $deskripsi = $_POST['deskripsi'];
    $jenis = $_POST['jenis'];
    
    // Menangani file gambar jika diunggah
    $gambar_mapel = $_FILES['gambar_mapel']['name'];
    $target_dir = "../uploads/gambar_mapel/";
    $target_file = $target_dir . basename($gambar_mapel);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Periksa apakah file yang diupload adalah gambar
    $check = getimagesize($_FILES["gambar_mapel"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<p>File bukan gambar.</p>";
        $uploadOk = 0;
    }

    // Periksa apakah file sudah ada
    if (file_exists($target_file)) {
        echo "<p>Maaf, file sudah ada.</p>";
        $uploadOk = 0;
    }

    // Periksa ukuran file
    if ($_FILES["gambar_mapel"]["size"] > 500000) {
        echo "<p>Maaf, ukuran file terlalu besar.</p>";
        $uploadOk = 0;
    }

    // Hanya mengizinkan format file tertentu
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "<p>Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.</p>";
        $uploadOk = 0;
    }

    // Periksa apakah uploadOk bernilai 0 karena ada kesalahan
    if ($uploadOk == 0) {
        echo "<p>Maaf, file gagal diunggah.</p>";
    // Jika semuanya baik, coba unggah file
    } else {
        if (move_uploaded_file($_FILES["gambar_mapel"]["tmp_name"], $target_file)) {
            echo "<p>File ". htmlspecialchars(basename($_FILES["gambar_mapel"]["name"])). " berhasil diunggah.</p>";
        } else {
            echo "<p>Maaf, terjadi kesalahan saat mengunggah file Anda.</p>";
        }
    }

    // Menyusun perintah SQL untuk memasukkan data
    $sql = "INSERT INTO mata_pelajaran (kode_mapel, nama_mapel, deskripsi, jenis, gambar) 
            VALUES (?, ?, ?, ?, ?)";

    // Menyiapkan statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $kode_mapel, $nama_mapel, $deskripsi, $jenis, $target_file);

    // Menjalankan statement
    if ($stmt->execute()) {
        echo "<p>Mata pelajaran berhasil ditambahkan.</p>";
        header("Location: dataMapel.php");
        exit();
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Menutup statement
    $stmt->close();
}

// Menutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mata Pelajaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/mapel.css">
</head>
<body>
<?php include '../navbar/navAdmin.php'; ?>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h2>Formulir Tambah Mata Pelajaran</h2>
            </div>
            <div class="form-card">
                <form action="tambah_matapelajaran.php" method="post" enctype="multipart/form-data">
                    <div>
                        <label for="gambar_mapel" class="form-label">Background Mata Pelajaran (Gambar):</label>
                        <input type="file" class="form-control" id="gambar_mapel" name="gambar_mapel" accept="image/*" required>
                    </div>

                    <div>
                        <label for="kode_mapel" class="form-label">Kode Mata Pelajaran:</label>
                        <input type="text" class="form-control" id="kode_mapel" name="kode_mapel" required>
                    </div>

                    <div>
                        <label for="nama_mapel" class="form-label">Nama Mata Pelajaran:</label>
                        <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" required>
                    </div>

                    <div >
                        <label for="jenis" class="form-label">Jenis Mata Pelajaran:</label>
                        <select class="form-control" id="jenis" name="jenis" required>
                            <option value="">Pilih Jenis</option>
                            <option value="Teknik Komputer">Teknik Komputer</option>
                            <option value="Teknik Mesin">Teknik Mesin</option>
                            <option value="Teknik Otomotif">Teknik Otomotif</option>
                            <option value="Teknik Listrik">Teknik Listrik</option>
                            <option value="Umum">Umum</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi:</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
                    </div>

                    
                    <div style="grid-column: 2 / 3; text-align: right;">
                        <button type="submit" class="btn btn-primary">Tambah Mata Pelajaran</button>
                    </div>
                    
                </form>
            </div>
    </div>
<?php include '../navbar/navFooter.php'; ?>
</body>
</html>
