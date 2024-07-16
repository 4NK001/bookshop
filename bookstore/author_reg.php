<?php
include('connection.php');

        

if (isset($_POST["submit"])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $photo = $_FILES['image']['name'];
    $keyuser = 'author';


    $sql="SELECT * FROM tbl_author WHERE email='$email'";

    $result=mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)>0){

        echo '<script>alert("User with this email already exists. Please choose a different email.");</script>';
    }
    else{
        move_uploaded_file($_FILES['image']['tmp_name'],'uploads/'.$photo);
        $sql = "INSERT INTO tbl_author (name,password,email,image) VALUES ('$name','$password','$email','$photo')";
 
        if(mysqli_query($conn, $sql))
{
    $sql="INSERT INTO tbl_login(username,Password,keyuser) VALUES ('$email','$password','$keyuser')";
    mysqli_query($conn, $sql);  
        

?>
<script type="text/javascript" src="swal/jquery.min.js"></script>
<script type="text/javascript" src="swal/bootstrap.min.js"></script>
<script type="text/javascript" src="swal/sweetalert2@11.js"></script>
<script>
        
                document.
addEventListener('DOMContentLoaded', function () {
                        // SweetAlert initialization code goes here
                        Swal.fire({
                            icon: 'success',
                            text: 'Successfully Registered',
                            didClose: () => {
                                window.location.replace('tetailer_reg.php');
                            }
                        });
                    });
            </script>
            <?php
                exit();
                }
        else{
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }    
}
   ?>





