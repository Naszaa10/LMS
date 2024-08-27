<?php
session_start();
include '../db.php';

// Ambil kelas_id dari sesi siswa yang sedang login
$kelas_id = $_SESSION['kelas_id'];
$nis_siswa = $_SESSION['nis_siswa'];

// Query untuk mendapatkan daftar mata pelajaran berdasarkan kelas
$sql = "
    SELECT mp.kode_mapel, mp.nama_mapel 
    FROM mata_pelajaran mp
    JOIN jadwal j ON mp.kode_mapel = j.kode_mapel
    WHERE j.id_kelas = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $kelas_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../navbar/navSiswa.php'; ?>
    <div id="mainContent" class="container mt-4">
        <h2>Dashboard Siswa</h2>
        <h4>Mata Pelajaran</h4>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['nama_mapel']); ?></h5>
                            <a href="detail_mapel.php?kode_mapel=<?php echo $row['kode_mapel']; ?>&kelas_id=<?php echo $kelas_id; ?>" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        
        <h4>Tugas yang Belum Dikerjakan</h4>
        <ul class="list-group">
            <?php
            // Query untuk mendapatkan tugas yang belum dikerjakan oleh siswa dan terkait dengan kelas siswa
            $sql_tugas = "
                SELECT t.id, t.judul, t.tanggal_tenggat, tp.nama_topik, t.topik_id, mp.kode_mapel
                FROM tugas t
                JOIN topik tp ON t.topik_id = tp.id
                JOIN mata_pelajaran mp ON tp.kode_mapel = mp.kode_mapel
                JOIN jadwal j ON mp.kode_mapel = j.kode_mapel
                LEFT JOIN pengumpulan_tugas pt ON t.id = pt.topik_id AND pt.nis_siswa = ?
                WHERE j.id_kelas = ? AND pt.id IS NULL AND tp.kelas_id = ?
            ";
            $stmt_tugas = $conn->prepare($sql_tugas);
            $stmt_tugas->bind_param("sii", $nis_siswa, $kelas_id, $kelas_id);
            $stmt_tugas->execute();
            $result_tugas = $stmt_tugas->get_result();

            while ($tugas = $result_tugas->fetch_assoc()): ?>
                <li class="list-group-item">
                    <h6><?php echo htmlspecialchars($tugas['judul']); ?></h6>
                    <p><?php echo htmlspecialchars($tugas['nama_topik']); ?> - Tenggat: <?php echo htmlspecialchars($tugas['tanggal_tenggat']); ?></p>
                    <a href="detail_mapel.php?kode_mapel=<?php echo $tugas['kode_mapel']; ?>&kelas_id=<?php echo $kelas_id; ?>&topik_id=<?php echo $tugas['topik_id']; ?>" class="btn btn-secondary">Kerjakan Tugas</a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>

<?php
$conn->close();
?>
