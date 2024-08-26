<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapot Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/rapot.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Top Navbar -->
    <?php
    include '../navbar/navAdmin.php';
    ?>
        <div id="mainContent">
            <div class="container mt-5">
                <h2 class="mb-4">Rapot Siswa</h2>
                <label for="kelas" class="form-label">Kelas</label>
                <select class="form-select" id="kelas">
                    <option value="">Pilih Kelas</option>
                    <option value="kelas1">Kelas 1</option>
                    <option value="kelas2">Kelas 2</option>
                    <!-- Tambahkan kelas lainnya di sini -->
                </select>
        
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Mata Pelajaran</th>
                            <th>Nilai</th>
                            <th>Nama Guru</th> <!-- Tambahkan kolom ini -->
                        </tr>
                    </thead>
                    <tbody id="nilaiTableBody">
                        <!-- Data Nilai -->
                        <tr data-kelas="kelas1">
                            <td>Ahmad</td>
                            <td>Matematika</td>
                            <td contenteditable="true">85</td>
                            <td>Pak Budi</td> <!-- Nama Guru -->
                        </tr>
                        <tr data-kelas="kelas2">
                            <td>Budi</td>
                            <td>Fisika</td>
                            <td contenteditable="true">90</td>
                            <td>Bu Nina</td> <!-- Nama Guru -->
                        </tr>
                        <!-- Tambahkan baris lainnya sesuai dengan kelasnya -->
                    </tbody>
                </table>
                <button class="btn btn-primary" id="printBtn">Cetak Rapot</button>
            </div>
        </div>
        

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const kelasSelect = document.getElementById('kelas');
            const nilaiTableBody = document.getElementById('nilaiTableBody');
            const printBtn = document.getElementById('printBtn');
    
            // Fungsi untuk memfilter tabel berdasarkan kelas yang dipilih
            function filterTable() {
                const selectedKelas = kelasSelect.value;
    
                Array.from(nilaiTableBody.querySelectorAll('tr')).forEach(row => {
                    if (selectedKelas === '' || row.getAttribute('data-kelas') === selectedKelas) {
                        row.style.display = ''; // Tampilkan baris
                    } else {
                        row.style.display = 'none'; // Sembunyikan baris
                    }
                });
            }
    
            // Tambahkan event listener pada elemen select
            kelasSelect.addEventListener('change', filterTable);
    
            // Tambahkan event listener pada tombol print
            printBtn.addEventListener('click', function () {
                window.print();
            });
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const printBtn = document.getElementById('printBtn');
            
            printBtn.addEventListener('click', function () {
                window.print();
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
        });
    </script>
</body>
</html>
