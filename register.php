<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/register.css">
    <style>
        .success-message {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>

<?php
include 'db.php'; // Sertakan koneksi database

$success_message = ""; // Variabel untuk pesan sukses

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];
    $nama = $_POST['nama']; // Ambil nama dari input

    if ($role === 'teacher') {
        $nip = $_POST['nip']; // Ambil NIP dari input

        // Query untuk insert ke tabel teachers
        $sql_teacher = "INSERT INTO teachers (username, password, nip, nama) VALUES (?, ?, ?, ?)";
        $stmt_teacher = $conn->prepare($sql_teacher);
        
        // Bind parameter (ssss -> string, string, string, string)
        $stmt_teacher->bind_param("ssss", $username, $password, $nip, $nama);
        
        // Eksekusi statement dan cek hasilnya
        if ($stmt_teacher->execute()) {
            $success_message = "Teacher registration successful!";
        } else {
            $success_message = "Error: " . $stmt_teacher->error;
        }

    } elseif ($role === 'student') {
        $nis = $_POST['nis']; // Ambil NIS dari input

        // Query untuk insert ke tabel students
        $sql_student = "INSERT INTO students (username, password, nis, nama) VALUES (?, ?, ?, ?)";
        $stmt_student = $conn->prepare($sql_student);
        
        // Bind parameter (ssss -> string, string, string, string)
        $stmt_student->bind_param("ssss", $username, $password, $nis, $nama);
        
        // Eksekusi statement dan cek hasilnya
        if ($stmt_student->execute()) {
            $success_message = "Student registration successful!";
        } else {
            $success_message = "Error: " . $stmt_student->error;
        }

    } elseif ($role === 'admin') {
        // Query untuk insert ke tabel admins
        $sql_admin = "INSERT INTO admin (username, password, nama) VALUES (?, ?, ?)";
        $stmt_admin = $conn->prepare($sql_admin);
        
        // Bind parameter (sss -> string, string, string)
        $stmt_admin->bind_param("sss", $username, $password, $nama);
        
        // Eksekusi statement dan cek hasilnya
        if ($stmt_admin->execute()) {
            $success_message = "Admin registration successful!";
        } else {
            $success_message = "Error: " . $stmt_admin->error;
        }

    } else {
        $success_message = "Invalid role selected!";
    }
}
?>

<body>
    <div class="card">
        <img src="gambar/logo.png" alt="Logo" class="card-logo">
        <h2 class="card-title">Register</h2>
        <?php if ($success_message): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select class="form-control" id="role" name="role" onchange="toggleFields()" required>
                    <option value="">Select Role</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <!-- Input untuk NIP (Guru) -->
            <div class="form-group" id="nipField" style="display: none;">
                <label for="nip">NIP (Guru):</label>
                <input type="text" class="form-control" id="nip" name="nip">
            </div>

            <!-- Input untuk NIS (Siswa) -->
            <div class="form-group" id="nisField" style="display: none;">
                <label for="nis">NIS (Siswa):</label>
                <input type="text" class="form-control" id="nis" name="nis">
            </div>

            <button type="submit" class="btn-primary">Register</button>
        </form>
    </div>

    <!-- JavaScript untuk menampilkan/menyembunyikan NIP dan NIS -->
    <script>
        function toggleFields() {
            var role = document.getElementById("role").value;
            document.getElementById("nipField").style.display = (role === "teacher") ? "block" : "none";
            document.getElementById("nisField").style.display = (role === "student") ? "block" : "none";
        }
    </script>
</body>
</html>
