<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nip = $_POST['nip'];
    $kode_mapel = $_POST['kode_mapel'];
    $id_kelas = $_POST['id_kelas'];
    $hari = $_POST['hari'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];

    $sql = "INSERT INTO jadwal (nip, kode_mapel, id_kelas, hari, waktu_mulai, waktu_selesai) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nip, $kode_mapel, $id_kelas, $hari, $waktu_mulai, $waktu_selesai);

    if ($stmt->execute()) {
        header("Location: dataJadwal.php?status=added");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch data for dropdowns
$teachers = $conn->query("SELECT nip, nama_guru FROM guru");
$subjects = $conn->query("SELECT kode_mapel, nama_mapel FROM mata_pelajaran");
$classes = $conn->query("SELECT id_kelas, nama_kelas, jenjang FROM kelas");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="..\css\jadwal.css">
</head>
<body>
<?php include '../navbar/navAdmin.php'; ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Tambah Jadwal</h2>
        </div>
    <div class="card-body">
    <form action="" method="POST">
        <div class="form-group">
            <label for="nip">Guru:</label>
            <select class="form-control" id="nip" name="nip" required>
                <option value="">Pilih Guru</option>
                <?php while ($row = $teachers->fetch_assoc()): ?>
                    <option value="<?= $row['nip'] ?>"><?= $row['nama_guru'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="kode_mapel">Mata Pelajaran:</label>
            <select class="form-control" id="kode_mapel" name="kode_mapel" required>
                <option value="">Pilih Mata Pelajaran</option>
                <?php while ($row = $subjects->fetch_assoc()): ?>
                    <option value="<?= $row['kode_mapel'] ?>"><?= $row['nama_mapel'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_kelas">Kelas:</label>
            <select class="form-control" id="id_kelas" name="id_kelas" required>
                <option value="">Pilih Kelas</option>
                <?php while ($row = $classes->fetch_assoc()): ?>
                    <option value="<?= $row['id_kelas'] ?>"> <?= $row['jenjang'] ?> <?= $row['nama_kelas'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="hari">Hari:</label>
                <select class="form-control" id="hari" name="hari" required>
                    <option value="">Pilih Hari</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                </select>
            </div>

        <div class="form-group">
            <label for="waktu_mulai">Waktu Mulai:</label>
            <input type="text" class="form-control" id="waktu_mulai" name="waktu_mulai" required>
        </div>
        <div class="form-group">
            <label for="waktu_selesai">Waktu Selesai:</label>
            <input type="text" class="form-control" id="waktu_selesai" name="waktu_selesai" required>
        </div>

        <div style="grid-column: 2 / 3; text-align: right;">
            <button type="submit" class="btn btn-primary">Tambah Jadwal</button>
            <a href="dataJadwal.php" class="btn btn-danger">Batal</a>
        </div>
        
    </form>
</div>

<?php include '../navbar/navFooter.php'; ?>
</body>
</html>
