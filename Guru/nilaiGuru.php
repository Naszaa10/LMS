<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="../css/nilai.css"> -->
</head>
<?php include '../navbar/navHeader.php';

$nip = $_SESSION['teacher_nip'];

// Ambil kelas yang diajar oleh guru
$queryClasses = "SELECT DISTINCT kelas.id_kelas, kelas.nama_kelas, kelas.jenjang
                 FROM kelas 
                 JOIN jadwal ON kelas.id_kelas = jadwal.id_kelas 
                 WHERE jadwal.nip = ?";
$stmtClasses = $conn->prepare($queryClasses);
$stmtClasses->bind_param("s", $nip);
$stmtClasses->execute();
$resultClasses = $stmtClasses->get_result();

// Ambil mata pelajaran yang diajar oleh guru
$querySubjects = "SELECT DISTINCT mata_pelajaran.kode_mapel, mata_pelajaran.nama_mapel, mata_pelajaran.deskripsi, mata_pelajaran.jenis, mata_pelajaran.gambar
                  FROM mata_pelajaran 
                  JOIN jadwal ON mata_pelajaran.kode_mapel = jadwal.kode_mapel 
                  WHERE jadwal.nip = ?";
$stmtSubjects = $conn->prepare($querySubjects);
$stmtSubjects->bind_param("s", $nip);
$stmtSubjects->execute();
$resultSubjects = $stmtSubjects->get_result();
?>
<body>
    <div id="mainContent">
        <div class="container mt-4">
            <h1 class="mb-4">Input Nilai Siswa</h1>
            <form id="nilaiForm" method="post" action="save_nilai.php">
                <!-- Form Pilihan Kelas dan Mata Pelajaran -->
                <div class="mb-3">
                    <label for="kelas" class="form-label">Kelas</label>
                    <select class="form-select" id="kelas" name="kelas" required>
                        <option value="">Pilih Kelas</option>
                        <?php while ($row = $resultClasses->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id_kelas']; ?>"> <?php echo $row['jenjang']. " " .$row['nama_kelas']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="mataPelajaran" class="form-label">Mata Pelajaran</label>
                    <select class="form-select" id="mataPelajaran" name="mataPelajaran" required>
                        <option value="">Pilih Mata Pelajaran</option>
                        <?php while ($row = $resultSubjects->fetch_assoc()) { ?>
                            <option value="<?php echo $row['kode_mapel']; ?>">
                                <?php echo $row['nama_mapel'] . " - " . $row['deskripsi'] . " (" . $row['jenis'] . ")"; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div id="tableContainer">
                    <!-- Tabel akan diisi dengan data siswa berdasarkan kelas yang dipilih -->
                </div>
                <button type="submit" class="btn btn-primary mt-4">Simpan Nilai</button>
            </form>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const kelasSelect = document.getElementById('kelas');
        const mataPelajaranSelect = document.getElementById('mataPelajaran');
        const tableContainer = document.getElementById('tableContainer');

        function updateTable() {
            const selectedKelas = kelasSelect.value;
            const selectedMataPelajaran = mataPelajaranSelect.value;

            if (selectedKelas && selectedMataPelajaran) {
                fetch(`fetch_students.php?kelas=${selectedKelas}&mata_pelajaran=${selectedMataPelajaran}`)
                    .then(response => response.json())
                    .then(data => {
                        let tableHtml = `
                            <table id="example" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Siswa</th>
                                        <th>Pengetahuan</th>
                                        <th>Keterampilan</th>
                                        <th>Nilai</th>
                                        <th>Predikat</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                        data.forEach(student => {
                            const pengetahuanValue = student.pengetahuan !== null ? student.pengetahuan : '';
                            const keterampilanValue = student.keterampilan !== null ? student.keterampilan : '';
                            const nilaiValue = student.nilai !== null ? student.nilai : '';
                            const predikatValue = student.predikat !== null ? student.predikat : '';

                            tableHtml += `
                                <tr>
                                    <td>${student.nama_siswa}</td>
                                    <td><input type="number" class="form-control" name="pengetahuan[${student.nis}]" value="${pengetahuanValue}" min="0" max="100"></td>
                                    <td><input type="number" class="form-control" name="keterampilan[${student.nis}]" value="${keterampilanValue}" min="0" max="100"></td>
                                    <td><input type="number" class="form-control" name="nilai[${student.nis}]" value="${nilaiValue}" min="0" max="100"></td>
                                    <td><input type="text" class="form-control" name="predikat[${student.nis}]" value="${predikatValue}"></td>
                                </tr>`;
                        });

                        tableHtml += '</tbody></table>';
                        tableContainer.innerHTML = tableHtml;

                        // Inisialisasi DataTables setelah tabel di-render
                        $('#example').DataTable();
                    });
            } else {
                tableContainer.innerHTML = '';
            }
        }

        kelasSelect.addEventListener('change', updateTable);
        mataPelajaranSelect.addEventListener('change', updateTable);
    });
    </script>

    <?php include '../navbar/navFooter.php'; ?>
    <?php include '../navbar/tabelSeries.php'; ?>
</body>
</html>


<?php
// Tutup koneksi database
$conn->close();
?>
