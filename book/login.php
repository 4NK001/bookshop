<?php 
include("connection.php");
session_start();

if (isset($_POST["login"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Protect against SQL injection
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Verify the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM tbl_login WHERE username='$email' AND Password='$password'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_array($result);
        if ($row) {
            if ($row["keyuser"] == "admin") {
                $_SESSION['username'] = $email;
                $_SESSION['name'] = 'admin';
                echo '<script>window.location.href="admin_home.php";</script>';
                exit();
            } elseif ($row["keyuser"] == "author") {
                $_SESSION['authoremail'] = $email;
                $sql = "SELECT * FROM tbl_author WHERE email='$email'";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $row = mysqli_fetch_array($result);
                    $_SESSION['authorid'] = $row["authorid"];
                    $_SESSION['AuthorName']=   $row['name'];
                }
                echo '<script>window.location.href="author_home.php";</script>';
                exit();
            } 
        elseif ($row["keyuser"] == "reader") {
            $_SESSION['readeremail'] = $email;
            $sql = "SELECT * FROM tbl_reader WHERE email='$email'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $row = mysqli_fetch_array($result);
                $_SESSION['userid'] = $row["userid"];
            }
            echo '<script>window.location.href="index.php";</script>';
            exit();
        }
            else {
                $_SESSION['loginMessage'] = "Invalid username or password";
                echo '<script>alert("Invalid username or password"); window.location.href="login.php";</script>';
                exit();
            }
        } else {
            $_SESSION['loginMessage'] = "Invalid username or password";
            echo '<script>alert("Invalid username or password"); window.location.href="login.php";</script>';
            exit();
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }}

?>

   
<!DOCTYPE html>    
<html>    
<head>    
<meta name="viewport" content="width=device-width, initial-scale=1">  
<link rel="stylesheet" href="mainstyle/css/style.css">  
 <!-- font awesome cdn link  -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
 <title> Sign-in </title>
<style>
   /*  body {
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
    .container form p a{
    color:var(--green);
    text-decoration: underline;
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

    button {
            background-color: #27ae60;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #219150; /* Slightly darker green on hover */
        }
/* forgot */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
            /* Dark overlay */
            animation: fadeIn 0.3s;
            /* Fade in effect */
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 400px;
            /* Responsive max width */
            transition: transform 0.3s ease;
            /* Animation effect */
            transform: translateY(-50px);
            /* Start slightly above */
        }

        .modal-content.show {
            transform: translateY(0);
            /* Slide down into view */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        h1 {
            margin: 0 0 10px;
            font-size: 24px;
        }

        p {
            margin: 0 0 15px;
            font-size: 16px;
        }

        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #27ae60;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #219150;
            /* Darker on hover */
        }
</style>
</head>
<body>
<header class="header">

<div class="header-1">

    <a href="./index.php" class="logo"> <i class="fas fa-book"></i>  Book Shop </a>

   


</div>

<div class="header-2">
    <nav class="navbar">
    <a href="./index.php">home</a>
            <a href="./view_history.php">History</a>
            <a href="./view_bookmark.php">Bookmark</a>
            <a href="./filterby_category.php">category</a>
            <!-- <a href="#reviews">reviews</a>
            <a href="#">feedback</a> -->
    </nav>
</div>

</header>

<!-- header section ends -->

<!-- bottom navbar  -->

<nav class="bottom-navbar">
<a href="#home" class="fas fa-home"></a>
<a href="#featured" class="fas fa-list"></a>
<a href="#arrivals" class="fas fa-tags"></a>
<a href="#reviews" class="fas fa-comments"></a>
<a href="#feedback" class="fas fa-feedback"></a>
</nav>

