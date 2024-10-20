<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jawaban Tugas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- CKEditor CDN -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
</head>
<?php include '../navbar/navHeader.php';

$nis = $_GET['nis'];
$id_tugas = $_GET['id_tugas'];

// Ambil jawaban berdasarkan NIS
$sql = "SELECT tugas_text FROM pengumpulan_tugas WHERE nis = ? AND id_tugas = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $nis, $id_tugas); // Gantilah "s" untuk nis dan "i" untuk id_tugas jika id_tugas adalah integer
$stmt->execute();
$result = $stmt->get_result();

if (!$stmt->execute()) {
    die('Gagal mengeksekusi pernyataan: ' . htmlspecialchars($stmt->error));
}

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$tugas_text = $row ? htmlspecialchars($row['tugas_text']) : "Jawaban tidak ditemukan.";
?>
    <div class="container mt-4">
        <h2>Jawaban Tugas</h2>
        <textarea id="tugasText" name="tugas_text" class="ckeditor" readonly>
            <?php echo $tugas_text; ?>
        </textarea>
        <a href="javascript:window.history.back();" class="btn btn-secondary mt-3">Kembali</a>
    </div>
<?php include '../navbar/navFooter.php'; ?>
    <script>
        // Inisialisasi CKEditor dalam mode baca saja
        CKEDITOR.replace('tugasText', {
            readOnly: true,
            height: 400
        });
    </script>
</body>
</html>
