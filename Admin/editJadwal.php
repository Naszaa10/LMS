<?php
include '../db.php';

$id_jadwal = $_GET['id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nip = $_POST['nip'];
    $kode_mapel = $_POST['kode_mapel'];
    $id_kelas = $_POST['id_kelas'];
    $hari = $_POST['hari'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];

    $sql = "UPDATE jadwal SET nip=?, kode_mapel=?, id_kelas=?, hari=?, waktu_mulai=?, waktu_selesai=? WHERE id_jadwal=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $nip, $kode_mapel, $id_kelas, $hari, $waktu_mulai, $waktu_selesai, $id_jadwal);
    
    if ($stmt->execute()) {
        header("Location: dataJadwal.php?status=success");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

$sql = "SELECT * FROM jadwal WHERE id_jadwal=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_jadwal);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="..\css\jadwal.css">
</head>
<body>
<?php include '../navbar/navAdmin.php'; ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Edit Jadwal</h2>
        </div>
    <div class="card-body">
    <form action="" method="POST">
        <div class="form-group">
            <label for="nip">Guru:</label>
            <input type="text" class="form-control" id="nip" name="nip" value="<?php echo htmlspecialchars($row['nip']); ?>" required>
        </div>
        <div class="form-group">
            <label for="kode_mapel">Mata Pelajaran:</label>
            <input type="text" class="form-control" id="kode_mapel" name="kode_mapel" value="<?php echo htmlspecialchars($row['kode_mapel']); ?>" required>
        </div>
        <div class="form-group">
            <label for="id_kelas">Kelas:</label>
            <input type="text" class="form-control" id="id_kelas" name="id_kelas" value="<?php echo htmlspecialchars($row['id_kelas']); ?>" required>
        </div>
        <div class="form-group">
            <label for="hari">Hari:</label>
            <input type="text" class="form-control" id="hari" name="hari" value="<?php echo htmlspecialchars($row['hari']); ?>" required>
        </div>
        <div class="form-group">
            <label for="waktu_mulai">Waktu Mulai:</label>
            <input type="text" class="form-control" id="waktu_mulai" name="waktu_mulai" value="<?php echo htmlspecialchars($row['waktu_mulai']); ?>" required>
        </div>
        <div class="form-group">
            <label for="waktu_selesai">Waktu Selesai:</label>
            <input type="text" class="form-control" id="waktu_selesai" name="waktu_selesai" value="<?php echo htmlspecialchars($row['waktu_selesai']); ?>" required>
        </div>
        
        <div style="grid-column: 2 / 3; text-align: right;">
            <button type="submit" class="btn btn-warning">Update Jadwal</button>
            <a href="jadwalList.php" class="btn btn-danger">Batal</a>
        </div>
    </form>
</div>

<?php include '../navbar/navFooter.php'; ?>

</body>
</html>
