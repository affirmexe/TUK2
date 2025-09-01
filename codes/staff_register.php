<?php
session_start();
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name             = trim($_POST['name'] ?? '');
    $email            = trim($_POST['email'] ?? '');
    $password         = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($name && $email && $password && $confirm_password) {
        if ($password !== $confirm_password) {
            $_SESSION['error'] = "Passwords do not match.";
            header("Location: staff_register.php");
            exit;
        }
        $stmt = $pdo->prepare("SELECT * FROM staffs WHERE email = ? OR name = ?");
        $stmt->execute([$email, $name]);
        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "A staff with that email or name already exists.";
            header("Location: staff_register.php");
            exit;
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Insert with empty defaults for address and no_telp; update later via staff settings.
        $stmt = $pdo->prepare("INSERT INTO staffs (name, address, email, no_telp, password, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        if ($stmt->execute([$name, '', $email, '', $hashed_password])) {
            $_SESSION['success'] = "Staff registration successful. Please login.";
            header("Location: staff_login.php");
            exit;
        } else {
            $_SESSION['error'] = "Registration failed. Please try again.";
            header("Location: staff_register.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: staff_register.php");
        exit;
    }
}

$error   = '';
$success = '';
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Register - TUK²</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/d554eb4963.js" crossorigin="anonymous"></script>
    <!-- Shared CSS -->
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="container fixed-container">
        <div class="login-card mx-auto my-5 p-4">
            <h2 class="text-center mb-4">
                <i class="fas fa-user-plus me-2"></i>Staff Register
            </h2>
            <?php if ($error): ?>
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                </div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success text-center">
                    <i class="fas fa-check me-2"></i><?php echo $success; ?>
                </div>
            <?php endif; ?>
            <form class="row g-3" method="POST" id="staffRegisterForm">
                <div class="col-md-6">
                    <label for="name" class="form-label">
                        <i class="fas fa-user me-1"></i>Name
                    </label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-1"></i>Email
                    </label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-1"></i>Password
                    </label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="col-md-6">
                    <label for="confirm_password" class="form-label">
                        <i class="fas fa-lock me-1"></i>Confirm Password
                    </label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-enter password" required>
                </div>
                <div class="col-12 form-check">
                    <input type="checkbox" class="form-check-input" id="showPassword">
                    <label class="form-check-label" for="showPassword">Show password</label>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-gold w-100">
                        <i class="fas fa-arrow-right me-1"></i>Register
                    </button>
                </div>
                <div class="col-12 text-center">
                    <i class="fas fa-sign-in-alt me-1"></i>
                    Already have an account? <a href="staff_login.php" class="text-decoration-none">Login here</a>
                </div>
            </form>
        </div>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Toggle Password Visibility Script -->
    <script>
        document.getElementById('showPassword').addEventListener('change', function() {
            const pwd = document.getElementById('password');
            const cpwd = document.getElementById('confirm_password');
            if (this.checked) {
                pwd.type = 'text';
                cpwd.type = 'text';
            } else {
                pwd.type = 'password';
                cpwd.type = 'password';
            }
        });
    </script>
</body>

</html>