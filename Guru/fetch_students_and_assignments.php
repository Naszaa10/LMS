<?php
include '../db.php'; // Koneksi ke database

if (isset($_GET['kelas']) && isset($_GET['mata_pelajaran'])) {
    $kelas = $_GET['kelas'];
    $mata_pelajaran = $_GET['mata_pelajaran'];

    // Query to fetch students and their assignment data
    $query = "SELECT siswa.nis, siswa.nama_siswa, tugas.judul, penilaian_tugas.nilai_tugas
              FROM siswa
              LEFT JOIN penilaian_tugas ON siswa.nis = penilaian_tugas.nis 
                AND penilaian_tugas.kode_mapel = ? 
                AND penilaian_tugas.id_kelas = ?
              LEFT JOIN tugas ON penilaian_tugas.id_tugas = tugas.id_tugas
              WHERE siswa.id_kelas = ?";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(['error' => 'Failed to prepare statement: ' . $conn->error]);
        exit();
    }

    $stmt->bind_param("sss", $mata_pelajaran, $kelas, $kelas);
    $stmt->execute();
    $result = $stmt->get_result();

    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    if (empty($students)) {
        echo json_encode(['message' => 'No data found']);
    } else {
        echo json_encode($students);
    }
} else {
    echo json_encode([]);
}

// Tutup koneksi database
$conn->close();
?>
