<?php
session_start();
include 'db.php'; // Include database connection

$error = ""; // Variable for error message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type']; // Tambahkan jenis pengguna

    if ($user_type === 'teacher') {
        // Query untuk mendapatkan data guru
        $sql = "SELECT * FROM teachers WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $teacher = $result->fetch_assoc();
            echo "Password from input: " . $password . "<br>";
            echo "Hashed password from DB: " . $teacher['password'] . "<br>";
            
            if (password_verify($password, $teacher['password'])) {
                $_SESSION['teacher_nip'] = $teacher['nip']; // Simpan NIP guru di session
                header("Location: Guru/index.php"); // Halaman dashboard guru
                exit();
            } else {
                $error = "Password is incorrect.";
            }
        } else {
            $error = "No user found.";
        }
    } elseif ($user_type === 'student') {
        // Query untuk mendapatkan data siswa
        $sql = "SELECT * FROM students WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();
            if (password_verify($password, $student['password'])) {
                $_SESSION['student_nis'] = $student['nis']; // Simpan NIS siswa di session
                header("Location: Siswa/index.php"); // Halaman dashboard siswa
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "No user found.";
        }
    } else {
        $error = "Invalid user type.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
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
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="user_type">Login as:</label>
                    <select class="form-control" id="user_type" name="user_type" required>
                        <option value="teacher">Guru</option>
                        <option value="student">Siswa</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>

            <!-- Error Message -->
            <?php if (!empty($error)) : ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <!-- Forgot Password Link -->
            <a href="forgot_password.php" class="forgot-password">Forgot Password?</a>
        </div>
    </div>
</body>
</html>
