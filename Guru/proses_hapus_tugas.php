<?php
session_start();
include '../db.php'; // Include your database connection

$topik_id = $_GET['topik_id'];
$kode_mapel = $_GET['kode_mapel'];
$id_kelas = $_GET['id_kelas'];

if (isset($_GET['id_tugas'])) {
    $id_tugas = $_GET['id_tugas'];

    // Prepare the delete statement
    $sql = "DELETE FROM tugas WHERE id_tugas = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_tugas);

    try {
        // Execute the statement
        if ($stmt->execute()) {
            // Set a success message
            $_SESSION['message'] = 'Tugas berhasil dihapus!';
            $_SESSION['msg_type'] = 'success';
        }
    } catch (mysqli_sql_exception $e) {
        // Handle foreign key constraint
        if ($e->getCode() == 1451) {
            $_SESSION['message'] = 'Tugas tidak bisa dihapus karena sudah terkait dengan data lain.';
            $_SESSION['msg_type'] = 'error';
        } else {
            $_SESSION['message'] = 'Error saat menghapus tugas. Silakan coba lagi.';
            $_SESSION['msg_type'] = 'error';
        }
    }

    // Close the statement
    $stmt->close();
} else {
    $_SESSION['message'] = 'ID tugas tidak ditemukan.';
    $_SESSION['msg_type'] = 'error';
}

// Redirect back to the previous page
header("Location: cek_tugas.php?topik_id=$topik_id&kode_mapel=$kode_mapel&id_kelas=$id_kelas'");
exit();
