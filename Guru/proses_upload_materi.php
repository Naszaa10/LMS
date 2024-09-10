<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

// Ambil data dari form
$topik_id = $_POST['topik_id'];
$nama_materi = $_POST['nama_materi'];
$file_materi = $_FILES['file_materi'];
$kode_mapel = $_POST['kode_mapel'];
$id_kelas = $_POST['id_kelas'];

// Validasi file
$target_dir = "../uploads/materi/";
$target_file = $target_dir . basename($file_materi["name"]);
$uploadOk = 1;

// Cek apakah file sudah ada
if (file_exists($target_file)) {
    echo "File sudah ada.";
    $uploadOk = 0;
}

// Cek ukuran file
if ($file_materi["size"] > 30000000) { // 30MB
    echo "File terlalu besar.";
    $uploadOk = 0;
}

// Jika upload tidak berhasil
if ($uploadOk == 0) {
    echo "File tidak di-upload.";
// Jika semua validasi lulus, lakukan upload
} else {
    if (move_uploaded_file($file_materi["tmp_name"], $target_file)) {
        // Query untuk menambahkan materi ke database
        $tanggal_unggah = date('Y-m-d H:i:s'); // Format tanggal dengan waktu
        $sql = "INSERT INTO materi (topik_id, judul, file, tanggal_unggah, kode_mapel, id_kelas) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssi", $topik_id, $nama_materi, $target_file, $tanggal_unggah, $kode_mapel, $id_kelas);

        if ($stmt->execute()) {
            // Redirect kembali ke halaman detail_mapel.php
            header("Location: detail_mapel.php?kode_mapel=" . urlencode($kode_mapel) . "&kelas_id=" . urlencode($id_kelas));
            exit();
        } else {
            echo "Gagal menambahkan materi: " . $conn->error;
        }
    } else {
        echo "Gagal meng-upload file.";
    }
}

// Tutup koneksi database
$stmt->close();
$conn->close();
?>
