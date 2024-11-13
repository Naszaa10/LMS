<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Tugas Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="../css/nilaiTugas.css"> -->
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

    <div id="mainContent">
        <div class="container mt-4">
            <h1 class="mb-4">Nilai Tugas Siswa</h1>
            <form id="nilaiForm">
                <div class="mb-3">
                    <label for="kelas" class="form-label">Kelas</label>
                    <select class="form-select" id="kelas" name="kelas" required>
                        <option value="">Pilih Kelas</option>
                        <?php while ($row = $resultClasses->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id_kelas']; ?>"><?php echo $row['jenjang'] . " " . $row['nama_kelas']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="mataPelajaran" class="form-label">Mata Pelajaran</label>
                    <select class="form-select" id="mataPelajaran" name="mataPelajaran" required>
                        <option value="">Pilih Mata Pelajaran</option>
                        <?php while ($row = $resultSubjects->fetch_assoc()) { ?>
                            <option value="<?php echo $row['kode_mapel']; ?>"><?php echo $row['nama_mapel'] . " - " . $row['deskripsi'] . " (" . $row['jenis'] . ")"; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div id="tableContainer">
                    <!-- Tabel akan diisi dengan data siswa berdasarkan kelas yang dipilih -->
                </div>
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
                fetch(`fetch_students_and_assignments.php?kelas=${selectedKelas}&mata_pelajaran=${selectedMataPelajaran}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            tableContainer.innerHTML = `<p>Error: ${data.error}</p>`;
                        } else {
                            let tableHtml = '<table id="example" class="table table-bordered">';
                            tableHtml += '<thead><tr><th>Nama Siswa</th><th>Nama Tugas</th><th>Nilai</th></tr></thead><tbody>';
                            data.forEach(student => {
                                const nilaiValue = student.nilai_tugas !== null ? student.nilai_tugas : '';
                                const tugasTitle = student.judul || 'Belum ada tugas';
                                tableHtml += `<tr>
                                                <td>${student.nama_siswa}</td>
                                                <td>${tugasTitle}</td>
                                                <td>${nilaiValue}</td>
                                            </tr>`;
                            });
                            tableHtml += '</tbody></table>';
                            tableContainer.innerHTML = tableHtml;

                            // Initialize DataTables on new table
                            $('#example').DataTable();
                        }
                    })
                    .catch(error => console.error('Error:', error));
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
