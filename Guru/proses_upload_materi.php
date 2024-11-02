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
$id_tahun_ajaran = $_POST['id_tahun_ajaran']; // Tambahkan id_tahun_ajaran

// Query untuk mendapatkan nama topik
$sql = "SELECT nama_topik FROM topik WHERE topik_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $topik_id);
$stmt->execute();
$result = $stmt->get_result();
$topik = $result->fetch_assoc();

if (!$topik) {
    echo "Topik tidak ditemukan.";
    exit();
}

$nama_topik = $topik['nama_topik'];

// Format nama file
$file_extension = pathinfo($file_materi["name"], PATHINFO_EXTENSION);
$new_file_name = $nama_topik . '_' . $nama_materi . '.' . $file_extension;

$target_dir = "../uploads/materi/";
$target_file = $target_dir . $new_file_name;
$uploadOk = 1;

// Validasi file
if (file_exists($target_file)) {
    echo "<script>alert('File sudah ada. Silakan hapus terlebih dahulu materi sebelumnya.');</script>";
    $uploadOk = 0;
}

// Cek ukuran file
if ($file_materi["size"] > 30000000) { // 30MB
    echo "<script>alert('File terlalu besar. Ukuran maksimal adalah 30MB.');</script>";
    $uploadOk = 0;
}


// Jika upload tidak berhasil
if ($uploadOk == 0) {
    header("Location: detail_mapel.php?kode_mapel=" . urlencode($kode_mapel) . "&kelas_id=" . urlencode($id_kelas) . "&tahun_ajaran=" . urlencode($id_tahun_ajaran));
    exit();
} else {
    if (move_uploaded_file($file_materi["tmp_name"], $target_file)) {
        // Query untuk menambahkan materi ke database
        $tanggal_unggah = date('Y-m-d H:i:s'); // Format tanggal dengan waktu
        $sql = "INSERT INTO materi (topik_id, judul, file, tanggal_unggah, kode_mapel, id_kelas, id_tahun_ajaran) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssii", $topik_id, $nama_materi, $target_file, $tanggal_unggah, $kode_mapel, $id_kelas, $id_tahun_ajaran);

        if ($stmt->execute()) {
            // Jika berhasil, tampilkan alert dan redirect menggunakan JavaScript
            echo "<script>
                alert('Materi berhasil ditambahkan!');
                window.location.href = 'detail_mapel.php?kode_mapel=" . urlencode($kode_mapel) . "&kelas_id=" . urlencode($id_kelas) . "&tahun_ajaran=" . urlencode($id_tahun_ajaran) . "';
            </script>";
            exit();
        } else {
            // Tampilkan pesan kesalahan jika gagal
            echo "<script>
                alert('Gagal menambahkan materi: " . addslashes($conn->error) . "');
            </script>";
        }   
    }     
}

// Tutup koneksi database
$stmt->close();
$conn->close();
?>
