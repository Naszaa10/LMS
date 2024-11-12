<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mata Pelajaran</title>
    <link rel="stylesheet" href="../css/detailMapel.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<?php include '../navbar/navHeader.php';

if (isset($_SESSION['message'])) {
    echo '<script type="text/javascript">';
    echo 'alert("' . addslashes($_SESSION['message']) . '");'; // Use addslashes to escape any quotes
    echo '</script>';
    unset($_SESSION['message']); // Clear the message after displaying
}

$nip = $_SESSION['teacher_nip'];

// Mendapatkan detail mata pelajaran
$kode_mapel = $_GET['kode_mapel'];
$id_kelas = $_GET['kelas_id'];

// Mendapatkan tahun ajaran terbaru
$query_tahun_ajaran = "SELECT id_tahun_ajaran FROM tahun_ajaran ORDER BY tahun_ajaran DESC LIMIT 1";
$result_tahun_ajaran = mysqli_query($conn, $query_tahun_ajaran);
$row_tahun_ajaran = mysqli_fetch_assoc($result_tahun_ajaran);
$id_tahun_ajaran = $row_tahun_ajaran['id_tahun_ajaran'];

$query_kelas = "
    SELECT kelas.id_kelas, tahun_ajaran.tahun_ajaran
    FROM kelas JOIN tahun_ajaran ON tahun_ajaran.id_tahun_ajaran = kelas.id_tahun_ajaran
    WHERE id_kelas = '$id_kelas'
";
$result_kelas = mysqli_query($conn, $query_kelas);
$row_kelas = mysqli_fetch_assoc($result_kelas);

$sql = "
    SELECT mata_pelajaran.nama_mapel, mata_pelajaran.kode_mapel
    FROM mata_pelajaran
    WHERE mata_pelajaran.kode_mapel = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $kode_mapel);
