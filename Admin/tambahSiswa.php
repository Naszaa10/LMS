<?php
include '../db.php';

// Menangani data formulir jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_siswa'])) {
    $nis = $_POST['nis'];
    $nama_siswa = $_POST['nama_siswa'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $id_kelas = $_POST['kelas'];
    $walikelas = $_POST['nama_wali_kelas'];
    $jurusan = $_POST['jurusan'];
    $angkatan = $_POST['angkatan'];

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Menyusun perintah SQL untuk memasukkan data
    $sql = "INSERT INTO siswa (nis, nama_siswa, password, email, id_kelas, nama_wali_kelas, jurusan, angkatan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Menyiapkan statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssisss", $nis, $nama_siswa, $hashed_password, $email, $id_kelas, $walikelas, $jurusan, $angkatan);

    // Menjalankan statement
    if ($stmt->execute()) {
        // Redirect ke halaman data siswa setelah berhasil menambah
        header("Location: dataSiswa.php");
        exit();
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Menutup statement
    $stmt->close();
}

// Mengambil data kelas untuk dropdown
$kelas_options = "";
$sql = "SELECT id_kelas, nama_kelas FROM kelas";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $kelas_options .= "<option value='" . htmlspecialchars($row['id_kelas']) . "'>" . htmlspecialchars($row['nama_kelas']) . "</option>";
    }
} else {
    $kelas_options = "<option value=''>Tidak ada kelas tersedia</option>";
}

// Mengambil data jurusan untuk dropdown
$jurusan_options = "";
$sql = "SELECT id_jurusan, nama_jurusan FROM jurusan";
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
    <title>Tambah Akun Siswa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/tambahmapel.css">
</head>
    <?php include '../navbar/navAdmin.php'; ?>

    <div class="container mt-4">
        <div class="form-card">
            <h2>Formulir Tambah Akun Siswa</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="nis">NIS:</label>
                    <input type="text" id="nis" name="nis" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="nama_siswa">Nama:</label>
                    <input type="text" id="nama_siswa" name="nama_siswa" class="form-control" required>
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
                    <label for="kelas">Kelas:</label>
                    <select id="kelas" name="kelas" class="form-control" required>
                        <option value="">Pilih Kelas</option>
                        <?php echo $kelas_options; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nama_wali_kelas">Nama Wali Kelas:</label>
                    <input type="text" id="nama_wali_kelas" name="nama_wali_kelas" class="form-control">
                </div>

                <div class="form-group">
                    <label for="jurusan">Jurusan:</label>
                    <select id="jurusan" name="jurusan" class="form-control" required>
                        <option value="">Pilih Jurusan</option>
                        <?php echo $jurusan_options; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="angkatan">Angkatan:</label>
                    <input type="text" id="angkatan" name="angkatan" class="form-control" required>
                </div>

                <button type="submit" name="submit_siswa" class="btn btn-primary">Tambah Akun</button>
            </form>
        </div>
    </div>
<?php include '../navbar/navFooter.php'; ?>
</html>
