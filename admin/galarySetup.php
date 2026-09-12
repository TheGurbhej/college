<?php
require_once "conn.php";
include "header.php";

$message = "";
$target_dir = "uploads/";

if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}

// -------------------------------------------------------------
// 1. DELETE ACTION (VIA MODAL POST)
// -------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['confirm_delete'])) {
    $delete_id = (int)$_POST['delete_id'];

    $stmt = $conn->prepare("SELECT image_name FROM gallery WHERE id = :id");
    $stmt->execute([':id' => $delete_id]);
    $image = $stmt->fetch();

    if ($image) {
        $file_path = $target_dir . $image['image_name'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        $del_stmt = $conn->prepare("DELETE FROM gallery WHERE id = :id");
        $del_stmt->execute([':id' => $delete_id]);

        $message = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Image removed successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>';
    }
}

// -------------------------------------------------------------
// 2. MODAL EDIT / UPDATE ACTION
// -------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_gallery'])) {
    $edit_id   = (int)$_POST['edit_id'];
    $title     = trim($_POST['edit_title'] ?? '');
    $category  = trim($_POST['edit_category'] ?? '');

    if (!empty($_FILES['edit_image']['name']) && $_FILES['edit_image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['edit_image']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed_types, true)) {
            $old_stmt = $conn->prepare("SELECT image_name FROM gallery WHERE id = :id");
            $old_stmt->execute([':id' => $edit_id]);
            $old_file = $old_stmt->fetchColumn();

            if ($old_file && file_exists($target_dir . $old_file)) {
                unlink($target_dir . $old_file);
            }

            $new_name = uniqid('img_', true) . '.' . $ext;
            if (move_uploaded_file($_FILES['edit_image']['tmp_name'], $target_dir . $new_name)) {
                $upd_stmt = $conn->prepare("UPDATE gallery SET title = :title, category = :category, image_name = :image_name WHERE id = :id");
                $upd_stmt->execute([
                    ':title'      => $title,
                    ':category'   => $category,
                    ':image_name' => $new_name,
                    ':id'         => $edit_id
                ]);
            }
        }
    } else {
        $upd_stmt = $conn->prepare("UPDATE gallery SET title = :title, category = :category WHERE id = :id");
        $upd_stmt->execute([
            ':title'    => $title,
            ':category' => $category,
            ':id'       => $edit_id
        ]);
    }

    $message = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Gallery item updated successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>';
}

// -------------------------------------------------------------
// 3. MULTI-IMAGE UPLOAD ACTION
// -------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['upload_gallery'])) {
    $category = trim($_POST['category'] ?? '');
    $caption  = trim($_POST['caption'] ?? '');
    $uploaded_count = 0;
    $total_files = count($_FILES['images']['name'] ?? []);

    if ($total_files > 0 && !empty($category)) {
        $sql = "INSERT INTO gallery (title, category, image_name) VALUES (:title, :category, :image_name)";
        $stmt = $conn->prepare($sql);
        $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];

        for ($i = 0; $i < $total_files; $i++) {
            $file_name  = $_FILES['images']['name'][$i];
            $file_tmp   = $_FILES['images']['tmp_name'][$i];
            $file_error = $_FILES['images']['error'][$i];

            if ($file_error === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                if (in_array($ext, $allowed_types, true)) {
                    $new_name = uniqid('img_', true) . '.' . $ext;
                    $destination = $target_dir . $new_name;

                    if (move_uploaded_file($file_tmp, $destination)) {
                        $stmt->execute([
                            ':title'      => $caption,
                            ':category'   => $category,
                            ':image_name' => $new_name
                        ]);
                        $uploaded_count++;
                    }
                }
            }
        }
    }

    if ($uploaded_count > 0) {
        $message = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Successfully uploaded ' . $uploaded_count . ' image(s).
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>';
    } else {
        $message = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Upload failed. Please check file format (JPG, PNG, WEBP) and size.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>';
    }
}

// -------------------------------------------------------------
// 4. FETCH DATA
// -------------------------------------------------------------
$stmt = $conn->query("SELECT * FROM gallery ORDER BY id DESC");
$gallery_items = $stmt->fetchAll();
?>

