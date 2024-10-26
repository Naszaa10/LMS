<?php
include '../navbar/navHeader.php';
// Query untuk mendapatkan data jadwal berdasarkan nip_guru

$sql = "SELECT j.kode_mapel, mp.nama_mapel, j.hari, k.nama_kelas, k.jenjang, j.waktu_mulai, j.waktu_selesai, g.nama_guru 
        FROM jadwal j 
        JOIN mata_pelajaran mp ON j.kode_mapel = mp.kode_mapel 
        JOIN kelas k ON j.id_kelas = k.id_kelas
        JOIN guru g ON j.nip = g.nip 
        WHERE j.nip = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nip);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-4">
        <h1>Jadwal Mengajar</h1>
        <table id="example" class="table table-bordered">
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
                        <td><?php echo htmlspecialchars($row['jenjang']) . ' ' . htmlspecialchars($row['nama_kelas']); ?></td>
                        <td><?php echo htmlspecialchars($row['waktu_mulai'] . ' - ' . $row['waktu_selesai']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php include '../navbar/navFooter.php'; ?>
<?php include '../navbar/tabelSeries.php'; ?>
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
