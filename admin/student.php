<?php
include "conn.php";

// ================= 1. AJAX HANDLER FOR SEMESTERS =================
if (isset($_GET['action']) && $_GET['action'] == 'get_semesters') {
    if (ob_get_length()) {
        ob_clean();
    }
    header('Content-Type: application/json');

    $dept_id = intval($_GET['dept_id']);

    try {
        $stmt = $conn->prepare("SELECT id, semester_name FROM semesters WHERE department_id = :dept_id AND status = 'Active'");
        $stmt->execute(['dept_id' => $dept_id]);
        $semesters = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($semesters);
    } catch (PDOException $e) {
        echo json_encode([]);
    }
    exit;
}

// ================= 2. ADD STUDENT LOGIC =================
$successMessage = "";
if (isset($_POST['addStudent'])) {
    $name         = $_POST['name'] ?? '';
    $email        = $_POST['email'] ?? '';
    $phonenumber  = $_POST['phonenumber'] ?? '';
    $department   = $_POST['department'] ?? '';
    $course       = $_POST['course'] ?? '';
    $semster      = $_POST['semster'] ?? '';
    $gender       = $_POST['gender'] ?? '';
    $dob          = $_POST['dob'] ?? null;
    $admisdate    = $_POST['admisdate'] ?? null;
    $address      = $_POST['address'] ?? '';

    $sql = "INSERT INTO student (name, email, phonenumber, department, course, semster, gender, dob, admisdate, address)
            VALUES (:name, :email, :phonenumber, :department, :course, :semster, :gender, :dob, :admisdate, :address)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name'        => $name,
        ':email'       => $email,
        ':phonenumber' => $phonenumber,
        ':department'  => $department,
        ':course'      => $course,
        ':semster'     => $semster,
        ':gender'      => $gender,
        ':dob'         => $dob,
        ':admisdate'   => $admisdate,
        ':address'     => $address
    ]);

    $successMessage = "Student Added Successfully!";
}

// Fetch Active Departments for Dropdowns & Filters
try {
    $dept_stmt = $conn->query("SELECT id, dept_name FROM departments WHERE status='Active'");
    $departmentsList = $dept_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $departmentsList = [];
}

include "header.php";
?>

