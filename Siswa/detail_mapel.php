<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mata Pelajaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/detailSiswa.css">
</head>
<body>
<?php

include '../navbar/navSiswa.php';

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info">' . htmlspecialchars($_SESSION['message']) . '</div>';
    unset($_SESSION['message']);
}

// Get the latest academic year
$query_latest_tahun_ajaran = "SELECT id_tahun_ajaran, tahun_ajaran FROM tahun_ajaran ORDER BY tahun_ajaran DESC LIMIT 1";
$result_latest_tahun_ajaran = mysqli_query($conn, $query_latest_tahun_ajaran);
$row_latest_tahun_ajaran = mysqli_fetch_assoc($result_latest_tahun_ajaran);
$id_tahun_ajaran = $row_latest_tahun_ajaran['id_tahun_ajaran'];

// Ambil kode mapel dari URL
$kode_mapel = $_GET['kode_mapel'];

// Query untuk mendapatkan ID kelas siswa
$query_kelas = "
    SELECT siswa.nis, siswa.id_kelas, kelas.id_kelas, tahun_ajaran.id_tahun_ajaran, tahun_ajaran.tahun_ajaran
    FROM siswa 
    JOIN kelas ON siswa.id_kelas = kelas.id_kelas 
    JOIN tahun_ajaran ON tahun_ajaran.id_tahun_ajaran = kelas.id_tahun_ajaran
    WHERE nis = '$nis_siswa'
";
$result_kelas = mysqli_query($conn, $query_kelas);
$row_kelas = mysqli_fetch_assoc($result_kelas);
$id_kelas = $row_kelas['id_kelas'];

// Query untuk mendapatkan detail mata pelajaran dan nip guru dari tabel jadwal
$query_mapel = "
    SELECT mp.kode_mapel, mp.nama_mapel,
           (SELECT nip FROM jadwal WHERE kode_mapel = mp.kode_mapel AND id_kelas = '$id_kelas' LIMIT 1) AS nip_guru
    FROM mata_pelajaran mp
    WHERE mp.kode_mapel = '$kode_mapel'
    LIMIT 1
";
$result_mapel = mysqli_query($conn, $query_mapel);
$row_mapel = mysqli_fetch_assoc($result_mapel);

// Ambil nip_guru dari hasil query di atas
$nip_guru = $row_mapel['nip_guru'];

// Query untuk mendapatkan nama guru berdasarkan nip_guru
$query_guru = "
    SELECT nama_guru
    FROM guru
    WHERE nip = '$nip_guru'
";
$result_guru = mysqli_query($conn, $query_guru);
$row_guru = mysqli_fetch_assoc($result_guru);

// Query untuk mendapatkan topik berdasarkan kode_mapel, id_kelas, dan tahun ajaran terbaru
$query_topik = "
    SELECT t.topik_id, t.nama_topik
    FROM topik t
    JOIN kelas k ON t.id_kelas = k.id_kelas
    WHERE t.kode_mapel = '$kode_mapel' AND k.id_tahun_ajaran = $id_tahun_ajaran
    ORDER BY t.topik_id
";
$result_topik = mysqli_query($conn, $query_topik);

// Query untuk mendapatkan materi berdasarkan topik_id dan tahun ajaran terbaru
$query_materi = "
    SELECT m.id_materi, m.judul, m.file, m.topik_id
    FROM materi m
    JOIN topik t ON m.topik_id = t.topik_id
    JOIN kelas k ON t.id_kelas = k.id_kelas
    WHERE t.kode_mapel = '$kode_mapel' AND k.id_tahun_ajaran = $id_tahun_ajaran
    ORDER BY m.topik_id
";
$result_materi = mysqli_query($conn, $query_materi);

// Array untuk menyimpan materi berdasarkan topik_id
$materi_by_topik = [];
while ($row_materi = mysqli_fetch_assoc($result_materi)) {
    $materi_by_topik[$row_materi['topik_id']][] = $row_materi;
}

// Query to get tasks along with their deadlines
$query_tugas = "
    SELECT t.id_tugas, t.judul, t.deskripsi_tugas, t.topik_id, t.tanggal_tenggat
    FROM tugas t
    JOIN kelas k ON t.id_kelas = k.id_kelas
    WHERE t.kode_mapel = '$kode_mapel' AND k.id_tahun_ajaran = $id_tahun_ajaran
";
$result_tugas = mysqli_query($conn, $query_tugas);

// Array to store tasks by topik_id with deadlines
$tugas_by_topik = [];
while ($row_tugas = mysqli_fetch_assoc($result_tugas)) {
    $tugas_by_topik[$row_tugas['topik_id']][] = $row_tugas;
}
?>

<!-- Display Topics, Materials, and Tasks -->
<div id="mainContent" class="container mt-4">
    <h2>Detail Mata Pelajaran</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($row_mapel['nama_mapel']); ?></h5>
            <p class="card-text"><strong>Kode Mapel:</strong> <?php echo htmlspecialchars($row_mapel['kode_mapel']); ?></p>
            <p class="card-text"><strong>Nama Guru:</strong> <?php echo htmlspecialchars($row_guru['nama_guru']); ?></p>
            <p class="card-text"><strong>Tahun Ajaran:</strong> <?php echo htmlspecialchars($row_kelas['tahun_ajaran']); ?></p>
        </div>
    </div>

    <!-- Topik dan Materi -->
    <div class="accordion" id="accordionExample">
        <h3>Materi dan Tugas</h3>
        <?php
        while ($row_topik = mysqli_fetch_assoc($result_topik)) {
            $topik_id = $row_topik['topik_id'];
            ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading<?php echo $topik_id; ?>">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $topik_id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $topik_id; ?>">
                        <?php echo htmlspecialchars($row_topik['nama_topik']); ?>
                    </button>
                </h2>
                <div id="collapse<?php echo $topik_id; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $topik_id; ?>" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <!-- Materi Section -->
                        <h4>Materi</h4>
                        <?php if (isset($materi_by_topik[$topik_id])): ?>
                            <?php foreach ($materi_by_topik[$topik_id] as $materi): ?>
                                <div class="mb-3">
                                    <a href="../uploads/<?php echo htmlspecialchars($materi['file']); ?>?id_materi=<?php echo $materi['id_materi']; ?>" class="btn btn-primary" download>
                                        <?php echo htmlspecialchars($materi['judul']); ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Tidak ada materi untuk topik ini.</p>
                        <?php endif; ?>

                    <!-- Tugas Section -->
                    <?php if (isset($tugas_by_topik[$topik_id])): ?>
                        <?php foreach ($tugas_by_topik[$topik_id] as $tugas): ?>
                            <?php
                            // Check if the deadline has passed
                            $current_date = date('Y-m-d');
                            $deadline = $tugas['tanggal_tenggat'];
                            $is_past_deadline = strtotime($current_date) > strtotime($deadline);
                            ?>
                            <div class="mt-2">
                                <?php if ($is_past_deadline): ?>
                                    <button class="btn btn-lg btn-warning" disabled>Sudah Melewati Waktu Pengumpulan</button>
                                <?php else: ?>
                                    <a href="tugas.php?topik_id=<?php echo htmlspecialchars($topik_id); ?>&kode_mapel=<?php echo htmlspecialchars($kode_mapel); ?>" class="btn btn-lg btn-warning">
                                        Kerjakan Tugas
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Tidak ada tugas untuk topik ini.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include '../navbar/navFooterSiswa.php'; ?>
</body>
</html>
