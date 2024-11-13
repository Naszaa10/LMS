<?php
include '../db.php'; // Include your database connection

if (isset($_GET['class_id'])) {
    $classId = $_GET['class_id'];

    // SQL query to fetch students by class ID
    $sql = "SELECT nis, nama_siswa FROM siswa WHERE id_kelas = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $classId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any students are found
    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    // Return the student data as JSON
    echo json_encode($students);
}
?>
