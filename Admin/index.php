<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboardAdmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php include '../navbar/navAdmin.php'; ?>

<?php 
// Koneksi ke database
include '../db.php'; 

// Query untuk menghitung jumlah login siswa hari ini
$query_login_siswa = "SELECT COUNT(*) AS jumlah FROM siswa WHERE DATE(terakhir_login) = CURDATE()";
$result_login_siswa = $conn->query($query_login_siswa);
$row_login_siswa = $result_login_siswa->fetch_assoc();
$jumlah_login_siswa = $row_login_siswa['jumlah'];

// Query untuk menghitung jumlah login guru hari ini
$query_login_guru = "SELECT COUNT(*) AS jumlah FROM guru WHERE DATE(terakhir_login) = CURDATE()";
$result_login_guru = $conn->query($query_login_guru);
$row_login_guru = $result_login_guru->fetch_assoc();
$jumlah_login_guru = $row_login_guru['jumlah'];

// Query untuk menghitung jumlah guru
$query_guru = "SELECT COUNT(*) AS jumlah FROM guru";
$result_guru = $conn->query($query_guru);
$row_guru = $result_guru->fetch_assoc();
$jumlah_guru = $row_guru['jumlah'];

// Query untuk menghitung jumlah siswa
$query_siswa = "SELECT COUNT(*) AS jumlah FROM siswa";
$result_siswa = $conn->query($query_siswa);
$row_siswa = $result_siswa->fetch_assoc();
$jumlah_siswa = $row_siswa['jumlah'];

// Query untuk menghitung jumlah kelas
$query_kelas = "SELECT COUNT(*) AS jumlah FROM kelas";
$result_kelas = $conn->query($query_kelas);
$row_kelas = $result_kelas->fetch_assoc();
$jumlah_kelas = $row_kelas['jumlah'];

// Query untuk menghitung jumlah jurusan
$query_jurusan = "SELECT COUNT(*) AS jumlah FROM jurusan";
$result_jurusan = $conn->query($query_jurusan);
$row_jurusan = $result_jurusan->fetch_assoc();
$jumlah_jurusan = $row_jurusan['jumlah'];

// Query untuk menghitung jumlah mata pelajaran
$query_mata_pelajaran = "SELECT COUNT(*) AS jumlah FROM mata_pelajaran";
$result_mata_pelajaran = $conn->query($query_mata_pelajaran);
$row_mata_pelajaran = $result_mata_pelajaran->fetch_assoc();
$jumlah_mapel = $row_mata_pelajaran['jumlah'];

// Query untuk menghitung jumlah siswa per kelas
$query_siswa_per_kelas = "
    SELECT k.nama_kelas, COUNT(s.nis) AS jumlah 
    FROM siswa s
    JOIN kelas k ON s.id_kelas = k.id_kelas
    GROUP BY k.nama_kelas";
$siswa_per_kelas_result = $conn->query($query_siswa_per_kelas);

$kelas_labels = [];
$kelas_data = [];

// Ambil data jumlah siswa per kelas
while ($row = $siswa_per_kelas_result->fetch_assoc()) {
    $kelas_labels[] = $row['nama_kelas'];
    $kelas_data[] = $row['jumlah'];
}

// Query untuk menghitung jumlah siswa per jurusan
$query_siswa_per_jurusan = "
    SELECT j.nama_jurusan, COUNT(s.nis) AS jumlah 
    FROM siswa s
    JOIN jurusan j ON s.id_jurusan = j.id_jurusan
    GROUP BY j.nama_jurusan";
$siswa_per_jurusan_result = $conn->query($query_siswa_per_jurusan);

$jurusan_labels = [];
$jurusan_data = [];

// Ambil data jumlah siswa per jurusan
while ($row = $siswa_per_jurusan_result->fetch_assoc()) {
    $jurusan_labels[] = $row['nama_jurusan'];
    $jurusan_data[] = $row['jumlah'];
}
?>

<div id="mainContent" class="container mt-4">
    <h1 class="mt-4">Dashboard Admin</h1>
    <p>Selamat datang di dashboard admin guru. Di sini Anda dapat mengelola semua data penting seperti guru, siswa, jurusan, dan jadwal pelajaran.</p>
    
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-chalkboard-teacher fa-2x me-3"></i>
                    <div>
                        Guru
                        <div class="text-white-50 small">Jumlah: <?php echo $jumlah_guru; ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-user-graduate fa-2x me-3"></i>
                    <div>
                        Siswa
                        <div class="text-white-50 small">Jumlah: <?php echo $jumlah_siswa; ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-warning text-white shadow">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-book-open fa-2x me-3"></i>
                    <div>
                        Jurusan
                        <div class="text-white-50 small">Jumlah: <?php echo $jumlah_jurusan; ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-dark text-white shadow">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-school fa-2x me-3"></i>
                    <div>
                        Kelas
                        <div class="text-white-50 small">Jumlah: <?php echo $jumlah_kelas; ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-danger text-white shadow">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-book fa-2x me-3"></i>
                    <div>
                        Mata Pelajaran
                        <div class="text-white-50 small">Jumlah: <?php echo $jumlah_mapel; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Perbandingan Jumlah Siswa per Kelas -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title">Statistik Siswa per Kelas</h5>
                </div>
                <div class="card-body">
                    <canvas id="kelasChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title">Statistik Siswa per Jurusan</h5>
                </div>
                <div class="card-body">
                    <canvas id="jurusanChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title">Jumlah Login Guru dan Siswa Hari Ini</h5>
                </div>
                <div class="card-body">
                    <canvas id="loginChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include '../navbar/navFooter.php'; ?>


<!-- Script Chart.js untuk menampilkan grafik -->
<!-- Script Chart.js untuk menampilkan grafik -->
<script>
    const ctxKelas = document.getElementById('kelasChart').getContext('2d');
    const kelasChart = new Chart(ctxKelas, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($kelas_labels); ?>,
            datasets: [{
                label: 'Jumlah Siswa per Kelas',
                data: <?php echo json_encode($kelas_data); ?>,
                backgroundColor: '#007bff',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0 // memastikan sumbu y hanya menunjukkan angka bulat
                    }
                }
            }
        }
    });

    const ctxJurusan = document.getElementById('jurusanChart').getContext('2d');
    const jurusanChart = new Chart(ctxJurusan, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($jurusan_labels); ?>,
            datasets: [{
                label: 'Jumlah Siswa per Jurusan',
                data: <?php echo json_encode($jurusan_data); ?>,
                backgroundColor: '#FF6384',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0 // memastikan sumbu y hanya menunjukkan angka bulat
                    }
                }
            }
        }
    });

    const ctxLogin = document.getElementById('loginChart').getContext('2d');
    const loginChart = new Chart(ctxLogin, {
        type: 'bar',
        data: {
            labels: ['Guru', 'Siswa'],
            datasets: [{
                label: 'Jumlah Login Hari Ini',
                data: [<?php echo $jumlah_login_guru; ?>, <?php echo $jumlah_login_siswa; ?>],
                backgroundColor: ['#DC3545', '#28A745'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0 // memastikan sumbu y hanya menunjukkan angka bulat
                    }
                }
            }
        }
    });
</script>



</body>
</html>
