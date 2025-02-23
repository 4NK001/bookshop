<?php
// Start the session
session_start();

// Include your database connection file
include 'connection.php'; // Make sure this file contains your DB connection setup

// Retrieve parameters from the POST request
$bookId = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
$pageNo = isset($_POST['page_no']) ? intval($_POST['page_no']) : 0;
$bookmarkTitle = isset($_POST['title']) ? $_POST['title'] : '';

// Ensure the user is logged in and user ID is available in the session
if (!isset($_SESSION['userid'])) {
    die('User not logged in.');
}

$userId = $_SESSION['userid']; // Assuming user ID is stored in the session

if ($bookId && $pageNo && $userId) {
    // Prepare a SQL query to check for existing bookmark
    $checkSql = "SELECT COUNT(*) AS count FROM tbl_bookmark WHERE user_id = '$userId' AND book_id = '$bookId' AND page_no = '$pageNo'";
    $result = $conn->query($checkSql);

    if ($result) {
        $row = $result->fetch_assoc();
        
        if ($row['count'] > 0) {
            // Bookmark already exists
            echo "Bookmark already exists.";
        } else {
            // Insert the new bookmark
            $insertSql = "INSERT INTO tbl_bookmark (user_id, book_id, page_no, title) VALUES ('$userId', '$bookId', '$pageNo', '$bookmarkTitle')";
            
            if ($conn->query($insertSql) === TRUE) {
                echo "Bookmark saved.";
            } else {
                echo "Error: " . $insertSql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Error checking bookmark existence: " . $conn->error;
    }
} else {
    echo "Invalid parameters.";
}

// Close the database connection
$conn->close();
?>