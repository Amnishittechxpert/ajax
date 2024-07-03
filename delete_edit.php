<?php
session_start();

include_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        
      
        $id = intval($_POST['id']); 
        
 
        $stmt = $conn->prepare("DELETE FROM user WHERE id=?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Record deleted successfully');</script>";
        } else {
            echo "Error deleting record: " . $stmt->error;
        }
        
        $stmt->close();
    }
    
    if (isset($_POST['edit'])) {
        $id = $_POST['id'];

        header("Location: edit_user.php?id=" . $id);
        exit; 
    }
}

$conn->close();
?>
