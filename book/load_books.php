<?php
include('connection.php');
$categoryid = isset($_GET['categoryid']) ? $_GET['categoryid'] : 0;

if ($categoryid == 0) {
    $result = mysqli_query($conn, "SELECT * FROM tbl_book");
} else {
    $result = mysqli_query($conn, "SELECT * FROM tbl_book WHERE categoryid = $categoryid");
}

$books = [];
while ($row = mysqli_fetch_assoc($result)) {
    $books[] = $row;
}
echo json_encode($books);
?>
