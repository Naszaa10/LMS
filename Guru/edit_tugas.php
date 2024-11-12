<?php
session_start();
include '../db.php'; // Include your database connection

$topik_id = $_GET['topik_id'];
$kode_mapel = $_GET['kode_mapel'];
$id_kelas = $_GET['id_kelas'];

// Ambil daftar tahun ajaran dari database
$sql_tahun = "SELECT id_tahun_ajaran, tahun_ajaran FROM tahun_ajaran";
$result_tahun = $conn->query($sql_tahun);

// Ambil nama topik berdasarkan topik_id
$sql_topik = "SELECT nama_topik FROM topik WHERE topik_id = ?";
$stmt_topik = $conn->prepare($sql_topik);
$stmt_topik->bind_param("i", $topik_id);
$stmt_topik->execute();
$result_topik = $stmt_topik->get_result();
$topik = $result_topik->fetch_assoc();
$nama_topik = $topik['nama_topik'];

if (isset($_GET['id_tugas'])) {
    $id_tugas = $_GET['id_tugas'];

    // Retrieve existing assignment details
    $sql = "SELECT * FROM tugas WHERE id_tugas = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_tugas);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $tugas = $result->fetch_assoc();
    } else {
        // Handle case where no assignment is found
        $_SESSION['message'] = "Tugas tidak ditemukan.";
        header("Location: cek_tugas.php?topik_id=$topik_id&kode_mapel=$kode_mapel&id_kelas=$id_kelas"); // Redirect back to the list
        exit;
    }
} else {
    // If id_tugas is not set, redirect back
    $_SESSION['message'] = "ID tugas tidak valid.";
    header("Location: cek_tugas.php?topik_id=$topik_id&kode_mapel=$kode_mapel&id_kelas=$id_kelas");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission to update the assignment
    $judul = $_POST['judul'];
    $tahun_ajaran = $_POST['tahun_ajaran']; // Get the selected academic year
    $file_tugas = $_FILES['file_tugas']['name'];
    $target_dir = "../uploads/tugasguru/"; // Change this to your upload directory

    // Prepare the SQL statement for updating the assignment
    $sql = "UPDATE tugas SET judul = ?, id_tahun_ajaran = ?, file_tugas = ? WHERE id_tugas = ?";
    $stmt = $conn->prepare($sql);

    // Check if a new file is being uploaded
    if (!empty($file_tugas)) {
        // Create new file name using topic name and task title
        $new_file_name = $nama_topik . '_' . $judul . '.' . pathinfo($file_tugas, PATHINFO_EXTENSION); // Create new file name
        $target_file = $target_dir . $new_file_name; // Set the target file path

        if (move_uploaded_file($_FILES['file_tugas']['tmp_name'], $target_file)) {
            // Bind parameters
            $stmt->bind_param("sssi", $judul, $tahun_ajaran, $new_file_name, $id_tugas); // Store new file name in DB
        } else {
            $_SESSION['message'] = "Gagal mengunggah file.";
            header("Location: edit_tugas.php?id_tugas=" . $id_tugas);
            exit;
        }
    } else {
        // If no new file, keep the existing file
        $stmt->bind_param("ssi", $judul, $tahun_ajaran, $tugas['file_tugas'], $id_tugas); // Keep existing file
    }

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['message'] = "Tugas berhasil diperbarui.";
        header("Location: cek_tugas.php?topik_id=$topik_id&kode_mapel=$kode_mapel&id_kelas=$id_kelas");
        exit;
    } else {
        $_SESSION['message'] = "Terjadi kesalahan saat memperbarui tugas.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas</title>
    <link rel="stylesheet" href="../css/detailMapel.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include '../navbar/navHeader.php'; ?>

<div class="container mt-4">
    <h2>Edit Tugas</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="judul">Nama Tugas</label>
            <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($tugas['judul']); ?>" required>
        </div>

        <div class="form-group">
            <label for="tahun_ajaran">Tahun Ajaran</label>
            <select name="tahun_ajaran" class="form-control" required>
                <?php while ($row_tahun = $result_tahun->fetch_assoc()): ?>
                    <option value="<?php echo $row_tahun['id_tahun_ajaran']; ?>" <?php if ($tugas['id_tahun_ajaran'] == $row_tahun['id_tahun_ajaran']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($row_tahun['tahun_ajaran']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="file_tugas">File Tugas</label>
            <input type="file" class="form-control-file" id="file_tugas" name="file_tugas" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip">
            <small>File saat ini: <?php echo htmlspecialchars($tugas['file_tugas']); ?></small>
        </div>
        <button type="submit" class="btn btn-primary">Update Tugas</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php include '../navbar/navFooter.php'; ?>
</body>
</html>
