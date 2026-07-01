<?php
include "header.php";
include "conn.php";

if (isset($_POST['addStudent'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $department = $_POST['department'];
    $course = $_POST['course'];
    $semster = $_POST['semster'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $admisdate = $_POST['admisdate'];
    $address = $_POST['address'];

    $sql = "INSERT INTO student
            (name, email, phonenumber, department, course, semster,gender,dob,admisdate, address)
            VALUES
            (:name, :email, :phonenumber, :department, :course, :semster, :gender ,:dob ,:admisdate ,:address)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':phonenumber' => $phonenumber,
        ':department' => $department,
        ':course' => $course,
        ':semster' => $semster,
        ':gender' => $gender,
        ':dob' => $dob,
        ':admisdate' => $admisdate,
        ':address' => $address
    ]);

    echo "Teacher Added Successfully!";
}
?>
<?php
include "conn.php";

$sql = "SELECT * FROM student";
$stmt = $conn->prepare($sql);
$stmt->execute();

$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<main>
    <div class="container">
        <h1 class="text-white fw-bold p-3">Student</h1>
    </div>
    <div class="container">
        <div class="bg-dark rounded-4 m-3 p-3">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active text-white" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Add Students</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-white" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Show Students</button>
                </li>
                <li class="nav-item text-white" role="presentation">
                    <button class="nav-link text-white" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Feedback</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">

                    <div class="text-white p-4">
                        <h2>Add Student</h2>
                    </div>
                    <div class="text-center pb-5">
                        <button type="button" class="btn btn-light w-25 fw-bold py-3 me-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <span class="fs-4">
                                <i class="bi bi-person-fill-add fs-2 "></i>
                                Add Student</span>
                        </button>
                        <button type="button" class="btn btn-light  w-25 fw-bold py-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <span class="fs-4">
                                <i class="bi bi-person-x-fill fs-2"></i>
                                Remove Student</span>
                        </button>

                    </div>
                </div>
                <div class="tab-pane fade " id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                    <div class="bg-light">
                        <table class="table table-bordered   table-sm table-striped" id="studentTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Department</th>
                                    <th>Course</th>
                                    <th>Semester</th>
                                    <th>Gender</th>
                                    <th>DOB</th>
                                    <th>Admission Date</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $stmt = $conn->prepare("SELECT * FROM student");
                                $stmt->execute();

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>

                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['name']; ?></td>
                                        <td><?= $row['email']; ?></td>
                                        <td><?= $row['phonenumber']; ?></td>
                                        <td><?= $row['department']; ?></td>
                                        <td><?= $row['course']; ?></td>
                                        <td><?= $row['semster']; ?></td>
                                        <td><?= $row['gender']; ?></td>
                                        <td><?= $row['dob']; ?></td>
                                        <td><?= $row['admisdate']; ?></td>
                                        <td><?= $row['address']; ?></td>
                                    </tr>

                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                    <div class="text-white">
                        <h1>Feedback</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Fill Form To Add Teacher</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" method="POST">

                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Student Name">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="student@example.com">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="phonenumber" placeholder="Enter Phone Number">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <select class="form-select" name="department">
                                <option value="">Select Department</option>
                                <option>Computer Science</option>
                                <option>Information Technology</option>
                                <option>Electronics</option>
                                <option>Mechanical</option>
                                <option>Civil</option>
                                <option>Electrical</option>
                                <option>Commerce</option>
                                <option>Mathematics</option>
                                <option>Physics</option>
                                <option>Chemistry</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Course</label>
                            <select class="form-select" name="course">
                                <option value="">Select Course</option>
                                <option>B.Tech</option>
                                <option>BCA</option>
                                <option>B.Sc</option>
                                <option>B.Com</option>
                                <option>M.Tech</option>
                                <option>MCA</option>
                                <option>M.Sc</option>
                                <option>M.Com</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Semester</label>
                            <select class="form-select" name="semster">
                                <option value="">Select Semester</option>
                                <option>1st</option>
                                <option>2nd</option>
                                <option>3rd</option>
                                <option>4th</option>
                                <option>5th</option>
                                <option>6th</option>
                                <option>7th</option>
                                <option>8th</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select class="form-select" name="gender">
                                <option value="">Select Gender</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" name="dob">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Admission Date</label>
                            <input type="date" class="form-control" name="admisdate">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="3"></textarea>
                        </div>

                        <div class="col-12 text-end">
                            <button type="reset" class="btn btn-secondary">Reset</button>
                            <button type="submit" name="addStudent" class="btn btn-primary">Add Student</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</main>
<?php
include "footer.php";
?>