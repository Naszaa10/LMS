<?php 
// session_start(); // Memulai session
include '../db.php'; // Menghubungkan ke database

// if (!isset($_SESSION['nip'])) {
//     die("NIP tidak ditemukan. Silakan login terlebih dahulu.");
// }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/pengumuman.css">
</head>
<body>

<?php include '../navbar/navAdmin.php'; ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Pengelolaan Pengumuman</h2>
        </div>
        
        <!-- Form untuk tambah atau edit pengumuman -->
        <div class="announcement-form" id="announcementForm">
            <form id="announcementFormContent">
                <div class="form-group">
                    <label for="judul">Judul Pengumuman:</label>
                    <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul" required>
                </div>
                <div class="form-group">
                    <label for="isi">Isi Pengumuman:</label>
                    <textarea class="form-control" id="isi" name="isi" rows="4" placeholder="Masukkan isi pengumuman" required></textarea>
                </div>
                <div class="form-group">
                    <label for="target">Kirim Kepada:</label>
                    <select class="form-control" id="target" name="target" required>
                        <option value="semua">Semua</option>
                        <option value="guru">Guru</option>
                        <option value="siswa">Siswa</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" id="submitBtn">Kirim Pengumuman</button>
                <a href="lihatPengumuman.php" class="btn btn-primary">Lihat Pengumuman</a>
            </form>
        </div>
    </div>

    <!-- Section untuk daftar pengumuman -->
    <ul class="list-group mb-3" id="announcementList">
        <!-- Daftar pengumuman akan ditambahkan di sini secara dinamis -->
    </ul>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    const form = document.getElementById('announcementFormContent');
    const announcementList = document.getElementById('announcementList');
    let editingIndex = -1;

    // Tambah/Edit pengumuman
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const judul = document.getElementById('judul').value;
        const isi = document.getElementById('isi').value;
        const target = document.getElementById('target').value;
        const tanggal = new Date().toISOString().slice(0, 10); // Format tanggal YYYY-MM-DD
        
        const data = {
            judul: judul,
            isi: isi,
            target: target,
            tanggal: tanggal // Menyertakan tanggal
        };

        // Mengirim data ke server
        $.ajax({
            type: "POST",
            url: "simpan_pengumuman.php", // Endpoint untuk menyimpan pengumuman
            data: data,
            success: function(response) {
                // Menampilkan pengumuman baru setelah berhasil disimpan
                displayAnnouncements();
                form.reset(); // Reset form
            },
            error: function(xhr, status, error) {
                alert("Terjadi kesalahan: " + error);
            }
        });
    });

    // Tampilkan daftar pengumuman
    function displayAnnouncements() {
        // Di sini, Anda harus mendapatkan daftar pengumuman dari server untuk ditampilkan
        // Untuk sekarang, kita hanya akan mengosongkan daftar
        announcementList.innerHTML = '';
    }
</script>

<?php include '../navbar/navFooter.php'; ?>
</body>
</html>
