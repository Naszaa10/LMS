<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\css\dashboardAdmin.css">
</head>
<body>

<?php include '../navbar/navAdmin.php'; ?>

            <div id="mainContent" class="container-fluid mt-1">
                <h1 class="mt-4">Dashboard Admin</h1>
                <p>Selamat datang di dashboard admin guru. Di sini Anda dapat mengelola</p>
                
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-primary text-white shadow">
                            <div class="card-body">
                                Guru
                                <div class="text-white-50 small">Jumlah :</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-success text-white shadow">
                            <div class="card-body">
                                Siswa
                                <div class="text-white-50 small">Jumlah :</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-warning text-white shadow">
                            <div class="card-body">
                                Jurusan
                                <div class="text-white-50 small">Jumlah :</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-dark text-white shadow">
                            <div class="card-body">
                                Kelas
                                <div class="text-white-50 small">Jumlah :</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-danger text-white shadow">
                            <div class="card-body">
                                Mata Pelajaran
                                <div class="text-white-50 small">Jumlah :</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-info text-white shadow">
                            <div class="card-body">
                                Kelola Jadwal
                                <div class="text-white-50 small">Kelola Jadwal Pelajaran</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-secondary text-white shadow">
                            <div class="card-body">
                                Rapot
                                <div class="text-white-50 small">Kelola dan Lihat Rapot Siswa</div>
                            </div>
                        </div>
                    </div>
        
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and custom JS -->
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>
