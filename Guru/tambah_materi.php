<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topik_id = $_POST['topik_id'];
    $materi_type = $_POST['materi_type'];

    if ($materi_type === 'text') {
        // Menyimpan materi teks
        $text_content = $_POST['text_content'];
        $materi_name = "Materi Teks";

        $query = "INSERT INTO Materi (topik_id, materi_name, materi_type, text_content) 
                  VALUES ('$topik_id', '$materi_name', 'text', '$text_content')";
        
        if ($conn->query($query) === TRUE) {
            header('Location: detail_mapel.php?id=' . $id);
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }

    } elseif ($materi_type === 'file') {
        // Menyimpan materi file
        $target_dir = "../uploads/";
        $file_name = basename($_FILES["file_content"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $materi_name = "Materi File";

        // Memeriksa apakah file adalah file yang diizinkan
        $allowed_types = array("pdf", "doc", "docx", "ppt", "pptx", "zip", "rar", "jpg", "png", "jpeg");
        if (in_array($file_type, $allowed_types)) {
            // Memeriksa apakah file berhasil diunggah
            if (move_uploaded_file($_FILES["file_content"]["tmp_name"], $target_file)) {
                $query = "INSERT INTO Materi (topik_id, materi_name, materi_type, path_file) 
                          VALUES ('$topik_id', '$materi_name', 'file', '$target_file')";

                if ($conn->query($query) === TRUE) {
                    echo "Materi file berhasil ditambahkan.";
                } else {
                    echo "Error: " . $query . "<br>" . $conn->error;
                }
            } else {
                echo "Terjadi kesalahan saat mengunggah file.";
            }
        } else {
            echo "Format file tidak diizinkan.";
        }

    } else {
        echo "Jenis materi tidak valid.";
    }
} else {
    echo "Permintaan tidak valid.";
}

$conn->close();
?>
