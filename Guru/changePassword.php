<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../navbar/navHeader.php';

$nip = $_SESSION['teacher_nip'];
 // Pastikan variabel sesi ini di-set saat login

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $currentPassword = mysqli_real_escape_string($conn, $_POST['currentPassword']);
    $newPassword = mysqli_real_escape_string($conn, $_POST['newPassword']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);

    // Ambil password lama dari database
    $query = "SELECT password FROM guru WHERE nip = '$nip'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    // Verifikasi apakah password lama benar
    if (password_verify($currentPassword, $data['password'])) {
        // Cek apakah password baru dan konfirmasi password cocok
        if ($newPassword == $confirmPassword) {
            // Enkripsi password baru
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update password di database
            $updateQuery = "UPDATE guru SET password = '$hashedPassword' WHERE nip = '$nip'";
            if (mysqli_query($conn, $updateQuery)) {
                $successMsg = "Password berhasil diubah.";
            } else {
                $errorMsg = "Terjadi kesalahan saat mengubah password. Silakan coba lagi.";
            }
        } else {
            $errorMsg = "Password baru dan konfirmasi password tidak cocok.";
        }
    } else {
        $errorMsg = "Password lama tidak sesuai.";
    }
}
?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Ganti Password</h4>
            </div>
            <div class="card-body">
                <?php if (isset($errorMsg)): ?>
                    <div class="alert alert-danger"><?php echo $errorMsg; ?></div>
                <?php endif; ?>
                <?php if (isset($successMsg)): ?>
                    <div class="alert alert-success"><?php echo $successMsg; ?></div>
                <?php endif; ?>
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
<?php include '../navbar/navFooter.php'; ?>
</body>
</html>
