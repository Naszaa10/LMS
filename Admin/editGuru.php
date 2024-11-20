<?php
include '../db.php';

if (isset($_GET['nip'])) {
    $nip = $_GET['nip'];

    // Mengambil data guru berdasarkan NIP
    $query = "SELECT * FROM guru WHERE nip = '$nip'";
    $result = $conn->query($query);
    $data_guru = $result->fetch_assoc();
}

// Mengambil semua jurusan untuk dropdown
$jurusan_query = "SELECT id_jurusan, nama_jurusan FROM jurusan";
$jurusan_result = $conn->query($jurusan_query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_guru = $_POST['nama_guru'];
    $email = $_POST['email'];
    $jurusan = $_POST['jurusan'];
    $password = !empty($_POST['password']) ? $_POST['password'] : null;

    // Hash password jika diubah
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE guru SET nama_guru='$nama_guru', email='$email', id_jurusan='$jurusan', password='$hashed_password' WHERE nip='$nip'";
    } else {
        // Jika password tidak diubah, tidak menyertakan kolom password
        $update_query = "UPDATE guru SET nama_guru='$nama_guru', email='$email', id_jurusan='$jurusan' WHERE nip='$nip'";
    }

    if ($conn->query($update_query)) {
        header('Location: dataGuru.php');
    } else {
        echo "Gagal memperbarui data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Guru</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="..\css\dataGuruSiswa.css">
</head>
<body>

<?php include '../navbar/navAdmin.php'; ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Edit Data Guru</h2>
        </div>
        <div class="form-card">
            
        <form method="POST" action="">
            <!-- Menampilkan NIP -->
            <div>
                <label for="nip">NIP</label>
                <input type="text" class="form-control" id="nip" name="nip" value="<?php echo htmlspecialchars($data_guru['nip']); ?>" readonly>
            </div>

            <div>
                <label for="nama_guru">Nama Guru</label>
                <input type="text" class="form-control" id="nama_guru" name="nama_guru" value="<?php echo htmlspecialchars($data_guru['nama_guru']); ?>" required>
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($data_guru['email']); ?>" required>
            </div>

            <div>
                <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="mb-3">
                <label for="jurusan">Jurusan</label>
                <select class="form-control" id="jurusan" name="jurusan" required>
                    <?php while ($row = $jurusan_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['id_jurusan']; ?>" <?php if ($row['id_jurusan'] == $data_guru['id_jurusan']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($row['nama_jurusan']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div style="grid-column: 2 / 3; text-align: right;">
                <button type="submit" class="btn btn-warning">Simpan</button>
                <a href="dataGuru.php" class="btn btn-danger">Batal</a>
            </div>
        </form>
    </div>

    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>
