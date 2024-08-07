<?php
$sql = "SELECT bookid, title, authorid, description, categoryid, image, bookfile FROM tbl_book";
$result = $conn->query($sql);

$books = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}

echo json_encode($books);

$conn->close();
?>