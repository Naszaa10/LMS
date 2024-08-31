<?php
include '../db.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kelas = $_POST['kelas'];
    $mataPelajaran = $_POST['mataPelajaran'];
    $nilaiArray = $_POST['nilai']; // Mengambil nilai dari formulir

    // Ambil tahun ajaran berdasarkan kode_mapel yang dipilih
    $queryTahunAjaran = "SELECT tahun_ajaran FROM mata_pelajaran WHERE kode_mapel = ?";
    $stmtTahunAjaran = $conn->prepare($queryTahunAjaran);
    $stmtTahunAjaran->bind_param("s", $mataPelajaran);
    $stmtTahunAjaran->execute();
    $resultTahunAjaran = $stmtTahunAjaran->get_result();
    $rowTahunAjaran = $resultTahunAjaran->fetch_assoc();
    $tahunAjaran = $rowTahunAjaran['tahun_ajaran'];

    foreach ($nilaiArray as $nis => $nilai) {
        // Jika nilai kosong, lewati penyimpanan
        if ($nilai === '') {
            continue;
        }

        // Cek apakah nilai sudah ada di database
        $queryCheckNilai = "SELECT COUNT(*) AS count FROM nilai WHERE nis = ? AND kode_mapel = ?";
        $stmtCheckNilai = $conn->prepare($queryCheckNilai);
        $stmtCheckNilai->bind_param("is", $nis, $mataPelajaran);
        $stmtCheckNilai->execute();
        $resultCheckNilai = $stmtCheckNilai->get_result();
        $rowCheckNilai = $resultCheckNilai->fetch_assoc();

        if ($rowCheckNilai['count'] == 0) {
            // Jika belum ada, lakukan insert
            $querySaveNilai = "INSERT INTO nilai (nis, kode_mapel, nilai, id_kelas, tahun_ajaran, tanggal_input) 
                               VALUES (?, ?, ?, ?, ?, NOW())";
            $stmtSaveNilai = $conn->prepare($querySaveNilai);
            $stmtSaveNilai->bind_param("isiss", $nis, $mataPelajaran, $nilai, $kelas, $tahunAjaran);
            $stmtSaveNilai->execute();
        }
    }

    // Setelah penyimpanan, arahkan kembali ke halaman input nilai
    header("Location: nilaiGuru.php?status=sukses");
    exit();
}
?>
