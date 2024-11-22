<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Nilai</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- <link rel="stylesheet" href="..\css\nilaiTugas.css"> -->
</head>
<body>
<?php include '../navbar/navAdmin.php';
// Fetching Kelas and Tahun Ajaran from table 'nilai'
$sql_kelas = "SELECT DISTINCT k.id_kelas, k.nama_kelas, k.jenjang FROM nilai n JOIN kelas k ON n.id_kelas = k.id_kelas";
$sql_tahun_ajaran = "SELECT DISTINCT ta.id_tahun_ajaran, ta.tahun_ajaran FROM nilai n JOIN tahun_ajaran ta ON n.id_tahun_ajaran = ta.id_tahun_ajaran";

$result_kelas = $conn->query($sql_kelas);
$result_tahun_ajaran = $conn->query($sql_tahun_ajaran);

// Fetching NIS dynamically via AJAX based on Kelas and Tahun Ajaran
if (isset($_POST['fetch_nis'])) {
    $kelas_id = $_POST['kelas'];
    $tahun_ajaran_id = $_POST['tahun_ajaran'];

    // SQL untuk mengambil NIS berdasarkan kelas dan tahun ajaran
    $sql_nis = "SELECT DISTINCT s.nis, s.nama_siswa FROM nilai n
    INNER JOIN siswa s ON n.nis = s.nis
    WHERE n.id_kelas = ? AND n.id_tahun_ajaran = ?";

    $stmt = $conn->prepare($sql_nis);
    $stmt->bind_param("ii", $kelas_id, $tahun_ajaran_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Buat response dalam bentuk <option> HTML
    $nis_options = "<option value=''>Pilih NIS</option>";
    while ($row = $result->fetch_assoc()) {
        $nis_options .= "<option value='{$row['nis']}'>{$row['nis']} - {$row['nama_siswa']}</option>";
    }
    
    echo $nis_options;
    exit;
}

// Fetching data nilai berdasarkan Kelas, Tahun Ajaran, dan NIS
if (isset($_POST['fetch_nilai'])) {
    $kelas_id = $_POST['kelas'];
    $tahun_ajaran_id = $_POST['tahun_ajaran'];
    $nis = $_POST['nis'];

    // SQL untuk mengambil nilai berdasarkan kelas, tahun ajaran, dan NIS
    $sql_nilai = "SELECT n.nis, s.nama_siswa, ta.tahun_ajaran, n.nilai, n.pengetahuan, n.keterampilan, n.predikat
                  FROM nilai n
                  JOIN siswa s ON n.nis = s.nis
                  JOIN tahun_ajaran ta ON n.id_tahun_ajaran = ta.id_tahun_ajaran
                  WHERE n.id_kelas = ? AND n.id_tahun_ajaran = ? AND n.nis = ?";
    $stmt = $conn->prepare($sql_nilai);
    $stmt->bind_param("iii", $kelas_id, $tahun_ajaran_id, $nis);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Kembalikan data dalam bentuk JSON
    echo json_encode($data);
    exit;
}
?>


    <div class="container mt-4">
        <h1>Manage Nilai</h1>

        <form action="" method="post" class="mb-4" id="filterForm">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="kelas">Kelas:</label>
                    <select id="kelas" name="kelas" class="form-control" required>
                        <option value="">Pilih Kelas</option>
                        <?php while ($row = $result_kelas->fetch_assoc()): ?>
                            <option value="<?php echo $row['id_kelas']; ?>"><?= $row['jenjang'] ?> <?php echo $row['nama_kelas']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="tahun_ajaran">Tahun Ajaran:</label>
                    <select id="tahun_ajaran" name="tahun_ajaran" class="form-control" required>
                        <option value="">Pilih Tahun Ajaran</option>
                        <?php while ($row = $result_tahun_ajaran->fetch_assoc()): ?>
                            <option value="<?php echo $row['id_tahun_ajaran']; ?>"><?php echo $row['tahun_ajaran']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group col-md-4 align-self-end">
                    <button type="button" id="fetchNIS" class="btn btn-success">Ambil NIS</button>
                </div>
            </div>
        </form>

        <form action="" method="post" class="mb-4" id="nisForm">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="nis">NIS:</label>
                    <select id="nis" name="nis" class="form-control" required>
                        <option value="">Pilih NIS</option>
                        <!-- NIS akan dimuat di sini melalui AJAX -->
                    </select>
                </div>
                <div class="form-group col-md-4 align-self-end">
                    <button type="button" id="filterData" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <table id="example" class="table table-bordered">
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Tahun Ajaran</th>
                    <th>Nilai</th>
                    <th>Pengetahuan</th>
                    <th>Keterampilan</th>
                    <th>Predikat</th>
                </tr>
            </thead>
            <tbody id="nilaiTableBody">
                <!-- Data nilai akan dimuat di sini -->
            </tbody>
        </table>
    </div>

    <?php include '../navbar/navFooter.php'; ?>
    <?php include '../navbar/tabelSeries.php'; ?>

    <script>
        $(document).ready(function() {
            // Fetch NIS based on Kelas and Tahun Ajaran
            $('#fetchNIS').click(function() {
                const kelas = $('#kelas').val();
                const tahun_ajaran = $('#tahun_ajaran').val();

                if (kelas && tahun_ajaran) {
                    $.ajax({
                        url: '', // URL halaman yang sama
                        type: 'POST',
                        data: {
                            kelas: kelas,
                            tahun_ajaran: tahun_ajaran,
                            fetch_nis: true
                        },
                        success: function(response) {
                            $('#nis').html(response);
                        },
                        error: function(xhr, status, error) {
                            alert("Terjadi kesalahan: " + error);
                        }
                    });
                } else {
                    alert("Silakan pilih kelas dan tahun ajaran terlebih dahulu.");
                }
            });

            // Fetch and display data nilai based on filter
            $('#filterData').click(function() {
                const kelas = $('#kelas').val();
                const tahun_ajaran = $('#tahun_ajaran').val();
                const nis = $('#nis').val();

                if (kelas && tahun_ajaran && nis) {
                    $.ajax({
                        url: '', // URL halaman yang sama
                        type: 'POST',
                        data: {
                            kelas: kelas,
                            tahun_ajaran: tahun_ajaran,
                            nis: nis,
                            fetch_nilai: true
                        },
                        success: function(response) {
                            const data = JSON.parse(response);
                            let tableBody = '';

                            if (data.length > 0) {
                                data.forEach(function(row) {
                                    tableBody += `
                                        <tr>
                                            <td>${row.nis}</td>
                                            <td>${row.nama_siswa}</td>
                                            <td>${row.tahun_ajaran}</td>
                                            <td>${row.nilai}</td>
                                            <td>${row.pengetahuan}</td>
                                            <td>${row.keterampilan}</td>
                                            <td>${row.predikat}</td>
                                        </tr>
                                    `;
                                });
                            } else {
                                tableBody = '<tr><td colspan="7" class="text-center">Data tidak ditemukan</td></tr>';
                            }

                            $('#nilaiTableBody').html(tableBody);
                        },
                        error: function(xhr, status, error) {
                            alert("Terjadi kesalahan: " + error);
                        }
                    });
                } else {
                    alert("Silakan lengkapi form filter terlebih dahulu.");
                }
            });
        });
    </script>
</body>
</html>
