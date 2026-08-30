<?php
include "conn.php";
if (isset($_GET['action']) && $_GET['action'] == 'get_semesters') {
    if (ob_get_length()) {
        ob_clean();
    }
    header('Content-Type: application/json');
    $dept_id = intval($_GET['dept_id']);

    try {
        $stmt = $conn->prepare("SELECT id, semester_name FROM semesters WHERE department_id = :dept_id AND status = 'Active'");
        $stmt->execute(['dept_id' => $dept_id]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $e) {
        echo json_encode([]);
    }
    exit;
}

$successMessage = "";
if (isset($_POST['addSchedule'])) {
    $department_id = $_POST['department_id'] ?? '';
    $semester_id   = $_POST['semester_id'] ?? '';
    $subject       = $_POST['subject'] ?? '';
    $teacher       = $_POST['teacher'] ?? '';
    $day_of_week   = $_POST['day_of_week'] ?? '';
    $start_time    = $_POST['start_time'] ?? '';
    $end_time      = $_POST['end_time'] ?? '';
    $room_no       = $_POST['room_no'] ?? '';

    $sql = "INSERT INTO timetable (department_id, semester_id, subject, teacher, day_of_week, start_time, end_time, room_no)
            VALUES (:department_id, :semester_id, :subject, :teacher, :day_of_week, :start_time, :end_time, :room_no)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':department_id' => $department_id,
        ':semester_id'   => $semester_id,
        ':subject'       => $subject,
        ':teacher'       => $teacher,
        ':day_of_week'   => $day_of_week,
        ':start_time'    => $start_time,
        ':end_time'      => $end_time,
        ':room_no'       => $room_no
    ]);

    $successMessage = "Class schedule added successfully!";
}

$dept_stmt = $conn->query("SELECT id, dept_name FROM departments WHERE status='Active'");
$departmentsList = $dept_stmt->fetchAll(PDO::FETCH_ASSOC);

include "header.php";
?>

