<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapot Cetak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="../css/rapot.css"> -->
</head>
<body>
<?php include '../navbar/navAdmin.php'; ?>
    <div class="container mt-2">
        <h1>Cetak Rapot</h1>

        <!-- Select Kelas -->
        <div class="mb-3">
            <label for="kelasSelect" class="form-label">Pilih Kelas</label>
            <select id="kelasSelect" name="kelas" class="form-select">
                <option value="">-- Pilih Kelas --</option>
                <option value="1">Kelas 1</option>
                <option value="2">Kelas 2</option>
                <option value="3">Kelas 3</option>
                <!-- Add more class options as needed -->
            </select>
        </div>

        <!-- Table with student names and print options -->
        <div id="studentsContainer" style="display:none;">
            <h3>Daftar Siswa</h3>
            <table id="example" class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAllStudents">
                            <label for="selectAllStudents">Pilih Semua</label>
                        </th>
                        <th>No</th>
                        <th>Nama Siswa</th>
                    </tr>
                </thead>
                <tbody id="studentsTableBody">
                    <!-- Data siswa akan dimuat secara dinamis menggunakan JavaScript -->
                </tbody>
            </table>
        </div>

        <div id="nilaiContainer" style="display:none;">
        <table id="example" class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mata Pelajaran</th>
                        <th>Nilai</th>
                        <th>Pengetahuan</th>
                        <th>Keterampilan</th>
                        <th>Tahun Ajaran</th>
                        <th>Nilai Akhir</th>
                        <th>Predikat</th>
                    </tr>
                </thead>
                <tbody id="nilaiTableBody">
                    <!-- Data nilai akan dimuat secara dinamis -->
                </tbody>
            </table>
        </div>
        <button class="btn btn-primary" id="printBtn">Cetak Rapot</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kelasSelect = document.getElementById('kelasSelect');
            const studentsContainer = document.getElementById('studentsContainer');
            const studentsTableBody = document.getElementById('studentsTableBody');
            const nilaiContainer = document.getElementById('nilaiContainer');
            const nilaiTable = document.getElementById('nilaiTable');
            const nilaiTableBody = document.getElementById('nilaiTableBody');
            const printBtn = document.getElementById('printBtn');

            // Dummy function to simulate fetching students based on class selected
            function loadStudents() {
                const kelasId = kelasSelect.value;

                if (kelasId) {
                    // Dummy student data
                    const students = [
                        { no: 1, nama_siswa: 'John Doe', nis: '12345' },
                        { no: 2, nama_siswa: 'Jane Smith', nis: '67890' },
                        { no: 3, nama_siswa: 'Alice Johnson', nis: '54321' },
                        // Add more students as needed
                    ];

                    studentsTableBody.innerHTML = ''; // Clear table body

                    students.forEach(student => {
                        const row = `
                            <tr>
                                <td><input type="checkbox" class="student-checkbox" id="student-${student.nis}"></td>
                                <td>${student.no}</td>
                                <td>${student.nama_siswa}</td>
                            </tr>`;
                        studentsTableBody.innerHTML += row;
                    });
                    studentsContainer.style.display = 'block';

                } else {
                    studentsContainer.style.display = 'none';
                }
            }

            kelasSelect.addEventListener('change', loadStudents);

            // Handle "Select All" checkbox functionality
            document.getElementById('selectAllStudents').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('input[type="checkbox"].student-checkbox');
                checkboxes.forEach((checkbox) => {
                    checkbox.checked = this.checked;
                });
            });

            // Function to load grades based on selected students
            function loadGrades() {
                const selectedNIS = [];
                const checkboxes = document.querySelectorAll('input[type="checkbox"].student-checkbox:checked');
                checkboxes.forEach((checkbox) => {
                    const studentId = checkbox.id.split('-')[1]; // Get NIS from checkbox id
                    selectedNIS.push(studentId);
                });

                if (selectedNIS.length > 0) {
                    // Dummy grades data based on selected students
                    const dummyGrades = [
                        { mata_pelajaran: 'Matematika', nilai: 85, pengetahuan: 'A', keterampilan: 'A', tahun_ajaran: '2024', nilai_akhir: '90', predikat: 'Baik' },
                        { mata_pelajaran: 'Bahasa Inggris', nilai: 78, pengetahuan: 'B', keterampilan: 'B', tahun_ajaran: '2024', nilai_akhir: '85', predikat: 'Baik' },
                        // Add more grades if needed
                    ];

                    nilaiTableBody.innerHTML = ''; // Clear table body

                    dummyGrades.forEach((grade, index) => {
                        const row = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${grade.mata_pelajaran}</td>
                                <td contenteditable="true">${grade.nilai}</td>
                                <td contenteditable="true">${grade.pengetahuan}</td>
                                <td contenteditable="true">${grade.keterampilan}</td>
                                <td contenteditable="true">${grade.tahun_ajaran}</td>
                                <td contenteditable="true">${grade.nilai_akhir}</td>
                                <td contenteditable="true">${grade.predikat}</td>
                            </tr>`;
                        nilaiTableBody.innerHTML += row;
                    });
                    nilaiTable.style.display = 'table';
                    nilaiContainer.style.display = 'block';
                } else {
                    nilaiTable.style.display = 'none';
                    nilaiContainer.style.display = 'none';
                }
            }

            // Event listener for print button
            printBtn.addEventListener('click', () => {
                loadGrades(); // Load grades before printing
                const selectedStudents = [];
                const checkboxes = document.querySelectorAll('input[type="checkbox"].student-checkbox:checked');
                checkboxes.forEach((checkbox) => {
                    const row = checkbox.closest('tr');
                    const studentData = Array.from(row.cells).map(cell => cell.innerText);
                    selectedStudents.push(studentData);
                });

                if (selectedStudents.length > 0) {
                    console.log('Students selected for printing:', selectedStudents);
                    // You can implement the actual print functionality here
                    window.print();
                } else {
                    alert('Silakan pilih setidaknya satu siswa untuk dicetak.');
                }
            });
        });
    </script>

<?php include '../navbar/navFooter.php'; ?>
<?php include '../navbar/tabelSeries.php'; ?>

</body>
</html>
