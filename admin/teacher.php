<?php

include "conn.php";

if (isset($_POST['addTeacher'])) {


    $photo = $_FILES['photo']['name'];
    move_uploaded_file(
        $_FILES['photo']['tmp_name'],
        "uploads/teachers/" . $photo
    );

    $sql = "INSERT INTO teacher(name,department,qualification,designation,date,salary,address,status,photoupload)
VALUES(:name,:department,:qualification,:designation,:date,:salary,:address,:status,:photo)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $_POST['name'],
        ':department' => $_POST['department'],
        ':qualification' => $_POST['qualification'],
        ':designation' => $_POST['designation'],
        ':date' => $_POST['date'],
        ':salary' => $_POST['salary'],
        ':address' => $_POST['address'],
        ':status' => $_POST['status'],
        ':photo' => $photo
    ]);
    $success = "Teacher Added Successfully!";
}

$stmt = $conn->query("SELECT * FROM teacher");

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    // Photo ka naam nikalo
    $stmt = $conn->prepare("SELECT photoupload FROM teacher WHERE id = ?");
    $stmt->execute([$id]);
    $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

    // Photo delete karo
    if ($teacher && file_exists("uploads/teachers/" . $teacher['photoupload'])) {
        unlink("uploads/teachers/" . $teacher['photoupload']);
    }

    // Database se record delete karo
    $stmt = $conn->prepare("DELETE FROM teacher WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: teacher.php");
    exit;
}

$teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['updateTeacher'])) {


    $photo = $_FILES['photo']['name'];

    if ($photo != "") {
        move_uploaded_file(
            $_FILES['photo']['tmp_name'],
            "uploads/teachers/" . $photo
        );
    } else {
        $photo = $_POST['old_photo'];
    }

    $sql = "UPDATE teacher SET name = :name, department = :department, qualification = :qualification, designation = :designation,
            date = :date, salary = :salary, address = :address ,status = :status, photoupload = :photo WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':id' => $_POST['id'],
        ':name' => $_POST['name'],
        ':department' => $_POST['department'],
        ':qualification' => $_POST['qualification'],
        ':designation' => $_POST['designation'],
        ':date' => $_POST['date'],
        ':salary' => $_POST['salary'],
        ':address' => $_POST['address'],
        ':status' => $_POST['status'],
        ':photo' => $photo
    ]);

    header("Location: teacher.php");
    exit;
}
?>
<?php
include "header.php";
?>

<main class="container-fluid py-4">
    <div class="card bg-primary text-white shadow mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h2> Teachers Management</h2>
                <p class="mb-0">Manage teachers easily.</p>
            </div>
            <button class="btn btn-light fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-person-plus-fill"></i> Add Teacher</button>
        </div>
    </div>

    <?php if (isset($success)) { ?>
        <div class="alert alert-success alert-dismissible fade show"><?= $success ?><button class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php } ?>

    <div class="row mb-4">
        <div class="">
            <div class="card shadow">
                <div class="card-body">
                    <h6>Total Teachers - <span class="fw-bold"><?= count($teachers) ?></span></h6>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Teacher List</h4>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Qualification</th>
                        <th>Designation</th>
                        <th>Date</th>
                        <th>Salary</th>
                        <th>Status</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($teachers as $row) { ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td>
                                <img src="uploads/teachers/<?= $row['photoupload']; ?>"
                                    width="50"
                                    height="50"
                                    class="rounded-circle"
                                    style="object-fit:cover;">
                            </td>
                            <td><?= $row['name'] ?></td>
                            <td><span class=""><?= $row['department'] ?></span></td>
                            <td><?= $row['qualification'] ?></td>
                            <td><span class=""><?= $row['designation'] ?></span></td>
                            <td><?= $row['date'] ?></td>
                            <td class="fw-bold text-success">₹<?= number_format($row['salary']) ?></td>
                            <td>
                                <?php
                                if ($row['status'] == 1) {
                                    echo "<span class='badge bg-success'>Active</span>";
                                } else {
                                    echo "<span class='badge bg-danger'>Inactive</span>";
                                }
                                ?>
                            </td>
                            <td><?= $row['address'] ?></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class=" btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal<?= $row['id']; ?>">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <a href="teacher.php?delete=<?= $row['id']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this teacher?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="editModal<?= $row['id']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header bg-primary">
                                        <h5 class="modal-title text-white fw-semibold">
                                            Edit Teacher
                                        </h5>

                                        <button type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal">
                                        </button>
                                    </div>

                                    <form method="POST" enctype="multipart/form-data">

                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                            <div class="row g-3">
                                                <div class="col-md-6"><label class="form-label">Name</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="name"
                                                        value="<?= $row['name']; ?>"
                                                        required>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Department</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="department"
                                                        value="<?= $row['department']; ?>"
                                                        required>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Qualification</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="qualification"
                                                        value="<?= $row['qualification']; ?>"
                                                        required>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Designation</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="designation"
                                                        value="<?= $row['designation']; ?>"
                                                        required>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Joining Date</label>
                                                    <input
                                                        type="date"
                                                        class="form-control"
                                                        name="date"
                                                        value="<?= $row['date']; ?>"
                                                        required>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Salary</label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="salary"
                                                        value="<?= $row['salary']; ?>"
                                                        required>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-select">
                                                        <option value="1" <?= $row['status'] == 1 ? 'selected' : '' ?>>Active</option>
                                                        <option value="0" <?= $row['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Current Photo</label><br>

                                                    <img src="uploads/teachers/<?= $row['photoupload']; ?>"
                                                        width="70"
                                                        height="70"
                                                        class="rounded mb-2"
                                                        style="object-fit:cover;">

                                                    <input type="file" name="photo" class="form-control">
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label">Address</label>

                                                    <textarea
                                                        class="form-control"
                                                        name="address"
                                                        required><?= $row['address']; ?></textarea>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button
                                                type="button"
                                                class="btn btn-secondary"
                                                data-bs-dismiss="modal">
                                                Cancel
                                            </button>

                                            <button
                                                type="submit"
                                                name="updateTeacher"
                                                class="btn btn-success">
                                                Update Teacher
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="exampleModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add New Teacher</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" class="row g-3">
                        <div class="col-md-6"><label class="form-label">Name</label><input required name="name" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Department</label><input required name="department" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Qualification</label><input required name="qualification" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Designation</label><input required name="designation" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Joining Date</label><input type="date" required name="date" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Salary</label><input type="number" required name="salary" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Status</label><select name="status" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-6"><label class="form-label">Photo</label><input type="file" name="photo" class="form-control"></div>
                        <div class="col-12"><label class="form-label">Address</label><textarea required name="address" class="form-control"></textarea></div>
                        <div class="text-end">
                            <button class="btn btn-secondary" type="reset">Reset</button>
                            <button class="btn btn-success" name="addTeacher">Save Teacher</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</main>

<?php include "footer.php"; ?>