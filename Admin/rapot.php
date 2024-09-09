<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapot Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/rapot.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/print.css" media="print">
</head>
<body>
    <!-- Top Navbar -->
    <?php include '../navbar/navAdmin.php'; ?>
    <?php include '../db.php'; // File koneksi database ?>

    <div id="mainContent">
        <div class="container mt-5">
            <h2>RAPOT SISWA</h2>
            
            <!-- Dropdown untuk memilih Siswa dan Kelas -->
            <div class="selectSiswa mb-3">
                <label for="nis" class="form-label">Siswa</label>
                <select class="form-select" id="nis">
                    <option value="">Pilih Siswa</option>
                    <?php
                    // Query untuk mengambil data siswa
                    $querySiswa = "SELECT nis, nama_siswa FROM siswa";
                    $resultSiswa = mysqli_query($conn, $querySiswa);
                    while ($rowSiswa = mysqli_fetch_assoc($resultSiswa)) {
                        echo '<option value="'.$rowSiswa['nis'].'">'.$rowSiswa['nama_siswa'].'</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="selectKelas mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <select class="form-select" id="kelas">
                    <option value="">Pilih Kelas</option>
                    <?php
                    // Query untuk mengambil data kelas
                    $queryKelas = "SELECT id, nama_kelas FROM kelas";
                    $resultKelas = mysqli_query($conn, $queryKelas);
                    while ($rowKelas = mysqli_fetch_assoc($resultKelas)) {
                        echo '<option value="'.$rowKelas['id'].'">'.$rowKelas['nama_kelas'].'</option>';
                    }
                    ?>
                </select>
            </div>

            <!-- Elemen untuk menampilkan nama dan kelas pada rapot -->
            <div id="printHeader">
                <p id="print-siswa"></p>
                <p id="print-kelas"></p>
            </div>

            <P>SMK Al FALAH</P>
            <P>TAHUN AJARAN 2021/2023</P>

            <!-- Tabel nilai siswa yang ditampilkan setelah memilih siswa dan kelas -->
            <table class="table" id="nilaiTable" style="display:none;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mata Pelajaran</th>
                        <th>Nilai</th>
                        <th>Pengetahuan</th>
                        <th>Keterampilan</th>
                        <th>Tahun Ajaran</th>
                        <th>Nilai Akhir</th>
                        <th>Predikat</th>
                    </tr>
                </thead>
                <tbody id="nilaiTableBody">
                    <!-- Data akan diambil berdasarkan siswa dan kelas yang dipilih -->
                </tbody>
            </table>

            <button class="btn btn-primary" id="printBtn">Cetak Rapot</button>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const siswaSelect = document.getElementById('nis');
            const kelasSelect = document.getElementById('kelas');
            const nilaiTable = document.getElementById('nilaiTable');
            const nilaiTableBody = document.getElementById('nilaiTableBody');
            const printBtn = document.getElementById('printBtn');

            // Fungsi untuk memuat data nilai berdasarkan pilihan siswa dan kelas
            function loadTable() {
                const nis = siswaSelect.value;
                const kelasId = kelasSelect.value;
                
                if (nis && kelasId) {
                    fetch(`getNilai.php?nis=${nis}&kelas_id=${kelasId}`)
                        .then(response => response.json())
                        .then(data => {
                            nilaiTableBody.innerHTML = '';
                            data.forEach(row => {
                                nilaiTableBody.innerHTML += `
                                    <tr>
                                        <td>${row.kode_mapel}</td>
                                        <td contenteditable="true">${row.nilai}</td>
                                        <td>${row.tahun_ajaran}</td>
                                        <td>${row.tanggal_input}</td>
                                    </tr>`;
                            });
                            nilaiTable.style.display = 'table';
                        })
                        .catch(error => console.error('Error fetching data:', error));
                } else {
                    nilaiTable.style.display = 'none';
                }
            }

            siswaSelect.addEventListener('change', loadTable);
            kelasSelect.addEventListener('change', loadTable);

            printBtn.addEventListener('click', () => {
                window.print();
            });
        });
    </script>
</body>
<?php
include '../navbar/navFooter.php';
?>
</html>
