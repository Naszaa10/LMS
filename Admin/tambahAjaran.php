<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan admin sudah login
// if (!isset($_SESSION['admin'])) {
//     header("Location: ../login.php");
//     exit();
// }

// Logika untuk menambah tahun ajaran
if (isset($_POST['submit_ajaran'])) {
    $thn_ajaran = $_POST['thn_ajaran'];

    // Query untuk menambah tahun ajaran ke dalam database
    $sql = "INSERT INTO tahun_ajaran (tahun_ajaran) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $thn_ajaran);

    if ($stmt->execute()) {
        echo "<script>alert('Tahun ajaran berhasil ditambahkan!'); window.location.href='tahunAjaran.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan tahun ajaran!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tahun Ajaran</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/Kelas.css"> <!-- Path ke file CSS terpisah -->
</head>
<body>
    <?php include '../navbar/navAdmin.php'; ?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>Tahun Ajaran</h2>
        </div>
    <div class="card-body">

            <form action="" method="post">
                <div class="form-group">
                    <label for="tahun-ajaran">Tahun Ajaran:</label>
                    <input type="text" id="thn_ajaran" name="thn_ajaran" class="form-control" required>
                </div>

                <div style="text-align: right;">
                    <button type="submit" name="submit_ajaran" class="btn btn-primary">Tambah Tahun Ajaran</button>
                </div>
            </form>
        </div>
    </div>
</body>
<?php include '../navbar/navFooter.php'; ?>
</html>
