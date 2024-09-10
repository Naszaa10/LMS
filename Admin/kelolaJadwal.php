<?php
include '../db.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        // Add new schedule
        $nip = $_POST['guru'];
        $kode_mapel = $_POST['mapel'];
        $hari = $_POST['hari'];
        $id_kelas = $_POST['kelas'];
        $waktu_mulai = $_POST['start_time'];
        $waktu_selesai = $_POST['end_time'];

        $sql = "INSERT INTO jadwal (nip, kode_mapel, hari, id_kelas, waktu_mulai, waktu_selesai) 
                VALUES ('$nip', '$kode_mapel', '$hari', '$id_kelas', '$waktu_mulai', '$waktu_selesai')";

        if ($conn->query($sql) === TRUE) {
            header("Location: kelolaJadwal.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($action === 'update') {
        // Update schedule
        $id = $_POST['id'];
        $nip = $_POST['guru'];
        $kode_mapel = $_POST['mapel'];
        $hari = $_POST['hari'];
        $id_kelas = $_POST['kelas'];
        $waktu_mulai = $_POST['start_time'];
        $waktu_selesai = $_POST['end_time'];

        $sql = "UPDATE jadwal SET nip='$nip', kode_mapel='$kode_mapel', hari='$hari', id_kelas='$id_kelas', waktu_mulai='$waktu_mulai', waktu_selesai='$waktu_selesai' WHERE id_jadwal='$id'";

        if ($conn->query($sql) === TRUE) {
            header("Location: kelolaJadwal.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($action === 'delete') {
        // Delete schedule
        $id = $_POST['id'];

        $sql = "DELETE FROM jadwal WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true]);
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => $conn->error]);
            exit();
        }
    }
}

// Fetch data for dropdowns
$gurus = $conn->query("SELECT nip, nama_guru FROM guru");
$mapels = $conn->query("SELECT kode_mapel, nama_mapel FROM mata_pelajaran");
$kelas = $conn->query("SELECT id_kelas, nama_kelas FROM kelas");

// Fetch schedule data
$sql = "SELECT j.id_jadwal, j.nip, g.nama_guru AS nama_guru, m.nama_mapel AS nama_mapel, m.kode_mapel, k.id_kelas, j.hari, k.nama_kelas AS nama_kelas, j.waktu_mulai, j.waktu_selesai
        FROM jadwal j
        JOIN guru g ON j.nip = g.nip
        JOIN mata_pelajaran m ON j.kode_mapel = m.kode_mapel
        JOIN kelas k ON j.id_kelas = k.id_kelas";
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
<?php include '../navbar/navAdmin.php'; ?>

