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

    // Fetch the current class details to determine the next class
    $queryCurrentClass = "SELECT * FROM kelas WHERE id_kelas = '$id_kelas_terpilih'";
    $resultCurrentClass = mysqli_query($conn, $queryCurrentClass);
    $currentClass = mysqli_fetch_assoc($resultCurrentClass);

    // Determine the next class based on the current class
    $nextClasses = [];
    if ($currentClass['jenjang'] == '10') {
        $nextClasses[] = '11';
    } elseif ($currentClass['jenjang'] == '11') {
        $nextClasses[] = '12';
    } elseif ($currentClass['jenjang'] == '12') {
        $nextClasses[] = 'Lulus';
    }

    // Fetch available classes based on the next classes
    $queryAvailableClasses = "SELECT * FROM kelas WHERE jenjang IN (" . implode(',', array_map(function($class) {
        return "'$class'";
    }, $nextClasses)) . ")";
    $resultAvailableClasses = mysqli_query($conn, $queryAvailableClasses);
}

// Jika form untuk update semua kelas disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_kelas_baru'])) {
    $id_kelas_baru = $_POST['id_kelas_baru'];
    $id_kelas_lama = $_POST['id_kelas_lama'];

    // Update seluruh siswa di kelas yang dipilih
    $queryUpdate = "UPDATE siswa SET id_kelas = '$id_kelas_baru' WHERE id_kelas = '$id_kelas_lama'";
    if (mysqli_query($conn, $queryUpdate)) {
        echo "Semua siswa di kelas berhasil dipindahkan ke kelas baru!";
        // Refresh halaman untuk memperbarui data
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Kelas Siswa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/naikKelas.css">
</head>
<body>
    <?php include '../navbar/navAdmin.php'; ?>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2>Pilih Kelas untuk Menampilkan dan Memperbarui Siswa</h2>
            </div>
        
            <div class="card-body">
                <!-- Form untuk memilih kelas -->
                <form action="" method="GET">
                    <div class="form-group">
                        <label for="kelas">Pilih Kelas:</label>
                        <select name="id_kelas" id="kelas" class="form-control">
                            <!-- Opsi default dengan value kosong -->
                            <option value="">Pilih kelas</option>
                            <?php
                            while ($kelas = mysqli_fetch_assoc($resultKelas)) {
                                $selected = $id_kelas_terpilih == $kelas['id_kelas'] ? 'selected' : '';
                                echo "<option value='{$kelas['id_kelas']}' $selected>{$kelas['jenjang']} {$kelas['nama_kelas']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div><button type="submit" class="btn btn-primary">Tampilkan Siswa</button></div>
                </form>
            </div>
        </div>

        <?php if ($id_kelas_terpilih && isset($resultSiswa)): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h2>Daftar Siswa di Kelas Terpilih</h2>
                </div>
                <!-- Tabel daftar siswa -->
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Email</th>
                            <th>Wali Kelas</th>
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
                                <td><?php echo $siswa['nama_wali_kelas']; ?></td>
                                <td><?php echo $siswa['angkatan']; ?></td>
                                <td><?php echo $siswa['nama_jurusan']; ?></td>
                                <td><?php echo $currentClass['jenjang'] . " " . $currentClass['nama_kelas']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Form untuk memperbarui kelas seluruh siswa -->
            <div class="card mt-4">
                <div class="card-header ">
                    <h2>Update Semua Siswa ke Kelas Baru</h2>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="id_kelas_baru">Pilih Kelas Baru:</label>
                            <select name="id_kelas_baru" id="id_kelas_baru" class="form-control">
                                <?php
                                if (isset($resultAvailableClasses)) {
                                    while ($kelas = mysqli_fetch_assoc($resultAvailableClasses)) {
                                        echo "<option value='{$kelas['id_kelas']}'>{$kelas['jenjang']} {$kelas['nama_kelas']}</option>";
                                    }
                                } else {
                                    echo "<option value=''>Tidak ada kelas yang tersedia untuk update</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" name="id_kelas_lama" value="<?php echo $id_kelas_terpilih; ?>">
                        <div><button type="submit" class="btn btn-success">Update Semua Siswa ke Kelas Baru</button></div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
