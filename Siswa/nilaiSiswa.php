<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/nilai.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
    include '../navbar/navSiswa.php';
    ?>

        <div id="mainContent">
            <div class="container mt-5">
                <h2 class="mb-4">Nilai Siswa</h2>

                <table class="table">
                    <thead>
                        <tr>
                            <th class="mapel">Mata Pelajaran</th>
                            <th class="nilai">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data Nilai Siswa -->
                        <tr>
                            <td class="mapel">Matematika</td>
                            <td class="nilai">85</td>
                        </tr>
                        <tr>
                            <td class="mapel">Bahasa Indonesia</td>
                            <td class="nilai">90</td>
                        </tr>
                        <tr>
                            <td class="mapel">IPA</td>
                            <td class="nilai">88</td>
                        </tr>
                    </tbody>
                </table>
                <button id="downloadPdf" class="btn btn-primary mt-4">Download PDF</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        document.getElementById('downloadPdf').addEventListener('click', () => {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.text('Nilai Siswa', 10, 10);

            const table = document.querySelector('table');
            const rows = table.querySelectorAll('tbody tr');
            const headers = table.querySelectorAll('thead th');
            const data = [];
            
            // Adding headers
            const header = headers.map(header => header.innerText);
            data.push(header);

            // Adding rows
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowData = Array.from(cells).map(cell => cell.innerText);
                data.push(rowData);
            });

            doc.autoTable({
                head: [header],
                body: data.slice(1),
                startY: 20
            });

            doc.save('nilai_siswa.pdf');
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebarMenu');
    
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('show');
        });
    });</script>

<?php
    include '../navbar/navFooter.php';
    ?>
</body>
</html>
