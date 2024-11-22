<?php
include '../db.php';

// Menangani data formulir jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_guru'])) {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $jurusan = $_POST['jurusan'];
    $foto_profil = $_POST['foto_profil'];

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Menyusun perintah SQL untuk memasukkan data
    $sql = "INSERT INTO guru (nip, nama_guru, password, email, id_jurusan, foto_profil) VALUES (?, ?, ?, ?, ?, ?)";

    // Menyiapkan statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssis", $nip, $nama, $hashed_password, $email, $jurusan, $foto_profil);

    // Menjalankan statement
    if ($stmt->execute()) {
        header("Location: dataGuru.php");
        exit();
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
    <link rel="stylesheet" href="..\css\dataGuruSiswa.css">
</head>
<body>
    <?php include '../navbar/navAdmin.php'; ?>

    <div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Formulir Tambah Akun Guru</h2>
        </div>
        <div class="form-card">

            <form action="" method="post">
                <input type="hidden" id="foto_profil" name="foto_profil" value="user.jpg">
                <div>
                    <label for="nip">NIP:</label>
                    <input type="text" id="nip" name="nip" class="form-control" required>
                </div>

                <div>
                    <label for="nama">Nama Guru:</label>
                    <input type="text" id="nama" name="nama" class="form-control" required>
                </div>

                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="jurusan">Jurusan:</label>
                    <select id="jurusan" name="jurusan" class="form-control" required>
                        <option value="">Pilih Jurusan</option>
                        <?php echo $jurusan_options; ?>
                    </select>
                </div>
                
                    <div style="grid-column: 2 / 3; text-align: right;">
                        <button type="submit" name="submit_guru" class="btn btn-primary">Tambah Akun</button>
                    </div>
                
            </form>
        </div>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>
