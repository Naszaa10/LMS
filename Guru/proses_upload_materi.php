<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topik_id = $_POST['topik_id'];
    $materi_type = $_POST['materi_type'];
    $materi_name = $_POST['materi_name'] ?? '';
    
    if ($materi_type === 'text') {
        $text_content = $_POST['text_content'];
        $query = "INSERT INTO Materi (topik_id, materi_name, materi_type, text_content) VALUES ('$topik_id', '$materi_name', 'text', '$text_content')";
    } else if ($materi_type === 'file') {
        $file_content = $_FILES['file_content']['name'];
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($file_content);
        move_uploaded_file($_FILES['file_content']['tmp_name'], $target_file);
        $query = "INSERT INTO Materi (topik_id, materi_name, materi_type, path_file) VALUES ('$topik_id', '$materi_name', 'file', '$target_file')";
    }

    if ($conn->query($query) === TRUE) {
        header("Location: detail_mata_pelajaran.php?id=$id");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
