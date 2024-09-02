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
        p.nis_siswa, 
        s.nama_siswa, 
        p.file_path, 
        p.tugas_text,
        p.tanggal_pengumpulan, 
        n.nilai
    FROM 
        pengumpulan_tugas p
    JOIN 
        siswa s ON p.nis_siswa = s.nis
    LEFT JOIN 
        penilaian_tugas n ON p.nis_siswa = n.nis_siswa 
                         AND p.topik_id = n.topik_id 
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor = 1; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($nomor++); ?></td>
                            <td><?php echo htmlspecialchars($row['nis_siswa']); ?></td>
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
                                <?php if ($row['nilai'] === NULL): ?>
                                    Belum Dinilai
                                <?php else: ?>
                                    <?php echo htmlspecialchars($row['nilai']); ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="beri_nilai.php?nis=<?php echo htmlspecialchars($row['nis_siswa']); ?>&topik_id=<?php echo htmlspecialchars($topik_id); ?>&kode_mapel=<?php echo htmlspecialchars($kode_mapel); ?>&id_kelas=<?php echo htmlspecialchars($id_kelas); ?>" class="btn btn-primary">Beri Nilai</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<?php include '../navbar/navFooter.php'; ?>
</html>
