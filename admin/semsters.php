<?php
include "conn.php";
$message = "";

if (isset($_POST['addSemester'])) {
    $department_id = $_POST['department_id'];
    $semester_name = $_POST['semester_name'];
    $status = $_POST['status'];

    $sql = "INSERT INTO semesters (department_id, semester_name, status) VALUES (:dept_id, :sem_name, :status)";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(['dept_id' => $department_id, 'sem_name' => $semester_name, 'status' => $status])) {
        $message = '<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-1"></i> Semester Added Successfully!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}

if (isset($_POST['editSemester'])) {
    $id = $_POST['semester_id'];
    $department_id = $_POST['edit_department_id'];
    $semester_name = $_POST['edit_semester_name'];
    $status = $_POST['edit_status'];

    $sql = "UPDATE semesters SET department_id=:dept_id, semester_name=:sem_name, status=:status WHERE id=:id";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(['dept_id' => $department_id, 'sem_name' => $semester_name, 'status' => $status, 'id' => $id])) {
        $message = '<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-1"></i> Semester Updated Successfully!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}

if (isset($_POST['deleteSemester'])) {
    $id = $_POST['delete_id'];
    $sql = "DELETE FROM semesters WHERE id=:id";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(['id' => $id])) {
        $message = '<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-trash me-1"></i> Semester Deleted Successfully!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}

$dept_stmt = $conn->query("SELECT id, dept_name, dept_code FROM departments WHERE status='Active'");
$departmentsList = $dept_stmt->fetchAll(PDO::FETCH_ASSOC);

include "header.php";
?>

<style>

    div.dataTables_wrapper div.dataTables_length label,
    div.dataTables_wrapper div.dataTables_filter label,
    div.dataTables_wrapper div.dataTables_info {
        color: #e9ecef !important;
        font-weight: 500;
        margin-bottom: 10px;
    }
    div.dataTables_wrapper div.dataTables_filter input,
    div.dataTables_wrapper div.dataTables_length select {
        background-color: #2b3035;
        color: #fff;
        border: 1px solid #495057;
        border-radius: 5px;
        padding: 4px 10px;
        margin-left: 5px;
    }
    div.dataTables_wrapper div.dataTables_filter input:focus,
    div.dataTables_wrapper div.dataTables_length select:focus {
        border-color: #0dcaf0;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 202, 240, 0.25);
    }
    .page-item .page-link {
        background-color: #2b3035;
        border-color: #495057;
        color: #e9ecef;
    }
    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .page-item.disabled .page-link {
        background-color: #1a1d20;
        border-color: #495057;
        color: #6c757d;
    }
    table.dataTable {
        margin-top: 15px !important;
        margin-bottom: 15px !important;
    }
    /* Table specific UI fixes */
    .table-dark th {
        color: #adb5bd !important;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        font-size: 0.85rem;
    }
</style>

<main class="py-4 bg-dark rounded-4 m-3">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-white mb-1">Semesters</h2>
                <p class="text-white-50 mb-0">Manage semesters by department</p>
            </div>
            <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addSemModal">
                <i class="bi bi-plus-circle me-2"></i> Add Semester
            </button>
        </div>

        <?= $message; ?>

        <div class="card border-secondary shadow-lg bg-dark">
            <div class="card-header bg-dark text-white border-secondary py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-list-task me-2"></i>All Semesters</h5>
            </div>
            <div class="card-body bg-dark text-light p-4">
                <div class="table-responsive">
                    <!-- Added table-bordered and border-secondary for clear grid lines -->
                    <table class="table table-dark table-bordered border-secondary table-hover align-middle mb-0 w-100" id="semestersTable">
                        <thead class="table-active align-middle">
                            <tr>
                                <th width="5%">#</th>
                                <th width="35%">Department</th>
                                <th width="25%">Semester Name</th>
                                <th width="15%">Status</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-white border-secondary">
                            <?php
                            $sql = "SELECT s.*, d.dept_name, d.dept_code FROM semesters s LEFT JOIN departments d ON s.department_id = d.id ORDER BY s.id DESC";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $count = 1;

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $statusBadge = ($row['status'] == 'Active') 
                                    ? '<span class="badge bg-success bg-opacity-75 px-3 py-2 rounded-pill">Active</span>' 
                                    : '<span class="badge bg-danger bg-opacity-75 px-3 py-2 rounded-pill">Inactive</span>';
                            ?>
                                <tr>
                                    <td class="text-light fw-bold"><?= $count++; ?></td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-light fs-6"><?= htmlspecialchars($row['dept_name'] ?? ''); ?></span>
                                            <span class="text-info small fw-semibold"><?= htmlspecialchars($row['dept_code'] ?? ''); ?></span>
                                        </div>
                                    </td>
                                    <td class="fw-bold text-white"><?= htmlspecialchars($row['semester_name']); ?></td>
                                    <td><?= $statusBadge; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info text-white shadow-sm edit-btn me-1" 
                                            data-id="<?= $row['id']; ?>"
                                            data-dept="<?= $row['department_id']; ?>"
                                            data-name="<?= htmlspecialchars($row['semester_name']); ?>"
                                            data-status="<?= $row['status']; ?>"
                                            data-bs-toggle="modal" data-bs-target="#editSemModal">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger shadow-sm delete-btn" 
                                            data-id="<?= $row['id']; ?>"
                                            data-bs-toggle="modal" data-bs-target="#deleteSemModal">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>


<div class="modal fade" id="addSemModal" tabindex="-1">
    <div class="modal-dialog text-dark">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add New Semester</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Department <span class="text-danger">*</span></label>
                        <select class="form-select" name="department_id" required>
                            <option value="">-- Choose Department --</option>
                            <?php foreach($departmentsList as $dept) { ?>
                                <option value="<?= $dept['id']; ?>"><?= htmlspecialchars($dept['dept_name']); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Semester Name <span class="text-danger">*</span></label>
                        <input type="text" name="semester_name" class="form-control" placeholder="e.g. 1st Semester" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0 bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="addSemester" class="btn btn-primary px-4">Save Semester</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editSemModal" tabindex="-1">
    <div class="modal-dialog text-dark">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Edit Semester</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="semester_id" id="edit_id">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Department <span class="text-danger">*</span></label>
                        <select class="form-select" name="edit_department_id" id="edit_department_id" required>
                            <?php foreach($departmentsList as $dept) { ?>
                                <option value="<?= $dept['id']; ?>"><?= htmlspecialchars($dept['dept_name']); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Semester Name <span class="text-danger">*</span></label>
                        <input type="text" name="edit_semester_name" id="edit_semester_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select class="form-select" name="edit_status" id="edit_status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0 bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="editSemester" class="btn btn-info text-white px-4">Update Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteSemModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered text-dark">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-body text-center p-4">
                <i class="bi bi-exclamation-circle text-danger display-4 mb-3 d-block"></i>
                <h5 class="fw-bold mb-3">Delete Semester?</h5>
                <p class="text-muted mb-4">This action cannot be undone.</p>
                <form method="POST">
                    <input type="hidden" name="delete_id" id="delete_id">
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="deleteSemester" class="btn btn-danger px-4">Yes, Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.8/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#semestersTable').DataTable({
            "pageLength": 10,
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search records..."
            }
        });

        $('.edit-btn').on('click', function() {
            $('#edit_id').val($(this).data('id'));
            $('#edit_department_id').val($(this).data('dept'));
            $('#edit_semester_name').val($(this).data('name'));
            $('#edit_status').val($(this).data('status'));
        });

        $('.delete-btn').on('click', function() {
            $('#delete_id').val($(this).data('id'));
        });
    });
</script>

<?php include "footer.php"; ?>