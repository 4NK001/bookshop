<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Shop</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
    /* Body and Overall Layout */
    body {
        background-color: white;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        color: #333;
    }

    .book-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
        margin: 20px auto;
        max-width: 1200px; /* Limits the container width */
    }

    /* Card Style */
    .book-card {
        display: flex;
        flex-direction: row;
        border: 1px solid #ddd;
        padding: 20px;
        max-width: 800px;
        background-color: #c5f2d2;
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    /* Image and Text Layout */
    .book-card img {
        width: 40%;
        height: auto;
        border-radius: 5px;
        margin-right: 20px;
    }

    .book-details {
        width: 60%;
    }

    /* Book Information */
    .book-details h3 {
        margin-bottom: 10px;
        font-size: 1.5rem;
        color: #333;
    }

    .book-details p {
        margin-bottom: 10px;
        font-size: 1rem;
        color: #555;
    }

    /* Button Container for Alignment */
    .btn-container {
        margin-top: 1rem;
        display: flex;
        gap: 10px; /* Space between buttons */
        flex-wrap: wrap; /* Ensure buttons wrap on smaller screens */
    }

    /* Button Styling */
    .btn {
        display: inline-block;
        padding: 0.9rem 2rem;
        border-radius: 0.5rem;
        color: #fff;
        background: #27ae60;
        font-size: 1.2rem;
        cursor: pointer;
        font-weight: 500;
        text-decoration: none;
        text-align: center;
    }

    .btn:hover {
        background: #2d8659; /* Darker green on hover */
    }

</style>
 <!-- custom css file link  -->
 <link rel="stylesheet" href="mainstyle/css/style.css">
</head>
<body>
<header class="header">

    <div class="header-1">

        <a href="./index.php" class="logo"> <i class="fas fa-book"></i>  Book Shop </a>

        <!-- <form action="" class="search-form">
            <input type="search" name="" placeholder="search here..." id="search-box">
            <label for="search-box" class="fas fa-search"></label>
        </form> -->

        <div class="icons">
            <!-- <div id="search-btn" class="fas fa-search"></div> -->
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
            <!-- <a href="#reviews">reviews</a>
            <a href="#">feedback</a> -->
        </nav>
    </div>

</header>

<!-- header section ends -->
<section class="book-container">

    <?php
    include('connection.php');
    
    // Retrieve the parameters from the URL
    $bookId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $pdfFile = isset($_GET['pdf']) ? $_GET['pdf'] : '';
// Ensure that the user is logged in and user ID is available in the session

    $sql = "SELECT tbl_book.bookid, tbl_book.title, tbl_book.authorid, tbl_book.description, tbl_book.categoryid, tbl_book.image, tbl_book.bookfile, tbl_author.name 
    FROM tbl_book 
    inner join tbl_author on tbl_book.authorid=tbl_author.authorid WHERE tbl_book.bookid=$bookId";
    $rslt = $conn->query($sql);

    // Check if any books found
    if ($rslt->num_rows > 0) {
        while ($row = $rslt->fetch_assoc()) {
            echo '<div class="book-card">';
            echo '<img src="uploads/' . $row['image'] . '" alt="' . $row['title'] . '">';
            echo '<div class="book-details">';
            echo '<h3>' . $row['title'] . '</h3>';
            echo '<p>Author: ' . $row['authorid'] . '</p>';
            echo '<p>Name: ' . $row['name'] . '</p>';
            echo '<p>' . $row['description'] . '</p>';
            
            // Container for the buttons
            echo '<div class="btn-container">';
            echo '<a href="view_pdf.php?id=' . urlencode($row["bookid"]) . '&pdf=' . urlencode($row["bookfile"]) . '" class="btn">Read</a>';
            echo '<a href="./view_review.php?id=' . urlencode($row["bookid"]) .'" class="btn">View Review</a>';
            echo '<a href="./donation.php?id=' . urlencode($row["bookid"]) .'" class="btn">Donation</a>';
            echo '</div>'; // End of button container

            echo '</div>'; // End of book-details
            echo '</div>'; // End of book-card
        }
    } else {
        echo "<p>No books found.</p>";
    }
    ?>

</section>

<script src="mainstyle/js/script.js"></script>

</body>
</html>
