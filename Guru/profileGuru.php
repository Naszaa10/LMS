<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $guru_id = 1; // Ganti dengan ID yang sesuai atau ambil dari session
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    // Menangani file gambar jika diunggah
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == UPLOAD_ERR_OK) {
        $gambar_mapel = $_FILES['profileImage']['name'];
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($gambar_mapel);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Periksa apakah file yang diupload adalah gambar
        $check = getimagesize($_FILES["profileImage"]["tmp_name"]);
        if ($check !== false) {
            // Hanya mengizinkan format file tertentu
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                die("Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.");
            }
            // Coba unggah file
            if (!move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file)) {
                die("Maaf, terjadi kesalahan saat mengunggah file.");
            }
        } else {
            die("File bukan gambar.");
        }
    }

    // Update data guru
    $sql = "UPDATE guru SET nama_guru = ?, email = ?, phone = ?, gambar = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $gambar = isset($target_file) ? $target_file : null;
    $stmt->bind_param("sssi", $name, $email, $phone, $gambar, $guru_id);

    if ($stmt->execute()) {
        echo "Profil berhasil diperbarui.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


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
<?php
    include '../navbar/navHeader.php';
    include '../db.php'; // Memasukkan koneksi database

    // Mendapatkan ID guru dari URL atau session
    $guru_id = 1; // Ganti dengan ID yang sesuai atau ambil dari session

    // Mengambil data guru dari database
    $sql = "SELECT * FROM guru WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $guru_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $guru = $result->fetch_assoc();
?>
    <div id="mainContent" class="container mt-5">
        <div class="card-group"> <!-- Wrapper untuk menggabungkan kedua card -->
            
            <!-- Sidebar (Foto Profil dan Menu) -->
            <div class="card col-md-4">
                <div class="card-header text-center">
                    <img src="<?php echo htmlspecialchars($guru['gambar']); ?>" class="rounded-circle profile-img" alt="Profile Image">
                    <h4 class="mt-3"><?php echo htmlspecialchars($guru['nama_guru']); ?></h4>
                    <p class="mt-3">NIP: <?php echo htmlspecialchars($guru['nip']); ?></p>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Edit Profile</h3>
                    <form action="update_profile.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="profileImage" class="form-label">Change Profile Picture</label>
                            <input type="file" class="form-control" id="profileImage" name="profileImage">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($guru['nama_guru']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($guru['email']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($guru['phone']); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="#">Change Password</a>
                    </li>
                    <li class="list-group-item">
                        <a href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php
    include '../navbar/navFooter.php';
    $stmt->close();
    $conn->close();
?>
</body>
</html>
