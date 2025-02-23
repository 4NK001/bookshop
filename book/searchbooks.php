<?php
include('connection.php');

$query = isset($_GET['query']) ? $_GET['query'] : '';

if (!empty($query)) {
    $stmt = $conn->prepare("SELECT bookid, title, description, image FROM tbl_book WHERE title LIKE ?");
    $searchTerm = '%' . $query . '%';
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    $books = [];
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }

    echo json_encode($books);
} else {
    echo json_encode([]);
}

$conn->close();
?>
