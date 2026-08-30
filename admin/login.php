<?php

session_start();

if (isset($_SESSION["check_login"]) && $_SESSION["check_login"] === true) {
    header("Location: dashboard.php");
    exit;
}

include "conn.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');


    if ($email === '' || $password === '') {

        echo "Email aur password enter karein.";
        exit;

    }


    // Email se user search karo

    $stmt = $conn->prepare(
        "SELECT id, name, email, password
         FROM users
         WHERE email = ?"
    );


    $stmt->execute([$email]);


    $row = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($row) {

        // Abhi database mein password plain text hai

        if ($row["password"] === $password) {

            $_SESSION["check_login"] = true;

            $_SESSION["user_id"] = $row["id"];

            $_SESSION["user_name"] = $row["name"];

            $_SESSION["user_email"] = $row["email"];


            header("Location: dashboard.php");
            exit;

        } else {

            echo "Password galat hai.";

        }

    } else {

        echo "Email ya password galat hai.";

    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">

    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-12 col-sm-8 col-md-6 col-lg-4">

                <div class="card shadow border-0 rounded-4">

                    <div class="card-body p-4 p-sm-5">

                        <!-- HEADER -->

                        <div class="text-center mb-4">

                            <div
                                class="bg-primary text-white
                                   d-inline-flex
                                   align-items-center
                                   justify-content-center
                                   rounded-circle
                                   p-3 mb-2">

                                <i class="bi bi-mortarboard-fill fs-3"></i>

                            </div>

                            <h4 class="fw-bold text-dark mt-2 mb-1">
                                Welcome Back
                            </h4>

                            <p class="text-muted small mb-0">
                                Login to College Management
                            </p>

                        </div>


                        <!-- LOGIN FORM -->

                        <form
                            action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                            method="POST">

                            <!-- EMAIL -->

                            <div class="mb-3">

                                <label
                                    for="email"
                                    class="form-label
                                       fw-semibold
                                       text-secondary
                                       small">

                                    Email Address

                                </label>

                                <div class="input-group">

                                    <span
                                        class="input-group-text
                                           bg-white
                                           border-end-0
                                           text-muted">

                                        <i class="bi bi-envelope"></i>

                                    </span>

                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        class="form-control
                                           border-start-0
                                           ps-0"
                                        placeholder="name@example.com"
                                        autocomplete="email"
                                        required>

                                </div>

                            </div>


                            <!-- PASSWORD -->

                            <div class="mb-3">

                                <div
                                    class="d-flex
                                       justify-content-between
                                       align-items-center
                                       mb-1">

                                    <label
                                        for="password"
                                        class="form-label
                                           fw-semibold
                                           text-secondary
                                           small
                                           mb-0">

                                        Password

                                    </label>

                                    <a
                                        href="#"
                                        class="text-decoration-none
                                           small
                                           text-primary">

                                        Forgot Password?

                                    </a>

                                </div>


                                <div class="input-group">

                                    <span
                                        class="input-group-text
                                           bg-white
                                           border-end-0
                                           text-muted">

                                        <i class="bi bi-lock"></i>

                                    </span>

                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        class="form-control
                                           border-start-0
                                           ps-0"
                                        placeholder="Enter your password"
                                        autocomplete="current-password"
                                        required>

                                </div>

                            </div>


                            <!-- REMEMBER -->

                            <div class="mb-4 form-check">

                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    id="rememberMe"
                                    name="remember">

                                <label
                                    class="form-check-label
                                       text-muted
                                       small"
                                    for="rememberMe">

                                    Remember me on this device

                                </label>

                            </div>


                            <!-- LOGIN BUTTON -->

                            <button
                                type="submit"
                                name="login"
                                class="btn btn-primary
                                   w-100
                                   py-2
                                   rounded-3
                                   fw-bold
                                   shadow-sm">

                                <i
                                    class="bi bi-box-arrow-in-right
                                       me-2"></i>

                                Sign In

                            </button>

                        </form>


                        <!-- REGISTER -->

                        <div class="text-center mt-4">

                            <p class="text-muted small mb-0">

                                Don't have an account?

                                <a
                                    href="register.php"
                                    class="text-primary
                                       fw-semibold
                                       text-decoration-none">

                                    Create Account

                                </a>

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Bootstrap JS -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>