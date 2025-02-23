<?php
include('connection.php');
if($_GET['id'])
{
   // $authorid=$_SESSION['authorid'];
    $bookid=$_GET['id'];
    $sql="delete from tbl_book where bookid=$bookid";
    $result=mysqli_query($conn,$sql);
    header('location:author_home.php');
}

?>


