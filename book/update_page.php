<?php
// Start the session
session_start();

// Include your database connection file
include 'connection.php'; // Make sure this file contains your DB connection setup

// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    echo 'User not logged in.';
    exit;
}

$userId = $_SESSION['userid']; // Get user ID from session
$bookId = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
$pageNo = isset($_POST['page_no']) ? intval($_POST['page_no']) : 0;

// Validate inputs
if ($bookId > 0 && $pageNo > 0) {
    // Update the page number in the history table
    $sql = "UPDATE tbl_history SET page_no = ? WHERE userid = ? AND bookid = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('iii', $pageNo, $userId, $bookId);
        
        if ($stmt->execute()) {
            echo 'Page number updated successfully.';
        } else {
            echo 'Error updating page number: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        echo 'Error preparing statement: ' . $conn->error;
    }
} else {
    echo 'Invalid parameters.';
}

// Close the database connection
$conn->close();
?>
