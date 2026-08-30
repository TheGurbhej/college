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

// B. Get Students based on Department & Semester (For Result Form)
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

// ================= 2. FORM SUBMISSIONS =================
$successMessage = "";

// A. Add Exam Schedule
if (isset($_POST['addSchedule'])) {
    $sql = "INSERT INTO exam_schedules (department_id, semester_id, exam_title, subject, exam_date, start_time, end_time, room_no) 
            VALUES (:dept, :sem, :title, :sub, :edate, :stime, :etime, :room)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':dept' => $_POST['department_id'],
        ':sem' => $_POST['semester_id'],
        ':title' => $_POST['exam_title'],
        ':sub' => $_POST['subject'],
        ':edate' => $_POST['exam_date'],
        ':stime' => $_POST['start_time'],
        ':etime' => $_POST['end_time'],
        ':room' => $_POST['room_no']
    ]);
    $successMessage = "Exam Schedule added successfully!";
}

// B. Add Exam Result
if (isset($_POST['addResult'])) {
    $sql = "INSERT INTO exam_results (student_id, exam_title, subject, marks_obtained, total_marks, grade) 
            VALUES (:sid, :title, :sub, :marks, :total, :grade)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':sid' => $_POST['student_id'],
        ':title' => $_POST['exam_title'],
        ':sub' => $_POST['subject'],
        ':marks' => $_POST['marks_obtained'],
        ':total' => $_POST['total_marks'],
        ':grade' => $_POST['grade']
    ]);
    $successMessage = "Student Result added successfully!";
}

// Fetch Active Departments for Dropdowns
$dept_stmt = $conn->query("SELECT id, dept_name FROM departments WHERE status='Active'");
$departmentsList = $dept_stmt->fetchAll(PDO::FETCH_ASSOC);

include "header.php";
?>

