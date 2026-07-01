
<?php
    include "header.php";
    include "conn.php";

if (isset($_POST['addTeacher'])) {

    $name = $_POST['name'];
    $department = $_POST['department'];
    $qualification = $_POST['qualification'];
    $designation = $_POST['designation'];
    $date = $_POST['date'];
    $salary = $_POST['salary'];
    $address = $_POST['address'];

    $sql = "INSERT INTO teacher
            (name, department, qualification, designation, date, salary, address)
            VALUES
            (:name, :department, :qualification, :designation, :date, :salary, :address)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':name' => $name,
        ':department' => $department,
        ':qualification' => $qualification,
        ':designation' => $designation,
        ':date' => $date,
        ':salary' => $salary,
        ':address' => $address
    ]);

    echo "Teacher Added Successfully!";
}
?>
<main>
    <div class="container">
        <h1 class="text-white fw-bold p-3">Teachers</h1>
    </div>
    <div class="container">
        <div class="bg-dark rounded-4 m-3 p-3">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active text-white" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Add Teacher</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-white" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Show Teacher</button>
                </li>
                <li class="nav-item text-white" role="presentation">
                    <button class="nav-link text-white" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Teacher Leave</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">

                    <div class="text-white p-4">
                        <h2>Add Teacher</h2>
                    </div>
                    <div class="text-center pb-5">
                        <button type="button" class="btn btn-light w-25 fw-bold py-3 me-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <span class="fs-4">
                                <i class="bi bi-person-fill-add fs-2 "></i>
                                Add Teacher</span>
                        </button>
                        <button type="button" class="btn btn-light  w-25 fw-bold py-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <span class="fs-4">
                                <i class="bi bi-person-x-fill fs-2"></i>
                                Remove Teacher</span>
                        </button>

                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                    <div class="text-white">
                        <h1>
                            Show Teacher
                        </h1>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                    <div class="text-white">
                        <h1>Teacher Leave</h1>
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
                            <input type="text" class="form-control" id="teacherName" name="name" placeholder="Enter Teacher Name">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <select class="form-select" id="department" name="department">
                                <option selected disabled>Select Department</option>
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
                            <label class="form-label">Qualification</label>
                            <input type="text" class="form-control" id="qualification" name="qualification">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Designation</label>
                            <select class="form-select" id="designation" name="designation">
                                <option selected disabled>Select Designation</option>
                                <option>Assistant Professor</option>
                                <option>Associate Professor</option>
                                <option>Professor</option>
                                <option>Head of Department</option>
                                <option>Lecturer</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Date of Joining</label>
                            <input type="date" class="form-control" id="joiningDate" name="date">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Salary</label>
                            <input type="number" class="form-control" id="salary" name="salary">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address"></textarea>
                        </div>

                        <div class="col-12 text-end">
                            <button type="reset" class="btn btn-secondary">Reset</button>
                            <button type="submit" name="addTeacher" class="btn btn-primary">Add Teacher</button>
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