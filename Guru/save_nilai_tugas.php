<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login_guru.php");
    exit();
}

// Ambil data dari form
$kelas = $_POST['kelas'] ?? null;
$mataPelajaran = $_POST['mataPelajaran'] ?? null;
$nilaiTugas = $_POST['nilai'] ?? [];
$tanggal_penilaian = date("Y-m-d"); // Atur tanggal penilaian saat ini

// Pastikan data kelas dan mata pelajaran tidak kosong
if (!$kelas || !$mataPelajaran) {
    die("Data kelas atau mata pelajaran tidak lengkap.");
}

// Mulai transaksi untuk menghindari kesalahan data
$conn->begin_transaction();

try {
    // Iterasi nilai setiap siswa dan simpan ke database
    foreach ($nilaiTugas as $nis => $nilai) {
        // Tentukan id_tugas yang terkait (misal diambil dari form atau input hidden, disesuaikan)
        $id_tugas = $_POST['id_tugas'] ?? null;

        if (!$id_tugas) {
            die("ID Tugas tidak ditemukan.");
        }

        // Cek apakah nilai sudah ada di tabel
        $queryCheck = "SELECT id_nilai_tugas FROM penilaian_tugas WHERE nis = ? AND id_tugas = ? AND kode_mapel = ? AND id_kelas = ?";
        $stmtCheck = $conn->prepare($queryCheck);
        $stmtCheck->bind_param("sisi", $nis, $id_tugas, $mataPelajaran, $kelas);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            // Jika nilai sudah ada, update nilai tugas dan tanggal penilaian
            $queryUpdate = "UPDATE penilaian_tugas SET nilai_tugas = ?, tanggal_penilaian = ? WHERE nis = ? AND id_tugas = ? AND kode_mapel = ? AND id_kelas = ?";
            $stmtUpdate = $conn->prepare($queryUpdate);
            $stmtUpdate->bind_param("issisi", $nilai, $tanggal_penilaian, $nis, $id_tugas, $mataPelajaran, $kelas);
            $stmtUpdate->execute();
            $stmtUpdate->close();
        } else {
            // Jika nilai belum ada, insert nilai baru
            $queryInsert = "INSERT INTO penilaian_tugas (nis, id_tugas, kode_mapel, id_kelas, nilai_tugas, tanggal_penilaian) VALUES (?, ?, ?, ?, ?, ?)";
            $stmtInsert = $conn->prepare($queryInsert);
            $stmtInsert->bind_param("sisiss", $nis, $id_tugas, $mataPelajaran, $kelas, $nilai, $tanggal_penilaian);
            $stmtInsert->execute();
            $stmtInsert->close();
        }

        $stmtCheck->close();
    }

    // Jika semua operasi berhasil, commit transaksi
    $conn->commit();
    echo "Nilai berhasil disimpan.";
} catch (Exception $e) {
    // Jika terjadi kesalahan, rollback transaksi
    $conn->rollback();
    echo "Terjadi kesalahan: " . $e->getMessage();
}

// Tutup koneksi database
$conn->close();

// Redirect kembali ke halaman nilai tugas
header("Location: nilai_tugas.php");
exit();
?>
