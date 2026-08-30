<?php
include "conn.php";

// ================= 1. AJAX HANDLER FOR SEMESTERS =================
if (isset($_GET['action']) && $_GET['action'] == 'get_semesters') {
    if (ob_get_length()) {
        ob_clean();
    }
    header('Content-Type: application/json');
    $dept_id = intval($_GET['dept_id']);

    $stmt = $conn->prepare("SELECT id, semester_name FROM semesters WHERE department_id = :dept_id AND status = 'Active'");
    $stmt->execute(['dept_id' => $dept_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

// Fetch Active Departments for Filter
$dept_stmt = $conn->query("SELECT id, dept_name FROM departments WHERE status='Active'");
$departmentsList = $dept_stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if a specific student is selected to view profile
$student_id = $_GET['id'] ?? null;
$studentData = null;

if ($student_id) {
    // Fetch individual student profile data
    $profile_stmt = $conn->prepare("SELECT s.*, d.dept_name, sem.semester_name FROM students s 
                                    LEFT JOIN departments d ON s.department_id = d.id 
                                    LEFT JOIN semesters sem ON s.semester_id = sem.id 
                                    WHERE s.id = :id");
    $profile_stmt->execute(['id' => $student_id]);
    $studentData = $profile_stmt->fetch(PDO::FETCH_ASSOC);
}

include "header.php";
?>

<main class="py-4">
    <div class="container-fluid px-4">

        <?php if ($student_id && $studentData) {
            // ================= 2. INDIVIDUAL STUDENT PROFILE VIEW =================
            $fullName = trim($studentData['first_name'] . ' ' . ($studentData['middle_name'] ?? '') . ' ' . $studentData['last_name']);
        ?>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-white fw-bold"><i class="bi bi-person-vcard-fill me-2"></i>Student Profile Details</h2>
                <a href="studentprofile.php" class="btn btn-outline-light btn-sm fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Back to Directory
                </a>
            </div>

            <!-- Profile Header Card -->
            <!-- Profile Header Card -->
            <div class="card shadow-sm border-0 mb-4 bg-dark text-white rounded-4">
                <div class="card-body p-4">
                    <div class="row align-items-center g-4">
                        <div class="col-auto">
                            <?php
                            // Database se photo ka naam nikal rahe hain
                            $dbPhoto = trim($studentData['profile_photo'] ?? '');
                            $targetPath = 'uploads/students/' . $dbPhoto;

                            // Debugging ke liye check kar rahe hain
                            // echo "Checking path: " . $targetPath; 

                            if (!empty($dbPhoto) && file_exists($targetPath)) {
                            ?>
                                <img src="<?= htmlspecialchars($targetPath); ?>" alt="Profile Photo" class="rounded-circle border border-3 border-primary object-fit-cover" style="width: 90px; height: 90px;">
                            <?php } else { ?>
                                <!-- Agar file nahi mili toh default icon dikhega sath me debug text -->
                                <div class="text-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center border border-3 border-primary mx-auto" style="width: 90px; height: 90px;">
                                        <i class="bi bi-person-circle display-4 text-primary"></i>
                                    </div>
                                    <small class="text-danger mt-1 d-block" style="font-size: 10px;">Photo not found: <?= htmlspecialchars($dbPhoto); ?></small>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md">
                            <h3 class="mb-1 text-info fw-bold"><?= htmlspecialchars($fullName); ?></h3>
                            <p class="text-white-50 mb-2">
                                <i class="bi bi-mortarboard-fill me-1"></i><?= htmlspecialchars($studentData['dept_name'] ?? 'N/A'); ?> &mdash; <?= htmlspecialchars($studentData['semester_name'] ?? 'N/A'); ?>
                            </p>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-secondary"><i class="bi bi-hash"></i>Gender: <?= htmlspecialchars($studentData['gender'] ?? ''); ?></span>
                                <span class="badge bg-secondary"><i class="bi bi-envelope me-1"></i><?= htmlspecialchars($studentData['email'] ?? ''); ?></span>
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Status: Active</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex gap-2">
                                <button onclick="window.print();" class="btn btn-outline-secondary btn-sm"><i class="bi bi-printer me-1"></i>Print</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Info Card -->
            <div class="card border-0 shadow bg-dark text-white rounded-4">
                <div class="card-body p-4">
                    <h5 class="text-info mb-3">Personal & Academic Information</h5>
                    <div class="row g-4 text-white">
                        <div class="col-md-6">
                            <table class="table table-dark table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th class="text-white-50 w-50">First Name</th>
                                        <td><?= htmlspecialchars($studentData['first_name'] ?? ''); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-white-50">Middle Name</th>
                                        <td><?= htmlspecialchars($studentData['middle_name'] ?? '—'); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-white-50">Last Name</th>
                                        <td><?= htmlspecialchars($studentData['last_name'] ?? ''); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-white-50">Gender</th>
                                        <td><?= htmlspecialchars($studentData['gender'] ?? ''); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-white-50">Date of Birth</th>
                                        <td><?= htmlspecialchars($studentData['dob'] ?? ''); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-dark table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th class="text-white-50 w-50">Mobile</th>
                                        <td><?= htmlspecialchars($studentData['mobile'] ?? ''); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-white-50">Email</th>
                                        <td><?= htmlspecialchars($studentData['email'] ?? ''); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-white-50">City</th>
                                        <td><?= htmlspecialchars($studentData['city'] ?? ''); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-white-50">Address</th>
                                        <td><?= htmlspecialchars($studentData['address'] ?? ''); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        <?php } else {
            // ================= 3. DEPARTMENT & SEMESTER FILTER + STUDENTS LIST TABLE =================
        ?>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-white fw-bold"><i class="bi bi-person-vcard-fill me-2"></i>Student Profiles Directory</h2>
            </div>

            <!-- Filter Bar Card -->
            <div class="card border-0 shadow-sm bg-dark text-white mb-4 rounded-4">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3 fw-semibold text-info"><i class="bi bi-filter-circle me-2"></i>Select Department & Semester</h5>
                    <div class="row g-3">

                        <!-- Department Dropdown -->
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Department</label>
                            <select class="form-select" id="filter_dept">
                                <option value="">-- Choose Department --</option>
                                <?php foreach ($departmentsList as $dept) { ?>
                                    <option value="<?= $dept['id']; ?>"><?= htmlspecialchars($dept['dept_name']); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Semester Dropdown (Dynamic) -->
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Semester</label>
                            <select class="form-select" id="filter_sem" disabled>
                                <option value="">-- Select Department First --</option>
                            </select>
                        </div>

                        <!-- Reset Button -->
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-outline-light w-100 fw-semibold" id="reset_filter">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Students List Table Card -->
            <div class="card border-0 shadow bg-dark text-white rounded-4">
                <div class="card-body p-4">
                    <h5 class="mb-3 text-white-50">Students List</h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle mb-0 text-white" id="studentTable">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>Department</th>
                                    <th>Semester</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="student_table_body">
                                <?php
                                $stmt = $conn->prepare("SELECT s.*, d.dept_name, sem.semester_name FROM students s 
                                                        LEFT JOIN departments d ON s.department_id = d.id 
                                                        LEFT JOIN semesters sem ON s.semester_id = sem.id 
                                                        ORDER BY s.id DESC");
                                $stmt->execute();
                                $count = 1;

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $deptId = $row['department_id'] ?? '';
                                    $semId = $row['semester_id'] ?? '';
                                    $fullName = trim($row['first_name'] . ' ' . ($row['middle_name'] ?? '') . ' ' . $row['last_name']);
                                ?>
                                    <tr data-dept-id="<?= $deptId; ?>" data-sem-id="<?= $semId; ?>">
                                        <td><?= $count++; ?></td>
                                        <td class="fw-bold text-info"><?= htmlspecialchars($fullName); ?></td>
                                        <td><?= htmlspecialchars($row['gender'] ?? ''); ?></td>
                                        <td><span class="badge bg-secondary"><?= htmlspecialchars($row['dept_name'] ?? 'N/A'); ?></span></td>
                                        <td><span class="badge bg-primary"><?= htmlspecialchars($row['semester_name'] ?? 'N/A'); ?></span></td>
                                        <td><?= htmlspecialchars($row['mobile'] ?? ''); ?></td>
                                        <td><?= htmlspecialchars($row['email'] ?? ''); ?></td>
                                        <td>
                                            <a href="studentprofile.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-info fw-semibold">
                                                <i class="bi bi-eye me-1"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php } ?>

    </div>
</main>

<!-- JAVASCRIPT FOR DEPENDENT DROPDOWNS & TABLE FILTERING -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        // 1. Department change -> Load Semesters via AJAX
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

        // 2. Semester change -> Filter Table Rows
        $('#filter_sem').on('change', function() {
            applyStudentFilter();
        });

        // 3. Reset Button
        $('#reset_filter').on('click', function() {
            $('#filter_dept').val('');
            $('#filter_sem').html('<option value="">-- Select Department First --</option>').prop('disabled', true);
            $('#studentTable tbody tr').show();
        });

        // Instant Client-Side Table Filter Function
        function applyStudentFilter() {
            var selectedDept = $('#filter_dept').val();
            var selectedSem = $('#filter_sem').val();

            $('#studentTable tbody tr').each(function() {
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

<?php
include "footer.php";
?>