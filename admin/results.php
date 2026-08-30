<?php
include "conn.php";

// ================= 1. AJAX HANDLERS =================
// A. Get Semesters based on Department
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

// B. Get Students based on Department & Semester
if (isset($_GET['action']) && $_GET['action'] == 'get_students') {
    if (ob_get_length()) {
        ob_clean();
    }
    header('Content-Type: application/json');
    $dept_id = intval($_GET['dept_id']);
    $sem_id = intval($_GET['sem_id']);

    $stmt = $conn->prepare("SELECT id, first_name, middle_name, last_name FROM students WHERE department_id = :dept_id AND semester_id = :sem_id");
    $stmt->execute(['dept_id' => $dept_id, 'sem_id' => $sem_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

// ================= 2. UPLOAD MARKS LOGIC =================
$successMessage = "";
if (isset($_POST['addResult'])) {
    $student_id     = $_POST['student_id'] ?? '';
    $exam_title     = $_POST['exam_title'] ?? '';
    $subject        = $_POST['subject'] ?? '';
    $marks_obtained = $_POST['marks_obtained'] ?? 0;
    $total_marks    = $_POST['total_marks'] ?? 0;
    $grade          = $_POST['grade'] ?? '';

    $sql = "INSERT INTO exam_results (student_id, exam_title, subject, marks_obtained, total_marks, grade) 
            VALUES (:sid, :title, :sub, :marks, :total, :grade)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':sid'   => $student_id,
        ':title' => $exam_title,
        ':sub'   => $subject,
        ':marks' => $marks_obtained,
        ':total' => $total_marks,
        ':grade' => $grade
    ]);

    $successMessage = "Marks uploaded successfully!";
}

// Fetch Active Departments for the Modal
$dept_stmt = $conn->query("SELECT id, dept_name FROM departments WHERE status='Active'");
$departmentsList = $dept_stmt->fetchAll(PDO::FETCH_ASSOC);

include "header.php";
?>

<main class="py-4">
    <div class="container-fluid px-4">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white fw-bold"><i class="bi bi-award-fill me-2"></i> Results & Marks</h2>
            <button type="button" class="btn btn-success fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#addResultModal">
                <i class="bi bi-file-earmark-plus-fill me-1"></i> Upload Marks
            </button>
        </div>

        <?php if (!empty($successMessage)) { ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?= $successMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>

        <!-- RESULTS TABLE CARD -->
        <div class="card border-0 shadow bg-dark text-white rounded-4">
            <div class="card-body p-4">
                <h5 class="mb-3 text-white-50">Student Results Directory</h5>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0 text-white" id="resultsTable">
                        <thead>
                            <tr class="text-info">
                                <th>#ID</th>
                                <th>Student Name</th>
                                <th>Department & Sem</th>
                                <th>Exam Title</th>
                                <th>Subject</th>
                                <th>Marks</th>
                                <th>Grade</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Joining with students, departments, and semesters
                            $stmt = $conn->query("SELECT r.*, s.first_name, s.last_name, d.dept_name, sem.semester_name 
                                                  FROM exam_results r 
                                                  JOIN students s ON r.student_id = s.id
                                                  LEFT JOIN departments d ON s.department_id = d.id
                                                  LEFT JOIN semesters sem ON s.semester_id = sem.id
                                                  ORDER BY r.id DESC");
                            $count = 1;

                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $fullName = trim($row['first_name'] . ' ' . $row['last_name']);
                            ?>
                                    <tr>
                                        <td><?= $count++; ?></td>
                                        <td class="fw-bold text-light"><?= htmlspecialchars($fullName); ?></td>
                                        <td><small class="text-white-50"><?= htmlspecialchars($row['dept_name'] ?? 'N/A') . ' - ' . htmlspecialchars($row['semester_name'] ?? 'N/A'); ?></small></td>
                                        <td><?= htmlspecialchars($row['exam_title']); ?></td>
                                        <td><?= htmlspecialchars($row['subject']); ?></td>
                                        <td class="fw-bold"><?= htmlspecialchars($row['marks_obtained']) . ' / ' . htmlspecialchars($row['total_marks']); ?></td>
                                        <td>
                                            <?php
                                            $gradeClass = (strtoupper($row['grade']) == 'F' || strtoupper($row['grade']) == 'FAIL') ? 'danger' : 'success';
                                            ?>
                                            <span class="badge bg-<?= $gradeClass; ?>"><?= htmlspecialchars($row['grade']); ?></span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="8" class="text-center py-4 text-white-50">No results published yet.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

<!-- MODAL: UPLOAD MARKS -->
<div class="modal fade" id="addResultModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg text-dark">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-award me-2"></i>Upload Student Marks</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form class="row g-3" method="POST">

                    <!-- Department -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Department <span class="text-danger">*</span></label>
                        <select class="form-select" id="res_dept" required>
                            <option value="">Select Department</option>
                            <?php foreach ($departmentsList as $dept) { ?>
                                <option value="<?= $dept['id']; ?>"><?= htmlspecialchars($dept['dept_name']); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Semester -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Semester <span class="text-danger">*</span></label>
                        <select class="form-select" id="res_sem" required disabled>
                            <option value="">Select Dept First</option>
                        </select>
                    </div>

                    <!-- Dynamic Student Dropdown -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-success">Select Student <span class="text-danger">*</span></label>
                        <select class="form-select border-success" name="student_id" id="res_student" required disabled>
                            <option value="">Load Sem First</option>
                        </select>
                    </div>

                    <!-- Exam Details -->
                    <div class="col-md-6 mt-4">
                        <label class="form-label fw-bold">Exam Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="exam_title" placeholder="e.g. Mid Term, Unit Test 1" required>
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="subject" placeholder="e.g. Data Structures" required>
                    </div>

                    <!-- Marks & Grade -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Marks Obtained <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" name="marks_obtained" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Total Marks <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" name="total_marks" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Grade <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="grade" placeholder="e.g. A, B+, Pass, F" required>
                    </div>

                    <!-- Submit -->
                    <div class="col-12 text-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="addResult" class="btn btn-success px-4 fw-semibold">Save Result</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT FOR AJAX STUDENT LOADER -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {

        // 1. Load Semesters based on Department
        $('#res_dept').on('change', function() {
            var deptId = $(this).val();
            $('#res_sem').html('<option value="">-- Select Semester --</option>').prop('disabled', true);
            $('#res_student').html('<option value="">-- Load Sem First --</option>').prop('disabled', true);

            if (deptId !== '') {
                $.ajax({
                    url: window.location.pathname,
                    type: 'GET',
                    data: {
                        action: 'get_semesters',
                        dept_id: deptId
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data && data.length > 0) {
                            $('#res_sem').prop('disabled', false);
                            $.each(data, function(k, v) {
                                $('#res_sem').append('<option value="' + v.id + '">' + v.semester_name + '</option>');
                            });
                        }
                    }
                });
            }
        });

        // 2. Load Students based on Semester & Department
        $('#res_sem').on('change', function() {
            var semId = $(this).val();
            var deptId = $('#res_dept').val();
            $('#res_student').html('<option value="">-- Select Student --</option>').prop('disabled', true);

            if (semId !== '' && deptId !== '') {
                $.ajax({
                    url: window.location.pathname,
                    type: 'GET',
                    data: {
                        action: 'get_students',
                        dept_id: deptId,
                        sem_id: semId
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data && data.length > 0) {
                            $('#res_student').prop('disabled', false);
                            $.each(data, function(k, v) {
                                var fullName = v.first_name + ' ' + (v.middle_name ? v.middle_name + ' ' : '') + v.last_name;
                                $('#res_student').append('<option value="' + v.id + '">' + fullName + '</option>');
                            });
                        } else {
                            $('#res_student').html('<option value="">No Students Found</option>');
                        }
                    }
                });
            }
        });

    });
</script>

<?php include "footer.php"; ?>