<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan admin sudah login
// if (!isset($_SESSION['admin'])) {
//     header("Location: ../login.php");
//     exit();
// }

// Mendapatkan ID kelas dari URL
if (isset($_GET['id_kelas'])) {
    $id_kelas = $_GET['id_kelas'];

    // Ambil data kelas berdasarkan ID untuk mengisi form edit
    $sql = "SELECT kelas.*, tahun_ajaran.tahun_ajaran, jurusan.nama_jurusan 
            FROM kelas 
            INNER JOIN tahun_ajaran ON kelas.id_tahun_ajaran = tahun_ajaran.id_tahun_ajaran 
            INNER JOIN jurusan ON kelas.id_jurusan = jurusan.id_jurusan 
            WHERE kelas.id_kelas = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_kelas);
    $stmt->execute();
    $result = $stmt->get_result();
    $kelas = $result->fetch_assoc();

    if (!$kelas) {
        echo "Kelas tidak ditemukan.";
        exit();
    }
} else {
    echo "ID Kelas tidak valid.";
    exit();
}

// Update data kelas jika form disubmit
if (isset($_POST['update_kelas'])) {
    $nama_kelas = $_POST['nama_kelas'];
    $id_tahun_ajaran = $_POST['id_tahun_ajaran'];
    $id_jurusan = $_POST['id_jurusan'];

    // Query untuk memperbarui data kelas
    $update_sql = "UPDATE kelas SET nama_kelas = ?, id_tahun_ajaran = ?, id_jurusan = ? WHERE id_kelas = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("siii", $nama_kelas, $id_tahun_ajaran, $id_jurusan, $id_kelas);

    if ($stmt->execute()) {
        echo "Data kelas berhasil diperbarui.";
        header("Location: tambahKelas.php"); // Redirect setelah berhasil diupdate
        exit();
    } else {
        echo "Terjadi kesalahan saat memperbarui data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kelas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/tambahmapel.css">
</head>
<body>
    <?php include '../navbar/navAdmin.php'; ?>

    <div id="mainContent" class="container mt-5">
        <div id="guruForm" class="form-card">
            <h2>Edit Kelas</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="nama_kelas">Nama Kelas:</label>
                    <input type="text" id="nama_kelas" name="nama_kelas" class="form-control" value="<?php echo htmlspecialchars($kelas['nama_kelas']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="id_tahun_ajaran">Tahun Ajaran:</label>
                    <select id="id_tahun_ajaran" name="id_tahun_ajaran" class="form-control" required>
                        <?php
                        // Ambil daftar tahun ajaran
                        $tahun_sql = "SELECT * FROM tahun_ajaran";
                        $tahun_result = $conn->query($tahun_sql);
                        while ($tahun = $tahun_result->fetch_assoc()) {
                            $selected = ($tahun['id_tahun_ajaran'] == $kelas['id_tahun_ajaran']) ? 'selected' : '';
                            echo "<option value='" . $tahun['id_tahun_ajaran'] . "' $selected>" . htmlspecialchars($tahun['tahun_ajaran']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_jurusan">Jurusan:</label>
                    <select id="id_jurusan" name="id_jurusan" class="form-control" required>
                        <?php
                        // Ambil daftar jurusan
                        $jurusan_sql = "SELECT * FROM jurusan";
                        $jurusan_result = $conn->query($jurusan_sql);
                        while ($jurusan = $jurusan_result->fetch_assoc()) {
                            $selected = ($jurusan['id_jurusan'] == $kelas['id_jurusan']) ? 'selected' : '';
                            echo "<option value='" . $jurusan['id_jurusan'] . "' $selected>" . htmlspecialchars($jurusan['nama_jurusan']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" name="update_kelas" class="btn btn-primary">Update Kelas</button>
                <a href="tambah_kelas.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>
