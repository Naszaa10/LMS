<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Series dengan Sorting</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        th {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Tabel Series</h1>
        <table class="table table-striped" id="seriesTable">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">No.</th>
                    <th onclick="sortTable(1)">Nama Series</th>
                    <th onclick="sortTable(2)">Tahun Rilis</th>
                    <th onclick="sortTable(3)">Genre</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Series A</td>
                    <td>2020</td>
                    <td>Drama</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Series B</td>
                    <td>2021</td>
                    <td>Action</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Series C</td>
                    <td>2022</td>
                    <td>Komedi</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let sortDirection = true; // true = ascending, false = descending

        function sortTable(columnIndex) {
            const table = document.getElementById("seriesTable");
            const rows = Array.from(table.rows).slice(1); // Ambil semua baris kecuali header
            const sortedRows = rows.sort((a, b) => {
                const cellA = a.cells[columnIndex].innerText;
                const cellB = b.cells[columnIndex].innerText;

                if (columnIndex === 2) { // Jika kolom tahun rilis, ubah ke number
                    return sortDirection ? cellA - cellB : cellB - cellA;
                } else { // Untuk kolom teks
                    return sortDirection ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
                }
            });

            // Ganti arah pengurutan
            sortDirection = !sortDirection;

            // Tambahkan kembali baris yang telah diurutkan ke tabel
            sortedRows.forEach(row => table.appendChild(row));
        }
    </script>
</body>
</html>
