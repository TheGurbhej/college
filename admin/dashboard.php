<?php
include "header.php";
include "conn.php";

// Fetching total students
// $sql = "SELECT COUNT(*) AS total_students FROM student";
// $stmt = $conn->prepare($sql);
// $stmt->execute();
// $totalStudents = $stmt->fetch(PDO::FETCH_ASSOC)['total_students'];

// Fetching total teachers
$sql = "SELECT COUNT(*) AS total_teachers FROM teacher";
$stmt = $conn->prepare($sql);
$stmt->execute();
$totalTeachers = $stmt->fetch(PDO::FETCH_ASSOC)['total_teachers'];
?>


<main class="content px-3 py-2">
    <div class="container-fluid">
        
        <!-- Header & Quick Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
            <h2 class="fw-bolder text-white">Dashboard Overview</h2>
            <div>
                <button class="btn btn-primary btn-sm me-2"><i class="fas fa-user-plus"></i> Add Student</button>
                <button class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i> Mark Attendance</button>
            </div>
        </div>

        <!-- Top Stats Row -->
        <div class="row g-3 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 h-100 border-start border-primary border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Students</h6>
                                <h2 class="fw-bold mb-0"><?= $totalStudents; ?></h2>
                            </div>
                            <i class="fas fa-user-graduate fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 h-100 border-start border-success border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Teachers</h6>
                                <h2 class="fw-bold mb-0"><?= $totalTeachers ?></h2>
                            </div>
                            <i class="fas fa-chalkboard-teacher fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 h-100 border-start border-warning border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Active Courses</h6>
                                <h2 class="fw-bold mb-0">28</h2>
                            </div>
                            <i class="fas fa-book fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 h-100 border-start border-info border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Today's Attendance</h6>
                                <h2 class="fw-bold mb-0">94%</h2>
                            </div>
                            <i class="fas fa-calendar-check fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row (Naya Section) -->
        <div class="row g-4 mb-4">
            <!-- Bar Chart -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <h6 class="fw-bold"><i class="fas fa-chart-bar text-primary me-2"></i> Monthly Attendance Trend</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="attendanceChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Doughnut Chart -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <h6 class="fw-bold"><i class="fas fa-chart-pie text-success me-2"></i> Students by Department</h6>
                    </div>
                    <div class="card-body d-flex justify-content-center">
                        <canvas id="departmentChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notice Board & Leadership Row -->
        <div class="row g-4">
            <!-- Notice Board -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-bullhorn me-2"></i> Notice Board</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h6 class="fw-bold mb-1 text-primary">Semester Exam Schedule Released</h6>
                                <small class="text-muted"><i class="far fa-clock"></i> 30 June 2026</small>
                            </li>
                            <li class="list-group-item">
                                <h6 class="fw-bold mb-1">Admissions Open for Session 2026-27</h6>
                                <small class="text-muted"><i class="far fa-clock"></i> 28 June 2026</small>
                            </li>
                            <li class="list-group-item">
                                <h6 class="fw-bold mb-1 text-danger">College Closed on Sunday</h6>
                                <small class="text-muted"><i class="far fa-clock"></i> 27 June 2026</small>
                            </li>
                            <li class="list-group-item text-center p-3">
                                <a href="#" class="btn btn-outline-dark btn-sm">View All Notices</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Current Leadership -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-user-tie me-2"></i> Current Leadership</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4 p-2 rounded shadow-sm border bg-light">
                            <!-- Image yahan uncomment kar lena if you have -->
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 24px;">R</div>
                            <div class="ms-3">
                                <h5 class="mb-1 fw-bold">Dr. Rajesh Sharma</h5>
                                <span class="badge bg-primary mb-1">Principal</span>
                                <p class="text-muted mb-0" style="font-size: 13px;">Responsible for academic administration.</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center p-2 rounded shadow-sm border bg-light">
                            <!-- Image yahan uncomment kar lena if you have -->
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 24px;">A</div>
                            <div class="ms-3">
                                <h5 class="mb-1 fw-bold">Mr. Amit Verma</h5>
                                <span class="badge bg-success mb-1">Director</span>
                                <p class="text-muted mb-0" style="font-size: 13px;">Oversees strategic planning.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include "footer.php"; ?>