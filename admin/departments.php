<?php
// PHP Backend Logic (Add, Edit, Delete) - Ise sabse upar rakhna zaroori hai
include "conn.php"; // Aapka database connection file (PDO)
$message = "";

// 1. ADD Department
if (isset($_POST['add_dept'])) {
    $dept_code = $_POST['dept_code'];
    $dept_name = $_POST['dept_name'];
    $hod_name = $_POST['hod_name'];
    $status = $_POST['status'];

    $sql = "INSERT INTO departments (dept_code, dept_name, hod_name, status) VALUES (:dept_code, :dept_name, :hod_name, :status)";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(['dept_code' => $dept_code, 'dept_name' => $dept_name, 'hod_name' => $hod_name, 'status' => $status])) {
        $message = '<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="bi bi-check-circle me-1"></i> Department Added Successfully!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    } else {
        $message = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="bi bi-exclamation-triangle me-1"></i> Failed to add department!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
}

// 2. UPDATE Department
if (isset($_POST['edit_dept'])) {
    $id = $_POST['dept_id'];
    $dept_code = $_POST['edit_dept_code'];
    $dept_name = $_POST['edit_dept_name'];
    $hod_name = $_POST['edit_hod_name'];
    $status = $_POST['edit_status'];

    $sql = "UPDATE departments SET dept_code=:dept_code, dept_name=:dept_name, hod_name=:hod_name, status=:status WHERE id=:id";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(['dept_code' => $dept_code, 'dept_name' => $dept_name, 'hod_name' => $hod_name, 'status' => $status, 'id' => $id])) {
        $message = '<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="bi bi-check-circle me-1"></i> Department Updated Successfully!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
}

// 3. DELETE Department
if (isset($_POST['delete_dept'])) {
    $id = $_POST['delete_id'];
    $sql = "DELETE FROM departments WHERE id=:id";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(['id' => $id])) {
        $message = '<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="bi bi-trash me-1"></i> Department Deleted Successfully!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
}

include "header.php";
?>

<main class="content px-3 py-4">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-white mb-0">Departments</h3>
                <nav aria-label="breadcrumb" class="py-2">
                    <ol class="breadcrumb mb-0 text-bg-light rounded rounded-2 pe-2 ps-2">
                        <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item">Academic Setup</li>
                        <li class="breadcrumb-item active" aria-current="page">Departments</li>
                    </ol>
                </nav>
            </div>
            <!-- Add Button -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDeptModal">
                <i class="bi bi-plus-circle me-1"></i> Add Department
            </button>
        </div>

        <!-- Notification Message -->
        <?= $message; ?>

        <!-- Data Table Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="departmentsTable" class="table table-hover table-bordered align-middle w-100">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Department Name</th>
                                <th>HOD</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // 4. FETCH Data from database
                            $sql = "SELECT * FROM departments ORDER BY id DESC";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $counter = 1;

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $statusBadge = ($row['status'] == 'Active') ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                            ?>
                                <tr>
                                    <td><?= $counter++; ?></td>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($row['dept_code']); ?></span></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($row['dept_name']); ?></td>
                                    <td><?= htmlspecialchars($row['hod_name'] ? $row['hod_name'] : 'N/A'); ?></td>
                                    <td><?= $statusBadge; ?></td>
                                    <td class="text-center">
                                        <!-- Edit Button (Passes data to JS via data-* attributes) -->
                                        <button class="btn btn-sm btn-outline-primary edit-btn"
                                            data-id="<?= $row['id']; ?>"
                                            data-code="<?= htmlspecialchars($row['dept_code']); ?>"
                                            data-name="<?= htmlspecialchars($row['dept_name']); ?>"
                                            data-hod="<?= htmlspecialchars($row['hod_name']); ?>"
                                            data-status="<?= $row['status']; ?>"
                                            data-bs-toggle="modal" data-bs-target="#editDeptModal" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <button class="btn btn-sm btn-outline-danger delete-btn"
                                            data-id="<?= $row['id']; ?>"
                                            data-bs-toggle="modal" data-bs-target="#deleteDeptModal" title="Delete">
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

<!-- ================= MODALS SECTION ================= -->

<!-- 1. ADD Department Modal -->
<div class="modal fade" id="addDeptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="bi bi-diagram-3 me-2"></i>Add New Department</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Department Name <span class="text-danger">*</span></label>
                        <input type="text" name="dept_name" class="form-control" placeholder="e.g. Computer Science" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Department Code <span class="text-danger">*</span></label>
                        <input type="text" name="dept_code" class="form-control" placeholder="e.g. CSE" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Head of Department</label>
                        <input type="text" name="hod_name" class="form-control" placeholder="e.g. Dr. Rajesh Sharma">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="add_dept" class="btn btn-primary">Save Department</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 2. EDIT Department Modal -->
<div class="modal fade" id="editDeptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Department</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <!-- Hidden input for ID -->
                    <input type="hidden" name="dept_id" id="edit_id">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Department Name <span class="text-danger">*</span></label>
                        <input type="text" name="edit_dept_name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Department Code <span class="text-danger">*</span></label>
                        <input type="text" name="edit_dept_code" id="edit_code" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Head of Department</label>
                        <input type="text" name="edit_hod_name" id="edit_hod" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="edit_status" id="edit_status" class="form-select">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit_dept" class="btn btn-primary">Update Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 3. DELETE Confirmation Modal -->
<div class="modal fade" id="deleteDeptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <i class="bi bi-exclamation-circle text-danger display-4 mb-3 d-block"></i>
                <h5 class="fw-bold mb-3">Are you sure?</h5>
                <p class="text-muted mb-4">Do you really want to delete this department? This action cannot be undone.</p>
                <form action="" method="POST">
                    <input type="hidden" name="delete_id" id="delete_id">
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="delete_dept" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>