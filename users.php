<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
   
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Registered Users</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once 'db_config.php';

            
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
                    $id = $_POST['id'];
                  
                    $stmt = $conn->prepare("DELETE FROM user WHERE id=?");
                    $stmt->bind_param("i", $id);
                    
                    if ($stmt->execute()) {
                        echo "<script>alert('Record deleted successfully');</script>";
           
                        echo "<script>window.location.href = 'users.php';</script>";
                    } else {
                        echo "Error deleting record: " . $conn->error;
                    }
                }

                // SQL query fetch users
                $sql = "SELECT * FROM user";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . ucfirst($row["gender"]) . "</td>";
                        echo "<td>" . $row["phone"] . "</td>";
                        echo "<td>" . $row["created_at"] . "</td>";
                        echo "<td>";
                        echo "<form method='get' action='edit_user.php'>";
                        echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                        echo "<button type='submit' class='btn btn-primary btn-sm' name='edit'>Edit</button>";
                        echo "</form>";
                        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                        echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                        echo "<button type='submit' class='btn btn-danger btn-sm mt-2' name='delete' onclick='return confirmDelete()'>Delete</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                        
                    }
                } else {
                    echo "<tr><td colspan='7'>No users found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this user?");
    }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
