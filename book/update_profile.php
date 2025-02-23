<?php
session_start();
$authorid = $_SESSION['authorid'];  // Get logged-in user's email


// Create connection
include('connection.php');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update profile information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $image = $_FILES['image']['name'];
    
    // Handle file upload
    if ($image) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        
        // Update query with image
        $sql = "UPDATE tbl_author SET name='$name', image='$image' WHERE authorid='$authorid'";
    } else {
        // Update query without image
        $sql = "UPDATE tbl_author SET name='$name' WHERE authorid='$authorid'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Profile updated successfully";
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}

$conn->close();
?>
