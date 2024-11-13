<?php
include '../db.php';

$nis = $_GET['nis']; // Get the student's NIS

// Query to get the grades for the given student
$sql = "SELECT mata_pelajaran, nilai, pengetahuan, keterampilan, tahun_ajaran, nilai_akhir, predikat FROM nilai WHERE nis = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $nis);
$stmt->execute();

$result = $stmt->get_result();
$grades = [];

while ($row = $result->fetch_assoc()) {
    $grades[] = $row; // Add each grade to the array
}

// Return the data as JSON
echo json_encode($grades);
?>
