<?php
session_start();
if (!isset($_SESSION['staff'])) {
    header("Location: staff_login.php");
    exit;
}

$staff = $_SESSION['staff'];
$role = isset($staff['role']) ? $staff['role'] : 'Staff';
$name = isset($staff['name']) ? $staff['name'] : $staff['email'];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Dashboard - TUK²</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Shared CSS -->
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="container py-5">
        <div class="dashboard-container text-center mx-auto p-4">
            <h1>Staff Dashboard</h1>
            <p class="lead">Welcome, <?php echo htmlspecialchars($name); ?>!</p>
            <p>You are logged in as: <strong><?php echo htmlspecialchars($role); ?></strong></p>
            <a href="logout.php" class="btn btn-gold mt-3">Logout</a>
        </div>
    </div>

    <!-- Shared JS -->
    <script src="assets/script.js"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>