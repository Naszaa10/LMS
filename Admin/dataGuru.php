<?php
include '../db.php';

// Menangani data formulir jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_guru'])) {
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
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Menutup statement
    $stmt->close();
}

// Mengambil Data Jurusan
$jurusan_options = "";
$sql = "SELECT * FROM jurusan";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $jurusan_options .= "<option value='" . htmlspecialchars($row['id_jurusan']) . "'>" . htmlspecialchars($row['nama_jurusan']) . "</option>";
    }
} else {
    $jurusan_options = "<option value=''>Tidak ada jurusan tersedia</option>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Akun Guru</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/tambahmapel.css">
</head>
<body>
    <?php include '../navbar/navAdmin.php'; ?>

    <div class="container mt-4">
        <div class="form-card">
            <h2>Formulir Tambah Akun Guru</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="nip">NIP:</label>
                    <input type="text" id="nip" name="nip" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" id="nama" name="nama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="jurusan">Jurusan:</label>
                    <select id="jurusan" name="jurusan" class="form-control" required>
                        <option value="">Pilih Jurusan</option>
                        <?php echo $jurusan_options; ?>
                    </select>
                </div>

                <button type="submit" name="submit_guru" class="btn btn-primary">Tambah Akun</button>
            </form>
        </div>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>
