<?php
session_start(); // Memulai session
include 'db.php'; // Menghubungkan ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nis = $_POST['nis'];
    $password = $_POST['password'];

    // Mengambil data siswa berdasarkan NIS
    $sql = "SELECT * FROM siswa WHERE nis = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nis);
    $stmt->execute();
    $result = $stmt->get_result();
    $siswa = $result->fetch_assoc();

    // Memeriksa apakah NIS ada dan password cocok
    if ($siswa && password_verify($password, $siswa['password'])) {
        // Jika berhasil login, simpan NIS dan nama ke session
        $query = "UPDATE siswa SET terakhir_login = NOW() WHERE nis = '$nis'";
        $conn->query($query);
        $_SESSION['nis_siswa'] = $siswa['nis'];
        header("Location: Siswa/dasboardSiswa.php"); // Redirect ke halaman dashboard siswa
        exit();
    } else {
        // Jika gagal, tampilkan pesan kesalahan
        $error = "NIS atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card mx-auto" style="width: 400px;">
            <div class="card-body">
                <h3 class="card-title text-center">Login Siswa</h3>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form action="login_siswa.php" method="post">
                    <div class="mb-3">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Login</button>
                </form>
                <div class="forgot-password">
                    <a href="login_guru.php">Login Sebagai Guru</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
