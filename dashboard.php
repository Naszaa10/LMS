<?php
session_start();
include 'db.php';

// Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Cek Role Pengguna
$role = $_SESSION['role'];

// Mengirimkan Ke Halaman Index Sesuai Role
if ($role == 'teacher') {
    header("Location: Guru/index.php");
    exit();
} elseif ($role == 'student') {
    header("Location: Siswa/index.php");
    exit();
} elseif ($role == 'admin') {
    header("Location: Admin/index.php");
    exit();
} else {
    // Jika Role Tidak Tersedia Maka Kembali Ke login
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
