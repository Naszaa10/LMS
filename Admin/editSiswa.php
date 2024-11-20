<?php
include '../db.php';

// Mengecek apakah NIS sudah dikirimkan melalui URL
if (isset($_GET['nis'])) {
    $nis = $_GET['nis'];

    // Mengambil data siswa berdasarkan NIS
    $query = "SELECT * FROM siswa WHERE nis = '$nis'";
    $result = $conn->query($query);
    $data_siswa = $result->fetch_assoc();
}

// Mengambil data kelas untuk dropdown
$kelas_options = "";
$kelas_query = "SELECT id_kelas, nama_kelas, jenjang FROM kelas";
$kelas_result = $conn->query($kelas_query);
if ($kelas_result->num_rows > 0) {
    while ($kelas = $kelas_result->fetch_assoc()) {
        $selected = ($kelas['id_kelas'] == $data_siswa['id_kelas']) ? 'selected' : '';
        $kelas_options .= "<option value='" . htmlspecialchars($kelas['id_kelas']) . "' $selected>" . htmlspecialchars($kelas['jenjang']) . ' ' . htmlspecialchars($kelas['nama_kelas']) . "</option>";
    }
}

// Mengambil data jurusan untuk dropdown
$jurusan_options = "";
$jurusan_query = "SELECT id_jurusan, nama_jurusan FROM jurusan";
$jurusan_result = $conn->query($jurusan_query);
if ($jurusan_result->num_rows > 0) {
    while ($jurusan = $jurusan_result->fetch_assoc()) {
        $selected = ($jurusan['id_jurusan'] == $data_siswa['id_jurusan']) ? 'selected' : '';
        $jurusan_options .= "<option value='" . htmlspecialchars($jurusan['id_jurusan']) . "' $selected>" . htmlspecialchars($jurusan['nama_jurusan']) . "</option>";
    }
}

// Mengecek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_siswa = $_POST['nama_siswa'];
    $email = $_POST['email'];
    $id_kelas = $_POST['id_kelas'];
    $nama_wali_kelas = $_POST['nama_wali_kelas'];
    $jurusan = $_POST['id_jurusan'];
    $angkatan = $_POST['angkatan'];
    $password = $_POST['password'];

    // Jika password diisi, hash password baru
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE siswa SET nama_siswa='$nama_siswa', email='$email', id_kelas='$id_kelas', nama_wali_kelas='$nama_wali_kelas', id_jurusan='$jurusan', angkatan='$angkatan', password='$hashed_password' WHERE nis='$nis'";
    } else {
        // Jika password tidak diubah
        $update_query = "UPDATE siswa SET nama_siswa='$nama_siswa', email='$email', id_kelas='$id_kelas', nama_wali_kelas='$nama_wali_kelas', id_jurusan='$jurusan', angkatan='$angkatan' WHERE nis='$nis'";
    }

    if ($conn->query($update_query)) {
        header('Location: dataSiswa.php'); // Kembali ke halaman data siswa setelah edit
    } else {
        echo "Gagal memperbarui data siswa.";
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="..\css\dataGuruSiswa.css">
</head>
<body>

<?php include '../navbar/navAdmin.php'; ?>

<div class="container mt-4">
    <div class="card mb-3">
        <div class="card-header">
            <h2>Edit Data Siswa</h2>
        </div>
        <div class="form-card">
        <form method="POST" action="">
            
            <div>
                <label for="nis">NIS</label>
                <input type="text" class="form-control" id="nis" name="nis" value="<?php echo htmlspecialchars($data_siswa['nis']); ?>" readonly>
            </div>

            <div>
                <label for="nama_siswa">Nama Siswa</label>
                <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" value="<?php echo htmlspecialchars($data_siswa['nama_siswa']); ?>" required>
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($data_siswa['email']); ?>" required>
            </div>

            <div>
                <label for="id_kelas">Kelas</label>
                <select class="form-control" id="id_kelas" name="id_kelas" required>
                    <?php echo $kelas_options; ?>
                </select>
            </div>

            <div>
                <label for="nama_wali_kelas">Nama Wali Kelas</label>
                <input type="text" class="form-control" id="nama_wali_kelas" name="nama_wali_kelas" value="<?php echo htmlspecialchars($data_siswa['nama_wali_kelas']); ?>" required>
            </div>

            <div>
                <label for="jurusan">Jurusan</label>
                <select class="form-control" id="id_jurusan" name="id_jurusan" required>
                    <?php echo $jurusan_options; ?>
                </select>
            </div>

            <div>
                <label for="angkatan">Angkatan</label>
                <input type="text" class="form-control" id="angkatan" name="angkatan" value="<?php echo htmlspecialchars($data_siswa['angkatan']); ?>" required>
            </div>

            <div>
                <label for="password">Password (kosongkan jika tidak ingin diubah)</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password baru jika ingin mengubah">
            </div>

            <div style="grid-column: 2 / 3; text-align: right; padding:">
                <button type="submit" class="btn btn-warning">Simpan</button>
                <a href="dataSiswa.php" class="btn btn-danger">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include '../navbar/navFooter.php'; ?>

</body>
</html>
