<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tugas_name = $_POST['tugas_name'];
    $tugas_type = $_POST['tugas_type'];
    $topik_id = $_POST['topik_id'];
    $deadline = $_POST['deadline'];

    if ($tugas_type == 'text') {
        $text_content = $_POST['text_content_tugas'];
        $query = "INSERT INTO Tugas (topik_id, tugas_name, tugas_type, text_content, deadline) VALUES ('$topik_id', '$tugas_name', 'text', '$text_content', '$deadline')";
    } else if ($tugas_type == 'file') {
        $file_content = $_FILES['file_content_tugas']['name'];
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($file_content);
        move_uploaded_file($_FILES['file_content_tugas']['tmp_name'], $target_file);
        $query = "INSERT INTO Tugas (topik_id, tugas_name, tugas_type, path_file, deadline) VALUES ('$topik_id', '$tugas_name', 'file', '$target_file', '$deadline')";
    }

    if ($conn->query($query) === TRUE) {
        header("Location: detail_mata_pelajaran.php?id=$topik_id");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
