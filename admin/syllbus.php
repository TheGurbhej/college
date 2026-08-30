<?php
include "conn.php";

// ================= AJAX HANDLER (For Dependent Dropdowns) =================
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'get_courses') {
        $dept_id = $_GET['dept_id'];
        $stmt = $conn->prepare("SELECT id, course_name, course_code FROM courses WHERE department_id = :dept_id");
        $stmt->execute(['dept_id' => $dept_id]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    if ($_GET['action'] == 'get_semesters') {
        $dept_id = $_GET['dept_id'];
        $stmt = $conn->prepare("SELECT id, semester_name FROM semesters WHERE department_id = :dept_id AND status = 'Active'");
        $stmt->execute(['dept_id' => $dept_id]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }
}

$message = "";

// --- 1. ADD SYLLABUS LOGIC ---
if (isset($_POST['addSyllabus'])) {
    $department_id = $_POST['department_id'];
    $course_id = $_POST['course_id'];
    $semester_id = $_POST['semester_id'];
    $title = $_POST['title'];

    // File Upload Handling
    $fileName = "";
    if (isset($_FILES['syllabus_file']) && $_FILES['syllabus_file']['error'] == 0) {
        $uploadDir = "uploads/syllabus/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = time() . '_' . basename($_FILES['syllabus_file']['name']);
        $targetFilePath = $uploadDir . $fileName;
        move_uploaded_file($_FILES['syllabus_file']['tmp_name'], $targetFilePath);
    }

    $sql = "INSERT INTO syllabus (department_id, course_id, semester_id, title, file_path) 
            VALUES (:dept, :course, :sem, :title, :file)";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([
        'dept' => $department_id,
        'course' => $course_id,
        'sem' => $semester_id,
        'title' => $title,
        'file' => $fileName
    ])) {
        $message = '<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-1"></i> Syllabus Uploaded Successfully!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}

// --- 2. DELETE SYLLABUS LOGIC ---
if (isset($_POST['deleteSyllabus'])) {
    $id = $_POST['delete_id'];
    
    // Fetch file to delete from directory
    $stmt = $conn->prepare("SELECT file_path FROM syllabus WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!empty($row['file_path']) && file_exists("uploads/syllabus/" . $row['file_path'])) {
        unlink("uploads/syllabus/" . $row['file_path']);
    }

    $sql = "DELETE FROM syllabus WHERE id = :id";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(['id' => $id])) {
        $message = '<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-trash me-1"></i> Syllabus Deleted Successfully!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}

// FETCH DEPARTMENTS FOR INITIAL DROPDOWN
$dept_stmt = $conn->query("SELECT id, dept_name FROM departments WHERE status='Active'");
$departmentsList = $dept_stmt->fetchAll(PDO::FETCH_ASSOC);

include "header.php";
?>

<main class="py-4 bg-dark rounded-4 m-3">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-white mb-1">Syllabus Management</h2>
                <p class="text-white-50 mb-0">Upload and manage course-wise syllabus</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSyllabusModal">
                <i class="bi bi-plus-circle me-2"></i> Upload Syllabus
            </button>
        </div>

        <?= $message; ?>

        <div class="card border-0 shadow bg-dark">
            <div class="card-header bg-dark text-white border-secondary">
                <h5 class="mb-0">All Uploaded Syllabus</h5>
            </div>
            <div class="card-body bg-dark">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle" id="syllabusTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Syllabus Title</th>
                                <th>Department</th>
                                <th>Course</th>
                                <th>Semester</th>
                                <th>File</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT s.*, d.dept_name, c.course_name, c.course_code, sem.semester_name 
                                    FROM syllabus s 
                                    LEFT JOIN departments d ON s.department_id = d.id 
                                    LEFT JOIN courses c ON s.course_id = c.id 
                                    LEFT JOIN semesters sem ON s.semester_id = sem.id 
                                    ORDER BY s.id DESC";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $count = 1;

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr>
                                    <td><?= $count++; ?></td>
                                    <td class="fw-bold"><?= htmlspecialchars($row['title']); ?></td>
                                    <td><?= htmlspecialchars($row['dept_name'] ?? 'N/A'); ?></td>
                                    <td>
                                        <span class="fw-semibold"><?= htmlspecialchars($row['course_name'] ?? 'N/A'); ?></span>
                                        <small class="text-white-50 d-block">(<?= htmlspecialchars($row['course_code'] ?? ''); ?>)</small>
                                    </td>
                                    <td><span class="badge bg-info text-dark"><?= htmlspecialchars($row['semester_name'] ?? 'N/A'); ?></span></td>
                                    <td>
                                        <?php if (!empty($row['file_path'])) { ?>
                                            <a href="uploads/syllabus/<?= $row['file_path']; ?>" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-file-earmark-pdf me-1"></i> View / Download
                                            </a>
                                        <?php } else { echo '<span class="text-muted">No File</span>'; } ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger delete-btn" 
                                            data-id="<?= $row['id']; ?>"
                                            data-bs-toggle="modal" data-bs-target="#deleteSyllabusModal">
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

<div class="modal fade" id="addSyllabusModal" tabindex="-1">
    <div class="modal-dialog modal-lg text-dark">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Upload New Syllabus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Department <span class="text-danger">*</span></label>
                            <select class="form-select" name="department_id" id="dept_select" required>
                                <option value="">-- Select Department --</option>
                                <?php foreach($departmentsList as $dept) { ?>
                                    <option value="<?= $dept['id']; ?>"><?= htmlspecialchars($dept['dept_name']); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Course <span class="text-danger">*</span></label>
                            <select class="form-select" name="course_id" id="course_select" required disabled>
                                <option value="">-- Select Department First --</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Semester <span class="text-danger">*</span></label>
                            <select class="form-select" name="semester_id" id="sem_select" required disabled>
                                <option value="">-- Select Department First --</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Syllabus Title / Subject Name <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Data Structures & Algorithms Syllabus 2026" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Upload File (PDF / DOC)</label>
                            <input type="file" name="syllabus_file" class="form-control" accept=".pdf,.doc,.docx">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="addSyllabus" class="btn btn-primary">Upload Syllabus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteSyllabusModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered text-dark">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <i class="bi bi-exclamation-circle text-danger display-4 mb-3 d-block"></i>
                <h5 class="fw-bold mb-3">Delete Syllabus?</h5>
                <p class="text-muted mb-4">This action cannot be undone.</p>
                <form method="POST">
                    <input type="hidden" name="delete_id" id="delete_syllabus_id">
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="deleteSyllabus" class="btn btn-danger">Yes, Delete</button>
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
        $('#syllabusTable').DataTable({"pageLength": 10});

        // 1. Department change hone par Courses & Semesters load honge
        $('#dept_select').on('change', function() {
            var deptId = $(this).val();

            if (deptId != '') {
                // Fetch Courses
                $.ajax({
                    url: 'syllbus.php',
                    type: 'GET',
                    data: { action: 'get_courses', dept_id: deptId },
                    dataType: 'json',
                    success: function(courses) {
                        $('#course_select').html('<option value="">-- Select Course --</option>').prop('disabled', false);
                        $.each(courses, function(key, course) {
                            $('#course_select').append('<option value="' + course.id + '">' + course.course_name + ' (' + course.course_code + ')</option>');
                        });
                    }
                });

                // Fetch Semesters
                $.ajax({
                    url: 'syllbus.php',
                    type: 'GET',
                    data: { action: 'get_semesters', dept_id: deptId },
                    dataType: 'json',
                    success: function(semesters) {
                        $('#sem_select').html('<option value="">-- Select Semester --</option>').prop('disabled', false);
                        $.each(semesters, function(key, sem) {
                            $('#sem_select').append('<option value="' + sem.id + '">' + sem.semester_name + '</option>');
                        });
                    }
                });

            } else {
                $('#course_select').html('<option value="">-- Select Department First --</option>').prop('disabled', true);
                $('#sem_select').html('<option value="">-- Select Department First --</option>').prop('disabled', true);
            }
        });

        // Delete button logic
        $('.delete-btn').on('click', function() {
            $('#delete_syllabus_id').val($(this).data('id'));
        });
    });
</script>

<?php include "footer.php"; ?>