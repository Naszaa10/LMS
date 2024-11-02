<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
<?php include '../navbar/navHeader.php'; ?>
<?php

// Ambil data siswa dari database
$querySiswa = "SELECT * FROM guru WHERE nip = '$nip'";
$resultSiswa = mysqli_query($conn, $querySiswa);
$siswa = mysqli_fetch_assoc($resultSiswa);


// Cek apakah form disubmit
if (isset($_POST['save_changes'])) {
    // Ambil data dari form
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Query untuk update data siswa
    $updateQuery = "UPDATE guru SET nama_guru = '$name', email = '$email' WHERE nip = '$nip'";
    $resultUpdate = mysqli_query($conn, $updateQuery);

    // Proses upload gambar jika ada file yang diupload
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
        $targetDir = "../uploads/profile/"; // Direktori penyimpanan
        $fileType = pathinfo($_FILES["profileImage"]["name"], PATHINFO_EXTENSION);
        $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');

        // Cek ukuran file (maksimal 5MB)
        if ($_FILES['profileImage']['size'] > 5 * 1024 * 1024) {
            echo "Ukuran file harus kurang dari 5MB.";
            exit(); // Hentikan eksekusi jika file terlalu besar
        }

        // Hapus gambar lama jika ada
        if (!empty($siswa['foto_profil']) && $siswa['foto_profil'] != 'default.png') {
            $oldImagePath = $targetDir . $siswa['foto_profil'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Hapus gambar lama
            }
        }

        // Atur zona waktu ke Jakarta
        date_default_timezone_set('Asia/Jakarta');

        // Ganti nama file dengan NIP dan timestamp
        $fileName = $nip . '_' . date("Ymd_His") . '_' . round(microtime(true) * 1000) . "." . $fileType;
        $targetFilePath = $targetDir . $fileName;

        if (in_array($fileType, $allowedTypes)) {
            // Upload file ke folder
            if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFilePath)) {
                // Simpan path gambar ke database
                $imageQuery = "UPDATE guru SET foto_profil = '$fileName' WHERE nip = '$nip'";
                mysqli_query($conn, $imageQuery);
            } else {
                echo "<script>
                alert('Terjadi kesalahan saat mengunggah file.');
                windows.locaton.href = 'profileGuru.php';
                </script> ";
            }
        } else {
            echo "<script>
                alert('Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.');
                windows.locaton.href = 'profileGuru.php';
                </script> ";
        }
    }

    if ($resultUpdate) {
        // Redirect ke halaman yang sama setelah update
        echo "<script>
                alert('Foto Profile Berhasil di Perbarui');
                windows.locaton.href = 'profileGuru.php';
                </script> "; // Pastikan untuk exit setelah redirect
    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan saat mengubah data.</div>";
    }
}
?>



<div id="mainContent" class="container mt-3">
    <div class="card-group"> <!-- Wrapper untuk menggabungkan kedua card -->
        
        <!-- Sidebar (Foto Profil dan Menu) -->
        <div class="card col-md-4">
            <div class="card-header text-center">
                <img src="../uploads/profile/<?php echo $siswa['foto_profil'] ?: 'default.png'; ?>" class="rounded-circle profile-img" alt="Profile Image">
                <h4 class="mt-3"><?php echo $siswa['nama_guru']; ?></h4>
                <p class="mt-3">NIP: <?php echo $siswa['nip']; ?></p>
            </div>
            <div class="card-body">
                <h3 class="card-title">Edit Profile</h3>
                <form method="POST" action="profileGuru.php" enctype="multipart/form-data"> <!-- Tambah enctype -->
                    <div class="mb-3">
                        <label for="profileImage" class="form-label">Change Profile Picture</label>
                        <input type="file" class="form-control" id="profileImage" name="profileImage"> <!-- Tambah name untuk file -->
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $siswa['nama_guru']; ?>"> <!-- Ambil data dari database -->
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $siswa['email']; ?>"> <!-- Ambil data dari database -->
                    </div>
                    <button type="submit" name="save_changes" class="btn btn-primary">Save Changes</button> <!-- Tambah name untuk tombol -->
                </form>
            </div>

            <ul class="list-group list-group-flush">
                <li class="list-group-item custom">
                    <a href="changePassword.php">Change Password</a>
                </li>
                <li class="list-group-item custom">
                    <a href="../logout.php">Logout</a>
                </li>
            </ul>
        </div>

    </div>
</div>
<?php
include '../navbar/navFooter.php'; // Footer
?>
</body>
</html>
