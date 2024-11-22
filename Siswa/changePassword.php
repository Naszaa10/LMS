<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../navbar/navSiswa.php';

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $currentPassword = mysqli_real_escape_string($conn, $_POST['currentPassword']);
    $newPassword = mysqli_real_escape_string($conn, $_POST['newPassword']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);

    // Ambil password lama dari database
    $query = "SELECT password FROM siswa WHERE nis = '$nis_siswa'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    // Verifikasi apakah password lama benar
    if (password_verify($currentPassword, $data['password'])) {
        // Cek apakah password baru dan konfirmasi password cocok
        if ($newPassword == $confirmPassword) {
            // Enkripsi password baru
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update password di database
            $updateQuery = "UPDATE siswa SET password = '$hashedPassword' WHERE nis = '$nis_siswa'";
            if (mysqli_query($conn, $updateQuery)) {
                // Password berhasil diubah
                $successMsg = "Password berhasil diubah.";
                header("Location: profileSiswa.php?success=" . urlencode($successMsg));
                exit(); // Pastikan untuk menghentikan eksekusi setelah redirect
            } else {
                // Terjadi kesalahan saat mengubah password
                $errorMsg = "Terjadi kesalahan saat mengubah password. Silakan coba lagi.";
                header("Location: profileSiswa.php?error=" . urlencode($errorMsg));
                exit();
            }
            } else {
                // Password baru dan konfirmasi password tidak cocok
                $errorMsg = "Password baru dan konfirmasi password tidak cocok.";
                header("Location: profileSiswa.php?error=" . urlencode($errorMsg));
                exit();
            }
            } else {
                // Password lama tidak sesuai
                $errorMsg = "Password lama tidak sesuai.";
                header("Location: profileSiswa.php?error=" . urlencode($errorMsg));
                exit();
            }
        }            
?>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Ganti Password</h4>
            </div>
            <div class="card-body">

                <form method="POST" action="changePassword.php">
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Password Lama</label>
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ganti Password</button>
                </form>
            </div>
        </div>
    </div>
<?php include '../navbar/navFooterSiswa.php'; ?>
</body>
</html>
