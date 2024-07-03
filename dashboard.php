<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?></h2>
        <h3>Your Details</h3>
        <ul>
            <li>ID: <?php echo htmlspecialchars($user['id']); ?></li>
            <li>Email: <?php echo htmlspecialchars($user['email']); ?></li>
            <li>Gender: <?php echo htmlspecialchars($user['gender']); ?></li>
            <li>Phone: <?php echo htmlspecialchars($user['phone']); ?></li>
            <li>Created At: <?php echo htmlspecialchars($user['created_at']); ?></li>
        </ul>
        <form method="post">
            <button type="submit" class="btn btn-danger" name="logout" onclick="return confirm('Are you sure you want to logout?')">Logout</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
