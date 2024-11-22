<?php
// Koneksi ke database
include '../db.php';

// Ambil semua kelas
$queryKelas = "SELECT * FROM kelas";
$resultKelas = mysqli_query($conn, $queryKelas);

// Jika kelas dipilih
$id_kelas_terpilih = isset($_GET['id_kelas']) ? $_GET['id_kelas'] : null;

// Ambil data siswa berdasarkan kelas yang dipilih
if ($id_kelas_terpilih) {
    // JOIN antara tabel siswa, kelas, dan jurusan untuk menampilkan nama_kelas dan nama_jurusan
    $querySiswa = "
        SELECT siswa.*, kelas.nama_kelas, jurusan.nama_jurusan
        FROM siswa
        JOIN kelas ON siswa.id_kelas = kelas.id_kelas
        JOIN jurusan ON siswa.id_jurusan = jurusan.id_jurusan
        WHERE siswa.id_kelas = '$id_kelas_terpilih'";
    $resultSiswa = mysqli_query($conn, $querySiswa);

    // Fetch current class details
    $queryCurrentClass = "SELECT * FROM kelas WHERE id_kelas = '$id_kelas_terpilih'";
    $resultCurrentClass = mysqli_query($conn, $queryCurrentClass);
    $currentClass = mysqli_fetch_assoc($resultCurrentClass);

    // Determine next classes
    $nextClasses = [];
    if ($currentClass['jenjang'] == '10') {
        $nextClasses[] = '11';
    } elseif ($currentClass['jenjang'] == '11') {
        $nextClasses[] = '12';
    } elseif ($currentClass['jenjang'] == '12') {
        $nextClasses[] = 'Lulus';
    }

    // Fetch available classes
    if (!empty($nextClasses) && $nextClasses[0] != 'Lulus') {
        $queryAvailableClasses = "SELECT * FROM kelas WHERE jenjang IN (" . implode(',', array_map(function ($class) {
            return "'$class'";
        }, $nextClasses)) . ")";
        $resultAvailableClasses = mysqli_query($conn, $queryAvailableClasses);
    }
}

// Jika form untuk update semua kelas disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kelas_lama = $_POST['id_kelas_lama'];

    // Periksa apakah kelas lama adalah kelas 12
    $queryCheckKelasLama = "SELECT jenjang FROM kelas WHERE id_kelas = '$id_kelas_lama'";
    $resultCheckKelasLama = mysqli_query($conn, $queryCheckKelasLama);
    $kelasLama = mysqli_fetch_assoc($resultCheckKelasLama);

    if ($kelasLama['jenjang'] == '12') {
        // Start transaction
        mysqli_begin_transaction($conn);
        
        try {
            // Pindahkan data siswa ke tabel alumni
            $queryInsertAlumni = "
                INSERT INTO alumni (nis, nama_siswa, email, angkatan, id_jurusan, foto_profil)
                SELECT nis, nama_siswa, email, angkatan, id_jurusan, foto_profil
                FROM siswa
                WHERE id_kelas = ?
            ";
            
            $stmt = mysqli_prepare($conn, $queryInsertAlumni);
            mysqli_stmt_bind_param($stmt, "s", $id_kelas_lama);
            $insertSuccess = mysqli_stmt_execute($stmt);
            
            if ($insertSuccess) {
                // Hapus data siswa dari tabel siswa setelah dipindahkan ke alumni
                $queryDeleteSiswa = "DELETE FROM siswa WHERE id_kelas = ?";
                $stmt = mysqli_prepare($conn, $queryDeleteSiswa);
                mysqli_stmt_bind_param($stmt, "s", $id_kelas_lama);
                $deleteSuccess = mysqli_stmt_execute($stmt);
                
                if ($deleteSuccess) {
                    mysqli_commit($conn);
                    echo "<div class='alert alert-success'>Data siswa kelas 12 berhasil dipindahkan ke tabel alumni!</div>";
                } else {
                    throw new Exception("Gagal menghapus data siswa");
                }
            } else {
                throw new Exception("Gagal memindahkan data ke alumni");
            }
        } catch (Exception $e) {
            mysqli_rollback($conn);
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    } else {
        // Update kelas siswa jika bukan kelas 12
        $id_kelas_baru = $_POST['id_kelas_baru'];
        $queryUpdate = "UPDATE siswa SET id_kelas = ? WHERE id_kelas = ?";
        $stmt = mysqli_prepare($conn, $queryUpdate);
        mysqli_stmt_bind_param($stmt, "ss", $id_kelas_baru, $id_kelas_lama);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<div class='alert alert-success'>Semua siswa di kelas berhasil dipindahkan ke kelas baru!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
        }
    }

    // Refresh halaman untuk memperbarui data
    echo "<meta http-equiv='refresh' content='2'>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Kelas Siswa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include '../navbar/navAdmin.php'; ?>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2>Pilih Kelas untuk Menampilkan dan Memperbarui Siswa</h2>
            </div>
            <div class="card-body">
                <form action="" method="GET">
                    <div class="form-group">
                        <label for="kelas">Pilih Kelas:</label>
                        <select name="id_kelas" id="kelas" class="form-control">
                            <option value="">Pilih kelas</option>
                            <?php
                            while ($kelas = mysqli_fetch_assoc($resultKelas)) {
                                $selected = $id_kelas_terpilih == $kelas['id_kelas'] ? 'selected' : '';
                                echo "<option value='{$kelas['id_kelas']}' $selected>{$kelas['jenjang']} {$kelas['nama_kelas']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Tampilkan Siswa</button>
                </form>
            </div>
        </div>

        <?php if ($id_kelas_terpilih && isset($resultSiswa)): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h2>Daftar Siswa di Kelas Terpilih</h2>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Email</th>
                            <th>Angkatan</th>
                            <th>Jurusan</th>
                            <th>Kelas Sekarang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($siswa = mysqli_fetch_assoc($resultSiswa)): ?>
                            <tr>
                                <td><?php echo $siswa['nis']; ?></td>
                                <td><?php echo $siswa['nama_siswa']; ?></td>
                                <td><?php echo $siswa['email']; ?></td>
                                <td><?php echo $siswa['angkatan']; ?></td>
                                <td><?php echo $siswa['nama_jurusan']; ?></td>
                                <td><?php echo $currentClass['jenjang'] . " " . $currentClass['nama_kelas']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h2>Update Status Siswa</h2>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <?php if ($currentClass['jenjang'] == '12'): ?>
                            <div class="alert alert-info">
                                Siswa kelas 12 akan dipindahkan ke tabel alumni setelah lulus
                            </div>
                            <input type="hidden" name="id_kelas_lama" value="<?php echo $id_kelas_terpilih; ?>">
                            <button type="submit" class="btn btn-success">Pindahkan ke Alumni</button>
                        <?php else: ?>
                            <div class="form-group">
                                <label for="id_kelas_baru">Pilih Kelas Baru:</label>
                                <select name="id_kelas_baru" id="id_kelas_baru" class="form-control">
                                    <?php
                                    if (isset($resultAvailableClasses)) {
                                        while ($kelas = mysqli_fetch_assoc($resultAvailableClasses)) {
                                            echo "<option value='{$kelas['id_kelas']}'>{$kelas['jenjang']} {$kelas['nama_kelas']}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" name="id_kelas_lama" value="<?php echo $id_kelas_terpilih; ?>">
                            <button type="submit" class="btn btn-success">Update Semua Siswa ke Kelas Baru</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>