<main class="py-4">
    <div class="container-fluid px-4">

        <!-- Page Header -->
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white fw-bold"><i class="bi bi-people-fill me-2"></i> Student Management</h2>
            <a href="AddStudent.php" class="btn btn-success fw-semibold shadow-sm text-decoration-none">
                <i class="bi bi-person-plus-fill me-1"></i> Add New Student
            </a>
        </div>

        <?php if (!empty($successMessage)) { ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?= $successMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>

        <!-- FILTER BAR CARD -->
        <div class="card border-0 shadow-sm bg-dark text-white mb-4 rounded-4">
            <div class="card-body p-4">
                <h5 class="card-title mb-3 fw-semibold text-info"><i class="bi bi-filter-circle me-2"></i>Filter Students by Department & Semester</h5>
                <div class="row g-3">

                    <!-- Department Filter Dropdown -->
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Department</label>
                        <select class="form-select" id="filter_dept">
                            <option value="">-- All Departments --</option>
                            <?php foreach ($departmentsList as $dept) { ?>
                                <option value="<?= $dept['id']; ?>"><?= htmlspecialchars($dept['dept_name']); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Semester Filter Dropdown (Dynamic) -->
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Semester</label>
                        <select class="form-select" id="filter_sem" disabled>
                            <option value="">-- Select Department First --</option>
                        </select>
                    </div>

                    <!-- Reset Filter Button -->
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-light w-100 fw-semibold" id="reset_filter">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- STUDENTS TABLE CARD -->
        <!-- STUDENTS TABLE CARD -->
        <div class="card border-0 shadow bg-dark text-white rounded-4">
            <div class="card-body p-4">
                <h5 class="mb-3 text-white-50">Students Directory List</h5>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0 text-white" id="nativeStudentTable">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Full Name</th>
                                <th>Gender</th>
                                <th>DOB</th>
                                <th>Department</th>
                                <th>Semester</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="student_table_body">
                            <?php
                            // Asli 'students' table se data fetch kar rahe hain sath me departments & semesters join karke
                            $stmt = $conn->prepare("SELECT s.*, d.dept_name, sem.semester_name 
                                                    FROM students s 
                                                    LEFT JOIN departments d ON s.department_id = d.id 
                                                    LEFT JOIN semesters sem ON s.semester_id = sem.id 
                                                    ORDER BY s.id DESC");
                            $stmt->execute();
                            $count = 1;

                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $deptId = $row['department_id'] ?? '';
                                    $semId = $row['semester_id'] ?? '';

                                    // Naam ko combine karna (First + Middle + Last)
                                    $fullName = trim($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);
                            ?>
                                    <tr data-dept-id="<?= $deptId; ?>" data-sem-id="<?= $semId; ?>">
                                        <td><?= $count++; ?></td>
                                        <td class="fw-bold text-info"><?= htmlspecialchars($fullName); ?></td>
                                        <td><?= htmlspecialchars($row['gender'] ?? ''); ?></td>
                                        <td><?= htmlspecialchars($row['dob'] ?? ''); ?></td>
                                        <td><span class="badge bg-secondary"><?= htmlspecialchars($row['dept_name'] ?? 'N/A'); ?></span></td>
                                        <td><span class="badge bg-primary"><?= htmlspecialchars($row['semester_name'] ?? 'N/A'); ?></span></td>
                                        <td><?= htmlspecialchars($row['mobile'] ?? ''); ?></td>
                                        <td><?= htmlspecialchars($row['email'] ?? ''); ?></td>
                                        <td><?= htmlspecialchars($row['city'] ?? ''); ?></td>
                                        <td>
                                            <a href="view_student.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="10" class="text-center text-white py-3">No students found in the database.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

<!-- MODAL FOR ADDING STUDENT -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg text-dark">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Fill Form To Add Student</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form class="row g-3" method="POST">

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Student Name" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" placeholder="student@example.com" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Phone Number</label>
                        <input type="text" class="form-control" name="phonenumber" placeholder="Enter Phone Number">
                    </div>

                    <!-- Department for Modal -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Department <span class="text-danger">*</span></label>
                        <select class="form-select" name="department" id="modal_dept_select" required>
                            <option value="">Select Department</option>
                            <?php foreach ($departmentsList as $dept) { ?>
                                <option value="<?= $dept['id']; ?>"><?= htmlspecialchars($dept['dept_name']); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Course Type</label>
                        <select class="form-select" name="course">
                            <option value="">Select Course</option>
                            <option value="BCA">BCA</option>
                            <option value="B.Tech">B.Tech</option>
                            <option value="B.Sc">B.Sc</option>
                            <option value="B.Com">B.Com</option>
                        </select>
                    </div>

                    <!-- Semester for Modal (Dynamic) -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Semester <span class="text-danger">*</span></label>
                        <select class="form-select" name="semster" id="modal_sem_select" required disabled>
                            <option value="">Select Department First</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Gender</label>
                        <select class="form-select" name="gender">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Date of Birth</label>
                        <input type="date" class="form-control" name="dob">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Admission Date</label>
                        <input type="date" class="form-control" name="admisdate">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Address</label>
                        <textarea class="form-control" name="address" rows="2" placeholder="Enter residential address"></textarea>
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="addStudent" class="btn btn-primary px-4 fw-semibold">Save Student</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT LOGIC -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {

        // 1. Modal Form: Department change -> Load Semesters
        $('#modal_dept_select').on('change', function() {
            var deptId = $(this).val();
            $('#modal_sem_select').html('<option value="">-- Select Semester --</option>').prop('disabled', true);

            if (deptId !== '') {
                $.ajax({
                    url: window.location.pathname,
                    type: 'GET',
                    data: {
                        action: 'get_semesters',
                        dept_id: deptId
                    },
                    dataType: 'json',
                    success: function(semesters) {
                        if (semesters && semesters.length > 0) {
                            $('#modal_sem_select').prop('disabled', false);
                            $.each(semesters, function(key, sem) {
                                $('#modal_sem_select').append('<option value="' + sem.id + '">' + sem.semester_name + '</option>');
                            });
                        } else {
                            $('#modal_sem_select').html('<option value="">No Semesters Found</option>');
                        }
                    }
                });
            }
        });

        // 2. Filter Bar: Department change -> Load Semesters & Filter Table
        $('#filter_dept').on('change', function() {
            var deptId = $(this).val();

            $('#filter_sem').html('<option value="">-- All Semesters --</option>').prop('disabled', true);

            if (deptId !== '') {
                $.ajax({
                    url: window.location.pathname,
                    type: 'GET',
                    data: {
                        action: 'get_semesters',
                        dept_id: deptId
                    },
                    dataType: 'json',
                    success: function(semesters) {
                        if (semesters && semesters.length > 0) {
                            $('#filter_sem').prop('disabled', false);
                            $.each(semesters, function(key, sem) {
                                $('#filter_sem').append('<option value="' + sem.id + '">' + sem.semester_name + '</option>');
                            });
                        } else {
                            $('#filter_sem').html('<option value="">No Semesters Found</option>');
                        }
                    }
                });
            }
            applyStudentFilter();
        });

        // 3. Filter Bar: Semester change -> Filter Table
        $('#filter_sem').on('change', function() {
            applyStudentFilter();
        });

        // 4. Reset Button Click
        $('#reset_filter').on('click', function() {
            $('#filter_dept').val('');
            $('#filter_sem').html('<option value="">-- Select Department First --</option>').prop('disabled', true);
            $('#nativeStudentTable tbody tr').show();
        });

        // Function to filter rows instantly based on selected IDs
        function applyStudentFilter() {
            var selectedDept = $('#filter_dept').val();
            var selectedSem = $('#filter_sem').val();

            $('#nativeStudentTable tbody tr').each(function() {
                var row = $(this);
                var rowDeptId = String(row.data('dept-id')).trim();
                var rowSemId = String(row.data('sem-id')).trim();

                var matchDept = (selectedDept === "" || rowDeptId === String(selectedDept));
                var matchSem = (selectedSem === "" || rowSemId === String(selectedSem));

                if (matchDept && matchSem) {
                    row.show();
                } else {
                    row.hide();
                }
            });
        }

    });
</script>

<?php include "footer.php"; ?>