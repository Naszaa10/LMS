<?php
include '../db.php';

// Menangani data formulir jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari formulir
    $nis = $_POST['nis'];
    $nama_siswa = $_POST['nama_siswa'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $id_kelas = $_POST['kelas']; // Pastikan nama ini sesuai dengan nama di formulir

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Menyusun perintah SQL untuk memasukkan data
    $sql = "INSERT INTO siswa (nis, nama_siswa, password, email, id_kelas) VALUES (?, ?, ?, ?, ?)";

    // Menyiapkan statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $nis, $nama_siswa, $hashed_password, $email, $id_kelas);

        // Menjalankan statement
        if ($stmt->execute()) {
            echo "<p>Akun Siswa berhasil ditambahkan.</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        // Menutup statement
        $stmt->close();
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

// Mengambil data kelas untuk dropdown
$kelas_options = "";
$sql = "SELECT id, nama_kelas FROM kelas";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $kelas_options .= "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['nama_kelas']) . "</option>";
    }
} else {
    $kelas_options = "<option value=''>Tidak ada kelas tersedia</option>";
}

// Menutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Akun Siswa</title>
    <link rel="stylesheet" href="../css/tambahmapel.css"> <!-- Pastikan path ke file CSS benar -->
</head>
<body>
    <h1>Formulir Tambah Akun Siswa</h1>
    <div class="form-card">
        <form action="dataSiswa.php" method="post">
            <label for="nip">NIS:</label>
            <input type="text" id="nis" name="nis" required><br><br>

            <label for="nama">Nama:</label>
            <input type="text" id="nama_siswa" name="nama_siswa" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="kelas">Kelas:</label>
            <select id="kelas" name="kelas" required>
                <option value="">Pilih Kelas</option>
                <?php echo $kelas_options; ?>
            </select><br><br>

            <input type="submit" value="Tambah Akun">
        </form>
    </div>
</body>
</html>
