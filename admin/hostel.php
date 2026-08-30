<?php
include "conn.php";

// ================= AJAX HANDLERS =================
if (isset($_GET['action']) && $_GET['action'] == 'get_semesters') {
    if (ob_get_length()) {
        ob_clean();
    }
    header('Content-Type: application/json');
    $stmt = $conn->prepare("SELECT id, semester_name FROM semesters WHERE department_id = :dept_id AND status = 'Active'");
    $stmt->execute(['dept_id' => intval($_GET['dept_id'])]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'get_students') {
    if (ob_get_length()) {
        ob_clean();
    }
    header('Content-Type: application/json');
    $stmt = $conn->prepare("SELECT id, first_name, last_name FROM students WHERE department_id = :dept_id AND semester_id = :sem_id");
    $stmt->execute(['dept_id' => intval($_GET['dept_id']), 'sem_id' => intval($_GET['sem_id'])]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

// ================= FORM SUBMISSION =================
$successMessage = "";
if (isset($_POST['addHostel'])) {
    $sql = "INSERT INTO hostel_allocations (student_id, hostel_name, room_no, allocation_date, status) 
            VALUES (:sid, :hostel, :room, :adate, :status)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':sid' => $_POST['student_id'],
        ':hostel' => $_POST['hostel_name'],
        ':room' => $_POST['room_no'],
        ':adate' => $_POST['allocation_date'],
        ':status' => $_POST['status']
    ]);
    $successMessage = "Hostel room allocated successfully!";
}

$dept_stmt = $conn->query("SELECT id, dept_name FROM departments WHERE status='Active'");
$departmentsList = $dept_stmt->fetchAll(PDO::FETCH_ASSOC);

include "header.php";
?>

<main class="py-4">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white fw-bold"><i class="bi bi-building-fill me-2"></i> Hostel Management</h2>
            <button class="btn btn-warning fw-semibold shadow-sm text-dark" data-bs-toggle="modal" data-bs-target="#addHostelModal">
                <i class="bi bi-plus-circle me-1"></i> Allocate Room
            </button>
        </div>

        <?php if (!empty($successMessage)) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?= $successMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php } ?>

        <div class="card border-0 shadow bg-dark text-white rounded-4">
            <div class="card-body p-4">
                <h5 class="mb-3 text-white-50">Room Allocations</h5>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead class="table-light text-dark">
                            <tr>
                                <th>Student Name</th>
                                <th>Course/Sem</th>
                                <th>Hostel Name</th>
                                <th>Room No.</th>
                                <th>Allocation Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->query("SELECT h.*, s.first_name, s.last_name, d.dept_name, sem.semester_name 
                                                  FROM hostel_allocations h 
                                                  JOIN students s ON h.student_id = s.id
                                                  LEFT JOIN departments d ON s.department_id = d.id
                                                  LEFT JOIN semesters sem ON s.semester_id = sem.id
                                                  ORDER BY h.id DESC");
                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                    <tr>
                                        <td class="fw-bold text-light"><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                        <td><small class="text-white-50"><?= htmlspecialchars($row['dept_name'] . ' - ' . $row['semester_name']); ?></small></td>
                                        <td class="fw-bold text-warning"><?= htmlspecialchars($row['hostel_name']); ?></td>
                                        <td class="fw-bold fs-5"><?= htmlspecialchars($row['room_no']); ?></td>
                                        <td><?= date("d M Y", strtotime($row['allocation_date'])); ?></td>
                                        <td>
                                            <span class="badge bg-<?= ($row['status'] == 'Allocated') ? 'success' : 'secondary'; ?>">
                                                <?= htmlspecialchars($row['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                            <?php }
                            } else {
                                echo '<tr><td colspan="6" class="text-center py-3 text-white-50">No rooms allocated yet.</td></tr>';
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- MODAL: ALLOCATE ROOM -->
<div class="modal fade" id="addHostelModal" tabindex="-1">
    <div class="modal-dialog modal-lg text-dark">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold">Allocate Hostel Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Department</label>
                        <select class="form-select" id="hos_dept" required>
                            <option value="">Select Department</option>
                            <?php foreach ($departmentsList as $dept) {
                                echo "<option value='{$dept['id']}'>{$dept['dept_name']}</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Semester</label>
                        <select class="form-select" id="hos_sem" required disabled>
                            <option value="">Select Dept First</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-warning">Select Student</label>
                        <select class="form-select border-warning" name="student_id" id="hos_student" required disabled>
                            <option value="">Load Sem First</option>
                        </select>
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="form-label fw-bold">Hostel Name</label>
                        <select class="form-select" name="hostel_name" required>
                            <option value="Boys Hostel Block A">Boys Hostel Block A</option>
                            <option value="Boys Hostel Block B">Boys Hostel Block B</option>
                            <option value="Girls Hostel Block C">Girls Hostel Block C</option>
                        </select>
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="form-label fw-bold">Room No.</label>
                        <input type="text" class="form-control" name="room_no" placeholder="e.g. 101, 205B" required>
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="form-label fw-bold">Allocation Date</label>
                        <input type="date" class="form-control" name="allocation_date" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="form-label fw-bold">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="Allocated">Allocated</option>
                            <option value="Vacated">Vacated</option>
                        </select>
                    </div>
                    <div class="col-12 text-end mt-4">
                        <button type="submit" name="addHostel" class="btn btn-warning fw-bold">Save Allocation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#hos_dept').on('change', function() {
            var deptId = $(this).val();
            $('#hos_sem').html('<option value="">-- Select Semester --</option>').prop('disabled', true);
            $('#hos_student').html('<option value="">-- Load Sem First --</option>').prop('disabled', true);
            if (deptId) {
                $.get(window.location.pathname, {
                    action: 'get_semesters',
                    dept_id: deptId
                }, function(data) {
                    $('#hos_sem').prop('disabled', false);
                    $.each(data, function(k, v) {
                        $('#hos_sem').append('<option value="' + v.id + '">' + v.semester_name + '</option>');
                    });
                }, 'json');
            }
        });

        $('#hos_sem').on('change', function() {
            var semId = $(this).val();
            var deptId = $('#hos_dept').val();
            $('#hos_student').html('<option value="">-- Select Student --</option>').prop('disabled', true);
            if (semId && deptId) {
                $.get(window.location.pathname, {
                    action: 'get_students',
                    dept_id: deptId,
                    sem_id: semId
                }, function(data) {
                    $('#hos_student').prop('disabled', false);
                    $.each(data, function(k, v) {
                        $('#hos_student').append('<option value="' + v.id + '">' + v.first_name + ' ' + v.last_name + '</option>');
                    });
                }, 'json');
            }
        });
    });
</script>

<?php include "footer.php"; ?>