<main class="py-4">
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white fw-bold"><i class="bi bi-calendar3 me-2"></i> Class Timetable</h2>
            <button type="button" class="btn btn-primary fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
                <i class="bi bi-plus-circle-fill me-1"></i> Add Schedule Slot
            </button>
        </div>

        <?php if (!empty($successMessage)) { ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?= $successMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>


        <div class="card border-0 shadow-sm bg-dark text-white mb-4 rounded-4">
            <div class="card-body p-4">
                <h5 class="card-title mb-3 fw-semibold text-info"><i class="bi bi-filter-circle me-2"></i>Filter Timetable</h5>
                <div class="row g-3">

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Department</label>
                        <select class="form-select" id="filter_dept">
                            <option value="">-- All Departments --</option>
                            <?php foreach ($departmentsList as $dept) { ?>
                                <option value="<?= $dept['id']; ?>"><?= htmlspecialchars($dept['dept_name']); ?></option>
                            <?php } ?>
                        </select>
                    </div>


                    <div class="col-md-3">
                        <label class="form-label fw-bold">Semester</label>
                        <select class="form-select" id="filter_sem" disabled>
                            <option value="">-- Select Department First --</option>
                        </select>
                    </div>


                    <div class="col-md-4">
                        <label class="form-label fw-bold">Day of Week</label>
                        <select class="form-select" id="filter_day">
                            <option value="">-- All Days --</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                        </select>
                    </div>


                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-light w-100 fw-semibold" id="reset_filter">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="card border-0 shadow bg-dark text-white rounded-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0 text-white" id="nativeTimetable">
                        <thead>
                            <tr class="text-info">
                                <th>Day</th>
                                <th>Timing</th>
                                <th>Subject</th>
                                <th>Teacher / Staff</th>
                                <th>Department</th>
                                <th>Semester</th>
                                <th>Room No.</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="timetable_body">
                            <?php

                            $stmt = $conn->prepare("SELECT t.*, d.dept_name, sem.semester_name 
                                                    FROM timetable t 
                                                    LEFT JOIN departments d ON t.department_id = d.id 
                                                    LEFT JOIN semesters sem ON t.semester_id = sem.id 
                                                    ORDER BY FIELD(t.day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'), t.start_time ASC");
                            $stmt->execute();

                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $timeSlot = date("h:i A", strtotime($row['start_time'])) . ' - ' . date("h:i A", strtotime($row['end_time']));
                            ?>
                                    <tr data-dept-id="<?= $row['department_id']; ?>" data-sem-id="<?= $row['semester_id']; ?>" data-day="<?= htmlspecialchars($row['day_of_week']); ?>">
                                        <td class="fw-bold text-warning"><?= htmlspecialchars($row['day_of_week']); ?></td>
                                        <td class="fw-bold"><?= $timeSlot; ?></td>
                                        <td class="text-info fw-semibold"><?= htmlspecialchars($row['subject']); ?></td>
                                        <td><i class="bi bi-person-fill me-1"></i><?= htmlspecialchars($row['teacher']); ?></td>
                                        <td><span class="badge bg-secondary"><?= htmlspecialchars($row['dept_name'] ?? 'N/A'); ?></span></td>
                                        <td><span class="badge bg-primary"><?= htmlspecialchars($row['semester_name'] ?? 'N/A'); ?></span></td>
                                        <td><span class="badge bg-light text-dark fw-bold"><?= htmlspecialchars($row['room_no']); ?></span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="8" class="text-center text-white py-4">No schedule found. Please add a class slot.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

<div class="modal fade" id="addScheduleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg text-dark">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-calendar-plus me-2"></i>Add Class Schedule</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form class="row g-3" method="POST">

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Department <span class="text-danger">*</span></label>
                        <select class="form-select" name="department_id" id="modal_dept_select" required>
                            <option value="">Select Department</option>
                            <?php foreach ($departmentsList as $dept) { ?>
                                <option value="<?= $dept['id']; ?>"><?= htmlspecialchars($dept['dept_name']); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Semester <span class="text-danger">*</span></label>
                        <select class="form-select" name="semester_id" id="modal_sem_select" required disabled>
                            <option value="">Select Department First</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Subject Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="subject" placeholder="e.g. Data Structures" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Teacher / Faculty <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="teacher" placeholder="e.g. Prof. Amit Sharma" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Day of Week <span class="text-danger">*</span></label>
                        <select class="form-select" name="day_of_week" required>
                            <option value="">Select Day</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Start Time <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" name="start_time" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">End Time <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" name="end_time" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Room / Lab Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="room_no" placeholder="e.g. Lab 4 or Room 102" required>
                    </div>


                    <div class="col-12 text-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="addSchedule" class="btn btn-primary px-4 fw-semibold">Save Schedule</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {

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
                        }
                    }
                });
            }
            applyTimetableFilter();
        });

        $('#filter_sem, #filter_day').on('change', function() {
            applyTimetableFilter();
        });

        $('#reset_filter').on('click', function() {
            $('#filter_dept, #filter_day').val('');
            $('#filter_sem').html('<option value="">-- Select Department First --</option>').prop('disabled', true);
            $('#nativeTimetable tbody tr').show();
        });

        function applyTimetableFilter() {
            var selDept = $('#filter_dept').val();
            var selSem = $('#filter_sem').val();
            var selDay = $('#filter_day').val();

            $('#nativeTimetable tbody tr').each(function() {
                var row = $(this);
                var rowDept = String(row.data('dept-id')).trim();
                var rowSem = String(row.data('sem-id')).trim();
                var rowDay = String(row.data('day')).trim();

                var matchDept = (selDept === "" || rowDept === String(selDept));
                var matchSem = (selSem === "" || rowSem === String(selSem));
                var matchDay = (selDay === "" || rowDay === String(selDay));

                if (matchDept && matchSem && matchDay) {
                    row.show();
                } else {
                    row.hide();
                }
            });
        }
    });
</script>

<?php include "footer.php"; ?>