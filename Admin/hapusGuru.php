<?php
include '../db.php';

if (isset($_GET['nip'])) {
    $nip = $_GET['nip'];

    // Menghapus data guru berdasarkan NIP
    $delete_query = "DELETE FROM guru WHERE nip='$nip'";
    if ($conn->query($delete_query)) {
        header('Location: dataGuru.php');
    } else {
        echo "Gagal menghapus data.";
    }
}
?>
