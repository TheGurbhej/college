<?php
require_once "conn.php";
include "header.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['upload_gallery'])) {
    $category = trim($_POST['category'] ?? '');
    $caption  = trim($_POST['caption'] ?? '');

    // Path inside admin/
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $uploaded_count = 0;
    $total_files = count($_FILES['images']['name'] ?? []);

    if ($total_files > 0 && !empty($category)) {
        // Prepare the PDO statement once outside the loop
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
?>

<main>
    <div class="container my-5">
        <?= $message; ?>
        <div class="card shadow-sm border-0">
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
                            <input type="text" class="form-control" id="imageCaption" name="caption" placeholder="e.g. Annual Sports Meet 2026">
                        </div>

                        <div class="col-12 text-end mt-4">
                            <button type="reset" class="btn btn-outline-secondary me-2">Reset</button>
                            <button type="submit" name="upload_gallery" class="btn btn-primary px-4">Upload to Gallery</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include "footer.php"; ?>