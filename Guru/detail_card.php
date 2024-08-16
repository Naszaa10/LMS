<?php

include '../db.php'; // Sertakan koneksi database

// Ambil ID mata pelajaran dari parameter URL
$course_id = $_GET['id']; // Pastikan parameter 'id' tersedia di URL

// Ambil detail kursus dari database
$course_sql = "SELECT * FROM courses WHERE id = ?";
$course_stmt = $conn->prepare($course_sql);
$course_stmt->bind_param("i", $course_id);
$course_stmt->execute();
$course = $course_stmt->get_result()->fetch_assoc();

// Ambil topik terkait kursus
$topics_sql = "SELECT * FROM topics WHERE course_id = ?";
$topics_stmt = $conn->prepare($topics_sql);
$topics_stmt->bind_param("i", $course_id);
$topics_stmt->execute();
$topics_result = $topics_stmt->get_result();

// Ambil tugas terkait kursus
$tasks_sql = "SELECT * FROM tasks WHERE course_id = ?";
$tasks_stmt = $conn->prepare($tasks_sql);
$tasks_stmt->bind_param("i", $course_id);
$tasks_stmt->execute();
$tasks_result = $tasks_stmt->get_result();

// Ambil pengumuman terkait kursus
$announcements_sql = "SELECT * FROM announcements WHERE course_id = ?";
$announcements_stmt = $conn->prepare($announcements_sql);
$announcements_stmt->bind_param("i", $course_id);
$announcements_stmt->execute();
$announcements_result = $announcements_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['code']) . ' - ' . htmlspecialchars($course['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../navbar/navHeader.php'; ?>
    <!-- Main Content -->
    <div id="mainContent" class="maincontent-card1 container mt-4">
        <h1><?php echo htmlspecialchars($course['code']) . ' - ' . htmlspecialchars($course['name']); ?></h1>
        <h4><?php echo htmlspecialchars($course['semester']) . ' - ' . htmlspecialchars($course['teacher']); ?></h4>

        <!-- Section for Topics -->
        <section class="mt-4">
            <h2>Outline Topik</h2>
            <div class="accordion" id="topicAccordion">
                <?php while($topic = $topics_result->fetch_assoc()): ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?php echo $topic['id']; ?>">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="add-topic"><?php echo htmlspecialchars($topic['title']); ?></p>
                            <div>
                                <button type="button" class="btn btn-tambah custom-btn me-2">Tambah</button>
                                <button type="button" class="btn btn-hapus custom-btn">Hapus</button>
                            </div>
                        </div>
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $topic['id']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $topic['id']; ?>">
                            <?php echo htmlspecialchars($topic['title']); ?>
                        </button>
                    </h2>
                    <div id="collapse<?php echo $topic['id']; ?>" class="accordion-collapse collapse show" aria-labelledby="heading<?php echo $topic['id']; ?>" data-bs-parent="#topicAccordion">
                        <div class="accordion-body">
                            <?php echo htmlspecialchars($topic['details']); ?>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-edit custom-btn me-2">Edit</button>
                            <button type="button" class="btn btn-hapus custom-btn">Hapus</button>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </section>

        <!-- Section for Tasks -->
        <section class="mt-4">
            <h2>Tugas</h2>
            <div class="d-flex justify-content-between align-items-center">
                <p class="add-topic">Tambah Tugas</p>
                <div>
                    <button type="button" class="btn btn-tambah custom-btn me-2">Tambah</button>
                    <button type="button" class="btn btn-hapus custom-btn">Hapus</button>
                </div>
            </div>
            <ul class="list-group">
                <?php while($task = $tasks_result->fetch_assoc()): ?>
                <li class="list-group-item">
                    <?php echo htmlspecialchars($task['title']); ?>
                </li>
                <?php endwhile; ?>
            </ul>
        </section>

        <!-- Section for Announcements -->
        <section class="mt-4">
            <h2>Pengumuman</h2>
            <div class="d-flex justify-content-between align-items-center">
                <p class="add-topic">Tambah Pengumuman</p>
                <div>
                    <button type="button" class="btn btn-tambah custom-btn me-2">Tambah</button>
                    <button type="button" class="btn btn-hapus custom-btn">Hapus</button>
                </div>
            </div>
            <ul class="list-group">
                <?php while($announcement = $announcements_result->fetch_assoc()): ?>
                <li class="list-group-item">
                    <?php echo htmlspecialchars($announcement['title']); ?>
                </li>
                <?php endwhile; ?>
            </ul>
        </section>
    </div>

    <?php include '../navbar/navFooter.php'; ?>
</body>
</html>

<?php
// Tutup koneksi database
$conn->close();
?>
