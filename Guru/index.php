<?php include '../navbar/navHeader.php'; ?>
<?php

// Query untuk mendapatkan data jadwal berdasarkan NIP guru
$sql = "
    SELECT jadwal.id_jadwal, kelas.nama_kelas, kelas.jenjang, mata_pelajaran.nama_mapel, mata_pelajaran.kode_mapel, mata_pelajaran.gambar, jadwal.id_kelas, jadwal.hari, jadwal.waktu_mulai, jadwal.waktu_selesai
    FROM jadwal, kelas, mata_pelajaran
    WHERE jadwal.id_kelas = kelas.id_kelas AND jadwal.kode_mapel = mata_pelajaran.kode_mapel AND jadwal.nip = ? 
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nip);
$stmt->execute();
$result = $stmt->get_result();
?>

<body class="mapel">
<div id="mainContent" class="main">
        <div class="container mt-4">
            <h1 class="mb-4">Daftar Mata Pelajaran</h1>
        <div class="row justify-content-center">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-6 mb-3">
                    <a href="detail_mapel.php?kode_mapel=<?php echo $row['kode_mapel']; ?>&kelas_id=<?php echo $row['id_kelas']; ?>">
                        <div class="card custom-card">
                            <img src="../gambar/<?php echo $row['gambar']; ?>" class="card-img-top" alt="<?php echo $row['nama_mapel']; ?>">
                            <div class="card-bodyy">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['nama_mapel']); ?></h5>
                                <p class="card-text">Kelas: <?php echo htmlspecialchars($row['jenjang']) . ' ' . htmlspecialchars($row['nama_kelas']); ?></p>
                                <p class="card-text">Hari: <?php echo htmlspecialchars($row['hari']); ?></p>
                                <p class="card-text">Waktu: <?php echo htmlspecialchars($row['waktu_mulai']) . " - " . htmlspecialchars($row['waktu_selesai']); ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Tidak ada jadwal ditemukan.</p>
        <?php endif; ?>
    </div>

    </div>
</body>
<?php include '../navbar/navFooter.php'; ?>
</html>

<?php
// Tutup koneksi database
$conn->close();
?>