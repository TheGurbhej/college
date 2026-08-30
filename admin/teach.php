<?php
include "header.php";
?>

<main>
    <div class="container-fluid">

        <!-- Heading -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="text-white fw-bold">Teachers</h2>
                <p class="text-white-50">Manage all teachers</p>
            </div>
        </div>

        <!-- Cards -->
        <div class="row mb-4">

            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5>Total Teachers</h5>
                        <h2>35</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5>Active</h5>
                        <h2>32</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <h5>On Leave</h5>
                        <h2>2</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5>HOD</h5>
                        <h2>1</h2>
                    </div>
                </div>
            </div>

        </div>

        <!-- Tabs -->
        <ul class="nav nav-pills mb-3">
            <li class="nav-item">
                <button class="nav-link active"
                    data-bs-toggle="pill"
                    data-bs-target="#addTeacher">
                    Add Teacher
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link"
                    data-bs-toggle="pill"
                    data-bs-target="#showTeacher">
                    Show Teachers
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link"
                    data-bs-toggle="pill"
                    data-bs-target="#teacherLeave">
                    Teacher Leave
                </button>
            </li>
        </ul>

        <div class="tab-content">

            <!-- Add Teacher -->

            <!-- Show Teacher -->

            <!-- Teacher Leave -->

        </div>

    </div>
</main>

<?php
include "footer.php";
?>