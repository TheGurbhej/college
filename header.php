<?php
include "./admin/conn.php";
?>
<?php

$sql = "SELECT COUNT(*) AS total FROM noticeboard";
$stmt = $conn->prepare($sql);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total = $row['total'];


if (isset($_POST['admissonadd'])) {

    $sql = "INSERT INTO onlineform(name,fname,mname,dob,gender,category,mnumber,email,address,course)
    VALUES(:name,:fname,:mname,:dob,:gender,:category,:mnumber,:email,:address,:course)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $_POST['name'],
        ':fname' => $_POST['fname'],
        ':mname' => $_POST['mname'],
        ':dob' => $_POST['dob'],
        ':gender' => $_POST['gender'],
        ':category' => $_POST['category'],
        ':mnumber' => $_POST['mnumber'],
        ':email' => $_POST['email'],
        ':address' => $_POST['address'],
        ':course' => $_POST['course']
    ]);
    $success = "Sumbit Successfully!";
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABC College</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.8/css/dataTables.dataTables.min.css">
</head>

<body>
    <nav class="navbar navbar-dark bg-danger fixed-top p-3">
        <div class="container    ">
            <a href="mailto:info@abccollege.com" class="text-white text-decoration-none">
                <i class="bi bi-envelope-fill me-2"></i>Youtubecollegeoftechnology@gmail.com
            </a>
            <div>
                <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-white me-3"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-white"><i class="bi bi-linkedin"></i></a>
            </div>
        </div>
    </nav>
    <nav v class="navbar navbar-expand-lg navbar-dark  bg-dark fixed-top mt-5   ">
        <div class="container">
            <img src="img/Gemini_Generated_-removebg-preview.png" style="width: 50px;" alt="">
            <a class="navbar-brand  " href="#">
                Youtube College of Technology
            </a>
            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collegeNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collegeNavbar">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                            Notice <span class="badge bg-danger me-1"><?php echo $total ?></span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                            href="#"
                            data-bs-toggle="dropdown">
                            Departments
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="computersci.php">Computer Science</a></li>
                            <li><a class="dropdown-item" href="#">Information Technology</a></li>
                            <li><a class="dropdown-item" href="#">Mechanical</a></li>
                            <li><a class="dropdown-item" href="#">Civil</a></li>
                            <li><a class="dropdown-item" href="#">Electrical</a></li>
                            <li><a class="dropdown-item" href="#">Commerce</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                            href="admission.php"
                            data-bs-toggle="dropdown">
                            Admissions
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="admission.php">Admission Process</a></li>
                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#onlineform" href="#">Apply Online</a></li>
                            <li><a class="dropdown-item" href="#">Fee Structure</a></li>
                            <li><a class="dropdown-item" href="#">Scholarships</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Academics</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                            href="#"
                            data-bs-toggle="dropdown">
                            Students
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Student Portal</a></li>
                            <li><a class="dropdown-item" href="#">Attendance</a></li>
                            <li><a class="dropdown-item" href="#">Results</a></li>
                            <li><a class="dropdown-item" href="#">Library</a></li>
                            <li><a class="dropdown-item" href="#">Hostel</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Faculty</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Placements</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Events</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Gallery</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>



    <div class="modal fade" id="onlineform" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h1 class="modal-title fs-5 text-white " id="exampleModalLabel">College Online Admission Form</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST">

                        <!-- Personal Details -->
                        <h4 class="mb-3 text-danger">Personal Details</h4>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Father's Name</label>
                                <input type="text" name="fname" class="form-control" placeholder="Enter Father's Name">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mother's Name</label>
                                <input type="text" name="mname" class="form-control" placeholder="Enter Mother's Name">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input name="dob" type="date" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="" selected disabled>Select Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select">
                                    <option>Select Category</option>
                                    <option>General</option>
                                    <option>OBC</option>
                                    <option>SC</option>
                                    <option>ST</option>
                                    <option>EWS</option>
                                </select>
                            </div>
                        </div>

                        <h4 class="mt-4 mb-3 text-danger">Contact Details</h4>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mobile Number</label>
                                <input name="mnumber" type="tel" class="form-control" placeholder="9876543210">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Address</label>
                                <input name="email" type="email" class="form-control" placeholder="example@email.com">
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <!-- Course -->
                        <h4 class="mt-4 mb-3 text-primary">Course Details</h4>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Select Course</label>
                                <select name="course" class="form-select">
                                    <option>Select Course</option>
                                    <option>BCA</option>
                                    <option>B.Sc</option>
                                    <option>B.Com</option>
                                    <option>BA</option>
                                    <option>BBA</option>
                                    <option>MCA</option>
                                    <option>M.Sc</option>
                                    <option>MBA</option>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="text-center mt-4">
                            <button type="submit" class="btn btn-danger  px-5">Submit Application</button>
                            <button type="reset" class="btn btn-secondary px-5">Reset</button>
                        </div> -->
                        <button name="admissonadd" type="submit" class="btn btn-danger  px-5">Submit Application</button>
                        <button type="reset" class="btn btn-secondary px-5">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>