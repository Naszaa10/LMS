<?php
include '../db.php';

// Menangani data formulir jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Menangani formulir akun guru
    if (isset($_POST['submit_guru'])) {
        $nip = $_POST['nip'];
        $nama = $_POST['nama'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $jurusan = $_POST['jurusan'];

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Menyusun perintah SQL untuk memasukkan data
        $sql = "INSERT INTO guru (nip, nama_guru, password, email, jurusan) VALUES (?, ?, ?, ?, ?)";

        // Menyiapkan statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $nip, $nama, $hashed_password, $email, $jurusan);

        // Menjalankan statement
        if ($stmt->execute()) {
            echo "<p>Akun guru berhasil ditambahkan.</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        // Menutup statement
        $stmt->close();
    }
    // Menangani formulir akun siswa
    elseif (isset($_POST['submit_siswa'])) {
        $nis = $_POST['nis'];
        $nama_siswa = $_POST['nama_siswa'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $id_kelas = $_POST['kelas'];

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Menyusun perintah SQL untuk memasukkan data
        $sql = "INSERT INTO siswa (nis, nama_siswa, password, email, id_kelas) VALUES (?, ?, ?, ?, ?)";

        // Menyiapkan statement
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssss", $nis, $nama_siswa, $hashed_password, $email, $id_kelas);

            // Menjalankan statement
            if ($stmt->execute()) {
                echo "<p>Akun siswa berhasil ditambahkan.</p>";
            } else {
                echo "<p>Error: " . $stmt->error . "</p>";
            }

            // Menutup statement
            $stmt->close();
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }
}

// Mengambil data kelas untuk dropdown
$kelas_options = "";
$sql = "SELECT id, nama_kelas FROM kelas";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $kelas_options .= "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['nama_kelas']) . "</option>";
    }
} else {
    $kelas_options = "<option value=''>Tidak ada kelas tersedia</option>";
}

// Mengambil data guru untuk tabel
$guru_data = "";
$sql = "SELECT nip, nama_guru, email, jurusan FROM guru";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $guru_data .= "<tr>
            <td>" . htmlspecialchars($row['nip']) . "</td>
            <td>" . htmlspecialchars($row['nama_guru']) . "</td>
            <td>" . htmlspecialchars($row['email']) . "</td>
            <td>" . htmlspecialchars($row['jurusan']) . "</td>
        </tr>";
    }
} else {
    $guru_data = "<tr><td colspan='4'>Tidak ada data guru.</td></tr>";
}

// Mengambil data siswa untuk tabel
$siswa_data = "";
$sql = "SELECT nis, nama_siswa, email, id_kelas FROM siswa";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $siswa_data .= "<tr>
            <td>" . htmlspecialchars($row['nis']) . "</td>
            <td>" . htmlspecialchars($row['nama_siswa']) . "</td>
            <td>" . htmlspecialchars($row['email']) . "</td>
            <td>" . htmlspecialchars($row['id_kelas']) . "</td>
        </tr>";
    }
} else {
    $siswa_data = "<tr><td colspan='4'>Tidak ada data siswa.</td></tr>";
}

// Menutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Akun</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/tambahmapel.css"> <!-- Path ke file CSS terpisah -->
    <style>
        .form-card {
            background-color: #ffffff; /* Warna latar belakang kartu */
            border: 1px solid #ddd; /* Border abu-abu pada kartu */
            border-radius: 0.5rem; /* Sudut membulat pada kartu */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Bayangan halus di bawah kartu */
            padding: 1.5rem; /* Jarak di dalam kartu */
            max-width: 900px; /* Lebar maksimum kartu */
            width: 80%; /* Lebar kartu 80% dari kontainer induk */
            margin: 0 auto; /* Pusatkan kartu secara horizontal */
            margin-top: 20px;
        }
        .hidden {
            display: none;
        }
        .table-container {
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <?php include '../navbar/navAdmin.php'; ?>

    <div id="mainContent" class="container mt-1">
        <div class="form-card">
            <h2>Formulir Tambah Akun</h2>
                <div class="text-center mb-4">
                    <button id="showGuruForm" class="btn btn-info">Tambah Akun Guru</button>
                    <button id="showSiswaForm" class="btn btn-info">Formulir Akun Siswa</button>
                </div>
        </div>
        
        <!-- Formulir Akun Guru -->
        <div id="guruForm" class="form-card hidden">
            <h2>Formulir Tambah Akun Guru</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="nip">NIP:</label>
                    <input type="text" id="nip" name="nip" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" id="nama" name="nama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="jurusan">Jurusan:</label>
                    <select id="jurusan" name="jurusan" class="form-control" required>
                        <option value="">Pilih Jurusan</option>
                        <option value="Teknik Komputer">Teknik Komputer</option>
                        <option value="Teknik Mesin">Teknik Mesin</option>
                        <option value="Teknik Otomotif">Teknik Otomotif</option>
                        <option value="Teknik Listrik">Teknik Listrik</option>
                        <option value="Umum">Umum</option>
                    </select>
                </div>

                <button type="submit" name="submit_guru" class="btn btn-primary">Tambah Akun</button>
            </form>
        </div>

        <!-- Formulir Akun Siswa -->
        <div id="siswaForm" class="form-card hidden">
            <h2>Formulir Tambah Akun Siswa</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="nis">NIS:</label>
                    <input type="text" id="nis" name="nis" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="nama_siswa">Nama:</label>
                    <input type="text" id="nama_siswa" name="nama_siswa" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="kelas">Kelas:</label>
                    <select id="kelas" name="kelas" class="form-control" required>
                        <option value="">Pilih Kelas</option>
                        <?php echo $kelas_options; ?>
                    </select>
                </div>

                <button type="submit" name="submit_siswa" class="btn btn-primary">Tambah Akun</button>
            </form>
        </div>

        <!-- Tabel Data Guru -->
        <div id="guruTable" class="table-container">
            <h2 class="text-center mt-5">Daftar Guru</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Jurusan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $guru_data; ?>
                </tbody>
            </table>
        </div>

        <!-- Tabel Data Siswa -->
        <div id="siswaTable" class="table-container">
            <h2 class="text-center mt-5">Daftar Siswa</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $siswa_data; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('showGuruForm').addEventListener('click', function() {
            document.getElementById('guruForm').classList.remove('hidden');
            document.getElementById('siswaForm').classList.add('hidden');
            document.getElementById('guruTable').classList.remove('hidden');
            document.getElementById('siswaTable').classList.add('hidden');
        });

        document.getElementById('showSiswaForm').addEventListener('click', function() {
            document.getElementById('siswaForm').classList.remove('hidden');
            document.getElementById('guruForm').classList.add('hidden');
            document.getElementById('siswaTable').classList.remove('hidden');
            document.getElementById('guruTable').classList.add('hidden');
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>

