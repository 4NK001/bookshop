<?php
include('connection.php');
if($_GET['id'])
{
    $authorid=$_GET['id'];
    $sql="delete from tbl_author where authorid=$authorid";
    $result=mysqli_query($conn,$sql);
    header('location:admin_home.php');
}

?>