<main class="container my-5">
    <?= $message; ?>

    <!-- Upload Form Card -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="card-title mb-0">Upload Gallery Images</h5>
        </div>
        <div class="card-body p-4">
            <form action="galarySetup.php" method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="galleryImages" class="form-label fw-semibold">Select Images</label>
                        <input class="form-control" type="file" id="galleryImages" name="images[]" multiple accept="image/*" required>
                        <div class="form-text">Supports JPG, PNG, WEBP.</div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="imageCategory" class="form-label fw-semibold">Target Album / Category</label>
                        <select class="form-select" id="imageCategory" name="category" required>
                            <option value="" selected disabled>Choose category...</option>
                            <option value="Campus Life">Campus Life</option>
                            <option value="Events">Events</option>
                            <option value="Sports">Sports</option>
                            <option value="Seminars">Seminars</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="imageCaption" class="form-label fw-semibold">Default Title / Caption</label>
                        <input type="text" class="form-control" id="imageCaption" name="caption" placeholder="e.g. Annual Sports Meet">
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="reset" class="btn btn-outline-secondary me-2">Reset</button>
                        <button type="submit" name="upload_gallery" class="btn btn-primary px-4">Upload to Gallery</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Gallery Table (Show) -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 fw-bold">Manage Gallery Items</h5>
            <span class="badge bg-secondary"><?= count($gallery_items); ?> Items</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 100px;">Preview</th>
                            <th>Title / Caption</th>
                            <th>Category</th>
                            <th>File Name</th>
                            <th class="text-end pe-4" style="width: 160px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($gallery_items)): ?>
                            <?php foreach ($gallery_items as $item): ?>
                                <tr>
                                    <td class="ps-4">
                                        <img src="<?= $target_dir . htmlspecialchars($item['image_name']); ?>"
                                            alt="thumbnail"
                                            class="rounded border object-fit-cover"
                                            style="width: 60px; height: 60px;">
                                    </td>
                                    <td class="fw-semibold text-truncate" style="max-width: 220px;">
                                        <?= htmlspecialchars($item['title'] ?: 'Untitled'); ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                            <?= htmlspecialchars($item['category']); ?>
                                        </span>
                                    </td>
                                    <td><small class="text-muted"><?= htmlspecialchars($item['image_name']); ?></small></td>
                                    <td class="text-end pe-4">
                                        <!-- Edit Modal Trigger -->
                                        <button type="button"
                                            class="btn btn-sm btn-outline-primary me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal"
                                            data-id="<?= $item['id']; ?>"
                                            data-title="<?= htmlspecialchars($item['title']); ?>"
                                            data-category="<?= htmlspecialchars($item['category']); ?>"
                                            data-img="<?= $target_dir . htmlspecialchars($item['image_name']); ?>">
                                            Edit
                                        </button>
                                        <!-- Delete Modal Trigger -->
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-id="<?= $item['id']; ?>"
                                            data-title="<?= htmlspecialchars($item['title'] ?: $item['image_name']); ?>"
                                            data-img="<?= $target_dir . htmlspecialchars($item['image_name']); ?>">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No images found in the gallery.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- 1. Bootstrap Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="galarySetup.php" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editModalLabel">Edit Image Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" name="edit_id" id="modal_edit_id">

                <div class="text-center mb-3">
                    <img id="modal_preview_img" src="" class="rounded border shadow-sm object-fit-cover" style="width: 140px; height: 140px;" alt="Image Preview">
                    <div class="form-text mt-1">Current Image</div>
                </div>

                <div class="mb-3">
                    <label for="modal_edit_title" class="form-label fw-semibold">Title / Caption</label>
                    <input type="text" class="form-control" name="edit_title" id="modal_edit_title">
                </div>

                <div class="mb-3">
                    <label for="modal_edit_category" class="form-label fw-semibold">Category</label>
                    <select class="form-select" name="edit_category" id="modal_edit_category" required>
                        <option value="Campus Life">Campus Life</option>
                        <option value="Events">Events</option>
                        <option value="Sports">Sports</option>
                        <option value="Seminars">Seminars</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="modal_edit_image" class="form-label fw-semibold">Replace Photo (Optional)</label>
                    <input type="file" class="form-control" name="edit_image" id="modal_edit_image" accept="image/*">
                    <div class="form-text">Choose a file only if you want to replace the current picture.</div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name="update_gallery" class="btn btn-primary px-4">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Bootstrap Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <form action="galarySetup.php" method="POST" class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <input type="hidden" name="delete_id" id="modal_delete_id">

                <img id="modal_delete_img" src="" class="rounded border object-fit-cover mb-3 shadow-sm" style="width: 80px; height: 80px;" alt="To Delete">

                <p class="mb-1 text-muted">Are you sure you want to delete this item?</p>
                <p class="fw-bold text-dark text-truncate px-2 mb-0" id="modal_delete_title"></p>
                <small class="text-danger">This action will permanently delete the file.</small>
            </div>
            <div class="modal-footer bg-light d-flex justify-content-center">
                <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name="confirm_delete" class="btn btn-danger px-3">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Edit Modal Handler
        const editModal = document.getElementById('editModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                document.getElementById('modal_edit_id').value = button.getAttribute('data-id');
                document.getElementById('modal_edit_title').value = button.getAttribute('data-title');
                document.getElementById('modal_edit_category').value = button.getAttribute('data-category');
                document.getElementById('modal_preview_img').src = button.getAttribute('data-img');
                document.getElementById('modal_edit_image').value = '';
            });
        }

        // 2. Delete Modal Handler
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                document.getElementById('modal_delete_id').value = button.getAttribute('data-id');
                document.getElementById('modal_delete_title').textContent = button.getAttribute('data-title');
                document.getElementById('modal_delete_img').src = button.getAttribute('data-img');
            });
        }
    });
</script>

<?php include "footer.php"; ?>