<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan admin sudah login
// if (!isset($_SESSION['admin'])) {
//     header("Location: ../login.php");
//     exit();
// }

// Menambah kelas
if (isset($_POST['submit_kelas'])) {
    $nama_kelas = $_POST['nama_kelas'];
    $id_tahun_ajaran = $_POST['tahun_ajaran'];
    $id_jurusan = $_POST['jurusan'];

    // Query untuk menambahkan kelas ke database
    $sql = "INSERT INTO kelas (nama_kelas, id_tahun_ajaran, id_jurusan) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $nama_kelas, $id_tahun_ajaran, $id_jurusan);

    if ($stmt->execute()) {
        echo "<script>alert('Kelas berhasil ditambahkan!'); window.location.href='data  Kelas.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan kelas!');</script>";
    }
}

// Mendapatkan daftar tahun ajaran
$tahun_query = "SELECT * FROM tahun_ajaran";
$tahun_result = $conn->query($tahun_query);

// Mendapatkan daftar jurusan
$jurusan_query = "SELECT * FROM jurusan";
$jurusan_result = $conn->query($jurusan_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kelas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/tambahmapel.css"> <!-- Path ke file CSS terpisah -->
</head>
<body>
    <?php include '../navbar/navAdmin.php'; ?>

    <div id="mainContent" class="container mt-5">
        <!-- Formulir Tambah Kelas -->
        <div id="guruForm" class="form-card">
            <h2>Formulir Tambah Kelas</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="nama_kelas">Nama Kelas:</label>
                    <input type="text" id="nama_kelas" name="nama_kelas" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="tahun_ajaran">Tahun Ajaran:</label>
                    <select id="tahun_ajaran" name="tahun_ajaran" class="form-control" required>
                        <option value="">Pilih Tahun Ajaran</option>
                        <?php while ($tahun_row = $tahun_result->fetch_assoc()): ?>
                            <option value="<?php echo $tahun_row['id_tahun_ajaran']; ?>"><?php echo htmlspecialchars($tahun_row['tahun_ajaran']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="jurusan">Jurusan:</label>
                    <select id="jurusan" name="jurusan" class="form-control" required>
                        <option value="">Pilih Jurusan</option>
                        <?php while ($jurusan_row = $jurusan_result->fetch_assoc()): ?>
                            <option value="<?php echo $jurusan_row['id_jurusan']; ?>"><?php echo htmlspecialchars($jurusan_row['nama_jurusan']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <button type="submit" name="submit_kelas" class="btn btn-primary">Tambah Kelas</button>
            </form>
        </div>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>
