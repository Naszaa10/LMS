<?php
session_start(); // Memulai session
include 'db.php'; // Menghubungkan ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nip = $_POST['nip'];
    $password = $_POST['password'];

    // Mengambil data guru berdasarkan NIP
    $sql = "SELECT * FROM guru WHERE nip = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nip);
    $stmt->execute();
    $result = $stmt->get_result();
    $guru = $result->fetch_assoc();

    // Memeriksa apakah NIP ada dan password cocok
    if ($guru && password_verify($password, $guru['password'])) {
        // Jika berhasil login, simpan NIP dan nama ke session
        $query = "UPDATE guru SET terakhir_login = NOW() WHERE nip = '$nip'";
        $conn->query($query);
        $_SESSION['teacher_nip'] = $guru['nip'];
        header("Location: Guru/dashboardGuru.php"); // Redirect ke halaman dashboard guru
        exit();
    } else {
        // Jika gagal, tampilkan pesan kesalahan
        $error = "NIP atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Guru</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card mx-auto" style="width: 400px;">
            <div class="card-body">
                <h3 class="card-title text-center">Login Guru</h3>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form action="login_guru.php" method="post">
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
