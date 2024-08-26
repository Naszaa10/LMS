<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Guru dan Murid</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/jadwal.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Top Navbar -->
    <?php
    include '../navbar/navAdmin.php';
    ?>


        <div id="mainContent" class="container">
        <h2 class="mb-4">Kelola Jadwal</h2>
        <!-- Form Tambah/Edit Jadwal -->
        <div class="mb-4">
            <form id="scheduleForm">
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label for="guru" class="form-label">Nama Guru</label>
                        <select id="guru" class="form-select" placeholder="Masukkan nama guru">
                            <option value="Tirta">Tirta</option>
                            <option value="Permata">Permata</option>
                            <option value="Susilo">Susilo</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="mapel" class="form-label">Mata Pelajaran</label>
                        <select id="mapel" class="form-select" placeholder="Masukkan mata pelajaran">
                            <option value="Indonesia">Indonesia</option>
                            <option value="Inggris">Inggris</option>
                            <option value="India">India</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="hari" class="form-label">Hari</label>
                        <select id="hari" class="form-select" placeholder="Masukkan hari">
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label for="kelas" class="form-label">Kelas</label>
                        <select id="kelas" class="form-select" placeholder="Masukkan kelas">
                            <option value="kelas1">Kelas 1</option>
                            <option value="kelas2">Kelas 2</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="start-time" class="form-label">Waktu Mulai</label>
                        <input type="time" id="start-time" class="form-control" placeholder="Masukkan waktu mulai">
                    </div>
                    <div class="col-md-4">
                        <label for="end-time" class="form-label">Waktu Selesai</label>
                        <input type="time" id="end-time" class="form-control" placeholder="Masukkan waktu selesai">
                    </div>
                </div>
                <button type="button" id="addScheduleBtn" class="btn btn-primary">Tambah Jadwal</button>
                <button type="button" id="updateScheduleBtn" class="btn btn-success d-none">Update Jadwal</button>
            </form> 
        </div>
        <!-- Tabel Jadwal -->
        <table class="table">
            <thead>
                <tr>
                    <th>Guru</th>
                    <th>Mata Pelajaran</th>
                    <th>Hari</th>
                    <th>Kelas</th>
                    <th>Jam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="scheduleTable">
                <!-- Data Jadwal Mengajar -->
            </tbody>
        </table>
    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fungsi untuk menambahkan jadwal
            function addSchedule() {
                const guru = document.getElementById('guru').value;
                const mapel = document.getElementById('mapel').value;
                const hari = document.getElementById('hari').value;
                const kelas = document.getElementById('kelas').value;
                const startTime = document.getElementById('start-time').value;
                const endTime = document.getElementById('end-time').value;

                if (guru && mapel && hari && kelas && startTime && endTime) {
                    const row = document.createElement('tr');

                    row.innerHTML = `
                        <td>${guru}</td>
                        <td>${mapel}</td>
                        <td>${hari}</td>
                        <td>${kelas}</td>
                        <td>${startTime} - ${endTime}</td>
                        <td><button class="btn btn-edit btn-sm edit-btn">Edit</button> 
                            <button class="btn btn-delete btn-sm delete-btn">Hapus</button>
                        </td>
                    `;

                    scheduleTable.appendChild(row);

                    // Reset form setelah menambahkan
                    document.getElementById('scheduleForm').reset();
                    $('.form-select').val(null).trigger('change'); // Reset Select2
                    addScheduleBtn.classList.remove('d-none');
                    updateScheduleBtn.classList.add('d-none');
                } else {
                    alert('Semua kolom harus diisi.');
                }
            }

            // Fungsi untuk mengedit jadwal
            function editSchedule(row) {
                const cells = row.querySelectorAll('td');
                document.getElementById('guru').value = cells[0].innerText;
                document.getElementById('mapel').value = cells[1].innerText;
                document.getElementById('hari').value = cells[2].innerText;
                document.getElementById('kelas').value = cells[3].innerText;
                const [startTime, endTime] = cells[4].innerText.split(' - ');
                document.getElementById('start-time').value = startTime;
                document.getElementById('end-time').value = endTime;

                // Update tombol
                addScheduleBtn.classList.add('d-none');
                updateScheduleBtn.classList.remove('d-none');

                selectedRow = row;
            }

            // Fungsi untuk memperbarui jadwal
            function updateSchedule() {
                if (selectedRow) {
                    const guru = document.getElementById('guru').value;
                    const mapel = document.getElementById('mapel').value;
                    const hari = document.getElementById('hari').value;
                    const kelas = document.getElementById('kelas').value;
                    const startTime = document.getElementById('start-time').value;
                    const endTime = document.getElementById('end-time').value;

                    selectedRow.innerHTML = `
                        <td>${guru}</td>
                        <td>${mapel}</td>
                        <td>${hari}</td>
                        <td>${kelas}</td>
                        <td>${startTime} - ${endTime}</td>
                         <td><button class="btn btn-edit btn-sm edit-btn">Edit</button>
                             <button class="btn btn-delete btn-sm delete-btn">Hapus</button>
                        </td>
                    `;

                    // Reset form setelah memperbarui
                    document.getElementById('scheduleForm').reset();
                    $('.form-select').val(null).trigger('change'); // Reset Select2
                    addScheduleBtn.classList.remove('d-none');
                    updateScheduleBtn.classList.add('d-none');
                    selectedRow = null;
                } else {
                    alert('Tidak ada jadwal yang dipilih untuk diperbarui.');
                }
            }

            // Event listener untuk tombol tambah
            addScheduleBtn.addEventListener('click', addSchedule);

            // Event listener untuk tombol update
            updateScheduleBtn.addEventListener('click', updateSchedule);

            // Event listener untuk edit dan hapus
            scheduleTable.addEventListener('click', function (e) {
                if (e.target.classList.contains('edit-btn')) {
                    editSchedule(e.target.closest('tr'));
                }

                if (e.target.classList.contains('delete-btn')) {
                    if (confirm('Anda yakin ingin menghapus jadwal ini?')) {
                        scheduleTable.removeChild(e.target.closest('tr'));
                    }
                }
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebarMenu');
    
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('show');
        });
    });</script>
</body>
</html>
