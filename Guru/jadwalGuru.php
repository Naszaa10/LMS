<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Mengajar Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/jadwal.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
    include '../navbar/navHeader.php';
    ?>
        <div id="mainContent" class="container">
            <h2 class="mb-4">Jadwal Mengajar</h2>
            <div class="mb-6">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari Nama Guru">
            </div>
            <table class="table" id="jadwalTable">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Guru</th>
                        <th>Mata Pelajaran</th>
                        <th>Hari</th>
                        <th>Kelas</th>
                        <th>Jam</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Budi</td>
                        <td>Matematika</td>
                        <td>Senin</td>
                        <td>XII IPA 1</td>
                        <td>08:00 - 09:30</td>
                    </tr>
                    <tr>
                        <td>Budi</td>
                        <td>Matematika</td>
                        <td>Senin</td>
                        <td>XII IPA 1</td>
                        <td>10:00 - 23:30</td>
                    </tr>
                    <tr>
                        <td>Cici</td>
                        <td>Fisika</td>
                        <td>Rabu</td>
                        <td>XII IPA 2</td>
                        <td>10:00 - 11:30</td>
                    </tr>
                    <tr>
                        <td>Nina</td>
                        <td>Bahasa Indonesia</td>
                        <td>Jumat</td>
                        <td>XII IPS 1</td>
                        <td>09:00 - 10:30</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let table = document.getElementById('scheduleTable');
            let tr = table.getElementsByTagName('tr');
            
            for (let i = 0; i < tr.length; i++) {
                let td = tr[i].getElementsByTagName('td')[0]; // kolom pertama (nama guru)
                if (td) {
                    let txtValue = td.textContent || td.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }       
            }
        });
    </script>

<?php
    include '../navbar/navFooter.php';
?>
</body>
</html>
