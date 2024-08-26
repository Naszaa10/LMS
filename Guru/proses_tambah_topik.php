<?php
include '../db.php';
// proses_tambah_topik.php

$topik_name = $_POST['topik_name'];
$mata_pelajaran_id = $_POST['mata_pelajaran_id'];

// Validasi data
if (!empty($topik_name)) {
    // Query untuk menambahkan topik ke database
    $query = "INSERT INTO Topik (mata_pelajaran_id, topik_name) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('is', $mata_pelajaran_id, $topik_name);

    if ($stmt->execute()) {
        // Redirect ke halaman detail mata pelajaran setelah berhasil menambah topik
        header('Location: detail_mapel.php?id=' . $mata_pelajaran_id);
        exit();
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Nama topik tidak boleh kosong.";
}
?>
