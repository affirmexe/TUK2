<?php
session_start();
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier'] ?? '');
    $password   = $_POST['password'] ?? '';

    if ($identifier && $password) {
        // Query the staffs table for a matching name or email
        $stmt = $pdo->prepare("SELECT * FROM staffs WHERE email = ? OR name = ?");
        $stmt->execute([$identifier, $identifier]);
        $staff = $stmt->fetch();

        if ($staff && password_verify($password, $staff['password'])) {
            $_SESSION['staff'] = $staff;
            header("Location: staff_dashboard.php");
            exit;
        } else {
            $_SESSION['error'] = "Identifier and password do not match.";
            header("Location: staff_login.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: staff_login.php");
        exit;
    }
}

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
    <title>Staff Login - TUK²</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container fixed-container">
        <div class="login-card mx-auto my-5 p-4">
            <h2 class="text-center mb-4">Staff Login</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger text-center"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="identifier" class="form-label">Name or Email:</label>
                    <input type="text" class="form-control" id="identifier" name="identifier" placeholder="Enter your name or email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>