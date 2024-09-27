<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="..\css\pengumuman.css">
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
        </form>
    </div>
    </div>

    <!-- Section untuk daftar pengumuman -->
    <ul class="list-group mb-3" id="announcementList">
        <!-- Daftar pengumuman akan ditambahkan di sini secara dinamis -->
    </ul>
</div>

<script>
    const form = document.getElementById('announcementFormContent');
    const announcementList = document.getElementById('announcementList');
    let announcements = [];
    let editingIndex = -1;

    // Tambah/Edit pengumuman
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const judul = document.getElementById('judul').value;
        const isi = document.getElementById('isi').value;
        const target = document.getElementById('target').value;
        
        if (editingIndex === -1) {
            // Tambah pengumuman baru
            announcements.push({ judul, isi, target });
        } else {
            // Edit pengumuman yang ada
            announcements[editingIndex] = { judul, isi, target };
            editingIndex = -1;
            document.getElementById('formTitle').textContent = 'Buat Pengumuman Baru';
            document.getElementById('submitBtn').textContent = 'Kirim Pengumuman';
        }

        form.reset();
        displayAnnouncements();
    });

    // Tampilkan daftar pengumuman
    function displayAnnouncements() {
        announcementList.innerHTML = '';
        announcements.forEach((announcement, index) => {
            const li = document.createElement('li');
            li.className = 'list-group-pgmn';
            li.innerHTML = `
                <div>
                    <strong>${announcement.judul}</strong> <br>
                    <small>Kepada: ${announcement.target}</small> <br>
                    <p>${announcement.isi}</p>
                </div>
                <div>
                    <button class="btn btn-warning btn-sm" onclick="editAnnouncement(${index})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteAnnouncement(${index})">Hapus</button>
                </div>
            `;
            announcementList.appendChild(li);
        });
    }

    // Edit pengumuman
    function editAnnouncement(index) {
        const announcement = announcements[index];
        document.getElementById('judul').value = announcement.judul;
        document.getElementById('isi').value = announcement.isi;
        document.getElementById('target').value = announcement.target;
        document.getElementById('formTitle').textContent = 'Edit Pengumuman';
        document.getElementById('submitBtn').textContent = 'Simpan Perubahan';
        editingIndex = index;
    }

    // Hapus pengumuman
    function deleteAnnouncement(index) {
        announcements.splice(index, 1);
        displayAnnouncements();
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<?php include '../navbar/navFooter.php'; ?>
</body>
</html>

