<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Materi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php 
    include '../navbar/navHeader.php'; 
    $topik_id = $_GET['topik_id'];
    ?>

    <div id="mainContent" class="container mt-4">
        <h2>Upload Materi</h2>
        <form method="POST" action="proses_upload_materi.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="file_materi" class="form-label">Pilih File Materi</label>
                <input type="file" class="form-control" id="file_materi" name="file_materi" required>
            </div>
            <input type="hidden" name="topik_id" value="<?php echo $topik_id; ?>">
            <button type="submit" class="btn btn-success">Upload</button>
        </form>
    </div>

    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>
