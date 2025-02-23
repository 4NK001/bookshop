<?php
// Start the session
session_start();

// Include your database connection file
include 'connection.php'; // Make sure this file contains your DB connection setup

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    // die('User not logged in.');
    echo '<script>window.location.href="login.php";</script>';
}

$userId = $_SESSION['userid']; // Get the user ID from session
// Retrieve the parameters from the URL
$bookId = isset($_GET['id']) ? intval($_GET['id']) : 0;


// Query to get comments for the specific book
$sql = "SELECT tbl_comment.user_id, tbl_comment.comments, tbl_comment.date, tbl_reader.name
FROM tbl_comment 
INNER JOIN tbl_reader ON tbl_comment.user_id = tbl_reader.userid 
WHERE tbl_comment.book_id = '$bookId'
";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Reviews</title>
    <link rel="stylesheet" href="mainstyle/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .comment-section {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .comment {
            font-size: medium;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .comment:last-child {
            border-bottom: none;
        }
        .comment h4 {
            margin: 0;
            font-size: 1.2em;
            color: #007bff;
        }
        .comment time {
            font-size: 0.9em;
            color: #999;
        }
        .comment p {
            margin-top: 5px;
            font-size: 1em;
            line-height: 1.4;
        }
    </style>
     <!-- custom css file link  -->
     <link rel="stylesheet" href="mainstyle/css/style.css">
</head>
<body>
<header class="header">

<div class="header-1">

    <a href="#" class="logo"> <i class="fas fa-book"></i>  Book Shop </a>

    <form action="" class="search-form">
        <input type="search" name="" placeholder="search here..." id="search-box">
        <label for="search-box" class="fas fa-search"></label>
    </form>

    <div class="icons">
        <div id="search-btn" class="fas fa-search"></div>
        <!-- <a href="./cart.html" class="fas fa-shopping-cart"></a> -->
        <div id="login-btn" class="fas fa-user"></div>
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
<section>
    <div class="comment-section">
        <h2>Reviews for Book ID: <?php echo $bookId; ?></h2>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            // Display each comment
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='comment'>";
                echo "<h4>User ID: " . htmlspecialchars($row['user_id']) . "</h4>";
                echo "<h5>Name: " . htmlspecialchars($row['name']) . "</h5>";
                echo "<time>Date: " . htmlspecialchars($row['date']) . "</time>";
                echo "<p>Comment: " . nl2br(htmlspecialchars($row['comments'])) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No reviews yet for this book.</p>";
        }
        ?>
    </div>
    </section>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
