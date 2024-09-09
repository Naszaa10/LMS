<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
session_start();
include '../navbar/navSiswa.php';
include '../db.php'; // File koneksi ke database

// Ambil NIS siswa yang login
$nis_siswa = $_SESSION['nis_siswa']; // Sesuaikan dengan variabel session yang kamu gunakan

// Query untuk mendapatkan tugas yang belum dikerjakan oleh siswa
$query_tugas = "
    SELECT * FROM tugas 
    WHERE kelas_id IN (SELECT id_kelas FROM siswa WHERE nis = '$nis_siswa') 
    AND id NOT IN (SELECT tugas_id FROM pengumpulan_tugas WHERE nis_siswa = '$nis_siswa')
";
$result_tugas = mysqli_query($conn, $query_tugas);

// Query untuk mendapatkan mata pelajaran berdasarkan kelas siswa
$query_mapel = "
    SELECT mp.*, 
        (SELECT COUNT(*) FROM materi m 
            JOIN pengunduhan_materi pm ON m.id = pm.materi_id 
            WHERE m.kode_mapel = mp.kode_mapel AND pm.nis = '$nis_siswa') AS total_materi_diunduh,
        (SELECT COUNT(*) FROM tugas t 
            WHERE t.kode_mapel = mp.kode_mapel 
            AND t.id IN (SELECT tugas_id FROM pengumpulan_tugas WHERE nis_siswa = '$nis_siswa')) AS total_tugas_dikumpulkan,
        (SELECT COUNT(*) FROM materi WHERE kode_mapel = mp.kode_mapel) AS total_materi,
        (SELECT COUNT(*) FROM tugas WHERE kode_mapel = mp.kode_mapel) AS total_tugas,
        (SELECT g.nama_guru FROM guru g 
            JOIN jadwal j ON g.nip = j.nip_guru 
            WHERE j.kode_mapel = mp.kode_mapel 
            LIMIT 1) AS nama_guru
    FROM mata_pelajaran mp 
    WHERE mp.kode_mapel IN (
        SELECT kode_mapel FROM jadwal 
        WHERE id_kelas = (SELECT id_kelas FROM siswa WHERE nis = '$nis_siswa')
    )
";
$result_mapel = mysqli_query($conn, $query_mapel);
?>

<!-- Main Content -->
<div id="mainContent" class="container mt-4">
    <!-- Upcoming Tasks -->
    <section class="tasks mb-4">
        <h3>Upcoming Tasks</h3>
        <ul class="list-group">
            <?php while ($row = mysqli_fetch_assoc($result_tugas)): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo htmlspecialchars($row['judul']); ?>
                    <span class="badge bg-primary rounded-pill">Due <?php echo htmlspecialchars($row['tanggal_tenggat']); ?></span>
                </li>
            <?php endwhile; ?>
        </ul>
    </section>

    <!-- Mata Pelajaran Cards -->
    <div class="row justify-content-center pt-3">
        <?php while ($row_mapel = mysqli_fetch_assoc($result_mapel)): 
            // Hitung progres persentase
            $total_materi = $row_mapel['total_materi'];
            $total_tugas = $row_mapel['total_tugas'];
            $total_materi_diunduh = $row_mapel['total_materi_diunduh'];
            $total_tugas_dikumpulkan = $row_mapel['total_tugas_dikumpulkan'];
            $progres_materi = $total_materi > 0 ? ($total_materi_diunduh / $total_materi) * 100 : 0;
            $progres_tugas = $total_tugas > 0 ? ($total_tugas_dikumpulkan / $total_tugas) * 100 : 0;
            $progres_total = ($progres_materi + $progres_tugas) / 2;
        ?>
            <div class="col-md-6 mb-3">
                <a href="detail_mapel.php?kode_mapel=<?php echo htmlspecialchars($row_mapel['kode_mapel']); ?>" class="card-link">
                    <div class="card custom-card">
                        <?php if ($row_mapel['gambar']): ?>
                            <img src="../gambar/<?php echo htmlspecialchars($row_mapel['gambar']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row_mapel['nama_mapel']); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <p class="card-title"><?php echo htmlspecialchars($row_mapel['nama_mapel']); ?></p>
                            <p class="card-text"><?php echo htmlspecialchars($row_mapel['deskripsi']); ?></p>
                            <p class="card-text"><strong>Guru: </strong><?php echo htmlspecialchars($row_mapel['nama_guru']); ?></p>
                            <div class="progress mb-2">
                                <div class="progress-bar" role="progressbar" style="width: <?php echo htmlspecialchars($progres_total); ?>%;" aria-valuenow="<?php echo htmlspecialchars($progres_total); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="card-persentase"><?php echo round($progres_total, 2); ?>% complete</p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<?php
include '../navbar/navFooter.php';
?>
</body>
</html>
