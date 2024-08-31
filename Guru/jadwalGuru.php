<?php
session_start();
include '../db.php';

// Ambil nip_guru dari sesi pengguna yang sedang login
$nip_guru = $_SESSION['teacher_nip'] ?? '';

// Query untuk mendapatkan data jadwal berdasarkan nip_guru
$sql = "SELECT j.kode_mapel, mp.nama_mapel, j.hari, k.nama_kelas, j.waktu_mulai, j.waktu_selesai, g.nama_guru 
        FROM jadwal j 
        JOIN mata_pelajaran mp ON j.kode_mapel = mp.kode_mapel 
        JOIN kelas k ON j.id_kelas = k.id 
        JOIN guru g ON j.nip_guru = g.nip 
        WHERE j.nip_guru = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nip_guru);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Mengajar Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/jadwal.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../navbar/navHeader.php'; ?>
    <div id="mainContent" class="container">
        <h2 class="mb-4">Jadwal Mengajar</h2>
        <div class="mb-6">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari Nama Mata Pelajaran">
        </div>
        <table class="table" id="jadwalTable">
            <thead>
                <tr>
                    <th>Nama Guru</th>
                    <th>Kode Mapel</th>
                    <th onclick="sortTable(0)">Mata Pelajaran</th>
                    <th>Hari</th>
                    <th>Kelas</th>
                    <th>Jam</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nama_guru']); ?></td>
                        <td><?php echo htmlspecialchars($row['kode_mapel']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_mapel']); ?></td>
                        <td><?php echo htmlspecialchars($row['hari']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_kelas']); ?></td>
                        <td><?php echo htmlspecialchars($row['waktu_mulai'] . ' - ' . $row['waktu_selesai']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php include '../navbar/navFooter.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let table = document.getElementById('jadwalTable');
        let tr = table.getElementsByTagName('tr');
        
        for (let i = 1; i < tr.length; i++) { // Mulai dari 1 untuk melewatkan header
            let td = tr[i].getElementsByTagName('td')[2]; // kolom kedua (nama mata pelajaran)
            if (td) {
                let txtValue = td.textContent || td.innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }       
        }
    });
</script>
</body>
</html>
