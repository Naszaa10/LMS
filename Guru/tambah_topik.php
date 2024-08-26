<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Topik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../navbar/navHeader.php'; ?>

    <div id="mainContent" class="container mt-4">
        <h2>Tambah Topik</h2>
        <form method="POST" action="proses_tambah_topik.php">
            <div class="mb-3">
                <label for="topik_name" class="form-label">Nama Topik</label>
                <input type="text" class="form-control" id="topik_name" name="topik_name" required>
            </div>
            <input type="hidden" name="mata_pelajaran_id" value="<?php echo $_GET['mata_pelajaran_id']; ?>">
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>

    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>
