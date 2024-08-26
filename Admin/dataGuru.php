<?php
include'../db.php';

// Menangani data formulir jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari formulir
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $jurusan = $_POST['jurusan'];

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Menyusun perintah SQL untuk memasukkan data
    $sql = "INSERT INTO guru (nip, nama_guru, password, email, jurusan) VALUES (?, ?, ?, ?, ?)";

    // Menyiapkan statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nip, $nama, $hashed_password, $email, $jurusan);

    // Menjalankan statement
    if ($stmt->execute()) {
        echo "<p>Akun guru berhasil ditambahkan.</p>";
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
    <title>Tambah Akun Guru</title>
    <link rel="stylesheet" href="../css/tambahmapel.css"> <!-- Pastikan path ke file CSS benar -->
</head>
<body>
    <h1>Formulir Tambah Akun Guru</h1>
    <div class="form-card">
        <form action="dataGuru.php" method="post">
            <label for="nip">NIP:</label>
            <input type="text" id="nip" name="nip" required><br><br>

            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="jurusan">Jurusan:</label>
            <select id="jurusan" name="jurusan" required>
                <option value="">Pilih Jurusan</option>
                <option value="Teknik Komputer">Teknik Komputer</option>
                <option value="Teknik Mesin">Teknik Mesin</option>
                <option value="Teknik Otomotif">Teknik Otomotif</option>
                <option value="Teknik Listrik">Teknik Listrik</option>
                <option value="Umum">Umum</option>
            </select><br><br>

            <input type="submit" value="Tambah Akun">
        </form>
    </div>
</body>
</html>