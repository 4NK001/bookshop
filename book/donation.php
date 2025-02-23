<?php
// Initialize subtotal with a default value or get it from the form
$subtotal = isset($_POST['donation_amount']) ? floatval($_POST['donation_amount']) : 0;
$grandtotal = "₹" . number_format($subtotal + 50, 2);
$qrCodeURL = "http://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($grandtotal);

include("connection.php");
session_start();
$userId = $_SESSION['userid']; // Get the user ID from session
// Retrieve the parameters from the URL
$bookId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Correct query to fetch authorId based on bookId
$sql = "SELECT authorid FROM tbl_book WHERE bookid = $bookId";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if ($row) {
    $authorId = $row["authorid"];
}

if (isset($_POST["submit"])) {
    // Simple SQL query without prepared statements
    $sqlc = "INSERT INTO tbl_donation (userId, bookId, authorId, amount, date) 
             VALUES ($userId, $bookId, $authorId, $subtotal, NOW())";
    
    if (mysqli_query($conn, $sqlc)) {
        echo "<script>alert('Donation successful!');</script>";
    } else {
        $error = mysqli_error($conn);
        echo "<script>alert('Error: $error');</script>";
    }
}

mysqli_close($conn); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Payment Interface</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .payment-container {
            max-width: 500px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .donation-details {
            margin-bottom: 20px;
        }
        .donation-details label {
            display: block; /* Ensures labels are block elements */
            margin-top: 10px; /* Adds spacing above each label */
        }
        .donation-details input {
            width: 97%;
            padding: 10px;
            margin-top: 5px; /* Reduced margin for input spacing */
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .qr-code {
            text-align: center;
            margin-bottom: 20px;
        }
        .payment-details {
            text-align: center;
        }
        .pay-now-btn {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .pay-now-btn:hover {
            background-color: #218838;
        }
    </style>
     <!-- custom css file link  -->
     <link rel="stylesheet" href="mainstyle/css/style.css">
</head>
<body>
<header class="header">

    <div class="header-1">

        <a href="#" class="logo"> <i class="fas fa-book"></i>  Book Shop </a>

        

        <div class="icons">
            
            <!-- <a href="./cart.html" class="fas fa-shopping-cart"></a> -->
            <div id="login-btn" class="fas fa-user"></div>
            <a href="logout.php" class="fas fa-sign-out-alt" title="Logout"></a>
        </div>

    </div>

    <div class="header-2">
        <nav class="navbar">
        <a href="./index.php">home</a>
            <a href="./view_history.php">History</a>
            <a href="./view_bookmark.php">Bookmark</a>
            <a href="./filterby_category.php">category</a>
        </nav>
    </div>

</header>

<!-- header section ends -->
<div class="payment-container">
    <h2>Make a Donation</h2>
    
    <form method="POST" action="">
        <div class="donation-details">
            <label for="donation_amount">Enter your donation amount:</label>
            <input type="number" id="donation_amount" name="donation_amount" placeholder="Enter amount" min="1" required>
            <label for="upi_id">Enter your UPI ID:</label>
            <input type="text" id="upi_id" name="upi_id" placeholder="example@upi" required>
        </div>

        <div class="qr-code">
            <p>Scan the QR code to make the payment:</p>
            <img src="<?php echo $qrCodeURL; ?>" alt="UPI QR Code">
            <p><strong>Total Amount (including fees): <?php echo $grandtotal; ?></strong></p>
        </div>
        
        <div class="payment-details">
            <button type="submit" name="submit" class="pay-now-btn">Donate Now</button>
        </div>
    </form>
</div>

</body>
</html>