<main class="py-4">
    <div class="container-fluid px-4">

        <h2 class="text-white fw-bold mb-4"><i class="bi bi-journal-text me-2"></i> Examinations Module</h2>

        <?php if (!empty($successMessage)) { ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?= $successMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php } ?>

        <div class="bg-dark rounded-4 p-3 shadow">
            <!-- TABS NAVIGATION -->
            <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold text-white" data-bs-toggle="pill" data-bs-target="#schedule-tab" type="button" role="tab">
                        <i class="bi bi-calendar-event me-1"></i> Exam Schedule
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold text-white" data-bs-toggle="pill" data-bs-target="#results-tab" type="button" role="tab">
                        <i class="bi bi-award me-1"></i> Results & Marks
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">

                <!-- ================= 1. EXAM SCHEDULE TAB ================= -->
                <div class="tab-pane fade show active" id="schedule-tab" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="text-info m-0">Upcoming Examinations</h5>
                        <button class="btn btn-primary btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
                            <i class="bi bi-plus-circle me-1"></i> Add Exam Schedule
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle">
                            <thead class="table-light text-dark">
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Exam Title</th>
                                    <th>Subject</th>
                                    <th>Department</th>
                                    <th>Semester</th>
                                    <th>Room</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $conn->query("SELECT e.*, d.dept_name, sem.semester_name FROM exam_schedules e 
                                                      LEFT JOIN departments d ON e.department_id = d.id 
                                                      LEFT JOIN semesters sem ON e.semester_id = sem.id 
                                                      ORDER BY e.exam_date ASC");
                                if ($stmt->rowCount() > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $timeSlot = date("h:i A", strtotime($row['start_time'])) . ' - ' . date("h:i A", strtotime($row['end_time']));
                                ?>
                                        <tr>
                                            <td class="text-warning fw-bold"><?= date("d M Y", strtotime($row['exam_date'])); ?></td>
                                            <td><?= $timeSlot; ?></td>
                                            <td><?= htmlspecialchars($row['exam_title']); ?></td>
                                            <td class="text-info"><?= htmlspecialchars($row['subject']); ?></td>
                                            <td><span class="badge bg-secondary"><?= htmlspecialchars($row['dept_name']); ?></span></td>
                                            <td><span class="badge bg-primary"><?= htmlspecialchars($row['semester_name']); ?></span></td>
                                            <td><span class="badge bg-light text-dark"><?= htmlspecialchars($row['room_no']); ?></span></td>
                                        </tr>
                                <?php }
                                } else {
                                    echo '<tr><td colspan="7" class="text-center py-3 text-white-50">No exam schedule found.</td></tr>';
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ================= 2. RESULTS & MARKS TAB ================= -->
                <div class="tab-pane fade" id="results-tab" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="text-info m-0">Student Results Directory</h5>
                        <button class="btn btn-success btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#addResultModal">
                            <i class="bi bi-file-earmark-plus me-1"></i> Upload Marks
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle">
                            <thead class="table-light text-dark">
                                <tr>
                                    <th>Student Name</th>
                                    <th>Department & Sem</th>
                                    <th>Exam Title</th>
                                    <th>Subject</th>
                                    <th>Marks Obtained</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $conn->query("SELECT r.*, s.first_name, s.last_name, d.dept_name, sem.semester_name 
                                                      FROM exam_results r 
                                                      JOIN students s ON r.student_id = s.id
                                                      JOIN departments d ON s.department_id = d.id
                                                      JOIN semesters sem ON s.semester_id = sem.id
                                                      ORDER BY r.id DESC");
                                if ($stmt->rowCount() > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                        <tr>
                                            <td class="fw-bold text-info"><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                            <td><small class="text-white-50"><?= htmlspecialchars($row['dept_name'] . ' - ' . $row['semester_name']); ?></small></td>
                                            <td><?= htmlspecialchars($row['exam_title']); ?></td>
                                            <td><?= htmlspecialchars($row['subject']); ?></td>
                                            <td class="fw-bold"><?= $row['marks_obtained'] . ' / ' . $row['total_marks']; ?></td>
                                            <td><span class="badge bg-success"><?= htmlspecialchars($row['grade']); ?></span></td>
                                        </tr>
                                <?php }
                                } else {
                                    echo '<tr><td colspan="6" class="text-center py-3 text-white-50">No results published yet.</td></tr>';
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<!-- MODAL: ADD EXAM SCHEDULE -->
<div class="modal fade" id="addScheduleModal" tabindex="-1">
    <div class="modal-dialog modal-lg text-dark">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Create Exam Schedule</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Department</label>
                        <select class="form-select" name="department_id" id="sch_dept" required>
                            <option value="">Select Department</option>
                            <?php foreach ($departmentsList as $dept) {
                                echo "<option value='{$dept['id']}'>{$dept['dept_name']}</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Semester</label>
                        <select class="form-select" name="semester_id" id="sch_sem" required disabled>
                            <option value="">Select Dept First</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Exam Title</label>
                        <input type="text" class="form-control" name="exam_title" placeholder="e.g. Mid Term, Final Exam" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Subject</label>
                        <input type="text" class="form-control" name="subject" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Exam Date</label>
                        <input type="date" class="form-control" name="exam_date" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Start Time</label>
                        <input type="time" class="form-control" name="start_time" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">End Time</label>
                        <input type="time" class="form-control" name="end_time" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Room No.</label>
                        <input type="text" class="form-control" name="room_no" required>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" name="addSchedule" class="btn btn-primary">Save Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: ADD RESULT -->
<div class="modal fade" id="addResultModal" tabindex="-1">
    <div class="modal-dialog modal-lg text-dark">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Upload Marks</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Department</label>
                        <select class="form-select" id="res_dept" required>
                            <option value="">Select Department</option>
                            <?php foreach ($departmentsList as $dept) {
                                echo "<option value='{$dept['id']}'>{$dept['dept_name']}</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Semester</label>
                        <select class="form-select" id="res_sem" required disabled>
                            <option value="">Select Dept First</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-success">Select Student</label>
                        <select class="form-select border-success" name="student_id" id="res_student" required disabled>
                            <option value="">Load Sem First</option>
                        </select>
                    </div>

                    <div class="col-md-6 mt-4">
                        <label class="form-label fw-bold">Exam Title</label>
                        <input type="text" class="form-control" name="exam_title" placeholder="e.g. Unit Test 1" required>
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="form-label fw-bold">Subject</label>
                        <input type="text" class="form-control" name="subject" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Marks Obtained</label>
                        <input type="number" step="0.01" class="form-control" name="marks_obtained" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Total Marks</label>
                        <input type="number" step="0.01" class="form-control" name="total_marks" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Grade</label>
                        <input type="text" class="form-control" name="grade" placeholder="e.g. A, B+, Pass" required>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" name="addResult" class="btn btn-success">Save Result</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        // 1. Logic for Schedule Modal (Dept -> Sem)
        $('#sch_dept').on('change', function() {
            var deptId = $(this).val();
            $('#sch_sem').html('<option value="">-- Select Semester --</option>').prop('disabled', true);
            if (deptId) {
                $.get(window.location.pathname, {
                    action: 'get_semesters',
                    dept_id: deptId
                }, function(data) {
                    $('#sch_sem').prop('disabled', false);
                    $.each(data, function(k, v) {
                        $('#sch_sem').append('<option value="' + v.id + '">' + v.semester_name + '</option>');
                    });
                }, 'json');
            }
        });

        // 2. Logic for Result Modal (Dept -> Sem -> Students)
        $('#res_dept').on('change', function() {
            var deptId = $(this).val();
            $('#res_sem').html('<option value="">-- Select Semester --</option>').prop('disabled', true);
            $('#res_student').html('<option value="">-- Load Sem First --</option>').prop('disabled', true);
            if (deptId) {
                $.get(window.location.pathname, {
                    action: 'get_semesters',
                    dept_id: deptId
                }, function(data) {
                    $('#res_sem').prop('disabled', false);
                    $.each(data, function(k, v) {
                        $('#res_sem').append('<option value="' + v.id + '">' + v.semester_name + '</option>');
                    });
                }, 'json');
            }
        });

        $('#res_sem').on('change', function() {
            var semId = $(this).val();
            var deptId = $('#res_dept').val();
            $('#res_student').html('<option value="">-- Select Student --</option>').prop('disabled', true);
            if (semId && deptId) {
                $.get(window.location.pathname, {
                    action: 'get_students',
                    dept_id: deptId,
                    sem_id: semId
                }, function(data) {
                    $('#res_student').prop('disabled', false);
                    $.each(data, function(k, v) {
                        var name = v.first_name + ' ' + (v.middle_name ? v.middle_name + ' ' : '') + v.last_name;
                        $('#res_student').append('<option value="' + v.id + '">' + name + '</option>');
                    });
                }, 'json');
            }
        });
    });
</script>

<?php include "footer.php"; ?>