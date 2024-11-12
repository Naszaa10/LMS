<?php
session_start();
include '../db.php'; // Include database connection

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login.php");
    exit();
}

// Ambil data dari form
$kode_mapel = $_POST['kode_mapel'];
$id_kelas = $_POST['id_kelas'];
$topik_id = $_POST['topik_id'];
$nama_tugas = $_POST['nama_tugas'];
$deskripsi_tugas = $_POST['deskripsi_tugas'];
$jenis_tugas = $_POST['jenis_tugas'];
$tenggat_waktu = $_POST['tenggat_waktu'];
$id_tahun_ajaran = $_POST['id_tahun_ajaran']; 

// Handle file upload
$file_tugas = $_FILES['file_tugas'] ?? null;
$file_path = null;

if ($file_tugas && $file_tugas['error'] === UPLOAD_ERR_OK) {
    $upload_dir = '../uploads/tugasguru/';
    
    // Generate a unique file name based on the specified format
    $topik_nama = str_replace(' ', '_', $topik_id); // Sanitize for filename
    $nama_tugas_sanitized = str_replace(' ', '_', $nama_tugas); // Sanitize for filename
    $tahun_ajaran_sanitized = str_replace(' ', '_', $id_tahun_ajaran); // Sanitize for filename
    $file_name = "{$topik_nama}_{$nama_tugas_sanitized}_{$kode_mapel}_{$tahun_ajaran_sanitized}_" . '.' . pathinfo($file_tugas['name'], PATHINFO_EXTENSION);
    $file_path = $upload_dir . $file_name;

    // Create the upload directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Move the uploaded file to the target directory
    if (!move_uploaded_file($file_tugas['tmp_name'], $file_path)) {
        echo "Error uploading file.";
        exit();
    }
}

// Insert tugas into database
$sql = "
    INSERT INTO tugas (kode_mapel, id_kelas, topik_id, judul, deskripsi_tugas, opsi_tugas, file_tugas, tanggal_tenggat, id_tahun_ajaran)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("siisssssi", $kode_mapel, $id_kelas, $topik_id, $nama_tugas, $deskripsi_tugas, $jenis_tugas, $file_path, $tenggat_waktu, $id_tahun_ajaran);

if ($stmt->execute()) {
    echo "<script>
    alert('Tugas berhasil ditambahkan!');
    window.location.href = 'detail_mapel.php?kode_mapel=" . urlencode($kode_mapel) . "&kelas_id=" . urlencode($id_kelas) . "&tahun_ajaran=" . urlencode($id_tahun_ajaran) . "';
    </script>";
} else {
    // Set an error message in the session
    $_SESSION['message'] = 'Gagal Menambah Tugas, Ulangi.';
    $_SESSION['msg_type'] = 'error'; // Set a type for error
    header("Location: detail_mapel.php?kode_mapel=$kode_mapel&kelas_id=$id_kelas&tahun_ajaran=$id_tahun_ajaran");
    exit();
}


// Tutup koneksi
$stmt->close();
$conn->close();
?>
