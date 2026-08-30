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
if (isset($_POST['addTransport'])) {
    $sql = "INSERT INTO transport_allocations (student_id, route_name, bus_no, pickup_point, status) 
            VALUES (:sid, :route, :bus, :pickup, :status)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':sid' => $_POST['student_id'],
        ':route' => $_POST['route_name'],
        ':bus' => $_POST['bus_no'],
        ':pickup' => $_POST['pickup_point'],
        ':status' => $_POST['status']
    ]);
    $successMessage = "Transport route assigned successfully!";
}

$dept_stmt = $conn->query("SELECT id, dept_name FROM departments WHERE status='Active'");
$departmentsList = $dept_stmt->fetchAll(PDO::FETCH_ASSOC);

include "header.php";
?>

<main class="py-4">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white fw-bold"><i class="bi bi-bus-front-fill me-2"></i> Transport Management</h2>
            <button class="btn btn-primary fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#addTransportModal">
                <i class="bi bi-plus-circle me-1"></i> Assign Transport
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
                <h5 class="mb-3 text-white-50">Assigned Transport Routes</h5>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead class="table-light text-dark">
                            <tr>
                                <th>Student Name</th>
                                <th>Course/Sem</th>
                                <th>Route Name</th>
                                <th>Bus No.</th>
                                <th>Pickup Point</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->query("SELECT t.*, s.first_name, s.last_name, d.dept_name, sem.semester_name 
                                                  FROM transport_allocations t 
                                                  JOIN students s ON t.student_id = s.id
                                                  LEFT JOIN departments d ON s.department_id = d.id
                                                  LEFT JOIN semesters sem ON s.semester_id = sem.id
                                                  ORDER BY t.id DESC");
                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                    <tr>
                                        <td class="fw-bold text-light"><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                        <td><small class="text-white-50"><?= htmlspecialchars($row['dept_name'] . ' - ' . $row['semester_name']); ?></small></td>
                                        <td class="text-info fw-bold"><?= htmlspecialchars($row['route_name']); ?></td>
                                        <td class="fw-bold"><?= htmlspecialchars($row['bus_no']); ?></td>
                                        <td><?= htmlspecialchars($row['pickup_point']); ?></td>
                                        <td>
                                            <span class="badge bg-<?= ($row['status'] == 'Active') ? 'success' : 'danger'; ?>">
                                                <?= htmlspecialchars($row['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                            <?php }
                            } else {
                                echo '<tr><td colspan="6" class="text-center py-3 text-white-50">No transport allocated yet.</td></tr>';
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- MODAL: ASSIGN TRANSPORT -->
<div class="modal fade" id="addTransportModal" tabindex="-1">
    <div class="modal-dialog modal-lg text-dark">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Assign Transport Route</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Department</label>
                        <select class="form-select" id="trans_dept" required>
                            <option value="">Select Department</option>
                            <?php foreach ($departmentsList as $dept) {
                                echo "<option value='{$dept['id']}'>{$dept['dept_name']}</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Semester</label>
                        <select class="form-select" id="trans_sem" required disabled>
                            <option value="">Select Dept First</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-primary">Select Student</label>
                        <select class="form-select border-primary" name="student_id" id="trans_student" required disabled>
                            <option value="">Load Sem First</option>
                        </select>
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="form-label fw-bold">Route Name</label>
                        <select class="form-select" name="route_name" required>
                            <option value="Route 1 - City Center">Route 1 - City Center</option>
                            <option value="Route 2 - North Zone">Route 2 - North Zone</option>
                            <option value="Route 3 - South Zone">Route 3 - South Zone</option>
                        </select>
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="form-label fw-bold">Bus No.</label>
                        <input type="text" class="form-control" name="bus_no" placeholder="e.g. RJ-07-PA-4521" required>
                    </div>
                    <div class="col-md-8 mt-4">
                        <label class="form-label fw-bold">Pickup Point</label>
                        <input type="text" class="form-control" name="pickup_point" placeholder="e.g. Rose Garden Stop" required>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label class="form-label fw-bold">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-12 text-end mt-4">
                        <button type="submit" name="addTransport" class="btn btn-primary fw-bold">Save Assignment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#trans_dept').on('change', function() {
            var deptId = $(this).val();
            $('#trans_sem').html('<option value="">-- Select Semester --</option>').prop('disabled', true);
            $('#trans_student').html('<option value="">-- Load Sem First --</option>').prop('disabled', true);
            if (deptId) {
                $.get(window.location.pathname, {
                    action: 'get_semesters',
                    dept_id: deptId
                }, function(data) {
                    $('#trans_sem').prop('disabled', false);
                    $.each(data, function(k, v) {
                        $('#trans_sem').append('<option value="' + v.id + '">' + v.semester_name + '</option>');
                    });
                }, 'json');
            }
        });

        $('#trans_sem').on('change', function() {
            var semId = $(this).val();
            var deptId = $('#trans_dept').val();
            $('#trans_student').html('<option value="">-- Select Student --</option>').prop('disabled', true);
            if (semId && deptId) {
                $.get(window.location.pathname, {
                    action: 'get_students',
                    dept_id: deptId,
                    sem_id: semId
                }, function(data) {
                    $('#trans_student').prop('disabled', false);
                    $.each(data, function(k, v) {
                        $('#trans_student').append('<option value="' + v.id + '">' + v.first_name + ' ' + v.last_name + '</option>');
                    });
                }, 'json');
            }
        });
    });
</script>

<?php include "footer.php"; ?>