<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kelas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/tambahmapel.css"> <!-- Path ke file CSS terpisah -->
</head>
<body>
    <?php include '../navbar/navAdmin.php'; ?>

    <div id="mainContent" class="container mt-5">
        <!-- Formulir Akun Guru -->
        <div id="guruForm" class="form-card">
            <h2>Formulir Tambah Kelas</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="nama">Nama Kelas:</label>
                    <input type="text" id="kelas" name="kelas" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="nama">Tahun Ajaran:</label>
                    <input type="text" id="kelas" name="kelas" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="nama">Jurusan:</label>
                    <input type="text" id="kelas" name="kelas" class="form-control" required>
                </div>

                <button type="submit" name="submit_guru" class="btn btn-primary">Tambah kelas</button>
                <button type="button" id="updateScheduleBtn" class="btn btn-warning hidden">Update Jadwal</button>
            </form>
        </div>

        <!-- Tabel Data Guru -->
        <div id="guruTable" class="table-container">
            <h2 class="text-center mt-5">Daftar Kelas</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo $row['nama_guru']; ?></td>
                    <td><?php echo $row['nama_kelas']; ?></td>
                    <td><?php echo $row['jurusan']; ?></td>
                    <td>
                        <button class="btn btn-edit btn-sm btn-warning">Edit</button>
                        <button class="btn btn-delete btn-sm btn-danger">Hapus</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <?php include '../navbar/navFooter.php'; ?>
</body>
</html>