<?php
session_start();
include 'db.php'; // Menghubungkan dengan database

$error = ""; // Variabel untuk menyimpan pesan kesalahan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type']; // Menentukan tipe pengguna

    if ($user_type === 'guru') {
        // Query untuk mendapatkan data guru berdasarkan NIP
        $sql = "SELECT * FROM guru WHERE nip = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $guru = $result->fetch_assoc();
            if (password_verify($password, $guru['password'])) {
                $_SESSION['teacher_nip'] = $guru['nip']; // Simpan NIP guru di session
                header("Location: Guru/index.php"); // Redirect ke dashboard guru
                exit();
            } else {
                $error = "Password salah.";
            }
        } else {
            $error = "Guru tidak ditemukan.";
        }
    } elseif ($user_type === 'siswa') {
        // Query untuk mendapatkan data siswa berdasarkan NIS
        $sql = "SELECT * FROM siswa WHERE nis = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $siswa = $result->fetch_assoc();
            if (password_verify($password, $siswa['password'])) {
                $_SESSION['student_nis'] = $siswa['nis']; // Simpan NIS siswa di session
                header("Location: Siswa/index.php"); // Redirect ke dashboard siswa
                exit();
            } else {
                $error = "Password salah.";
            }
        } else {
            $error = "Siswa tidak ditemukan.";
        }
    } else {
        $error = "Tipe pengguna tidak valid.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="card">
            <img src="gambar/logo.png" alt="Logo" class="logo">
            <h2>Login</h2>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="username">Username (NIP/NIS):</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="user_type">Login sebagai:</label>
                    <select class="form-control" id="user_type" name="user_type" required>
                        <option value="guru">Guru</option>
                        <option value="siswa">Siswa</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>

            <!-- Pesan Kesalahan -->
            <?php if (!empty($error)) : ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <!-- Link Lupa Password -->
            <a href="forgot_password.php" class="forgot-password">Lupa Password?</a>
        </div>
    </div>
</body>
</html>