<?php
    session_start();
    include('connection.php');

    $name=$email=$password=$confpassword=$keyuser="";

    if (isset($_POST["submit"])){

       
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $photo = $_FILES['image']['name'];
    $keyuser = 'author';

    $sql="SELECT * FROM tbl_author WHERE email='$email'";

        $result=mysqli_query($conn,$sql);
    
        if(mysqli_num_rows($result)>0){
    
            echo '<script>alert("User with this email already exists. Please choose a different email.");</script>';
        }
        else{
        
            move_uploaded_file($_FILES['image']['tmp_name'],'uploads/'.$photo);
            $sql = "INSERT INTO tbl_author (name,password,email,image) VALUES ('$name','$password','$email','$photo')";
            if(mysqli_query($conn,$sql)){
    
    
              
                $sql="INSERT INTO tbl_login(username,password,keyuser) VALUES ('$email','$password','$keyuser')";
                mysqli_query($conn, $sql);
                ?>
                <script type="text/javascript" src="swal/jquery.min.js"></script>
                <script type="text/javascript" src="swal/bootstrap.min.js"></script>
                <script type="text/javascript" src="swal/sweetalert2@11.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                            // SweetAlert initialization code goes here
                            Swal.fire({
                                icon: 'success',
                                text: 'Successfully Registered',
                                didClose: () => {
                                    window.location.replace('index.php');
                                }
                            });
                        });
                </script>
                <?php
                    exit();
            }
            else{
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
    
   
?>


<!DOCTYPE html>    
<html>    
<head>    
<meta name="viewport" content="width=device-width, initial-scale=1">  
<link rel="stylesheet" href="mainstyle/css/style.css">  
 <!-- font awesome cdn link  -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
 <title> author_reg </title>
<style>
 /*    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 20px;
    } */

    body {
            font-family: Arial, sans-serif;
            background: url('mainstyle/image/backgrd1.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 20px;
        }
    .container {
        max-width: 400px;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin: auto;
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    label {
        font-weight: bold;
        font-size: larger;
        display: block;
        margin-bottom: 5px;
    }
    input {
        width: calc(100% - 12px);
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    input[type="submit"] {
        background-color: #27ae60;
        color: white;
        border: none;
        padding: 12px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>
</head>
<body>
<header class="header">

<div class="header-1">

    <a href="#" class="logo"> <i class="fas fa-book"></i> Books4MU </a>

 

</div>

<div class="header-2">
    <nav class="navbar">
        <a href="./index.html">home</a>
        <a href="#featured">featured</a>
        <a href="#">category</a>
        <a href="#reviews">reviews</a>
        <a href="./feedback.html">feedback</a>
    </nav>
</div>

</header>

<!-- header section ends -->

<!-- bottom navbar  -->

<nav class="bottom-navbar" >
<a href="#home" class="fas fa-home"></a>
<a href="#featured" class="fas fa-list"></a>
<a href="#arrivals" class="fas fa-tags"></a>
<a href="#reviews" class="fas fa-comments"></a>
<a href="#feedback" class="fas fa-feedback"></a>
</nav>


<div class="container"style="margin-top:60px;">
    <h2>Registration Form</h2>
    <form action="" method="POST" enctype="multipart/form-data"  class="contact-form">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Your Name" required>
            <span name="nameError" id="nameError"></span>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Your Email" required>
            <span name="emailError" id="emailError"></span>
        </div>
        <div class="form-group">
            <label for="image">choose photo:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="password" required>
        </div>
        <div class="form-group">
            <label for="password">Confirm Password:</label>
            <input type="password" id="password1" name="password1" placeholder="confrim password" required>
            <span name="passwordError" id="passwordError"></span>
        </div>
        
        <input type="submit" name="submit" value="Submit">
    </form>
</div>

<!-- footer section starts  -->

<section class="footer">

  <div class="box-container">

      <div class="box">
          <h3>our locations</h3>
          <a href="#"> <i class="fas fa-map-marker-alt"></i> india </a>
          <a href="#"> <i class="fas fa-map-marker-alt"></i> USA </a>
      </div>

      <div class="box">
          <h3>quick links</h3>
          <a href="./index.html"> <i class="fas fa-arrow-right"></i> home </a>
          <a href="#"> <i class="fas fa-arrow-right"></i> featured </a>
          <a href="#"> <i class="fas fa-arrow-right"></i> Category </a>
          <a href="#"> <i class="fas fa-arrow-right"></i> reviews </a>
          <a href="./feedback.html"> <i class="fas fa-arrow-right"></i> feedback </a>
      </div>

      <div class="box">
          <h3>extra links</h3>
          <a href="#"> <i class="fas fa-arrow-right"></i> account info </a>
          <a href="#"> <i class="fas fa-arrow-right"></i> ordered items </a>
          <a href="#"> <i class="fas fa-arrow-right"></i> privacy policy </a>
          <a href="#"> <i class="fas fa-arrow-right"></i> payment method </a>
          <a href="#"> <i class="fas fa-arrow-right"></i> our serivces </a>
      </div>

      <div class="box">
          <h3>contact info</h3>
          <a href="#"> <i class="fas fa-phone"></i> 91670 XXXXX </a>
          <a href="#"> <i class="fas fa-phone"></i> 77388 XXXXX </a>
          <a href="#"> <i class="fas fa-envelope"></i> kordepriyanka1118@gmail.com </a>
          <a href="#"> <i class="fas fa-envelope"></i> rohitmishra.rm2106@gmail.com </a>
          <img src="image/worldmap.png" class="map" alt="">
      </div>
      
  </div>

  <div class="share">
      <a href="#" class="fab fa-facebook-f"></a>
      <a href="https://twitter.com/priyankakorde" class="fab fa-twitter"></a>
      <a href="X" class="fab fa-instagram"></a>
      <a href="https://www.linkedin.com/in/priyanka-korde-2029521a1/" class="fab fa-linkedin"></a>
      <a href="https://www.linkedin.com/in/rohit-m-3494521a2/" class="fab fa-linkedin"></a>
  </div>

  <div class="credit"> created by <span>Priyanka Korde & Rohit Mishra </span>copyright &copy;2022 all rights reserved! </div>

</section>

<!-- footer section ends -->
<script src="./js/script.js"></script>
<script src="mainstyle/js/bookstore_validation.js"></script>

</body>    
</html>    
