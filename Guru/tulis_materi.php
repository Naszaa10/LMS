<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tulis Materi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php 
    include '../navbar/navHeader.php'; 
    $topik_id = $_GET['topik_id'];
    ?>

    <div id="mainContent" class="container mt-4">
        <h2>Tulis Materi</h2>
        <form method="POST" action="proses_tulis_materi.php">
            <div class="mb-3">
                <label for="isi_materi" class="form-label">Isi Materi</label>
                <textarea class="form-control" id="isi_materi" name="isi_materi" rows="8" required></textarea>
            </div>
            <input type="hidden" name="topik_id" value="<?php echo $topik_id; ?>">
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>

    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>
