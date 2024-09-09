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
session_start();
include '../navbar/navSiswa.php';
include '../db.php';

// Ambil kode mapel dari URL
$kode_mapel = $_GET['kode_mapel'];

// Ambil NIS siswa dari session
$nis_siswa = $_SESSION['nis_siswa'];

// Query untuk mendapatkan ID kelas siswa
$query_kelas = "
    SELECT id_kelas, tahun_ajaran
    FROM siswa 
    WHERE nis = '$nis_siswa'
";
$result_kelas = mysqli_query($conn, $query_kelas);
$row_kelas = mysqli_fetch_assoc($result_kelas);
$id_kelas = $row_kelas['id_kelas'];

// Query untuk mendapatkan detail mata pelajaran dan nip guru dari tabel jadwal
$query_mapel = "
    SELECT mp.kode_mapel, mp.nama_mapel,
           (SELECT nip_guru FROM jadwal WHERE kode_mapel = mp.kode_mapel AND id_kelas = '$id_kelas' LIMIT 1) AS nip_guru
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

// Query untuk mendapatkan topik dan materi berdasarkan kode_mapel dan id_kelas
$query_topik = "
    SELECT t.id, t.nama_topik, m.id AS materi_id, m.judul, m.file
    FROM topik t
    LEFT JOIN materi m ON t.id = m.id
    WHERE t.kode_mapel = '$kode_mapel' AND t.kelas_id = $id_kelas
";
$result_topik = mysqli_query($conn, $query_topik);

// Query untuk mendapatkan tugas yang ada untuk mata pelajaran ini berdasarkan id_kelas
$query_tugas = "
    SELECT t.id, t.judul, t.keterangan, t.tanggal_tenggat, t.opsi_tugas, t.topik_id
    FROM tugas t
    WHERE t.kode_mapel = '$kode_mapel' AND t.kelas_id = $id_kelas
";
$result_tugas = mysqli_query($conn, $query_tugas);
?>

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
        <h3>Materi</h3>
        <?php
        $current_topic_id = null;
        $first_topic = true;
        while ($row_topik = mysqli_fetch_assoc($result_topik)) {
            if ($current_topic_id != $row_topik['id']) {
                if (!$first_topic) {
                    echo '</div></div>';
                }
                $current_topic_id = $row_topik['id'];
                $first_topic = false;
                ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?php echo $current_topic_id; ?>">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $current_topic_id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $current_topic_id; ?>">
                            <?php echo htmlspecialchars($row_topik['nama_topik']); ?>
                        </button>
                    </h2>
                    <div id="collapse<?php echo $current_topic_id; ?>" class="accordion-collapse collapse show" aria-labelledby="heading<?php echo $current_topic_id; ?>" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <?php
            }
            if ($row_topik['materi_id']) {
                ?>
                <div class="mb-3">
                    <a href="../uploads/<?php echo htmlspecialchars($row_topik['file']); ?>" class="btn btn-primary" download><?php echo htmlspecialchars($row_topik['judul']); ?></a>
                </div>
                <?php
            }
        }
        if (!$first_topic) {
            echo '</div></div>';
        }
        ?>
    </div>

    <!-- Tugas -->
    <div>
    <section class="tugas mt-4">
        <h4>Tugas</h4>
        <?php if ($result_tugas && mysqli_num_rows($result_tugas) > 0): ?>
            <?php while ($row_tugas = mysqli_fetch_assoc($result_tugas)): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row_tugas['judul']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($row_tugas['keterangan']); ?></p>
                        <p class="card-text"><strong>Tanggal Tenggat:</strong> <?php echo htmlspecialchars($row_tugas['tanggal_tenggat']); ?></p>
                        
                        <?php if ($row_tugas['opsi_tugas'] == 'teks'): ?>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#submitTugasModal<?php echo $row_tugas['id']; ?>">Kumpulkan Tugas</button>
                            <a href="#"class="btn btn-primary">Lihat Nilai Tugas</a>
                            <!-- Modal for Text Submission -->
                            <div class="modal fade" id="submitTugasModal<?php echo $row_tugas['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Kumpulkan Tugas: <?php echo htmlspecialchars($row_tugas['judul']); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="kirim_tugas.php" method="post">
                                                <input type="hidden" name="tugas_id" value="<?php echo htmlspecialchars($row_tugas['id']); ?>">
                                                <input type="hidden" name="topik_id" value="<?php echo htmlspecialchars($row_tugas['topik_id']); ?>">
                                                <input type="hidden" name="kode_mapel" value="<?php echo htmlspecialchars($kode_mapel); ?>">
                                                <input type="hidden" name="id_kelas" value="<?php echo htmlspecialchars($id_kelas); ?>">
                                                <input type="hidden" name="nis_siswa" value="<?php echo htmlspecialchars($nis_siswa); ?>">
                                                <div class="mb-3">
                                                    <label for="jawaban" class="form-label">Jawaban:</label>
                                                    <textarea class="form-control" id="jawaban" name="jawaban" rows="4" required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php elseif ($row_tugas['opsi_tugas'] == 'upload'): ?>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadTugasModal<?php echo $row_tugas['id']; ?>">Unggah Tugas</button>
                            <a href="#"class="btn btn-primary">Lihat Nilai Tugas</a>
                
                            <!-- Modal for File Upload -->
                            <div class="modal fade" id="uploadTugasModal<?php echo $row_tugas['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Unggah Tugas: <?php echo htmlspecialchars($row_tugas['judul']); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="kirim_tugas.php" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="tugas_id" value="<?php echo htmlspecialchars($row_tugas['id']); ?>">
                                                <input type="hidden" name="topik_id" value="<?php echo htmlspecialchars($row_tugas['topik_id']); ?>">
                                                <input type="hidden" name="kode_mapel" value="<?php echo htmlspecialchars($kode_mapel); ?>">
                                                <input type="hidden" name="id_kelas" value="<?php echo htmlspecialchars($id_kelas); ?>">
                                                <input type="hidden" name="nis_siswa" value="<?php echo htmlspecialchars($nis_siswa); ?>">
                                                <div class="mb-3">
                                                    <label for="file_upload" class="form-label">Unggah File:</label>
                                                    <input class="form-control" type="file" id="file_upload" name="file_upload" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Kirim Tugas</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Tidak ada tugas untuk mata pelajaran ini.</p>
        <?php endif; ?>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

</body>
<?php
    include '../navbar/navFooter.php';
    ?>
</html>
