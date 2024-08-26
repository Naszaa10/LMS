<?php
session_start();
include '../db.php';

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

$mapel_id = $_GET['mapel_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $tipe = $_POST['tipe']; // "materi" atau "tugas"
    $isi_materi = $_POST['isi_materi'];
    $tugas_tipe = $_POST['tugas_tipe']; // "upload" atau "ketik"
    $tenggat_waktu = $_POST['tenggat_waktu'];
    $kelas_ids = $_POST['kelas_ids']; // array of selected kelas IDs

    // Proses untuk upload file
    if ($tipe === 'materi' && isset($_FILES['file_materi'])) {
        $file_name = $_FILES['file_materi']['name'];
        $file_tmp = $_FILES['file_materi']['tmp_name'];
        $file_destination = "../uploads/materi/" . $file_name;

        if (move_uploaded_file($file_tmp, $file_destination)) {
            $isi_materi = $file_name; // Simpan nama file di database
        }
    }

    // Insert ke tabel materi atau tugas
    $stmt = $conn->prepare("
        INSERT INTO materi (judul, isi, tipe, tenggat_waktu, tugas_tipe, mata_pelajaran_id) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sssssi", $judul, $isi_materi, $tipe, $tenggat_waktu, $tugas_tipe, $mapel_id);
    $stmt->execute();

    // Ambil ID dari materi/tugas yang baru saja dimasukkan
    $materi_id = $conn->insert_id;

    // Masukkan data ke dalam tabel penghubung antara materi/tugas dan kelas
    foreach ($kelas_ids as $kelas_id) {
        $stmt_kelas = $conn->prepare("
            INSERT INTO materi_kelas (materi_id, kelas_id) 
            VALUES (?, ?)
        ");
        $stmt_kelas->bind_param("ii", $materi_id, $kelas_id);
        $stmt_kelas->execute();
    }

    // Redirect ke halaman detail_mapel
    header("Location: detail_mapel.php?mapel_id=$mapel_id");
    exit();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Materi/Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../navbar/navHeader.php'; ?>
    <div id="mainContent" class="container mt-4">
        <h2>Tambah Materi atau Tugas</h2>
        <form action="tambah_materi_tugas.php?mapel_id=<?php echo $mapel_id; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>

            <div class="mb-3">
                <label for="tipe" class="form-label">Tipe</label>
                <select class="form-select" id="tipe" name="tipe" required>
                    <option value="materi">Materi</option>
                    <option value="tugas">Tugas</option>
                </select>
            </div>

            <div class="mb-3" id="materi-section">
                <label for="isi_materi" class="form-label">Isi Materi</label>
                <textarea class="form-control" id="isi_materi" name="isi_materi" rows="3"></textarea>
                <label for="file_materi" class="form-label mt-2">Atau Upload File</label>
                <input type="file" class="form-control" id="file_materi" name="file_materi">
            </div>

            <div class="mb-3 d-none" id="tugas-section">
                <label for="tugas_tipe" class="form-label">Tipe Tugas</label>
                <select class="form-select" id="tugas_tipe" name="tugas_tipe">
                    <option value="upload">Upload File</option>
                    <option value="ketik">Ketik Tugas</option>
                </select>
                <label for="tenggat_waktu" class="form-label mt-2">Tenggat Waktu</label>
                <input type="datetime-local" class="form-control" id="tenggat_waktu" name="tenggat_waktu">
            </div>

            <div class="mb-3">
                <label for="kelas_ids" class="form-label">Tampilkan untuk Kelas</label>
                <?php
                // Ambil daftar kelas yang diajar oleh guru
                $sqlKelas = "
                    SELECT kelas.id, kelas.nama_kelas 
                    FROM guru_mapel_kelas 
                    JOIN kelas ON guru_mapel_kelas.kelas_id = kelas.id 
                    WHERE guru_mapel_kelas.mata_pelajaran_id = ?
                ";
                $stmtKelas = $conn->prepare($sqlKelas);
                $stmtKelas->bind_param("i", $mapel_id);
                $stmtKelas->execute();
                $resultKelas = $stmtKelas->get_result();

                while ($rowKelas = $resultKelas->fetch_assoc()) {
                    echo '<div class="form-check">';
                    echo '<input class="form-check-input" type="checkbox" name="kelas_ids[]" value="' . $rowKelas['id'] . '">';
                    echo '<label class="form-check-label">' . $rowKelas['nama_kelas'] . '</label>';
                    echo '</div>';
                }
                ?>
            </div>

            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>

<script>
document.getElementById('tipe').addEventListener('change', function () {
    var materiSection = document.getElementById('materi-section');
    var tugasSection = document.getElementById('tugas-section');
    if (this.value === 'materi') {
        materiSection.classList.remove('d-none');
        tugasSection.classList.add('d-none');
    } else {
        materiSection.classList.add('d-none');
        tugasSection.classList.remove('d-none');
    }
});
</script>

<?php
$conn->close();
?>
