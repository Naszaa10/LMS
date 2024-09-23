<?php
include '../db.php';

if (isset($_GET['id_kelas'])) {
    $id_kelas = $_GET['id_kelas'];

    // Menghapus data guru berdasarkan NIP
    $delete_query = "DELETE FROM kelas WHERE id_kelas='$id_kelas'";
    if ($conn->query($delete_query)) {
        header('Location: dataKelas.php');
    } else {
        echo "Gagal menghapus data.";
    }
}
?>