<div id="mainContent" class="container mt-2">
    <h1>Tambah/Edit Jadwal</h1>
    <form id="scheduleForm" method="POST">
        <input type="hidden" id="scheduleId" name="id" value="">
        <input type="hidden" name="action" value="">
        <div class="form-group">
            <label for="guru">Guru:</label>
            <select class="form-control" id="guru" name="guru" required>
                <option value="">Pilih Guru</option>
                <?php while ($row = $gurus->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($row['nip']); ?>"><?php echo htmlspecialchars($row['nama_guru']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="mapel">Mata Pelajaran:</label>
            <select class="form-control" id="mapel" name="mapel" required>
                <option value="">Pilih Mata Pelajaran</option>
                <?php while ($row = $mapels->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($row['kode_mapel']); ?>"><?php echo htmlspecialchars($row['nama_mapel']); ?></option>
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
            </select>
        </div>
        <div class="form-group">
            <label for="kelas">Kelas:</label>
            <select class="form-control" id="kelas" name="kelas" required>
                <option value="">Pilih Kelas</option>
                <?php while ($row = $kelas->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($row['id_kelas']); ?>"><?php echo htmlspecialchars($row['nama_kelas']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="start-time">Waktu Mulai:</label>
            <input type="text" class="form-control" id="start-time" name="start_time" required>
        </div>
        <div class="form-group">
            <label for="end-time">Waktu Selesai:</label>
            <input type="text" class="form-control" id="end-time" name="end_time" required>
        </div>
        <button type="submit" id="addScheduleBtn" class="btn btn-primary">Tambah Jadwal</button>
        <button type="submit" id="updateScheduleBtn" class="btn btn-warning hidden">Update Jadwal</button>
    </form>
    <hr>
    <h3>Daftar Jadwal</h3>
    <div class="form-group">
        <label for="searchTeacher">Cari Berdasarkan Nama Guru:</label>
        <input type="text" class="form-control" id="searchTeacher" placeholder="Masukkan Nama Guru">
    </div>
    <!-- Table initially hidden -->
    <table id="scheduleTable" class="table table-striped hidden">
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
                <tr data-id="<?php echo htmlspecialchars($row['id_jadwal']); ?>">
                    <td><?php echo $no++; ?></td>
                    <td data-nip="<?php echo htmlspecialchars($row['nip']); ?>"><?php echo htmlspecialchars($row['nama_guru']); ?></td>
                    <td data-mapel="<?php echo htmlspecialchars($row['kode_mapel']); ?>"><?php echo htmlspecialchars($row['nama_mapel']); ?></td>
                    <td><?php echo htmlspecialchars($row['hari']); ?></td>
                    <td data-kelas="<?php echo htmlspecialchars($row['id_kelas']); ?>"><?php echo htmlspecialchars($row['nama_kelas']); ?></td>
                    <td><?php echo htmlspecialchars($row['waktu_mulai'] . ' - ' . $row['waktu_selesai']); ?></td>
                    <td>
                        <button class="btn btn-edit btn-sm btn-warning">Edit</button>
                        <button class="btn btn-delete btn-sm btn-danger">Hapus</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../navbar/navFooter.php'; ?>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function () {
    // Ambil nilai dari Local Storage dan set ke input pencarian
    var searchText = localStorage.getItem('searchText') || '';
    $('#searchTeacher').val(searchText);

    if (searchText) {
        $('#scheduleTable').removeClass('hidden'); // Tampilkan tabel ketika ada teks pencarian
        $('#scheduleTable tbody tr').each(function () {
            var teacherName = $(this).find('td:eq(1)').text().toLowerCase();
            $(this).toggle(teacherName.includes(searchText.toLowerCase()));
        });
    }

    // Handle search input
    $('#searchTeacher').on('input', function () {
        searchText = $(this).val().toLowerCase();
        localStorage.setItem('searchText', searchText); // Simpan teks pencarian di Local Storage

        if (searchText) {
            $('#scheduleTable').removeClass('hidden'); // Tampilkan tabel ketika mencari
            $('#scheduleTable tbody tr').each(function () {
                var teacherName = $(this).find('td:eq(1)').text().toLowerCase();
                $(this).toggle(teacherName.includes(searchText));
            });
        } else {
            $('#scheduleTable').addClass('hidden'); // Sembunyikan tabel ketika pencarian dihapus
        }
    });

    // Handle delete button click
    $(document).on('click', '.btn-delete', function () {
        var row = $(this).closest('tr');
        var id = row.data('id');

        $.ajax({
            type: 'POST',
            url: 'kelolaJadwal.php',
            data: { id: id, action: 'delete' },
            success: function (response) {
                var result = JSON.parse(response);
                if (result.success) {
                    row.remove();
                    location.reload(); // Refresh halaman setelah penghapusan
                } else {
                    alert('Error: ' + result.message);
                }
            }
        });
    });

    // Handle edit button click
    $(document).on('click', '.btn-edit', function () {
        var row = $(this).closest('tr');
        var id = row.data('id');

        // Set nilai form untuk mengedit
        $('#scheduleId').val(id);
        $('#guru').val(row.find('td:eq(1)').data('nip'));
        $('#mapel').val(row.find('td:eq(2)').data('mapel'));
        $('#hari').val(row.find('td:eq(3)').text());
        $('#kelas').val(row.find('td:eq(4)').data('kelas'));
        $('#start-time').val(row.find('td:eq(5)').text().split(' - ')[0]);
        $('#end-time').val(row.find('td:eq(5)').text().split(' - ')[1]);

        // Tampilkan tombol update, sembunyikan tombol tambah
        $('#addScheduleBtn').addClass('hidden');
        $('#updateScheduleBtn').removeClass('hidden');
        $('input[name="action"]').val('update');
    });

    // Handle add schedule button click
    $('#addScheduleBtn').click(function () {
        $('input[name="action"]').val('add');
    });

    // Handle update schedule button click
    $('#updateScheduleBtn').click(function () {
        $('input[name="action"]').val('update');
    });
});
</script>
</body>
</html>
