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

    <div id="mainContent">
        <div class="container mt-5">
            <h2>RAPOT SISWA</h2>
            <div class="selectSiswa mb-3">
                <label for="siswa" class="form-label">Siswa</label>
                <select class="form-select" id="siswa">
                    <option value="">Pilih Siswa</option>
                    <option value="Ajan">Ajan</option>
                    <option value="Mila">Mila</option>
                    <!-- Tambahkan siswa lainnya di sini -->
                </select>
            </div>
            <div class="selectKelas">
                <label for="kelas" class="form-label">Kelas</label>
                <select class="form-select" id="kelas">
                    <option value="">Pilih Kelas</option>
                    <option value="kelas1">Kelas 1</option>
                    <option value="kelas2">Kelas 2</option>
                    <!-- Tambahkan kelas lainnya di sini -->
                </select>
            </div>

            <!-- Elemen baru untuk menampilkan nilai yang dipilih -->
            <div class="selected-value mb-3">
                <span id="selected-siswa"></span> - 
                <span id="selected-kelas"></span>
            </div>

            <!-- Elemen untuk menampilkan nama dan kelas pada rapot -->
            <div id="printHeader">
                <p id="print-siswa"></p>
                <p id="print-kelas"></p>
            </div>

            <P>SMK Al FALAH</P>
            <P>TAHUN AJARAN 2021/2023</P>

            <table class="table">
                <thead>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <th>Nilai</th>
                        <th>Index</th>
                        <th>Nama Guru</th>
                    </tr>
                </thead>
                <tbody id="nilaiTableBody">
                    <!-- Data Nilai Ajan di Kelas 1 -->
                    <tr data-siswa="Ajan" data-kelas="kelas1">
                        <td>Matematika</td>
                        <td contenteditable="true">85</td>
                        <td contenteditable="true">A</td>
                        <td>Pak Budi</td>
                    </tr>
                    <tr data-siswa="Ajan" data-kelas="kelas1">
                        <td>Fisika</td>
                        <td contenteditable="true">90</td>
                        <td contenteditable="true">A</td>
                        <td>Bu Nina</td>
                    </tr>
                    <!-- Data Nilai Mila di Kelas 2 -->
                    <tr data-siswa="Mila" data-kelas="kelas2">
                        <td>Biologi</td>
                        <td contenteditable="true">80</td>
                        <td contenteditable="true">B</td>
                        <td>Pak Rudi</td>
                    </tr>
                    <tr data-siswa="Mila" data-kelas="kelas2">
                        <td>Kimia</td>
                        <td contenteditable="true">88</td>
                        <td contenteditable="true">A</td>
                        <td>Bu Sari</td>
                    </tr>
                    <!-- Tambahkan data nilai lainnya sesuai dengan kelas dan siswa -->
                </tbody>
            </table>
            <button class="btn btn-primary" id="printBtn">Cetak Rapot</button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const siswaSelect = document.getElementById('siswa');
            const kelasSelect = document.getElementById('kelas');
            const selectedSiswa = document.getElementById('selected-siswa');
            const selectedKelas = document.getElementById('selected-kelas');
            const printSiswa = document.getElementById('print-siswa');
            const printKelas = document.getElementById('print-kelas');
            const tableBody = document.getElementById('nilaiTableBody');
            const printBtn = document.getElementById('printBtn');

            function filterTable() {
                const siswaValue = siswaSelect.value;
                const kelasValue = kelasSelect.value;

                selectedSiswa.textContent = siswaValue;
                selectedKelas.textContent = kelasValue;
                printSiswa.textContent = `Nama Siswa: ${siswaValue}`;
                printKelas.textContent = `Kelas: ${kelasValue}`;

                Array.from(tableBody.children).forEach(row => {
                    const rowSiswa = row.getAttribute('data-siswa');
                    const rowKelas = row.getAttribute('data-kelas');
                    if ((siswaValue === '' || rowSiswa === siswaValue) &&
                        (kelasValue === '' || rowKelas === kelasValue)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            siswaSelect.addEventListener('change', filterTable);
            kelasSelect.addEventListener('change', filterTable);

            printBtn.addEventListener('click', () => {
                window.print();
            });
        });
    </script>

        <?php include '../navbar/navFooter.php'; ?>
</body>
</html>
