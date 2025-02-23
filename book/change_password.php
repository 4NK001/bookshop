<?php
session_start();
$authorid = $_SESSION['authorid']; // Get logged-in user's email

include('connection.php');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Change password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if new passwords match
    if ($newPassword !== $confirmPassword) {
        die("New passwords do not match");
    }

    // Validate current password
    $sql = "SELECT l.password ,a.email
    FROM tbl_login l 
    JOIN tbl_author a ON l.username = a.email 
    WHERE a.authorid = '$authorid'";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        $email=$row['email'];
        // Example: Verify password (should use hashing in a real scenario)
        if ($currentPassword === $storedPassword) {
            // Update password
            $sqlUpdate = "UPDATE tbl_login SET password='$newPassword' WHERE username='$email'";
            if ($conn->query($sqlUpdate) === TRUE) {
                echo "Password changed successfully";
            } else {
                echo "Error changing password: " . $conn->error;
            }
        } else {
            echo "Current password is incorrect";
        }
    } else {
        echo "User not found";
    }
}

$conn->close();
?>
