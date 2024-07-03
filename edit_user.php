<?php
include_once 'db_config.php'; 

$id = $name = $email = $gender = $phone = $createdAt = '';
$nameErr = $emailErr = '';

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = sanitizeInput($_GET['id']);

   
    $stmt = $conn->prepare("SELECT * FROM user WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $gender = $row['gender'];
        $phone = $row['phone'];
        $createdAt = $row['created_at'];
    } else {
        echo "User not found.";
        exit;
    }

    $stmt->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = sanitizeInput($_POST['id']);
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $gender = $_POST['gender'];
    $phone = sanitizeInput($_POST['phone']);
    $createdAt = $_POST['createdAt'];

 
    $valid = true;

    if (empty($name)) {
        $nameErr = "Name is required";
        $valid = false;
    }

    if (empty($email)) {
        $emailErr = "Email is required";
        $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $valid = false;
    }

    
    if ($valid) {

        $stmt = $conn->prepare("UPDATE user SET name=?, email=?, gender=?, phone=?, created_at=? WHERE id=?");
        $stmt->bind_param("sssssi", $name, $email, $gender, $phone, $createdAt, $id);

        if ($stmt->execute()) {
           
            echo "<script>alert('Record updated successfully');</script>";
            echo "<script>window.location.href = 'users.php';</script>";
            exit;
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $stmt->close();
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit User</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                <span class="error"><?php echo $nameErr; ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                <span class="error"><?php echo $emailErr; ?></span>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="male" <?php if ($gender === 'male') echo 'selected'; ?>>Male</option>
                    <option value="female" <?php if ($gender === 'female') echo 'selected'; ?>>Female</option>
                    <option value="other" <?php if ($gender === 'other') echo 'selected'; ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
            </div>
            <div class="form-group">
                <label for="createdAt">Created At:</label>
                <input type="date" class="form-control" id="createdAt" name="createdAt" value="<?php echo $createdAt; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="update">Update</button>
            <a href="users.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
