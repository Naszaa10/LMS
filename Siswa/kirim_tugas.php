<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan guru sudah login
if (!isset($_SESSION['teacher_nip'])) {
    header("Location: ../login_siswa.php");
    exit();
}

$tugas_id = $_POST['tugas_id'];
$topik_id = $_POST['topik_id'];
$kode_mapel = $_POST['kode_mapel'];
$id_kelas = $_POST['id_kelas'];
$nis_siswa = $_POST['nis_siswa'];
$jawaban = $_POST['jawaban'] ?? null;

// Pastikan nis_siswa sudah didefinisikan
if (!isset($nis_siswa)) {
    die("NIS siswa tidak ditemukan.");
}

// Flag to check if submission was successful
$submission_successful = false;

// Jika tipe tugas adalah teks
if (isset($jawaban) && !empty($jawaban)) {
    // Query untuk menyimpan jawaban teks
    $query = "
        INSERT INTO pengumpulan_tugas (nis, id_tugas, tugas_text, topik_id, kode_mapel, id_kelas, tanggal_pengumpulan)
        VALUES (?, ?, ?, ?, ?, ?, NOW())
    ";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        $_SESSION['message'] = "Error preparing statement: " . $conn->error;
        header("Location: detail_mapel.php?kode_mapel=" . urlencode($kode_mapel));
        exit();
    }

    $stmt->bind_param('sisisi', $nis_siswa, $tugas_id, $jawaban, $topik_id, $kode_mapel, $id_kelas);
    
    if ($stmt->execute()) {
        $submission_successful = true; // Mark submission as successful
    } else {
        $_SESSION['message'] = "Error executing statement: " . $stmt->error;
        header("Location: detail_mapel.php?kode_mapel=" . urlencode($kode_mapel));
        exit();
    }
    $stmt->close();
}

// Jika tipe tugas adalah upload
if (isset($_FILES['file_tugas']) && $_FILES['file_tugas']['error'] == UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['file_tugas']['tmp_name'];
    $file_name = basename($_FILES['file_tugas']['name']);
    $file_dest = '../uploads/tugas/' . $file_name;

    // Periksa apakah direktori tujuan ada, jika tidak buat direktori
    if (!is_dir('../uploads/tugas/')) {
        mkdir('../uploads/tugas/', 0777, true);
    }

    // Pindahkan file dari lokasi sementara ke folder tujuan
    if (move_uploaded_file($file_tmp, $file_dest)) {
        // Query untuk menyimpan informasi file
        $query = "
            INSERT INTO pengumpulan_tugas (nis, id_tugas, file_path, topik_id, kode_mapel, id_kelas, tanggal_pengumpulan)
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            $_SESSION['message'] = "Error preparing statement: " . $conn->error;
            header("Location: detail_mapel.php?kode_mapel=" . urlencode($kode_mapel));
            exit();
        }

        $stmt->bind_param('sisisi', $nis_siswa, $tugas_id, $file_name, $topik_id, $kode_mapel, $id_kelas);
        
        if ($stmt->execute()) {
            $submission_successful = true; // Mark submission as successful
        } else {
            $_SESSION['message'] = "Error executing statement: " . $stmt->error;
            header("Location: detail_mapel.php?kode_mapel=" . urlencode($kode_mapel));
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Gagal mengunggah file.";
        header("Location: detail_mapel.php?kode_mapel=" . urlencode($kode_mapel));
        exit();
    }
} else {
    if (isset($_FILES['file_upload']['error']) && $_FILES['file_upload']['error'] != UPLOAD_ERR_NO_FILE) {
        $_SESSION['message'] = "Terjadi kesalahan saat mengunggah file: " . $_FILES['file_upload']['error'];
        header("Location: detail_mapel.php?kode_mapel=" . urlencode($kode_mapel));
        exit();
    }
}

// Set success message after successful submission
if ($submission_successful) {
    $_SESSION['message'] = "Pengumpulan tugas berhasil.";
}

// Redirect after successful submission
header("Location: detail_mapel.php?kode_mapel=" . urlencode($kode_mapel));
exit();
?>
