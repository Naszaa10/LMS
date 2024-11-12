<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login_guru.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kelas = $_POST['kelas'];
    $mataPelajaran = $_POST['mataPelajaran'];
    $tanggalInput = date('Y-m-d'); // Tanggal input saat ini

    // Ambil nip guru dari session
    $nip_guru = $_SESSION['teacher_nip']; 

    foreach ($_POST['nilai'] as $nis => $nilai) {
        $pengetahuan = $_POST['pengetahuan'][$nis] ?? null;
        $keterampilan = $_POST['keterampilan'][$nis] ?? null;
        $predikat = $_POST['predikat'][$nis] ?? null;

        // Ambil tahun ajaran dari tabel kelas
        $queryTahunAjaran = "SELECT id_tahun_ajaran FROM kelas WHERE id_kelas = ?";
        $stmtTahunAjaran = $conn->prepare($queryTahunAjaran);
        $stmtTahunAjaran->bind_param("s", $kelas);
        $stmtTahunAjaran->execute();
        $resultTahunAjaran = $stmtTahunAjaran->get_result();
        $tahunAjaran = $resultTahunAjaran->fetch_assoc()['id_tahun_ajaran'];

        // Query untuk menyimpan atau memperbarui nilai
        $query = "INSERT INTO nilai (nis, kode_mapel, nilai, id_kelas, id_tahun_ajaran, tanggal_input, pengetahuan, keterampilan, predikat, nip)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                  ON DUPLICATE KEY UPDATE 
                      nilai = IF(VALUES(nilai) != nilai, VALUES(nilai), nilai), 
                      pengetahuan = IF(VALUES(pengetahuan) != pengetahuan, VALUES(pengetahuan), pengetahuan), 
                      keterampilan = IF(VALUES(keterampilan) != keterampilan, VALUES(keterampilan), keterampilan), 
                      predikat = IF(VALUES(predikat) != predikat, VALUES(predikat), predikat), 
                      tanggal_input = IF(VALUES(tanggal_input) != tanggal_input, VALUES(tanggal_input), tanggal_input)";

        $stmt = $conn->prepare($query);
        
        // Bind parameter dengan tipe yang benar
        $stmt->bind_param("ssiissiiss", $nis, $mataPelajaran, $nilai, $kelas, $tahunAjaran, $tanggalInput, $pengetahuan, $keterampilan, $predikat, $nip_guru);
        $stmt->execute();
    }

    header("Location: nilaiGuru.php"); // Redirect ke halaman sukses atau yang sesuai
    exit();
}
?>
