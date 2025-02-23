<?php
include('connection.php');
if($_GET['id'])
{
    $categoryid=$_GET['id'];
    $sql="delete from tbl_category where categoryid=$categoryid";
    $result=mysqli_query($conn,$sql);
    header('location:admin_home.php');
}

?>