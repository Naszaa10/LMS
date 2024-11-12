<?php
session_start();
include '../db.php';

$topik_id = $_GET['topik_id'] ?? '';
$kode_mapel = $_GET['kode_mapel'] ?? '';
$kelas_id = $_GET['id_kelas'] ?? '';

// Hapus materi dan tugas yang terkait dengan topik ini
$sqlMateri = "DELETE FROM materi WHERE topik_id = ?";
$stmtMateri = $conn->prepare($sqlMateri);
$stmtMateri->bind_param("i", $topik_id);
$stmtMateri->execute();

$sqlTugas = "DELETE FROM tugas WHERE topik_id = ?";
$stmtTugas = $conn->prepare($sqlTugas);
$stmtTugas->bind_param("i", $topik_id);
$stmtTugas->execute();

// Hapus topik
$sqlTopik = "DELETE FROM topik WHERE topik_id = ? AND kode_mapel = ? AND id_kelas = ?";
$stmtTopik = $conn->prepare($sqlTopik);
$stmtTopik->bind_param("isi", $topik_id, $kode_mapel, $kelas_id);
$stmtTopik->execute();

// Check if the deletion was successful
if ($stmtTopik->affected_rows > 0) { // Check if any rows were deleted
    $_SESSION['message'] = 'Topik berhasil dihapus!'; // Set success message
    $_SESSION['msg_type'] = 'success'; // Optional: set a type for success
} else {
    $_SESSION['message'] = 'Topik gagal dihapus: ' . $conn->error; // Set error message
    $_SESSION['msg_type'] = 'error'; // Optional: set a type for errors
}

// Redirect ke halaman detail mata pelajaran
header("Location: detail_mapel.php?kode_mapel=$kode_mapel&kelas_id=$kelas_id");
exit();
?>
