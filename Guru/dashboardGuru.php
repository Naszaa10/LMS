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

<?php include '../navbar/navHeader.php'; ?>

            <div id="mainContent" class="container-fluid mt-1">
                <h1 class="mt-4">Dashboard Guru</h1>
                <p>Selamat datang di dashboard  guru. Di sini Anda dapat melihat</p>
                
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
        
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and custom JS -->
    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>
