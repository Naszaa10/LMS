<?php
include '../db.php';

// Menangani form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'add') {
        $guru = $_POST['guru'];
        $mapel = $_POST['mapel'];
        $hari = $_POST['hari'];
        $kelas = $_POST['kelas'];
        $startTime = $_POST['start_time'];
        $endTime = $_POST['end_time'];

        $sql = "INSERT INTO jadwal (nip_guru, kode_mapel, hari, id_kelas, waktu_mulai, waktu_selesai) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssss', $guru, $mapel, $hari, $kelas, $startTime, $endTime);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        }
        $stmt->close();
    } elseif ($action == 'update') {
        $id = $_POST['id'];
        $guru = $_POST['guru'];
        $mapel = $_POST['mapel'];
        $hari = $_POST['hari'];
        $kelas = $_POST['kelas'];
        $startTime = $_POST['start_time'];
        $endTime = $_POST['end_time'];

        $sql = "UPDATE jadwal SET nip_guru=?, kode_mapel=?, hari=?, id_kelas=?, waktu_mulai=?, waktu_selesai=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssssi', $guru, $mapel, $hari, $kelas, $startTime, $endTime, $id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        }
        $stmt->close();
    } elseif ($action == 'delete') {
        $id = $_POST['id'];

        $sql = "DELETE FROM jadwal WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        }
        $stmt->close();
    }
}

// Fetch data for dropdowns
$gurus = $conn->query("SELECT nip, nama_guru FROM guru");
$mapels = $conn->query("SELECT kode_mapel, nama_mapel FROM mata_pelajaran");
$kelas = $conn->query("SELECT id, nama_kelas FROM kelas");

// Fetch schedule data
$sql = "SELECT j.id, g.nama_guru AS nama_guru, m.nama_mapel AS nama_mapel, j.hari, k.nama_kelas AS nama_kelas, j.waktu_mulai, j.waktu_selesai
        FROM jadwal j
        JOIN guru g ON j.nip_guru = g.nip
        JOIN mata_pelajaran m ON j.kode_mapel = m.kode_mapel
        JOIN kelas k ON j.id_kelas = k.id";
$result = $conn->query($sql);

if (!$result) {
    die('Query failed: ' . $conn->error);
}

$no = 1;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pengajaran</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/jadwal.css">
    <style>
        .hidden { display: none; }
    </style>
</head>
<body>
<?php
    include '../navbar/navAdmin.php';
?>
        
<div id="mainContent" class="container mt-5">
    <h1>Tambah/Edit Jadwal</h1>
    <form id="scheduleForm">
        <input type="hidden" id="scheduleId" name="id" value="">
        <div class="form-group">
            <label for="guru">Guru:</label>
            <select class="form-control" id="guru" name="guru" required>
                <option value="">Pilih Guru</option>
                <?php while ($row = $gurus->fetch_assoc()): ?>
                    <option value="<?php echo $row['nip']; ?>"><?php echo $row['nama_guru']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="mapel">Mata Pelajaran:</label>
            <select class="form-control" id="mapel" name="mapel" required>
                <option value="">Pilih Mata Pelajaran</option>
                <?php while ($row = $mapels->fetch_assoc()): ?>
                    <option value="<?php echo $row['kode_mapel']; ?>"><?php echo $row['nama_mapel']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="hari">Hari:</label>
            <select class="form-control" id="hari" name="hari" required>
                <option value="">Pilih Hari</option>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
                <option value="Sabtu">Sabtu</option>
                <option value="Minggu">Minggu</option>
            </select>
        </div>
        <div class="form-group">
            <label for="kelas">Kelas:</label>
            <select class="form-control" id="kelas" name="kelas" required>
                <option value="">Pilih Kelas</option>
                <?php while ($row = $kelas->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nama_kelas']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="start-time">Waktu Mulai:</label>
            <input type="time" class="form-control" id="start-time" name="start_time" required>
        </div>
        <div class="form-group">
            <label for="end-time">Waktu Selesai:</label>
            <input type="time" class="form-control" id="end-time" name="end_time" required>
        </div>
        <button type="button" id="addScheduleBtn" class="btn btn-primary">Tambah Jadwal</button>
        <button type="button" id="updateScheduleBtn" class="btn btn-warning hidden">Update Jadwal</button>
    </form>
    <hr>
    <h3>Daftar Jadwal</h3>
    <div class="form-group">
        <label for="searchTeacher">Cari Berdasarkan Nama Guru:</label>
        <input type="text" class="form-control" id="searchTeacher" placeholder="Masukkan nama guru">
    </div>
    <table id="scheduleTable" class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Guru</th>
                <th>Mata Pelajaran</th>
                <th>Hari</th>
                <th>Kelas</th>
                <th>Waktu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['nama_guru']; ?></td>
                    <td><?php echo $row['nama_mapel']; ?></td>
                    <td><?php echo $row['hari']; ?></td>
                    <td><?php echo $row['nama_kelas']; ?></td>
                    <td><?php echo $row['waktu_mulai'] . ' - ' . $row['waktu_selesai']; ?></td>
                    <td>
                        <button class="btn btn-edit btn-sm btn-warning">Edit</button>
                        <button class="btn btn-delete btn-sm btn-danger">Hapus</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('scheduleForm');
    const addBtn = document.getElementById('addScheduleBtn');
    const updateBtn = document.getElementById('updateScheduleBtn');
    const scheduleTable = document.getElementById('scheduleTable');
    const searchTeacher = document.getElementById('searchTeacher');

    addBtn.addEventListener('click', function() {
        submitForm('add');
    });

    updateBtn.addEventListener('click', function() {
        submitForm('update');
    });

    scheduleTable.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-edit')) {
            const row = e.target.closest('tr');
            const id = row.children[0].textContent;
            const guru = row.children[1].textContent;
            const mapel = row.children[2].textContent;
            const hari = row.children[3].textContent;
            const kelas = row.children[4].textContent;
            const waktu = row.children[5].textContent.split(' - ');

            document.getElementById('scheduleId').value = id;
            document.getElementById('guru').value = guru;
            document.getElementById('mapel').value = mapel;
            document.getElementById('hari').value = hari;
            document.getElementById('kelas').value = kelas;
            document.getElementById('start-time').value = waktu[0];
            document.getElementById('end-time').value = waktu[1];

            addBtn.classList.add('hidden');
            updateBtn.classList.remove('hidden');
        } else if (e.target.classList.contains('btn-delete')) {
            const row = e.target.closest('tr');
            const id = row.children[0].textContent;
            if (confirm('Apakah Anda yakin ingin menghapus jadwal ini?')) {
                fetch('kelolaJadwal.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'delete',
                        id: id,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        row.remove();
                    } else {
                        alert('Gagal menghapus jadwal: ' + data.message);
                    }
                });
            }
        }
    });

    searchTeacher.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        filterTable(query);
    });

    function filterTable(query) {
        const rows = scheduleTable.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const teacherName = row.children[1].textContent.toLowerCase();
            if (teacherName.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function submitForm(action) {
        const formData = new FormData(form);
        formData.append('action', action);

        fetch('kelolaJadwal.php', {
            method: 'POST',
            body: new URLSearchParams(formData),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Jadwal berhasil ' + (action === 'add' ? 'ditambahkan' : 'diperbarui'));
                location.reload();
            } else {
                alert('Gagal ' + (action === 'add' ? 'menambahkan' : 'memperbarui') + ' jadwal: ' + data.message);
            }
        });
    }
});
</script>
<?php
include '../navbar/navFooter.php';
?>
</body>
</html>
