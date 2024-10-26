<?php
session_start();
include '../db.php'; // Menghubungkan dengan database

// Pastikan admin sudah login
// if (!isset($_SESSION['admin'])) {
//     header("Location: ../login.php");
//     exit();
// }

// Logic untuk menghapus tahun ajaran
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM tahun_ajaran WHERE id_tahun_ajaran = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Tahun ajaran berhasil dihapus!'); window.location.href='tahunAjaran.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus tahun ajaran!');</script>";
    }
}

// Logic untuk mengedit tahun ajaran
if (isset($_POST['edit_ajaran'])) {
    $id = $_POST['id_tahun_ajaran'];
    $thn_ajaran = $_POST['thn_ajaran'];

    $sql = "UPDATE tahun_ajaran SET tahun_ajaran = ? WHERE id_tahun_ajaran = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $thn_ajaran, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Tahun ajaran berhasil diperbarui!'); window.location.href='tahunAjaran.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui tahun ajaran!');</script>";
    }
}

// Fetch data tahun ajaran
$sql = "SELECT * FROM tahun_ajaran";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tahun Ajaran</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/tambahmapel.css">
</head>
<body>
    <?php include '../navbar/navAdmin.php'; ?>

    <div class="container mt-4">
        <h1>Manage Tahun Ajaran</h1>
        <!-- Button to add new tahun ajaran -->
        <a href="tambahAjaran.php" class="btn btn-primary">Tambah Tahun Ajaran</a>

        <table id="example" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tahun Ajaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id_tahun_ajaran']; ?></td>
                    <td><?php echo $row['tahun_ajaran']; ?></td>
                    <td>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#editModal<?php echo $row['id_tahun_ajaran']; ?>">Edit</button>
                        <a href="?delete=<?php echo $row['id_tahun_ajaran']; ?>" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus tahun ajaran ini?');">Hapus</a>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editModal<?php echo $row['id_tahun_ajaran']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Tahun Ajaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post">
                                    <input type="hidden" name="id_tahun_ajaran" value="<?php echo $row['id_tahun_ajaran']; ?>">
                                    <div class="form-group">
                                        <label for="thn_ajaran">Tahun Ajaran:</label>
                                        <input type="text" id="thn_ajaran" name="thn_ajaran" class="form-control" value="<?php echo $row['tahun_ajaran']; ?>" required>
                                    </div>
                                    <button type="submit" name="edit_ajaran" class="btn btn-primary">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php include '../navbar/navFooter.php'; ?>
    <?php include '../navbar/tabelSeries.php'; ?>

</body>
</html>
