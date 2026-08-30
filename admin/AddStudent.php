<?php
include "conn.php";

$message = "";

// ================= 1. AJAX HANDLER FOR SEMESTERS =================
if (isset($_GET['action']) && $_GET['action'] == 'get_semesters') {
    $dept_id = intval($_GET['dept_id']);
    $stmt = $conn->prepare("SELECT id, semester_name FROM semesters WHERE department_id = :dept_id AND status = 'Active'");
    $stmt->execute(['dept_id' => $dept_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

// ================= 2. SAME PAGE SAVE LOGIC =================
if (isset($_POST['submit_student'])) {
    $first_name       = $_POST['first_name'] ?? '';
    $middle_name      = $_POST['middle_name'] ?? '';
    $last_name        = $_POST['last_name'] ?? '';
    $gender           = $_POST['gender'] ?? '';
    $dob              = $_POST['dob'] ?? null;
    $blood_group      = $_POST['blood_group'] ?? '';
    $nationality      = $_POST['nationality'] ?? '';
    $category         = $_POST['category'] ?? '';
    $religion         = $_POST['religion'] ?? '';
    $id_number        = $_POST['id_number'] ?? '';

    $mobile           = $_POST['mobile'] ?? '';
    $alt_mobile       = $_POST['alt_mobile'] ?? '';
    $email            = $_POST['email'] ?? '';
    $address          = $_POST['address'] ?? '';
    $city             = $_POST['city'] ?? '';
    $state            = $_POST['state'] ?? '';
    $pincode          = $_POST['pincode'] ?? '';

    $father_name      = $_POST['father_name'] ?? '';
    $father_phone     = $_POST['father_phone'] ?? '';
    $father_occupation= $_POST['father_occupation'] ?? '';
    $mother_name      = $_POST['mother_name'] ?? '';
    $mother_phone     = $_POST['mother_phone'] ?? '';
    $mother_occupation= $_POST['mother_occupation'] ?? '';
    $guardian_name    = $_POST['guardian_name'] ?? '';
    $guardian_phone   = $_POST['guardian_phone'] ?? '';
    $relationship     = $_POST['relationship'] ?? '';

    $admission_number = $_POST['admission_number'] ?? '';
    $enrollment_number= $_POST['enrollment_number'] ?? '';
    $roll_number      = $_POST['roll_number'] ?? '';
    $academic_year    = $_POST['academic_year'] ?? '';
    $department_id    = !empty($_POST['department_id']) ? $_POST['department_id'] : null;
    $semester_id      = !empty($_POST['semester_id']) ? $_POST['semester_id'] : null;
    $section          = $_POST['section'] ?? '';
    $admission_date   = !empty($_POST['admission_date']) ? $_POST['admission_date'] : null;
    $student_type     = $_POST['student_type'] ?? 'Regular';
    $status           = $_POST['status'] ?? 'Active';

    // File Upload Function
    function uploadFile($fileInputName, $targetDir) {
        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] == 0) {
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $ext = pathinfo($_FILES[$fileInputName]['name'], PATHINFO_EXTENSION);
            $fileName = time() . '_' . rand(1000, 9999) . '.' . $ext;
            $targetPath = $targetDir . $fileName;
            if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $targetPath)) {
                return $fileName;
            }
        }
        return null;
    }

    $uploadDir = "uploads/students/";
    $profile_photo = uploadFile('profile_photo', $uploadDir);
    $doc_signature = uploadFile('doc_signature', $uploadDir);
    $doc_10th      = uploadFile('doc_10th', $uploadDir);
    $doc_12th      = uploadFile('doc_12th', $uploadDir);
    $doc_id        = uploadFile('doc_id', $uploadDir);
    $doc_tc        = uploadFile('doc_tc', $uploadDir);
    $doc_migration = uploadFile('doc_migration', $uploadDir);
    $doc_character = uploadFile('doc_character', $uploadDir);
    $doc_other     = uploadFile('doc_other', $uploadDir);

    try {
        $sql = "INSERT INTO students (
                    first_name, middle_name, last_name, gender, dob, blood_group, nationality, category, religion, id_number, profile_photo,
                    mobile, alt_mobile, email, address, city, state, pincode,
                    father_name, father_phone, father_occupation, mother_name, mother_phone, mother_occupation, guardian_name, guardian_phone, relationship,
                    admission_number, enrollment_number, roll_number, academic_year, department_id, semester_id, section, admission_date, student_type, status,
                    doc_signature, doc_10th, doc_12th, doc_id, doc_tc, doc_migration, doc_character, doc_other
                ) VALUES (
                    :fn, :mn, :ln, :g, :dob, :bg, :nat, :cat, :rel, :idn, :pp,
                    :mob, :amob, :email, :addr, :city, :state, :pin,
                    :fan, :fap, :fao, :mon, :mop, :mao, :gan, :gap, :relat,
                    :adn, :enn, :rn, :ay, :did, :sid, :sec, :addate, :stype, :stat,
                    :dsig, :d10, :d12, :didoc, :dtc, :dmig, :dchar, :doth
                )";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'fn' => $first_name, 'mn' => $middle_name, 'ln' => $last_name, 'g' => $gender, 'dob' => $dob, 'bg' => $blood_group, 'nat' => $nationality, 'cat' => $category, 'rel' => $religion, 'idn' => $id_number, 'pp' => $profile_photo,
            'mob' => $mobile, 'amob' => $alt_mobile, 'email' => $email, 'addr' => $address, 'city' => $city, 'state' => $state, 'pin' => $pincode,
            'fan' => $father_name, 'fap' => $father_phone, 'fao' => $father_occupation, 'mon' => $mother_name, 'mop' => $mother_phone, 'mao' => $mother_occupation, 'gan' => $guardian_name, 'gap' => $guardian_phone, 'relat' => $relationship,
            'adn' => $admission_number, 'enn' => $enrollment_number, 'rn' => $roll_number, 'ay' => $academic_year, 'did' => $department_id, 'sid' => $semester_id, 'sec' => $section, 'addate' => $admission_date, 'stype' => $student_type, 'stat' => $status,
            'dsig' => $doc_signature, 'd10' => $doc_10th, 'd12' => $doc_12th, 'didoc' => $doc_id, 'dtc' => $doc_tc, 'dmig' => $doc_migration, 'dchar' => $doc_character, 'doth' => $doc_other
        ]);

        // Success Alert Message on Same Page
        $message = '<div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i><strong>Success!</strong> Student Admission Successful!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';

    } catch (PDOException $e) {
        $message = '<div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Error!</strong> ' . $e->getMessage() . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
    }
}

