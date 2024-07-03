<?php
session_start();


$loginName = $loginEmail = '';
$nameErr = $emailErr = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    include_once 'db_config.php';

 
    function sanitizeInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    $loginName = sanitizeInput($_POST['loginName']);
    $loginEmail = sanitizeInput($_POST['loginEmail']);

   
    $valid = true;

    if (empty($loginName)) {
        $nameErr = "Name is required";
        $valid = false;
    }

    if (empty($loginEmail)) {
        $emailErr = "Email is required";
        $valid = false;
    } elseif (!filter_var($loginEmail, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $valid = false;
    }

    if ($valid) {
      
        $stmt = $conn->prepare("SELECT * FROM user WHERE name=? OR email=?");
        $stmt->bind_param("ss", $loginName, $loginEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Check if both name and email match
            if ($user['name'] == $loginName && $user['email'] == $loginEmail) {
                $_SESSION['user'] = $user;
                header("Location: dashboard.php");
                exit;
            } elseif ($user['name'] != $loginName) {
                $nameErr = "Name does not match";
            } elseif ($user['email'] != $loginEmail) {
                $emailErr = "Email does not match";
            }
        } else {
            echo "User not found";
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="loginName">Name:</label>
                <input type="text" class="form-control" id="loginName" name="loginName" placeholder="Enter name" value="<?php echo htmlspecialchars($loginName); ?>">
                <span class="error"><?php echo $nameErr; ?></span>
            </div>
            <div class="form-group">
                <label for="loginEmail">Email:</label>
                <input type="email" class="form-control" id="loginEmail" name="loginEmail" placeholder="Enter email" value="<?php echo htmlspecialchars($loginEmail); ?>">
                <span class="error"><?php echo $emailErr; ?></span>
            </div>
            <button type="submit" class="btn btn-primary" name="login">Login</button>
            <a href="signup.php" class="btn btn-primary">SignUp</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
