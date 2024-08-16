<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursus Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="ccss/style.css">
</head>
<body>
    <?php
    include '../navbar/navAdmin.php';
    ?>

            <!-- Main Content -->
        <div id="mainContent" class="maincontent-card1">
                <h1>20232-01175-Matematika-327</h1>
                <h4>2023/2024 Genap - Matematika - Febri Mulyadi, Steler</h4>

                <section class="mt-4">
                    <h2>Topic Outline</h2>
                    <div class="accordion" id="topicAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="add-topic">Tambah Topic</p>
                                    <div>
                                        <button type="button" class="btn btn-tambah custom-btn me-2">Tambah</button>
                                        <button type="button" class="btn btn-hapus custom-btn">Hapus</button>
                                    </div>
                                </div>
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Topic 1
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#topicAccordion">
                                <div class="accordion-body">
                                    Details for Topic 1.
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-edit custom-btn me-2">Edit</button>
                                    <button type="button" class="btn btn-hapus custom-btn">Hapus</button>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Topic 2
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#topicAccordion">
                                <div class="accordion-body">
                                    Details for Topic 2.
                                </div>
                            </div>
                        </div>
                        <!-- Repeat for additional topics -->
                    </div>
                </section>

                <section class="mt-4">
                    <h2>Tugas</h2>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="add-topic">Tambah Forum</p>
                        <div>
                            <button type="button" class="btn btn-tambah custom-btn me-2">Tambah</button>
                            <button type="button" class="btn btn-hapus custom-btn">Hapus</button>
                        </div>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item">
                            TugasPost 1
                        </li>
                        <li class="list-group-item">
                            Tugas Post 2
                        </li>
                        <!-- Repeat for additional forum posts -->
                    </ul>
                </section>

                <section class="mt-4">
                    <h2>Pengumuman</h2>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="add-topic">Tambah pengumuman</p>
                        <div>
                            <button type="button" class="btn btn-tambah custom-btn me-2">Tambah</button>
                            <button type="button" class="btn btn-hapus custom-btn">Hapus</button>
                        </div>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item">
                            Pengumuman 1
                        </li>
                        <li class="list-group-item">
                            Pengumuman 2
                        </li>
                        <!-- Repeat for additional announcements -->
                    </ul>
                </section>

                
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebarMenu');
    
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('show');
        });
    });</script>
</body>
</html>
