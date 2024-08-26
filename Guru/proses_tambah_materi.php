<?php
include '../db.php';

$materi_name = $_POST['materi_name'];
$materi_type = $_POST['materi_type'];
$topik_id = $_POST['topik_id'];
$text_content = NULL;
$path_file = NULL;

if ($materi_type === 'text') {
    $text_content = $_POST['text_content'];
} elseif ($materi_type === 'file') {
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["path_file"]["name"]);
    if (move_uploaded_file($_FILES["path_file"]["tmp_name"], $target_file)) {
        $path_file = $target_file;
    } else {
        echo "Terjadi kesalahan saat mengunggah file.";
        exit;
    }
}

// Insert ke database
$query = "INSERT INTO Materi (topik_id, materi_name, materi_type, text_content, path_file) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("issss", $topik_id, $materi_name, $materi_type, $text_content, $path_file);

if ($stmt->execute()) {
    header('Location: detail_mapel.php?id=' . $id);  // Redirect ke halaman detail mapel
} else {
    echo "Terjadi kesalahan saat menyimpan data.";
}

$stmt->close();
$conn->close();
?>
