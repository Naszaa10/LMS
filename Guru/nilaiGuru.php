<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/nilai.css">
</head>
<body>
<?php
    include '../navbar/navHeader.php';
    ?>
        <div id="mainContent">
            <div class="container mt-5">
                <h2 class="mb-4">Input Nilai Siswa</h2>
                <form id="nilaiForm">
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <select class="form-select" id="kelas">
                            <option selected>Pilih Kelas</option>
                            <option value="kelas1">Kelas 1</option>
                            <option value="kelas2">Kelas 2</option>
                            <!-- Tambahkan kelas lainnya di sini -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mataPelajaran" class="form-label">Mata Pelajaran</label>
                        <select class="form-select" id="mataPelajaran">
                            <option selected>Pilih Mata Pelajaran</option>
                            <option value="matematika">Matematika</option>
                            <option value="bahasa_indonesia">Bahasa Indonesia</option>
                            <!-- Tambahkan mata pelajaran lainnya di sini -->
                        </select>
                    </div>
                    <div id="tableContainer">
                        <!-- Tabel akan diisi dengan data siswa berdasarkan kelas yang dipilih -->
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Simpan Nilai</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const kelasSelect = document.getElementById('kelas');
            const tableContainer = document.getElementById('tableContainer');

            kelasSelect.addEventListener('change', function () {
                const selectedKelas = kelasSelect.value;
                // Simulated data for students based on the selected class
                const students = {
                    kelas1: ['Siswa 1', 'Siswa 2', 'Siswa 3'],
                    kelas2: ['Siswa 4', 'Siswa 5', 'Siswa 6']
                };

                const selectedStudents = students[selectedKelas] || [];

                // Generate table HTML
                let tableHtml = '<table class="table table-bordered">';
                tableHtml += '<thead><tr><th class="siswa">Nama Siswa</th><th class="nilai">Nilai</th></tr></thead><tbody>';

                selectedStudents.forEach(student => {
                    tableHtml += `<tr><td class="siswa">${student}</td><td class="nilai"><input type="number" class="form-control" name="${student}" min="0" max="100"></td></tr>`;
                });

                tableHtml += '</tbody></table>';

                tableContainer.innerHTML = tableHtml;
            });
        });
    </script>

<?php
    include '../navbar/navFooter.php';
    ?>
</body>
</html>
