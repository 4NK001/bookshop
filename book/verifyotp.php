<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_entered_otp = $_POST['otp'];
    $user_email = $_SESSION['emailforpwdchange'];

    require 'connection.php';

    $sql = "SELECT * FROM tbl_otp WHERE email = ? AND otp = ? AND status = 'unused' AND TIMESTAMPDIFF(MINUTE, timestamp, NOW()) <= 30";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user_email, $user_entered_otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Mark the OTP as used
        $updateSql = "UPDATE tbl_otp SET status = 'used' WHERE email = ? AND otp = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ss", $user_email, $user_entered_otp);
        $updateStmt->execute();

        // Return success response
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid or expired OTP.']);
    }
}
?>
