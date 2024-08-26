<?php
session_start();
include '../db.php';

// Ambil ID mata pelajaran dari URL
$mapel_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Ambil data mata pelajaran berdasarkan ID
$sql_mapel = "SELECT * FROM mata_pelajaran WHERE id = ?";
$stmt_mapel = $conn->prepare($sql_mapel);
$stmt_mapel->bind_param("i", $mapel_id);
$stmt_mapel->execute();
$result_mapel = $stmt_mapel->get_result();
$mapel = $result_mapel->fetch_assoc();

// Ambil kelas yang diajar oleh guru untuk mata pelajaran ini
$sql_kelas = "SELECT kelas.id, kelas.nama_kelas FROM guru_mapel_kelas 
              JOIN kelas ON guru_mapel_kelas.kelas_id = kelas.id 
              WHERE guru_mapel_kelas.mata_pelajaran_id = ? AND guru_mapel_kelas.guru_id = ?";
$stmt_kelas = $conn->prepare($sql_kelas);
$stmt_kelas->bind_param("is", $mapel_id, $_SESSION['teacher_nip']);
$stmt_kelas->execute();
$result_kelas = $stmt_kelas->get_result();

// Jika form materi/tugas disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $topik_id = $_POST['topik_id'];
    $judul = $_POST['judul'];
    $deadline = $_POST['deadline'];
    $jenis = $_POST['jenis']; // 'materi' atau 'tugas'
    $jenis_upload = $_POST['jenis_upload']; // 'text' atau 'file'
    $content = $_POST['content'];
    $file = $_FILES['file']['name'];
    $hide = isset($_POST['hide']) ? 1 : 0;
    $kelas_ids = $_POST['kelas'];

    // Upload file jika ada
    if ($jenis_upload == 'file' && $file) {
        $target_dir = "../uploads/$jenis/";
        $target_file = $target_dir . basename($file);
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
        $content = $file; // Simpan nama file di database
    }

    // Simpan materi atau tugas untuk setiap kelas yang dipilih
    foreach ($kelas_ids as $kelas_id) {
        $sql = "INSERT INTO $jenis (mata_pelajran_id, topik_id, kelas_id, judul, content, deadline, hide) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiisssi", $mapel_id, $topik_id, $kelas_id, $judul, $content, $deadline, $hide);
        $stmt->execute();
    }

    header("Location: detail_mapel.php?id=$mapel_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mata Pelajaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../navbar/navHeader.php'; ?>

    <div id="mainContent" class="container mt-4">
        <h1>Detail Mata Pelajaran: <?php echo htmlspecialchars($mapel['nama_mapel']); ?></h1>

        <!-- Seksi menampilkan 16 topik -->
        <div class="row mt-4">
            <?php for ($i = 1; $i <= 16; $i++): ?>
                <div class="col-md-3 mb-3">
                    <div class="card custom-card">
                        <div class="card-body">
                            <h5 class="card-title">Topik <?php echo $i; ?></h5>
                            <!-- Tombol untuk membuka form upload materi/tugas -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal" data-topik="<?php echo $i; ?>">
                                Tambah Materi/Tugas
                            </button>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Modal Upload Materi/Tugas -->
        <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="detail_mapel.php?id=<?php echo $mapel_id; ?>" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadModalLabel">Tambah Materi/Tugas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="topik_id" name="topik_id">
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="judul" name="judul" required>
                            </div>
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis</label>
                                <select class="form-select" id="jenis" name="jenis" required>
                                    <option value="materi">Materi</option>
                                    <option value="tugas">Tugas</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_upload" class="form-label">Jenis Upload</label>
                                <select class="form-select" id="jenis_upload" name="jenis_upload" required>
                                    <option value="text">Teks</option>
                                    <option value="file">File</option>
                                </select>
                            </div>
                            <div class="mb-3" id="content_input">
                                <label for="content" class="form-label">Konten</label>
                                <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                            </div>
                            <div class="mb-3" id="file_input" style="display:none;">
                                <label for="file" class="form-label">File</label>
                                <input type="file" class="form-control" id="file" name="file">
                            </div>
                            <div class="mb-3" id="deadline_input" style="display:none;">
                                <label for="deadline" class="form-label">Deadline</label>
                                <input type="datetime-local" class="form-control" id="deadline" name="deadline">
                            </div>
                            <div class="mb-3">
                                <label for="kelas" class="form-label">Pilih Kelas</label>
                                <?php while ($kelas = $result_kelas->fetch_assoc()): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kelas[]" value="<?php echo $kelas['id']; ?>" id="kelas<?php echo $kelas['id']; ?>">
                                        <label class="form-check-label" for="kelas<?php echo $kelas['id']; ?>">
                                            <?php echo htmlspecialchars($kelas['nama_kelas']); ?>
                                        </label>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="hide" name="hide">
                                <label class="form-check-label" for="hide">Sembunyikan</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <?php include '../navbar/navFooter.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mengatur modal dengan data topik yang dipilih
        var uploadModal = document.getElementById('uploadModal')
        uploadModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var topik = button.getAttribute('data-topik')
            var modalTitle = uploadModal.querySelector('.modal-title')
            var topikInput = uploadModal.querySelector('#topik_id')

            modalTitle.textContent = 'Tambah Materi/Tugas untuk Topik ' + topik
            topikInput.value = topik
        })

        // Menyesuaikan input berdasarkan jenis upload yang dipilih
        document.getElementById('jenis_upload').addEventListener('change', function () {
            var jenis_upload = this.value
            var content_input = document.getElementById('content_input')
            var file_input = document.getElementById('file_input')

            if (jenis_upload === 'file') {
                content_input.style.display = 'none'
                file_input.style.display = 'block'
            } else {
                content_input.style.display = 'block'
                file_input.style.display = 'none'
            }
        })

        // Tampilkan/Non-aktifkan input deadline berdasarkan jenis yang dipilih
        document.getElementById('jenis').addEventListener('change', function () {
            var jenis = this.value
            var deadline_input = document.getElementById('deadline_input')

            if (jenis === 'tugas') {
                deadline_input.style.display = 'block'
            } else {
                deadline_input.style.display = 'none'
            }
        })
    </script>
</body>
</html>
