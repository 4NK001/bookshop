


<?php
session_start();
include_once('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = $_SESSION['emailforpwdchange'];
    $usertype = $_SESSION['usertypeforpwdchange'];
    $newpwd = $_POST['newpwd'];
    $confirmpwd = $_POST['confirmpwd'];

    if ($newpwd === $confirmpwd) {
   
        // Update password in the login table
        $sql = "UPDATE tbl_login SET Password = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $newpwd, $user_email);
        $stmt->execute();


        // Redirect to login page
        header("Location: login.php");
        exit();
    } else {
        echo "<script>alert('Passwords do not match');</script>";
    }
}
?>