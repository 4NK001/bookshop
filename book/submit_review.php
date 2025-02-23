<?php
session_start();
include 'connection.php'; // Include your database connection file

// Get the JSON data from the POST request
$data = json_decode(file_get_contents("php://input"));

if (isset($data->comments) && isset($data->book_id) && isset($data->user_id)) {
    $comments = $conn->real_escape_string($data->comments);
    $bookId = intval($data->book_id);
    $userId = intval($data->user_id);

    // Insert the comment into the database
    $sql = "INSERT INTO tbl_comment (book_id, user_id, comments, date) VALUES ('$bookId', '$userId', '$comments', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Review submitted successfully!']);
    } else {
        echo json_encode(['message' => 'Error: ' . $conn->error]);
    }
} else {
    echo json_encode(['message' => 'Invalid input.']);
}

$conn->close();
?>
