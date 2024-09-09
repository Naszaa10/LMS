<?php
include '../db.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kelas = $_POST['kelas'];
    $mataPelajaran = $_POST['mataPelajaran'];
    $tanggalInput = date('Y-m-d'); // Tanggal input saat ini

    foreach ($_POST['nilai'] as $nis => $nilai) {
        $pengetahuan = $_POST['pengetahuan'][$nis] ?? null;
        $keterampilan = $_POST['keterampilan'][$nis] ?? null;
        $predikat = $_POST['predikat'][$nis] ?? null;

        // Ambil tahun ajaran dari tabel siswa
        $queryTahunAjaran = "SELECT tahun_ajaran FROM siswa WHERE nis = ?";
        $stmtTahunAjaran = $conn->prepare($queryTahunAjaran);
        $stmtTahunAjaran->bind_param("s", $nis);
        $stmtTahunAjaran->execute();
        $resultTahunAjaran = $stmtTahunAjaran->get_result();
        $tahunAjaran = $resultTahunAjaran->fetch_assoc()['tahun_ajaran'];

        // Query untuk menyimpan atau memperbarui nilai
        $query = "INSERT INTO nilai (nis, kode_mapel, nilai, id_kelas, tahun_ajaran, tanggal_input, pengetahuan, keterampilan, predikat)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                  ON DUPLICATE KEY UPDATE nilai = VALUES(nilai), pengetahuan = VALUES(pengetahuan), keterampilan = VALUES(keterampilan), predikat = VALUES(predikat), tanggal_input = VALUES(tanggal_input)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssissssss", $nis, $mataPelajaran, $nilai, $kelas, $tahunAjaran, $tanggalInput, $pengetahuan, $keterampilan, $predikat);
        $stmt->execute();
    }

    header("Location: nilaiGuru.php"); // Redirect ke halaman sukses atau yang sesuai
}
?>
