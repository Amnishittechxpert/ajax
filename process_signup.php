<?php
$nameErr = $emailErr = $genderErr = $phoneErr = $createdAtErr = '';

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['signup'])) {
        include_once 'db_config.php';

        $name = sanitizeInput($_POST['name']);
        $email = sanitizeInput($_POST['email']);
        $gender = $_POST['gender'];
        $phone = sanitizeInput($_POST['phone']);
        $createdAt = sanitizeInput($_POST['createdAt']);

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

        if (empty($gender)) {
            $genderErr = "Gender is required";
            $valid = false;
        }

        if (empty($phone)) {
            $phoneErr = "Phone number is required";
            $valid = false;
        } elseif (!preg_match("/^\d{10}$/", $phone)) {
            $phoneErr = "Invalid phone number format (10 digits)";
            $valid = false;
        }

        if (empty($createdAt)) {
            $createdAtErr = "Created At date is required";
            $valid = false;
        }

        // Insert data into database if all inputs are valid
        if ($valid) {
            $sql = "INSERT INTO user (name, email, gender, phone, created_at)
                    VALUES ('$name', '$email', '$gender', '$phone', '$createdAt')";

            if ($conn->query($sql) === TRUE) {
                echo 'success';
            } else {
                echo 'Error: ' . $sql . '<br>' . $conn->error;
            }

            $conn->close();
        }
    }
}
?>
