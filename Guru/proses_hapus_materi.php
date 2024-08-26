<?php
include '../db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Dapatkan topik_id untuk kembali ke halaman detail_mapel.php
    $query = "SELECT topik_id FROM Materi WHERE id='$id'";
    $result = $conn->query($query);
    $topik = $result->fetch_assoc();
    $topik_id = $topik['topik_id'];

    $deleteQuery = "DELETE FROM Materi WHERE id='$id'";
    
    if ($conn->query($deleteQuery) === TRUE) {
        header("Location: detail_mata_pelajaran.php?id=$topik_id");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
