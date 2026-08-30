<?php
include "conn.php";
$message = "";

// --- ADD COURSE ---
if (isset($_POST['addCourse'])) {
    $course_name = $_POST['course_name'];
    $course_code = $_POST['course_code'];
    $department_id = $_POST['department_id'];
    $semester_id = $_POST['semester_id'];
    $duration = $_POST['duration'];
    $description = $_POST['description'];

    $sql = "INSERT INTO courses (course_name, course_code, department_id, semester_id, duration, description) VALUES (:name, :code, :dept, :sem, :duration, :desc)";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(['name' => $course_name, 'code' => $course_code, 'dept' => $department_id, 'sem' => $semester_id, 'duration' => $duration, 'desc' => $description])) {
        $message = '<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-1"></i> Course Added Successfully!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}

// --- EDIT COURSE ---
if (isset($_POST['editCourse'])) {
    $id = $_POST['course_id'];
    $course_name = $_POST['edit_course_name'];
    $course_code = $_POST['edit_course_code'];
    $department_id = $_POST['edit_department_id'];
    $semester_id = $_POST['edit_semester_id'];
    $duration = $_POST['edit_duration'];
    $description = $_POST['edit_description'];

    $sql = "UPDATE courses SET course_name=:name, course_code=:code, department_id=:dept, semester_id=:sem, duration=:duration, description=:desc WHERE id=:id";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(['name' => $course_name, 'code' => $course_code, 'dept' => $department_id, 'sem' => $semester_id, 'duration' => $duration, 'desc' => $description, 'id' => $id])) {
        $message = '<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-1"></i> Course Updated Successfully!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}

// --- DELETE COURSE ---
if (isset($_POST['deleteCourse'])) {
    $id = $_POST['delete_id'];
    $sql = "DELETE FROM courses WHERE id=:id";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(['id' => $id])) {
        $message = '<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-trash me-1"></i> Course Deleted Successfully!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}

// FETCH DROPDOWN DATA
$dept_stmt = $conn->query("SELECT id, dept_name FROM departments WHERE status='Active'");
$departmentsList = $dept_stmt->fetchAll(PDO::FETCH_ASSOC);

$sem_stmt = $conn->query("SELECT id, semester_name FROM semesters WHERE status='Active'");
$semestersList = $sem_stmt->fetchAll(PDO::FETCH_ASSOC);

include "header.php";
?>

<main class="py-4 bg-dark rounded-4 m-3">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-white mb-1">Courses</h2>
                <p class="text-white-50 mb-0">Manage college courses</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                <i class="bi bi-plus-circle me-2"></i> Add Course
            </button>
        </div>

        <?= $message; ?>

        <div class="card border-0 shadow bg-dark">
            <div class="card-header bg-dark text-white border-secondary">
                <h5 class="mb-0">All Courses</h5>
            </div>
            <div class="card-body bg-dark">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle" id="coursesTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Course</th>
                                <th>Department</th>
                                <th>Semester</th>
                                <th>Duration</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT c.*, d.dept_name, s.semester_name FROM courses c LEFT JOIN departments d ON c.department_id = d.id LEFT JOIN semesters s ON c.semester_id = s.id ORDER BY c.id DESC";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $count = 1;

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr>
                                    <td><?= $count++; ?></td>
                                    <td>
                                        <span class="fw-bold"><?= htmlspecialchars($row['course_name']); ?></span>
                                        <small class="text-white-50 d-block">(<?= htmlspecialchars($row['course_code']); ?>)</small>
                                    </td>
                                    <td><?= htmlspecialchars($row['dept_name'] ?? ''); ?></td>
                                    <td><span class="badge bg-info text-dark"><?= htmlspecialchars($row['semester_name'] ?? ''); ?></span></td>
                                    <td><?= htmlspecialchars($row['duration']); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info edit-btn" 
                                            data-id="<?= $row['id']; ?>"
                                            data-name="<?= htmlspecialchars($row['course_name']); ?>"
                                            data-code="<?= htmlspecialchars($row['course_code']); ?>"
                                            data-dept="<?= $row['department_id']; ?>"
                                            data-sem="<?= $row['semester_id']; ?>"
                                            data-duration="<?= htmlspecialchars($row['duration']); ?>"
                                            data-desc="<?= htmlspecialchars($row['description']); ?>"
                                            data-bs-toggle="modal" data-bs-target="#editCourseModal">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger delete-btn" 
                                            data-id="<?= $row['id']; ?>"
                                            data-bs-toggle="modal" data-bs-target="#deleteCourseModal">
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

<!-- ADD COURSE MODAL -->
<div class="modal fade" id="addCourseModal" tabindex="-1">
    <div class="modal-dialog modal-lg text-dark">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add New Course</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Course Name</label>
                            <input type="text" name="course_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Course Code</label>
                            <input type="text" name="course_code" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Department</label>
                            <select class="form-select" name="department_id" required>
                                <option value="">-- Select Department --</option>
                                <?php foreach($departmentsList as $dept) { ?>
                                    <option value="<?= $dept['id']; ?>"><?= htmlspecialchars($dept['dept_name']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Semester</label>
                            <select class="form-select" name="semester_id" required>
                                <option value="">-- Select Semester --</option>
                                <?php foreach($semestersList as $sem) { ?>
                                    <option value="<?= $sem['id']; ?>"><?= htmlspecialchars($sem['semester_name']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Duration</label>
                            <input type="text" name="duration" class="form-control" placeholder="e.g. 6 Months, 1 Year" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Description</label>
                            <textarea class="form-control" rows="2" name="description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="addCourse" class="btn btn-primary">Save Course</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT COURSE MODAL -->
<div class="modal fade" id="editCourseModal" tabindex="-1">
    <div class="modal-dialog modal-lg text-dark">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Edit Course</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="course_id" id="edit_id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Course Name</label>
                            <input type="text" name="edit_course_name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Course Code</label>
                            <input type="text" name="edit_course_code" id="edit_code" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Department</label>
                            <select class="form-select" name="edit_department_id" id="edit_dept" required>
                                <?php foreach($departmentsList as $dept) { ?>
                                    <option value="<?= $dept['id']; ?>"><?= htmlspecialchars($dept['dept_name']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Semester</label>
                            <select class="form-select" name="edit_semester_id" id="edit_sem" required>
                                <?php foreach($semestersList as $sem) { ?>
                                    <option value="<?= $sem['id']; ?>"><?= htmlspecialchars($sem['semester_name']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Duration</label>
                            <input type="text" name="edit_duration" id="edit_duration" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Description</label>
                            <textarea class="form-control" rows="2" name="edit_description" id="edit_description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="editCourse" class="btn btn-info text-white">Update Course</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DELETE COURSE MODAL -->
<div class="modal fade" id="deleteCourseModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered text-dark">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <i class="bi bi-exclamation-circle text-danger display-4 mb-3 d-block"></i>
                <h5 class="fw-bold mb-3">Delete Course?</h5>
                <p class="text-muted mb-4">This action cannot be undone.</p>
                <form method="POST">
                    <input type="hidden" name="delete_id" id="delete_course_id">
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="deleteCourse" class="btn btn-danger">Yes, Delete</button>
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
        $('#coursesTable').DataTable({"pageLength": 10});

        $('.edit-btn').on('click', function() {
            $('#edit_id').val($(this).data('id'));
            $('#edit_name').val($(this).data('name'));
            $('#edit_code').val($(this).data('code'));
            $('#edit_dept').val($(this).data('dept'));
            $('#edit_sem').val($(this).data('sem'));
            $('#edit_duration').val($(this).data('duration'));
            $('#edit_description').val($(this).data('desc'));
        });

        $('.delete-btn').on('click', function() {
            $('#delete_course_id').val($(this).data('id'));
        });
    });
</script>

<?php include "footer.php"; ?>