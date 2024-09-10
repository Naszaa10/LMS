<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

$nip = $_SESSION['teacher_nip'];
$topik_id = $_GET['topik_id'];
$kode_mapel = $_GET['kode_mapel'];
$id_kelas = $_GET['id_kelas'];

// Ambil data pengumpulan tugas dengan nilai dari tabel penilaian_tugas
$sql = "
    SELECT 
        p.nis, 
        s.nama_siswa, 
        p.file_path, 
        p.tugas_text,
        p.tanggal_pengumpulan, 
        n.nilai_tugas,
        p.id_tugas  -- Tambahkan id_tugas di sini
    FROM 
        pengumpulan_tugas p
    JOIN 
        siswa s ON p.nis = s.nis
    LEFT JOIN 
        penilaian_tugas n ON p.nis = n.nis
                         AND p.id_tugas = n.id_tugas
                         AND p.kode_mapel = n.kode_mapel 
                         AND p.id_kelas = n.id_kelas
    WHERE 
        p.topik_id = ? 
        AND p.kode_mapel = ? 
        AND p.id_kelas = ?
";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param("sii", $topik_id, $kode_mapel, $id_kelas);

if (!$stmt->execute()) {
    die('Execute failed: ' . htmlspecialchars($stmt->error));
}

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Pengumpulan Tugas</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/detailMapel.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include '../navbar/navHeader.php'; ?>

    <div id="mainContent" class="container mt-4">
        <h2>Pengumpulan Tugas</h2>
        <form action="proses_nilai.php" method="post">
            <input type="hidden" name="topik_id" value="<?php echo htmlspecialchars($topik_id); ?>">
            <input type="hidden" name="kode_mapel" value="<?php echo htmlspecialchars($kode_mapel); ?>">
            <input type="hidden" name="id_kelas" value="<?php echo htmlspecialchars($id_kelas); ?>">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Jawaban Tugas</th>
                            <th>Tanggal Pengumpulan</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($nomor++); ?></td>
                                <td><?php echo htmlspecialchars($row['nis']); ?></td>
                                <td><?php echo htmlspecialchars($row['nama_siswa']); ?></td>
                                <td>
                                    <?php if ($row['file_path']): ?>
                                        <a href="../uploads/tugas/<?php echo htmlspecialchars($row['file_path']); ?>" download>
                                            <?php echo htmlspecialchars(basename($row['file_path'])); ?>
                                        </a>
                                    <?php elseif ($row['tugas_text']): ?>
                                        <p><?php echo htmlspecialchars($row['tugas_text']); ?></p>
                                    <?php else: ?>
                                        Tidak Ada
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['tanggal_pengumpulan']); ?></td>
                                <td>
                                    <input type="number" name="nilai[<?php echo htmlspecialchars($row['nis']); ?>]" value="<?php echo htmlspecialchars($row['nilai_tugas']); ?>" step="0.1">
                                    <input type="hidden" name="id_tugas[<?php echo htmlspecialchars($row['nis']); ?>]" value="<?php echo htmlspecialchars($row['id_tugas']); ?>">
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Nilai</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<?php include '../navbar/navFooter.php'; ?>
</html>
