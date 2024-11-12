<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/nilai.css">
</head>
<body>
<?php
    include '../navbar/navSiswa.php';

    // Ambil tahun ajaran dari formulir jika ada
    $tahunAjaran = isset($_POST['tahun_ajaran']) ? $_POST['tahun_ajaran'] : '';

    // Ambil data tambahan siswa dan wali kelas
    $querySiswa = "SELECT siswa.nama_siswa, siswa.nama_wali_kelas, kelas.nama_kelas
    FROM siswa
    JOIN kelas ON siswa.id_kelas = kelas.id_kelas
    WHERE siswa.nis = '$nis_siswa'";
    $resultSiswa = mysqli_query($conn, $querySiswa);
    $dataSiswa = mysqli_fetch_assoc($resultSiswa);

    // Ambil daftar tahun ajaran dari database
    $queryTahunAjaran = "SELECT DISTINCT id_tahun_ajaran, tahun_ajaran FROM tahun_ajaran";
    $resultTahunAjaran = mysqli_query($conn, $queryTahunAjaran);

    // Ambil data nilai siswa berdasarkan NIS dan tahun ajaran
    $queryNilai = "SELECT mata_pelajaran.nama_mapel, nilai.nilai 
                   FROM nilai 
                   JOIN mata_pelajaran ON nilai.kode_mapel = mata_pelajaran.kode_mapel 
                   WHERE nilai.nis = '$nis_siswa' AND nilai.id_tahun_ajaran = '$tahunAjaran'";
    $resultNilai = mysqli_query($conn, $queryNilai);
?>

<div id="mainContent">
    <div class="container mt-4">
        <h2 class="mb-4">Nilai Siswa</h2>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="tahun_ajaran" class="form-label">Pilih Tahun Ajaran:</label>
                <select id="tahun_ajaran" name="tahun_ajaran" class="form-select" required>
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    <?php while ($row = mysqli_fetch_assoc($resultTahunAjaran)): ?>
                        <option value="<?php echo $row['id_tahun_ajaran']; ?>" <?php echo ($row['tahun_ajaran'] == $tahunAjaran) ? 'selected' : ''; ?>>
                            <?php echo $row['tahun_ajaran']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tampilkan</button>
        </form>

        <table id="example" class="table table-bordered">
            <thead>
                <tr>
                    <th class="mapel">Mata Pelajaran</th>
                    <th class="nilai">Nilai</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultNilai)): ?>
                    <tr>
                        <td class="mapel"><?php echo $row['nama_mapel']; ?></td>
                        <td class="nilai"><?php echo $row['nilai']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <button id="downloadPdf" class="btn btn-primary mt-4">Download PDF</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.16/jspdf.plugin.autotable.min.js"></script>
<script>
    document.getElementById('downloadPdf').addEventListener('click', () => {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const table = document.querySelector('table');
        const rows = table.querySelectorAll('tbody tr');
        const headers = table.querySelectorAll('thead th');
        const data = [];

        // Get the selected year from the form
        const tahunAjaran = document.getElementById('tahun_ajaran').value || 'unknown';
        const siswaNama = "<?php echo addslashes($dataSiswa['nama_siswa']); ?>";
        const siswaKelas = "<?php echo addslashes($dataSiswa['nama_kelas']); ?>";
        const waliKelas = "<?php echo addslashes($dataSiswa['nama_wali_kelas']); ?>";
        const nisSiswa = "<?php echo addslashes($nis_siswa); ?>"; // Include NIS from PHP

        // Add title and student information
        doc.text('Rapor Nilai Siswa', 10, 10);
        doc.text(`Nama Siswa: ${siswaNama}`, 10, 20);
        doc.text(`Kelas: ${siswaKelas}`, 10, 30);
        doc.text(`Tahun Ajaran: ${tahunAjaran}`, 10, 40); // Ensure this line reads the correct value
        doc.text(`Nama Wali Kelas: ${waliKelas}`, 10, 50);

        // Adding headers
        const header = Array.from(headers).map(header => header.innerText);
        data.push(header);

        // Adding rows
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const rowData = Array.from(cells).map(cell => cell.innerText);
            data.push(rowData);
        });

        // Generate PDF with autoTable plugin
        doc.autoTable({
            head: [header],
            body: data.slice(1),
            startY: 60
        });

        // Save the PDF file with format: Nilai_nis_tahun_ajaran.pdf
        const fileName = `Nilai_${nisSiswa}_${tahunAjaran}.pdf`;
        doc.save(fileName);
    });
</script>


<?php
    include '../navbar/navFooterSiswa.php';
    include '../navbar/tabelSeries.php';
    ?>
</body>
</html>
