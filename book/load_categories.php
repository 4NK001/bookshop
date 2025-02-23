<?php
include('connection.php');
$result = mysqli_query($conn, "SELECT * FROM tbl_category");
$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}
echo json_encode($categories);
?>
