<?php
include '../navbar/navAdmin.php';
include '../db.php'; // Include the database connection

// Function to get students by class
function getStudentsByClass($classId) {
    global $conn;
    $sql = "SELECT nis, nama_siswa FROM siswa WHERE id_kelas = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $classId);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to get all classes with jenjang (grade level)
function getAllClasses() {
    global $conn;
    $sql = "SELECT id_kelas, nama_kelas, jenjang FROM kelas";
    $result = $conn->query($sql);
    return $result;
}
?>

<div class="container mt-4">
    <h1 class="text-center mb-4">Cetak Rapot</h1>

    <!-- Select Kelas (Classes dropdown populated from the database) -->
    <div class="mb-4">
        <label for="kelasSelect" class="form-label">Pilih Kelas</label>
        <select id="kelasSelect" name="kelas" class="form-select">
            <option value="">-- Pilih Kelas --</option>
            <?php
            // Fetch and display the list of classes with their jenjang
            $kelasResult = getAllClasses();
            while ($row = $kelasResult->fetch_assoc()) {
                echo "<option value='" . $row['id_kelas'] . "'>" . $row['jenjang'] . " - " . $row['nama_kelas'] . "</option>";
            }
            ?>
        </select>
    </div>

    <!-- Students Table -->
    <div id="studentsContainer" style="display:none;">
        <h3 class="text-success">Daftar Siswa</h3>
        <table class="table table-striped table-bordered">
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
                <!-- Student rows will be dynamically added here -->
            </tbody>
        </table>
    </div>

    <!-- Grades Table -->
    <div id="nilaiContainer" style="display:none;">
        <h3 class="text-info">Nilai Siswa</h3>
        <table class="table table-striped table-bordered">
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
                <!-- Grades rows will be dynamically added here -->
            </tbody>
        </table>
    </div>
    <div style="text-align: right;">
        <button class="btn btn-primary btn-lg" id="printBtn">Cetak Rapot</button>
    </div>
</div>

<?php include '../navbar/navFooter.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kelasSelect = document.getElementById('kelasSelect');
    const studentsContainer = document.getElementById('studentsContainer');
    const studentsTableBody = document.getElementById('studentsTableBody');
    const nilaiContainer = document.getElementById('nilaiContainer');
    const nilaiTableBody = document.getElementById('nilaiTableBody');
    const printBtn = document.getElementById('printBtn');

    // Load students based on selected class
    kelasSelect.addEventListener('change', function() {
        const classId = kelasSelect.value;
        if (classId) {
            fetchStudents(classId); // Fetch students when a class is selected
        } else {
            studentsContainer.style.display = 'none'; // Hide student list if no class is selected
        }
    });

    // Fetch and display students based on class selection
    function fetchStudents(classId) {
        fetch('panggilsiswa.php?class_id=' + classId) // Send request to fetch students
            .then(response => response.json())
            .then(data => {
                studentsTableBody.innerHTML = ''; // Clear previous data
                if (data.length > 0) {
                    data.forEach((student, index) => {
                        const row = `
                            <tr>
                                <td><input type="checkbox" class="student-checkbox" data-nis="${student.nis}"></td>
                                <td>${index + 1}</td>
                                <td>${student.nama_siswa}</td>
                            </tr>`;
                        studentsTableBody.innerHTML += row;
                    });
                    studentsContainer.style.display = 'block'; // Show students table
                } else {
                    studentsContainer.style.display = 'none'; // Hide if no students found
                    alert("No students found for this class.");
                }
            })
            .catch(error => console.error('Error fetching students:', error));
    }

    // Handle "Select All" checkbox functionality
    document.getElementById('selectAllStudents').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"].student-checkbox');
        checkboxes.forEach((checkbox) => {
            checkbox.checked = this.checked;
        });
    });

    // Fetch and display grades for selected students
    printBtn.addEventListener('click', function() {
        const selectedStudents = [];
        const checkboxes = document.querySelectorAll('input[type="checkbox"].student-checkbox:checked');
        checkboxes.forEach((checkbox) => {
            const nis = checkbox.dataset.nis;
            selectedStudents.push(nis);
            fetchGrades(nis); // Fetch grades for each selected student
        });

        if (selectedStudents.length > 0) {
            printGrades(); // Call function to print the grades table
        } else {
            alert('Silakan pilih setidaknya satu siswa untuk dicetak.');
        }
    });

    // Fetch grades for a specific student
    function fetchGrades(nis) {
        fetch('getGrades.php?nis=' + nis) // Send request to get grades for the student
            .then(response => response.json())
            .then(data => {
                data.forEach((grade, index) => {
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${grade.mata_pelajaran}</td>
                            <td>${grade.nilai}</td>
                            <td>${grade.pengetahuan}</td>
                            <td>${grade.keterampilan}</td>
                            <td>${grade.tahun_ajaran}</td>
                            <td>${grade.nilai_akhir}</td>
                            <td>${grade.predikat}</td>
                        </tr>`;
                    nilaiTableBody.innerHTML += row;
                });
                nilaiContainer.style.display = 'block'; // Show the grades table
            })
            .catch(error => console.error('Error fetching grades:', error));
    }

    // Function to print only the grades table
    function printGrades() {
        const tableContent = document.getElementById('nilaiContainer').innerHTML;
        const printWindow = window.open('', '', 'height=500,width=800');
        printWindow.document.write('<html><head><title>Print Grades</title>');
        printWindow.document.write('<style>body {font-family: Arial, sans-serif;} table {width: 100%; border-collapse: collapse;} th, td {border: 1px solid #ddd; padding: 8px; text-align: center;} th {background-color: #f2f2f2;}</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<h2>Daftar Nilai Siswa</h2>');
        printWindow.document.write(tableContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.onload = function() {
            printWindow.print();
            printWindow.close();
        };
    }
});
</script>
