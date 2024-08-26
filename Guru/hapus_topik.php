<?php
// Contoh logika untuk menghapus topik
include '../db.php'; // Menghubungkan dengan database

if (isset($_GET['topik_id']) && isset($_GET['mata_pelajaran_id'])) {
    $topik_id = $_GET['topik_id'];
    $mapel_id = $_GET['mata_pelajaran_id'];

    // Lakukan query penghapusan topik
    $sql = "DELETE FROM topik WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $topik_id);

    if ($stmt->execute()) {
        // Redirect ke halaman detail_mapel dengan mapel_id
        header("Location: detail_mapel.php?mapel_id=$mapel_id");
        exit();
    } else {
        echo "Gagal menghapus topik.";
    }
} else {
    echo "Data tidak valid.";
}

// Tutup koneksi database
$conn->close();
?>