$stmt->execute();
$result = $stmt->get_result();
$mapel = $result->fetch_assoc();
?>

    <div id="mainContent" class="container mt-1">
        <h2>Detail Mata Pelajaran</h2>
        <p>Kode Mata Pelajaran: <?php echo htmlspecialchars($kode_mapel); ?></p>
        <p>Nama Mata Pelajaran: <?php echo htmlspecialchars($mapel['nama_mapel']); ?></p>
        <p>Tahun Ajaran: <?php echo htmlspecialchars($row_kelas['tahun_ajaran']); ?></p>

        <!-- Button untuk membuka modal tambah topik -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahTopikModal" title="Add">
        <i class="fa fa-table"></i> Tambah Topik</button>

        <!-- Modal Tambah Topik -->
        <div class="modal fade" id="tambahTopikModal" tabindex="-1" role="dialog" aria-labelledby="tambahTopikModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahTopikModalLabel">Tambah Topik</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="proses_tambah_topik.php" method="post">
                            <div class="form-group">
                                <label for="nama_topik">Nama Topik</label>
                                <input type="text" class="form-control" id="nama_topik" name="nama_topik" required>
                            </div>
                            <input type="hidden" name="kode_mapel" value="<?php echo htmlspecialchars($kode_mapel); ?>">
                            <input type="hidden" name="id_kelas" value="<?php echo htmlspecialchars($id_kelas); ?>">
                            <input type="hidden" name="id_tahun_ajaran" value="<?php echo htmlspecialchars($id_tahun_ajaran); ?>"> <!-- Added hidden input -->
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Menampilkan topik yang ada -->
        <?php
        $sql = "SELECT * FROM topik WHERE kode_mapel = ? AND id_kelas = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $kode_mapel, $id_kelas);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>
        <div class="row mt-4">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['nama_topik']); ?></h5>
                                <a href="#" class="btn btn-custom upload" data-toggle="modal" data-target="#uploadMateriModal" data-topik-id="<?php echo $row['topik_id']; ?>">
                                    Upload Materi
                                </a>
                                <a href="cek_materi.php?topik_id=<?php echo $row['topik_id']; ?>&kode_mapel=<?php echo htmlspecialchars($kode_mapel); ?>&id_kelas=<?php echo htmlspecialchars($id_kelas); ?>" class="btn btn-info">
                                    Cek Materi
                                </a>
                                <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#tugasModal" data-topik-id="<?php echo $row['topik_id']; ?>">
                                    Tugas
                                </a>
                                <a href="cek_tugas.php?topik_id=<?php echo $row['topik_id']; ?>&kode_mapel=<?php echo htmlspecialchars($kode_mapel); ?>&id_kelas=<?php echo htmlspecialchars($id_kelas); ?>" class="btn btn-success">
                                    Cek Tugas
                                </a>
                                <a href="cek_pengumpulan_tugas.php?topik_id=<?php echo $row['topik_id']; ?>&kode_mapel=<?php echo htmlspecialchars($kode_mapel); ?>&id_kelas=<?php echo htmlspecialchars($id_kelas); ?>" class="btn btn-warning">
                                    Cek Pengumpulan
                                </a>
                                <a href="hapus_topik.php?topik_id=<?php echo $row['topik_id']; ?>&kode_mapel=<?php echo htmlspecialchars($kode_mapel); ?>&id_kelas=<?php echo htmlspecialchars($id_kelas); ?>" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus topik ini?');">
                                    Hapus<br>Topik
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Tidak ada topik ditemukan.</p>
            <?php endif; ?>
        </div>

    <!-- Modal Upload Materi -->
    <div class="modal fade" id="uploadMateriModal" tabindex="-1" role="dialog" aria-labelledby="uploadMateriModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadMateriModalLabel">Upload Materi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="proses_upload_materi.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="kode_mapel" value="<?php echo htmlspecialchars($kode_mapel); ?>">
                        <input type="hidden" name="id_kelas" value="<?php echo htmlspecialchars($id_kelas); ?>">
                        <input type="hidden" name="id_tahun_ajaran" value="<?php echo htmlspecialchars($id_tahun_ajaran); ?>"> <!-- Added hidden input -->
                        <input type="hidden" name="topik_id" id="uploadMateriTopikId">
                        <div class="form-group">
                            <label for="nama_materi">Nama Materi</label>
                            <input type="text" class="form-control" id="nama_materi" name="nama_materi" required>
                        </div>
                        <div class="form-group">
                            <label for="file_materi">File Materi</label>
                            <input type="file" class="form-control-file" id="file_materi" name="file_materi" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tugas -->
    <div class="modal fade" id="tugasModal" tabindex="-1" role="dialog" aria-labelledby="tugasModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tugasModalLabel">Tambah Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="proses_tambah_tugas.php" method="post" enctype="multipart/form-data">  
                        <input type="hidden" name="kode_mapel" value="<?php echo htmlspecialchars($kode_mapel); ?>">
                        <input type="hidden" name="id_kelas" value="<?php echo htmlspecialchars($id_kelas); ?>">
                        <input type="hidden" name="id_tahun_ajaran" value="<?php echo htmlspecialchars($id_tahun_ajaran); ?>"> <!-- Added hidden input -->
                        <input type="hidden" name="topik_id" id="tugasTopikId">
                        <div class="form-group">
                            <label for="nama_tugas">Nama Tugas</label>
                            <input type="text" class="form-control" id="nama_tugas" name="nama_tugas" required>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi_tugas">Deskripsi Tugas</label>
                            <textarea class="form-control" id="deskripsi_tugas" name="deskripsi_tugas" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="jenis_tugas">Jenis Tugas</label>
                            <select class="form-control" id="jenis_tugas" name="jenis_tugas" required>
                                <option value="upload">Upload File</option>
                                <option value="teks">Ketik di Laman</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="file_tugas">File Tugas (opsional)</label>
                            <input type="file" class="form-control-file" id="file_tugas" name="file_tugas">
                        </div>
                        <div class="form-group">
                            <label for="tenggat_waktu">Tenggat Waktu</label>
                            <input type="date" class="form-control" id="tenggat_waktu" name="tenggat_waktu" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#uploadMateriModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Tombol yang diklik
            var topikId = button.data('topik-id'); // Mendapatkan data-topik-id
            var modal = $(this);
            modal.find('#uploadMateriTopikId').val(topikId); // Menetapkan nilai pada input hidden
        });

        $('#tugasModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Tombol yang diklik
            var topikId = button.data('topik-id'); // Mendapatkan data-topik-id
            var modal = $(this);
            modal.find('#tugasTopikId').val(topikId); // Menetapkan nilai pada input hidden
        });
    </script>
</body>
<?php include '../navbar/navFooter.php'; ?>
</html>
