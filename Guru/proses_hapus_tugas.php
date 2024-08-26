<?php
include '../db.php';

$id = $_GET['id'];
$topik_id = $_GET['topik_id'];

$query = "DELETE FROM Tugas WHERE id='$id'";

if ($conn->query($query) === TRUE) {
    header("Location: detail_mata_pelajaran.php?id=$topik_id");
} else {
    echo "Error: " . $conn->error;
}
?>