<div class="container" style="Margin-top:60px;">
    <h2>Sign In...</h2>
    <form action="<?php $_SERVER["PHP_SELF"]?>" method="POST" class="contact-form">
       
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Your Email" required>
            <span name="emailError" id="emailError"></span>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="password" required>
        </div>
       
        <input type="submit" name="login" value="Submit">
       
    </form>
    <p>Don't have an account? <a href="#" id="create-account">Create one</a></p>
    <p><a href="#" class="forgot-password-link" id="forgotPasswordLink">Forgot Password?</a></p>


    <!-- Registration form toggle -->
    <div id="entity-selection" style="display: none;">
        <!-- <p>Select entity type:</p> -->
        <a href="./author_reg.php"><button type="button">Author</button></a>
        <a href="./reader_reg.php"><button type="button">Reader</button></a>
    </div>

</div>

<!-- forgot model -->

<div id="forgotPasswordModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h1>Find your password</h1>
            <p>Step 1: Enter your email address:</p>
            <form id="emailForm">
                <input type="email" name="forgotemail" placeholder="Enter your email" required>
                <input type="hidden" name="usertype" value="user"> <!-- Adjust this value based on your needs -->
                <input type="button" value="Next" id="sendOtpButton">
            </form>
        </div>
    </div>

    <div id="otpModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeOtpModal">&times;</span>
             <h1>Find your password</h1>
            <p>Step 2: Ente OTP</p>
            <form id="otpForm">
                <input type="text" name="otp" placeholder="Enter the OTP" required>
                <input type="submit" value="Verify OTP">
            </form>
        </div>
    </div>

    <div id="changePasswordModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeChangePasswordModal">&times;</span>
             <h1>Find your password</h1>
            <p>Step 3: New Credentials</p>
            <form id="changePasswordForm" method="POST" action="set_password.php">
                <label for="newpwd">New Password:</label>
                <input type="password" name="newpwd" required>
                <label for="confirmpwd">Confirm Password:</label>
                <input type="password" name="confirmpwd" required>
                <input type="submit" name="save" value="Change Password">
            </form>
        </div>
    </div>

<script src="./js/script.js"></script>
<script src="mainstyle/js/bookstore_validation.js"></script>
<!-- regitration -->
       <script>
        const createAccountLink = document.getElementById('create-account');
        const entitySelection = document.getElementById('entity-selection');

        createAccountLink.addEventListener('click', function(event) {
            event.preventDefault(); // Prevents the default anchor behavior
            entitySelection.style.display = 'block'; // Shows the entity selection buttons
        });
    </script>
     <script>
// forgotjs
document.getElementById('forgotPasswordLink').onclick = function() {
            document.getElementById('forgotPasswordModal').style.display = 'block';
        }

        document.getElementById('closeModal').onclick = function() {
            document.getElementById('forgotPasswordModal').style.display = 'none';
        }

        document.getElementById('closeOtpModal').onclick = function() {
            document.getElementById('otpModal').style.display = 'none';
        }

        // Handle sending the OTP
        document.getElementById('sendOtpButton').onclick = function() {
    const email = document.querySelector('input[name="forgotemail"]').value;
    const usertype = document.querySelector('input[name="usertype"]').value;

    // AJAX request to send the OTP
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'send_otp.php', true); // Adjust this to your PHP script
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = xhr.responseText;
            if (response.includes('Message has been sent.')) {
                // Close email modal and open OTP modal
                document.getElementById('forgotPasswordModal').style.display = 'none';
                document.getElementById('otpModal').style.display = 'block';
            } else {
                alert(response); // Display error message
            }
        }
    };
    xhr.send('forgotemail=' + encodeURIComponent(email) + '&usertype=' + encodeURIComponent(usertype));
};


        document.getElementById('otpForm').onsubmit = function(event) {
            event.preventDefault();
            const otp = document.querySelector('input[name="otp"]').value;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'verifyotp.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    // Close OTP modal and open Change Password modal
                    document.getElementById('otpModal').style.display = 'none';
                    document.getElementById('changePasswordModal').style.display = 'block';
                } else {
                    alert(response.message); // Show error message
                }
            };
            xhr.send('otp=' + encodeURIComponent(otp));
        }
</script>
</body>    
</html>    

