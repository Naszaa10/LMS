<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
    <style>
        body {
            background-color: #f8f9fa; /* Warna latar belakang yang lebih terang */
        }

        .card {
            transition: transform 0.3s, box-shadow 0.3s; /* Animasi saat hover */
        }

        .card:hover {
            transform: translateY(-5px); /* Efek mengangkat saat hover */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Bayangan lebih besar saat hover */
        }

        .text-white-50 {
            opacity: 0.75; /* Sedikit transparansi pada teks */
        }

        /* Kustomisasi warna untuk kesesuaian dengan sidebar */
        .bg-primary {
            background-color: #007bff !important; /* Warna sesuai dengan sidebar */
        }

        .bg-success {
            background-color: #28a745 !important; /* Warna sesuai dengan sidebar */
        }

        h1, h2 {
            color: #333; /* Warna teks judul */
        }

        #calendar {
            max-width: 100%; /* Lebar maksimum kalender */
            margin: 0 auto; /* Centering the calendar */
        }

        #clock {
            font-size: 2rem; /* Ukuran font jam */
            font-weight: bold;
            color: #333;
            text-align: center;
            margin: 20px 0; /* Margin atas dan bawah */
        }

        .fc-toolbar-title {
            font-size: 1.5rem; /* Ukuran font nama bulan */
            font-weight: bold;
            color: #333; /* Warna nama bulan */
        }
    </style>
</head>
<body>
<?php include '../navbar/navHeader.php'; ?>
<?php
// Query untuk mendapatkan jumlah mata pelajaran unik dari tabel jadwal
$queryMataPelajaran = "SELECT COUNT(DISTINCT kode_mapel) as jumlah FROM jadwal WHERE nip = '$nip'";
$resultMataPelajaran = mysqli_query($conn, $queryMataPelajaran);
$rowMataPelajaran = mysqli_fetch_assoc($resultMataPelajaran);
$jumlahMataPelajaran = $rowMataPelajaran['jumlah'];

// Query untuk mendapatkan jumlah jadwal
$queryJadwal = "SELECT COUNT(*) as jumlah FROM jadwal WHERE nip = '$nip'";
$resultJadwal = mysqli_query($conn, $queryJadwal);
$rowJadwal = mysqli_fetch_assoc($resultJadwal);
$jumlahJadwal = $rowJadwal['jumlah'];

// Query untuk mendapatkan pengumuman terbaru
$queryPengumuman = "SELECT isi_pengumuman FROM pengumuman WHERE id = (SELECT MAX(id) FROM pengumuman WHERE role IN ('guru', 'semua'));";
$resultPengumuman = mysqli_query($conn, $queryPengumuman);

// Periksa apakah ada pengumuman
if (mysqli_num_rows($resultPengumuman) > 0) {
    $rowPengumuman = mysqli_fetch_assoc($resultPengumuman);
    $isiPengumuman = $rowPengumuman['isi_pengumuman'];
} else {
    $isiPengumuman = "Belum ada pengumuman.";
}

// Query untuk mendapatkan jumlah siswa yang login berdasarkan kelas, hanya hari ini
$querySiswaLogin = "
SELECT k.nama_kelas, COUNT(s.id_kelas) AS jumlah_login
FROM siswa s
JOIN kelas k ON s.id_kelas = k.id_kelas
WHERE DATE(s.terakhir_login) = CURDATE()
GROUP BY k.nama_kelas";
$resultSiswaLogin = mysqli_query($conn, $querySiswaLogin);

$kelasData = [];
$jumlahLoginData = [];

while ($row = mysqli_fetch_assoc($resultSiswaLogin)) {
    $kelasData[] = $row['nama_kelas'];
    $jumlahLoginData[] = $row['jumlah_login'];
}
?>
<div id="mainContent" class="container mt-4">
    <h1 class="mt-4">Dashboard Guru</h1>
    <p>Selamat datang di dashboard Guru. Di sini Anda dapat melihat informasi penting.</p>

    <div class="row mb-4">
        <div class="col-lg-8 col-md-8 mb-4">
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="card bg-primary text-white shadow">
                        <div class="card-body d-flex align-items-center">
                            <i class="fas fa-book fa-2x me-3"></i>
                            <div>
                                <h5>Mata Pelajaran</h5>
                                <div class="text-white-50 small">Jumlah: <?php echo $jumlahMataPelajaran; ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="card bg-success text-white shadow">
                        <div class="card-body d-flex align-items-center">
                            <i class="fas fa-calendar-alt fa-2x me-3"></i>
                            <div>
                                <h5>Jadwal</h5>
                                <div class="text-white-50 small">Jumlah: <?php echo $jumlahJadwal; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="mt-1">Pengumuman</h2>
            <div class="card mb-1">
                <div class="card-body">
                    <h5 class="card-title">Pengumuman Terbaru</h5>
                    <textarea class="form-control" rows="5" readonly><?php echo $isiPengumuman; ?></textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-8 mb-5">
            <!-- Card untuk jam -->
            <!-- <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title text-center">Jam Sekarang</h5>
                    <div id="clock" class="text-center"></div>
                </div>
            </div> -->

            <!-- Card untuk kalender -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title text-center">Kalender</h5>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="row mt-0">
        <div class="col-lg-10 col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Siswa yang Login Berdasarkan Kelas</h5>
                    <canvas id="loginChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js and FullCalendar -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>

<script>
    // Initialize the chart
    const ctx = document.getElementById('loginChart').getContext('2d');
    const loginChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($kelasData); ?>,
            datasets: [{
                label: 'Jumlah Siswa Login',
                data: <?php echo json_encode($jumlahLoginData); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
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

    /// Inisialisasi kalender
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth', // Tampilkan bulan
            headerToolbar: {
                left: '',
                center: 'title',
                right: ''
            },
            editable: false,
            selectable: false,
            events: [
                // Tambahkan event di sini jika perlu
            ]
        });
        calendar.render();
    });
</script>

<?php include '../navbar/navFooter.php'; ?>
