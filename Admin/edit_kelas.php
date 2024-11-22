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
    $jenjang = $_POST['jenjang'];

    // Query untuk memperbarui data kelas
    $update_sql = "UPDATE kelas SET nama_kelas = ?, id_tahun_ajaran = ?, id_jurusan = ?, jenjang = ? WHERE id_kelas = ?";
    $stmt = $conn->prepare($update_sql);
    
    // Pastikan id_kelas diisi dari data kelas yang diambil sebelumnya
    $stmt->bind_param("siiii", $nama_kelas, $id_tahun_ajaran, $id_jurusan, $jenjang, $kelas['id_kelas']); 

    if ($stmt->execute()) {
        echo "Data kelas berhasil diperbarui.";
        header("Location: dataKelas.php"); // Redirect setelah berhasil diupdate
        exit();
    } else {
        echo "Terjadi kesalahan saat memperbarui data: " . $stmt->error; // Tampilkan kesalahan
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
    <link rel="stylesheet" href="../css/kelas.css">
</head>
<body>
    <?php include '../navbar/navAdmin.php'; ?>

    <div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Edit Jadwal</h2>
        </div>
    <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="nama_kelas">Nama Kelas:</label>
                    <input type="text" id="nama_kelas" name="nama_kelas" class="form-control" value="<?php echo htmlspecialchars($kelas['nama_kelas']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="jenjang">Jenjang Kelas:</label>
                    <select id="jenjang" name="jenjang" class="form-control" required>
                    <?php
                        // Ambil daftar jenjang unik dari tabel kelas
                        $jenjang_sql = "SELECT DISTINCT jenjang FROM kelas";
                        $jenjang_kelas = $conn->query($jenjang_sql);

                        // Loop untuk menampilkan jenjang, pastikan jenjang hanya muncul 1 kali
                        while ($jenjang = $jenjang_kelas->fetch_assoc()) {
                            // Tentukan apakah jenjang ini yang sedang terpilih
                            $selected = ($jenjang['jenjang'] == $kelas['jenjang']) ? 'selected' : '';
                            
                            // Tampilkan option untuk dropdown
                            echo "<option value='" . $jenjang['jenjang'] . "' $selected>" . htmlspecialchars($jenjang['jenjang']) . "</option>";
                        }
                    ?>

                    </select>
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
                <div style="grid-column: 2 / 3; text-align: right;">
                    <button type="submit" name="update_kelas" class="btn btn-warning">Update Kelas</button>
                    <a href="tambah_kelas.php" class="btn btn-danger">Batal</a>
                </div>
            </form>
        </div>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>
