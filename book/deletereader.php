<?php
include('connection.php');
if($_GET['id'])
{
    $userid=$_GET['id'];
    $sql="delete from tbl_reader where userid=$userid";
    $result=mysqli_query($conn,$sql);
    header('location:admin_home.php');
}

?>