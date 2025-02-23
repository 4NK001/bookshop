<?php
include('connection.php');
if($_GET['id'])
{
    $bookid=$_GET['id'];
    $sql="delete from tbl_book where bookid=$bookid";
    $result=mysqli_query($conn,$sql);
    header('location:admin_home.php');
}

?>