<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['tugas_id'])) {
    $tugas_id = $_GET['tugas_id'];

    // Query untuk mengambil nilai tugas
    $query = "
        SELECT p.nilai, p.komentar, p.tanggal_penilaian, t.judul
        FROM penilaian_tugas p
        JOIN tugas t ON p.tugas_id = t.id
        WHERE p.tugas_id = '$tugas_id' AND p.nis_siswa = '{$_SESSION['nis_siswa']}'
    ";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    // Mengembalikan data sebagai JSON
    echo json_encode($data);
}
?>
