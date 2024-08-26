<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../navbar/navHeader.php'; ?>

    <div id="mainContent" class="container mt-4">
        <h2>Tambah Tugas</h2>
        <form method="POST" action="proses_tambah_tugas.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="tugas_name" class="form-label">Nama Tugas</label>
                <input type="text" class="form-control" id="tugas_name" name="tugas_name" required>
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Tenggat Waktu</label>
                <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
            </div>
            <div class="mb-3">
                <label for="tugas_description" class="form-label">Deskripsi Tugas</label>
                <textarea class="form-control" id="tugas_description" name="tugas_description" rows="3"></textarea>
            </div>
            <input type="hidden" name="mata_pelajaran_id" value="<?php echo $_GET['mata_pelajaran_id']; ?>">
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>

    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>
