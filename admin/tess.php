<?php
include "conn.php";

// ================= 1. AJAX HANDLERS FOR DEPENDENT DROPDOWNS =================
if (isset($_GET['action'])) {
    
    // Fetch Courses by Department
    if ($_GET['action'] == 'get_courses') {
        $dept_id = intval($_GET['dept_id']);
        $stmt = $conn->prepare("SELECT id, course_name, course_code FROM courses WHERE department_id = :dept_id");
        $stmt->execute(['dept_id' => $dept_id]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    // Fetch Semesters by Course or Department
    if ($_GET['action'] == 'get_semesters') {
        $dept_id = intval($_GET['dept_id']);
        $stmt = $conn->prepare("SELECT id, semester_name FROM semesters WHERE department_id = :dept_id AND status = 'Active'");
        $stmt->execute(['dept_id' => $dept_id]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }
}

$message = "";

// ================= 2. SAVE / UPLOAD SYLLABUS LOGIC =================
if (isset($_POST['addSyllabus'])) {
    $department_id = $_POST['department_id'];
    $course_id     = $_POST['course_id'];
    $semester_id   = $_POST['semester_id'];
    $title         = $_POST['title'];

    // File Upload Process
    $fileName = "";
    if (isset($_FILES['syllabus_file']) && $_FILES['syllabus_file']['error'] == 0) {
        $uploadDir = "uploads/syllabus/";
        
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $ext = pathinfo($_FILES['syllabus_file']['name'], PATHINFO_EXTENSION);
        $fileName = time() . '_' . rand(100, 999) . '.' . $ext;
        $targetPath = $uploadDir . $fileName;
        
        move_uploaded_file($_FILES['syllabus_file']['tmp_name'], $targetPath);
    }

    $sql = "INSERT INTO syllabus (department_id, course_id, semester_id, title, file_path) 
            VALUES (:dept, :course, :sem, :title, :file)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([
        'dept'   => $department_id,
        'course' => $course_id,
        'sem'    => $semester_id,
        'title'  => $title,
        'file'   => $fileName
    ])) {
        $message = '<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-1"></i> Syllabus / Subject Added Successfully!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    } else {
        $message = '<div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-1"></i> Error in saving record!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}

// ================= 3. DELETE LOGIC =================
if (isset($_POST['deleteSyllabus'])) {
    $id = $_POST['delete_id'];
    
    $stmt = $conn->prepare("SELECT file_path FROM syllabus WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!empty($row['file_path']) && file_exists("uploads/syllabus/" . $row['file_path'])) {
        unlink("uploads/syllabus/" . $row['file_path']);
    }

    $sql = "DELETE FROM syllabus WHERE id = :id";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(['id' => $id])) {
        $message = '<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-trash me-1"></i> Record Deleted Successfully!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}

// FETCH DEPARTMENTS FOR DROPDOWN
$dept_stmt = $conn->query("SELECT id, dept_name FROM departments WHERE status='Active'");
$departmentsList = $dept_stmt->fetchAll(PDO::FETCH_ASSOC);

include "header.php";
?>

<main class="py-4 px-3">
    <div class="container-fluid">
        
        <?= $message; ?>

        <div class="card border-0 rounded-3 mb-4 shadow-sm" style="background-color: #212529;">
            <div class="card-body p-4">
                <h3 class="text-white mb-4 fw-normal">Manage and update Syllabus</h3>
                <button type="button" class="btn btn-success px-4 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#addSyllabusModal">
                    + Upload Syllabus
                </button>
            </div>
        </div>

        <div class="card border-0 shadow bg-dark rounded-3">
            <div class="card-body bg-dark rounded-3 p-4">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle w-100" id="syllabusTable">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">Subject Name</th>
                                <th width="20%">Department</th>
                                <th width="20%">Course</th>
                                <th width="15%">Semester</th>
                                <th width="15%" class="text-center">Action</th>
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
                                    <td class="fw-bold text-info"><?= htmlspecialchars($row['title']); ?></td>
                                    <td><?= htmlspecialchars($row['dept_name'] ?? 'N/A'); ?></td>
                                    <td>
                                        <span class="fw-semibold"><?= htmlspecialchars($row['course_name'] ?? 'N/A'); ?></span>
                                        <small class="text-white-50 d-block">(<?= htmlspecialchars($row['course_code'] ?? ''); ?>)</small>
                                    </td>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($row['semester_name'] ?? 'N/A'); ?></span></td>
                                    <td class="text-center">
                                        <?php if (!empty($row['file_path'])) { ?>
                                            <a href="uploads/syllabus/<?= $row['file_path']; ?>" target="_blank" class="btn btn-sm btn-outline-success me-1" title="View File">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                        <?php } else { ?>
                                            <button class="btn btn-sm btn-outline-secondary me-1" disabled title="No File">
                                                <i class="bi bi-eye-slash"></i>
                                            </button>
                                        <?php } ?>

                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn" 
                                            data-id="<?= $row['id']; ?>" data-bs-toggle="modal" data-bs-target="#deleteSyllabusModal" title="Delete">
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

<div class="modal fade" id="addSyllabusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg text-dark">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-cloud-arrow-up-fill me-2"></i> Upload New Syllabus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                <option value="">-- Select Dept First --</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Semester <span class="text-danger">*</span></label>
                            <select class="form-select" name="semester_id" id="sem_select" required disabled>
                                <option value="">-- Select Dept First --</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Subject Name <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Data Structures & Algorithms" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Upload File (PDF / DOC)</label>
                            <input type="file" name="syllabus_file" class="form-control" accept=".pdf,.doc,.docx">
                        </div>

                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="addSyllabus" class="btn btn-success">Save & Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteSyllabusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered text-dark">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <i class="bi bi-exclamation-circle text-danger display-4 mb-3 d-block"></i>
                <h5 class="fw-bold mb-3">Delete Subject?</h5>
                <p class="text-muted mb-4">Are you sure? This action cannot be undone.</p>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.8/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        
        // DataTables init
        if ($.fn.DataTable) {
            $('#syllabusTable').DataTable({"pageLength": 10});
        }

        // Delete button click handler
        $(document).on('click', '.delete-btn', function() {
            $('#delete_syllabus_id').val($(this).data('id'));
        });

        // Department select change handler
        $('#dept_select').on('change', function() {
            var deptId = $(this).val();

            if (deptId !== '') {
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
                $('#course_select').html('<option value="">-- Select Dept First --</option>').prop('disabled', true);
                $('#sem_select').html('<option value="">-- Select Dept First --</option>').prop('disabled', true);
            }
        });

    });
</script>

<?php include "footer.php"; ?>