// Fetch Initial Departments
$dept_stmt = $conn->query("SELECT id, dept_name FROM departments WHERE status='Active'");
$departmentsList = $dept_stmt->fetchAll(PDO::FETCH_ASSOC);

include "header.php";
?>
<main class="bg-light p-4">
    <div class="container-fluid">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark fw-bold mb-0">Student Admission Form</h3>
            <a href="student.php" class="btn btn-outline-dark"><i class="bi bi-list-ul me-2"></i>View All Students</a>
        </div>
        
        <!-- Toast / Alert Message Area -->
        <?= $message; ?>

        <!-- Form action points to AddStudent.php -->
        <form action="AddStudent.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
 
            <!-- Basic Information -->
            <div class="card shadow-sm border-0 mb-4" id="basicInfo">
                <div class="card-header bg-primary bg-gradient text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-person-fill me-2"></i>Basic Information</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
 
                        <div class="col-md-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option selected disabled value="">Choose...</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Blood Group</label>
                            <select name="blood_group" class="form-select">
                                <option selected disabled value="">Choose...</option>
                                <option>A+</option><option>A-</option>
                                <option>B+</option><option>B-</option>
                                <option>O+</option><option>O-</option>
                                <option>AB+</option><option>AB-</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Nationality</label>
                            <input type="text" name="nationality" class="form-control">
                        </div>
 
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <input type="text" name="category" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Religion</label>
                            <input type="text" name="religion" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ID Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-credit-card-2-front"></i></span>
                                <input type="text" name="id_number" class="form-control" placeholder="ID Number">
                            </div>
                        </div>
 
                        <div class="col-12"><hr class="my-2"></div>
 
                        <div class="col-md-4">
                            <label class="form-label">Profile Photo</label>
                            <input type="file" name="profile_photo" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
 
            <!-- Contact Information -->
            <div class="card shadow-sm border-0 mb-4" id="contactInfo">
                <div class="card-header bg-primary bg-gradient text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-telephone-fill me-2"></i>Contact Information</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Mobile <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-phone-fill"></i></span>
                                <input type="tel" name="mobile" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Alternate Mobile</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                <input type="tel" name="alt_mobile" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
 
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="1234 Main St">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <input type="text" name="state" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Pincode</label>
                            <input type="text" name="pincode" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
 
            <!-- Parent/Guardian Information -->
            <div class="card shadow-sm border-0 mb-4" id="guardianInfo">
                <div class="card-header bg-primary bg-gradient text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Parent / Guardian Information</h5>
                </div>
                <div class="card-body p-4">
                    <h6 class="text-uppercase text-body-secondary small fw-bold mb-3">Father</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4"><input type="text" name="father_name" class="form-control" placeholder="Father Name"></div>
                        <div class="col-md-4"><input type="tel" name="father_phone" class="form-control" placeholder="Father Phone"></div>
                        <div class="col-md-4"><input type="text" name="father_occupation" class="form-control" placeholder="Father Occupation"></div>
                    </div>
 
                    <h6 class="text-uppercase text-body-secondary small fw-bold mb-3">Mother</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4"><input type="text" name="mother_name" class="form-control" placeholder="Mother Name"></div>
                        <div class="col-md-4"><input type="tel" name="mother_phone" class="form-control" placeholder="Mother Phone"></div>
                        <div class="col-md-4"><input type="text" name="mother_occupation" class="form-control" placeholder="Mother Occupation"></div>
                    </div>
                </div>
            </div>
 
            <!-- Academic Information -->
            <div class="card shadow-sm border-0 mb-4" id="academicInfo">
                <div class="card-header bg-primary bg-gradient text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-journal-bookmark-fill me-2"></i>Academic Information</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Admission Number</label>
                            <input type="text" name="admission_number" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Enrollment Number</label>
                            <input type="text" name="enrollment_number" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Roll Number</label>
                            <input type="text" name="roll_number" class="form-control">
                        </div>
 
                        <div class="col-md-4">
                            <label class="form-label">Academic Year</label>
                            <input type="text" name="academic_year" class="form-control" placeholder="e.g. 2026-2027">
                        </div>
                        
                        <!-- Department -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-primary">Department <span class="text-danger">*</span></label>
                            <select class="form-select" name="department_id" id="dept_select" required>
                                <option value="">Select Department</option>
                                <?php foreach($departmentsList as $dept) { ?>
                                    <option value="<?= $dept['id']; ?>"><?= htmlspecialchars($dept['dept_name']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
 
                        <!-- Semester -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-primary">Semester <span class="text-danger">*</span></label>
                            <select class="form-select" name="semester_id" id="sem_select" required disabled>
                                <option value="">Select Dept First</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
 
            <!-- Submit Button Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="declaration" required>
                        <label class="form-check-label" for="declaration">
                            I declare that the information provided above is true.
                        </label>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="reset" class="btn btn-outline-secondary btn-lg">Reset</button>
                        <button type="submit" name="submit_student" class="btn btn-primary btn-lg">
                            <i class="bi bi-check2-circle me-1"></i>Save Student
                        </button>
                    </div>
                </div>
            </div>
 
        </form>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        // Department select -> Fetch Semesters
        $('#dept_select').on('change', function() {
            var deptId = $(this).val();

            if (deptId !== '') {
                $.ajax({
                    url: 'AddStudent.php',
                    type: 'GET',
                    data: { action: 'get_semesters', dept_id: deptId },
                    dataType: 'json',
                    success: function(semesters) {
                        $('#sem_select').html('<option value="">-- Select Semester --</option>').prop('disabled', false);
                        $.each(semesters, function(key, sem) {
                            $('#sem_select').append('<option value="' + sem.id + '">' + sem.semester_name + '</option>');
                        });
                    }
                });
            } else {
                $('#sem_select').html('<option value="">-- Select Dept First --</option>').prop('disabled', true);
            }
        });
    });
</script>

<?php include "footer.php"; ?>