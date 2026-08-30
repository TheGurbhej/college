<?php
include "header.php";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carwash";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$msg = "";

// --- 1. Database se Image Fetch karne ka Logic ---
$profile_pic = "img/98681.jpg"; // Default backup image
$fetch_img_sql = "SELECT img_source FROM profile_img LIMIT 1";
$img_result = $conn->query($fetch_img_sql);

if ($img_result && $img_result->num_rows > 0) {
    $row = $img_result->fetch_assoc();
    if (!empty($row['img_source']) && file_exists($row['img_source'])) {
        $profile_pic = $row['img_source'];
    }
}

// Password update process
if (isset($_POST['update'])) {
    $email = trim($_POST['email']);
    $oldPassword = trim($_POST['oldPassword']);
    $newPassword = trim($_POST['newPassword']);
    $confirmPassword = trim($_POST['confirmPassword']);

    if ($newPassword != $confirmPassword) {
        $msg = "<div class='alert alert-danger'>New passwords do not match.</div>";
    } else {
        $sql = "SELECT * FROM users WHERE email='$email' AND password='$oldPassword'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $update = "UPDATE users SET password='$newPassword' WHERE email='$email'";
            if ($conn->query($update) === TRUE) {
                $msg = "<div class='alert alert-success'>Password updated successfully.</div>";
            } else {
                $msg = "<div class='alert alert-danger'>Error updating password.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Old email or password is incorrect.</div>";
        }
    }
}

// --- 2. Cropped Image Upload aur Table Sync ---
if (isset($_POST['cropped_image'])) {
    $image = $_POST['cropped_image'];
    $image = str_replace('data:image/png;base64,', '', $image);
    $image = str_replace(' ', '+', $image);

    $imageData = base64_decode($image);

    // Agar uploads folder nahi hai to create ho jaye
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }

    $filename = "profile_" . time() . ".png";
    $folder = "uploads/" . $filename;

    if (file_put_contents($folder, $imageData)) {

        $check_sql = "SELECT * FROM profile_img LIMIT 1";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            $db_query = "UPDATE profile_img SET img_source='$folder'";
        } else {
            $db_query = "INSERT INTO profile_img (img_source) VALUES ('$folder')";
        }

        if ($conn->query($db_query) === TRUE) {
            $msg = "<div class='alert alert-success'>Image uploaded and saved to database successfully.</div>";
            $profile_pic = $folder; // Page instant refresh par new image handle karega
        } else {
            $msg = "<div class='alert alert-danger'>Database error: " . $conn->error . "</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Upload failed.</div>";
    }
}
?>

<main>
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <?php echo $msg; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="profile-wrapper mx-auto mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <img src="<?php echo $profile_pic; ?>" class="profile-img" alt="Profile">

                    <div class="profile-overlay">
                        <i class="bi bi-camera-fill fs-2"></i>
                        <span>Change Photo</span>
                    </div>

                    <div class="camera-icon">
                        <i class="bi bi-camera-fill"></i>
                    </div>
                </div>

                <div class="text-center">
                    <button type="button" class="btn w-50 align-items-center btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Edit Profile
                    </button>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header">
                        <h5 class="mb-0">Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" value="John Doe">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" value="admin">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-control" value="demo@gmail.com">
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn w-100 btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="py-4">
                    <div class="bg-white shadow-sm">
                        <div class="card">
                            <div class="card-header pb-4">
                                <h5 class="mb-0">Password update</h5>
                            </div>
                            <form action="#" class="p-3" method="post">
                                <div class="mb-3">
                                    <label for="oldPassword" class="form-label">Old Password</label>
                                    <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="Enter old password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="newPassword" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter new password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm new password" required>
                                </div>
                                <button type="submit" name="update" class="btn btn-primary w-100">Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Set Profile Photo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="file" name="fileupload" id="imageInput" accept="image/*" hidden>
                                <input type="hidden" name="cropped_image" id="cropped_image">

                                <div class="d-flex gap-2 mb-3">
                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('imageInput').click()">Upload Image</button>
                                    <button type="button" class="btn btn-success" id="startCamera">Open Camera</button>
                                    <button type="button" class="btn btn-warning d-none" id="captureBtn">Capture</button>
                                </div>

                                <div id="cameraContainer" class="d-none text-center mb-3">
                                    <video id="video" width="100%" autoplay playsinline></video>
                                </div>

                                <div class="text-center">
                                    <img id="previewImage" class="img-fluid rounded border" style="max-height:400px;">
                                </div>
                                <canvas id="canvas" class="d-none"></canvas>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="saveProfile" id="cropBtn">Crop & Set Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</main>

<?php
include "footer.php";
?>