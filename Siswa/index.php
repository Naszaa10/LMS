<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar with Profile and Sidebar Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php
    include '../navbar/navHeader.php';
    ?>
        <!-- Main Content -->
        <div id="mainContent">
            <!-- Main content here -->
            <section class="tasks mb-4">
                <h3>Upcoming Tasks</h3>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Task 1
                        <span class="badge bg-primary rounded-pill">Due Soon</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Task 2
                        <span class="badge bg-warning rounded-pill">In Progress</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Task 3
                        <span class="badge bg-success rounded-pill">Completed</span>
                    </li>
                </ul>
            </section>
            <div class="row justify-content-center pt-3">
                <!-- Card 1 -->
                <div class="col-md-6 mb-3">
                    <a href="card1.html" class="card-link">
                        <div class="card custom-card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Placeholder Image">
                            <div class="card-body">
                                <p class="card-title">Matematika</p>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <div class="progress mb-2">
                                    <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="card-persentase">50% complete</p>
                            </div>
                        </div>
                    </a>
                </div>  

                <!-- Card 2 -->
                <div class="col-md-6 mb-3">
                    <a href="card2.html" class="card-link">
                        <div class="card custom-card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Placeholder Image">
                            <div class="card-body">
                                <p class="card-title">Bahasa Inggris</p>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <div class="progress mb-2">
                                    <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="card-persentase">75% complete</p>
                            </div>
                        </div>
                    </a>
                </div> 
        </div>
    </div>
    <?php
    include '../navbar/navFooter.php';
    ?>
</body>
</html>
