<?php
session_start();
include '../db.php'; // File koneksi ke database

// Ambil NIS siswa yang login
$nis_siswa = $_SESSION['nis_siswa'];

// Query untuk mengambil nilai tugas berdasarkan NIS
$query = "
    SELECT 
        pt.tanggal_penilaian, 
        mp.nama_mapel, 
        t.judul, 
        pt.nilai_tugas 
    FROM 
        penilaian_tugas pt
    JOIN 
        tugas t ON pt.id_tugas = t.id_tugas
    JOIN 
        mata_pelajaran mp ON t.kode_mapel = mp.kode_mapel
    WHERE 
        pt.nis = '$nis_siswa'
    ORDER BY 
        pt.tanggal_penilaian DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/nilaiTugas.css">
</head>
<body>
<?php include '../navbar/navSiswa.php'; ?>
    <div id="mainContent" class="container mt-4">
        <h2 class="mb-4">Nilai Tugas</h2>
        <div class="mb-6">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari Nama Mata Pelajaran">
        </div>
        <table class="table" id="jadwalTable">
            <thead>
                <tr>
                    <th>Hari/Tanggal</th>
                    <th onclick="sortTable(1)">Mata Pelajaran</th>
                    <th>Nama Tugas</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['tanggal_penilaian']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_mapel']); ?></td>
                        <td><?php echo htmlspecialchars($row['judul']); ?></td>
                        <td><?php echo htmlspecialchars($row['nilai_tugas']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php include '../navbar/navFooter.php'; ?>
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let table = document.getElementById('jadwalTable');
        let tr = table.getElementsByTagName('tr');
        
        for (let i = 1; i < tr.length; i++) { // Mulai dari 1 untuk melewatkan header
            let td = tr[i].getElementsByTagName('td')[1]; // kolom kedua (nama mata pelajaran)
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
