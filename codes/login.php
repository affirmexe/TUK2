<?php
session_start();
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $identifier = trim($_POST['identifier'] ?? '');
    $password   = $_POST['password'] ?? '';
    $remember   = isset($_POST['remember']); // optional

    if ($identifier && $password) {
        // Query using identifier for either email or name
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR name = ?");
        $stmt->execute([$identifier, $identifier]);
        $user = $stmt->fetch();

        // Verify password; ensure passwords are hashed when stored
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            if ($remember) {
                // Set cookie for 30 days (for demonstration purposes)
                setcookie('remember', $identifier, time() + (86400 * 30), "/");
            }
            header("Location: dashboard.php");
            exit;
        } else {
            $_SESSION['error'] = "Identifier and password do not match.";
            header("Location: login.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: login.php");
        exit;
    }
}

// Retrieve and clear the flash error, if any
$error = '';
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - TUK²</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/d554eb4963.js" crossorigin="anonymous"></script>
    <!-- Shared CSS -->
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="container fixed-container">
        <div class="login-card mx-auto my-5">
            <h2 class="text-center mb-4">
                <i class="fas fa-sign-in-alt me-2"></i>Login
            </h2>
            <?php if ($error): ?>
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                </div>
            <?php endif; ?>
            <form method="POST" id="loginForm">
                <div class="mb-3">
                    <label for="identifier" class="form-label">
                        <i class="fas fa-user me-1"></i> Name / Email:
                    </label>
                    <input type="text" id="identifier" name="identifier" class="form-control" required placeholder="Your name or Gmail...">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-1"></i> Password:
                    </label>
                    <div class="input-group position-relative">
                        <input type="password" id="password" name="password" class="form-control" required placeholder="Enter your password...">
                        <button class="btn btn-outline-secondary toggle-password" type="button" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Remember session
                    </label>
                </div>
                <button type="submit" class="btn btn-gold w-100">
                    <i class="fas fa-arrow-right me-1"></i>Login
                </button>
                <div class="text-center mt-3">
                    <i class="fas fa-user-plus me-1"></i>
                    Don't have an account? <a href="register.php" class="text-decoration-none">Register here</a>
                </div>
            </form>
        </div>
    </div>
    <!-- Shared JS -->
    <script src="assets/script.js"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>