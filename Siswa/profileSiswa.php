<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
    include '../navbar/navHeader.php';
?>
    <div id="mainContent" class="container mt-5">
        <div class="card-group"> <!-- Wrapper untuk menggabungkan kedua card -->
            
            <!-- Sidebar (Foto Profil dan Menu) -->
            <div class="card col-md-4">
                <div class="card-header text-center">
                    <img src="https://via.placeholder.com/150" class="rounded-circle profile-img" alt="Profile Image">
                    <h4 class="mt-3">Nama Siswa</h4>
                    <p class="mt-3">NIS: 198273645</p>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Edit Profile</h3>
                    <form>
                        <div class="mb-3">
                            <label for="profileImage" class="form-label">Change Profile Picture</label>
                            <input type="file" class="form-control" id="profileImage">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" value="Nama Siswa">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="guru@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" value="+628123456789">
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
?>
</body>
</html>
