<?php
include '../db.php  ';
// Menangani data formulir jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari formulir
    $kode_mapel = $_POST['kode_mapel'];
    $nama_mapel = $_POST['nama_mapel'];
    $deskripsi = $_POST['deskripsi'];
    $jenis = $_POST['jenis'];

    // Menyusun perintah SQL untuk memasukkan data
    $sql = "INSERT INTO mata_pelajaran (kode_mapel, nama_mapel, deskripsi, jenis) VALUES (?, ?, ?, ?)";

    // Menyiapkan statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $kode_mapel, $nama_mapel, $deskripsi, $jenis);

    // Menjalankan statement
    if ($stmt->execute()) {
        echo "<p>Mata pelajaran berhasil ditambahkan.</p>";
    } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
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
    <link rel="stylesheet" href="../css/tambahmapel.css"> <!-- Pastikan path ke file CSS benar -->
</head>
<body>
    <h1>Formulir Tambah Mata Pelajaran</h1>
    <div class="form-card">
        <form action="tambah_mapel.php" method="post">
            <label for="kode_mapel">Kode Mata Pelajaran:</label>
            <input type="text" id="kode_mapel" name="kode_mapel" required><br><br>

            <label for="nama_mapel">Nama Mata Pelajaran:</label>
            <input type="text" id="nama_mapel" name="nama_mapel" required><br><br>

            <label for="deskripsi">Deskripsi:</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" required></textarea><br><br>

            <label for="jenis">Mata Pelajaran</label>
            <select id="jenis" name="jenis" required>
                <option value="">Pilih Jenis</option>
                <option value="Teknik Komputer">Teknik Komputer</option>
                <option value="Teknik Mesin">Teknik Mesin</option>
                <option value="Teknik Otomotif">Teknik Otomotif</option>
                <option value="Teknik Listrik">Teknik Listrik</option>
                <option value="Umum">Umum</option>
            </select><br><br>

            <input type="submit" value="Tambah Mata Pelajaran">
        </form>
    </div>
</body>
</html>
