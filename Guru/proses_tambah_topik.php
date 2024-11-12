<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login_guru.php");
    exit();
}

// Ambil data dari form
$nama_topik = $_POST['nama_topik'];
$kode_mapel = $_POST['kode_mapel'];
$id_kelas = $_POST['id_kelas'];
$id_tahun_ajaran = $_POST['id_tahun_ajaran']; // Ambil id_tahun_ajaran dari form

// Query untuk menambahkan topik
$sql = "INSERT INTO topik (nama_topik, kode_mapel, id_kelas, id_tahun_ajaran) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii", $nama_topik, $kode_mapel, $id_kelas, $id_tahun_ajaran);

if ($stmt->execute()) {
    // Set a success message in the session
    session_start();
    $_SESSION['message'] = 'Topik berhasil ditambahkan!';
    $_SESSION['msg_type'] = 'success';

    // Redirect back to detail_mapel.php
    header("Location: detail_mapel.php?kode_mapel=$kode_mapel&kelas_id=$id_kelas");
    exit();
} else {
    // Set an error message in the session
    session_start();
    $_SESSION['message'] = 'Gagal menambahkan topik: ' . $conn->error;
    $_SESSION['msg_type'] = 'error';

    // Redirect back to detail_mapel.php
    header("Location: detail_mapel.php?kode_mapel=$kode_mapel&kelas_id=$id_kelas");
    exit();
}


// Tutup koneksi database
$stmt->close();
$conn->close();
?>
