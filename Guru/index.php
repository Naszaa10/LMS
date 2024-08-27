<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

$nip = $_SESSION['teacher_nip'];

// Query untuk mendapatkan data jadwal berdasarkan NIP guru
$sql = "
    SELECT jadwal.id, kelas.nama_kelas, mata_pelajaran.nama_mapel, mata_pelajaran.kode_mapel, jadwal.id_kelas, jadwal.hari, jadwal.waktu_mulai, jadwal.waktu_selesai
    FROM jadwal, kelas, mata_pelajaran
    WHERE jadwal.id_kelas = kelas.id AND jadwal.kode_mapel = mata_pelajaran.kode_mapel AND jadwal.nip_guru = ? 
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nip);
$stmt->execute();
$result = $stmt->get_result();
?>


<?php include '../navbar/navHeader.php'; ?>
<body>
    <div id="mainContent" class="container mt-4">
        <h2>Jadwal Mengajar</h2>
        <div class="row justify-content-center">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-6 mb-3">
                    <a href="detail_mapel.php?kode_mapel=<?php echo $row['kode_mapel']; ?>&kelas_id=<?php echo $row['id_kelas']; ?>">
                        <div class="card custom-card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Gambar Placeholder">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['nama_mapel']); ?></h5>
                                <p class="card-text">Kelas: <?php echo htmlspecialchars($row['nama_kelas']); ?></p>
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
