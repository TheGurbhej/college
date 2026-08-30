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
if (isset($_POST['addFee'])) {
    $receipt_no = "REC-" . strtoupper(substr(uniqid(), -5));
    $sql = "INSERT INTO fees_collections (student_id, amount, payment_date, payment_mode, receipt_no) 
            VALUES (:sid, :amt, :pdate, :pmode, :receipt)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':sid' => $_POST['student_id'],
        ':amt' => $_POST['amount'],
        ':pdate' => $_POST['payment_date'],
        ':pmode' => $_POST['payment_mode'],
        ':receipt' => $receipt_no
    ]);
    $successMessage = "Fee collected successfully! Receipt No: " . $receipt_no;
}

// Fetch Active Departments for Fees Form
$dept_stmt = $conn->query("SELECT id, dept_name FROM departments WHERE status='Active'");
$departmentsList = $dept_stmt->fetchAll(PDO::FETCH_ASSOC);

include "header.php";
?>

<main class="py-4">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white fw-bold"><i class="bi bi-cash-coin me-2"></i> Fees Management</h2>
            <button class="btn btn-success fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#addFeeModal">
                <i class="bi bi-plus-circle me-1"></i> Collect Fee
            </button>
        </div>

        <?php if (!empty($successMessage)) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?= $successMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php } ?>

        <!-- FEES TABLE -->
        <div class="card border-0 shadow bg-dark text-white rounded-4">
            <div class="card-body p-4">
                <h5 class="mb-3 text-white-50">Recent Fee Collections</h5>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead class="table-light text-dark">
                            <tr>
                                <th>Receipt No</th>
                                <th>Date</th>
                                <th>Student Name</th>
                                <th>Course/Sem</th>
                                <th>Amount</th>
                                <th>Payment Mode</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->query("SELECT f.*, s.first_name, s.last_name, d.dept_name, sem.semester_name 
                                                  FROM fees_collections f 
                                                  JOIN students s ON f.student_id = s.id
                                                  LEFT JOIN departments d ON s.department_id = d.id
                                                  LEFT JOIN semesters sem ON s.semester_id = sem.id
                                                  ORDER BY f.id DESC");
                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                    <tr>
                                        <td class="fw-bold text-warning"><?= htmlspecialchars($row['receipt_no']); ?></td>
                                        <td><?= date("d M Y", strtotime($row['payment_date'])); ?></td>
                                        <td class="fw-bold text-light"><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                        <td><small class="text-white-50"><?= htmlspecialchars($row['dept_name'] . ' - ' . $row['semester_name']); ?></small></td>
                                        <td class="fw-bold text-success">&#8377;<?= number_format($row['amount'], 2); ?></td>
                                        <td><span class="badge bg-secondary"><?= htmlspecialchars($row['payment_mode']); ?></span></td>
                                    </tr>
                            <?php }
                            } else {
                                echo '<tr><td colspan="6" class="text-center py-3 text-white-50">No fee records found.</td></tr>';
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- MODAL: COLLECT FEE -->
<div class="modal fade" id="addFeeModal" tabindex="-1">
    <div class="modal-dialog modal-lg text-dark">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Collect Student Fee</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Department</label>
                        <select class="form-select" id="fee_dept" required>
                            <option value="">Select Department</option>
                            <?php foreach ($departmentsList as $dept) {
                                echo "<option value='{$dept['id']}'>{$dept['dept_name']}</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Semester</label>
                        <select class="form-select" id="fee_sem" required disabled>
                            <option value="">Select Dept First</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-success">Select Student</label>
                        <select class="form-select border-success" name="student_id" id="fee_student" required disabled>
                            <option value="">Load Sem First</option>
                        </select>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label class="form-label fw-bold">Amount (&#8377;)</label>
                        <input type="number" step="0.01" class="form-control" name="amount" required>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label class="form-label fw-bold">Payment Date</label>
                        <input type="date" class="form-control" name="payment_date" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label class="form-label fw-bold">Payment Mode</label>
                        <select class="form-select" name="payment_mode" required>
                            <option value="Cash">Cash</option>
                            <option value="UPI / Online">UPI / Online</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                    </div>
                    <div class="col-12 text-end mt-4">
                        <button type="submit" name="addFee" class="btn btn-success">Save & Generate Receipt</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#fee_dept').on('change', function() {
            var deptId = $(this).val();
            $('#fee_sem').html('<option value="">-- Select Semester --</option>').prop('disabled', true);
            $('#fee_student').html('<option value="">-- Load Sem First --</option>').prop('disabled', true);
            if (deptId) {
                $.get(window.location.pathname, {
                    action: 'get_semesters',
                    dept_id: deptId
                }, function(data) {
                    $('#fee_sem').prop('disabled', false);
                    $.each(data, function(k, v) {
                        $('#fee_sem').append('<option value="' + v.id + '">' + v.semester_name + '</option>');
                    });
                }, 'json');
            }
        });

        $('#fee_sem').on('change', function() {
            var semId = $(this).val();
            var deptId = $('#fee_dept').val();
            $('#fee_student').html('<option value="">-- Select Student --</option>').prop('disabled', true);
            if (semId && deptId) {
                $.get(window.location.pathname, {
                    action: 'get_students',
                    dept_id: deptId,
                    sem_id: semId
                }, function(data) {
                    $('#fee_student').prop('disabled', false);
                    $.each(data, function(k, v) {
                        $('#fee_student').append('<option value="' + v.id + '">' + v.first_name + ' ' + v.last_name + '</option>');
                    });
                }, 'json');
            }
        });
    });
</script>

<?php include "footer.php"; ?>