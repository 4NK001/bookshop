<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="mainstyle/css/style.css">

    <link rel="apple-touch-icon" sizes="180x180" href="mainstyle/favicon_io/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="mainstyle/favicon_io/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="mainstyle/favicon_io/favicon-16x16.png">
<link rel="manifest" href="mainstyle/favicon_io/site.webmanifest">

<style>
    .book-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.book-card {
    border: 1px solid #ddd;
    padding: 20px;
    text-align: center;
    max-width: 200px;
}

.book-card img {
    width: 100%;
    height: auto;
}

.btn{
    margin-top: 1rem;
    display:inline-block;
    padding:.9rem 3rem;
    border-radius: .5rem;
    color:#fff;
    background:var(--green);
    font-size: 1.7rem;
    cursor: pointer;
    font-weight: 500;
}

.btn:hover{
    background:var(--dark-color);
}

.pdf-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    justify-content: center;
    align-items: center;
}

#pdf-container {
    background: #fff;
    padding: 20px;
    position: relative;
}

#pdf-canvas {
    width: 100%;
    height: auto;
}

.pdf-btn {
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
    margin: 5px;
}

#close-modal {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}


    </style>
</head>
<body>
    
<!-- header section starts  -->

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

<!-- bottom navbar  -->

<nav class="bottom-navbar">
    <a href="#home" class="fas fa-home"></a>
    <a href="#featured" class="fas fa-list"></a>
    <a href="#arrivals" class="fas fa-tags"></a>
    <a href="#reviews" class="fas fa-comments"></a>
    <a href="#feedback" class="fas fa-feedback"></a>
</nav>


<!-- home section starts  -->

<section class="home" id="home">

    <div class="row">
<?php
include('connection.php');
session_start();
  $userid=$_SESSION['userid']; 
  if (!isset($_SESSION['userid'])) {
    // die('User not logged in.');
    echo '<script>window.location.href="login.php";</script>';
} 
    $sql = "SELECT tbl_book.bookid, tbl_book.authorid, tbl_book.description, tbl_book.categoryid, tbl_book.image, tbl_book.bookfile, tbl_bookmark.page_no, tbl_bookmark.title FROM tbl_book inner join tbl_bookmark on tbl_book.bookid=tbl_bookmark.book_id and tbl_bookmark.user_id=$userid";
$rslt = $conn->query($sql);

// Check if any books found
if ($rslt->num_rows > 0) {
    while ($row = $rslt->fetch_assoc()) {
        // Output HTML for each book
        echo '<div class="book-card">';
        echo '<img src="uploads/' . $row['image'] . '" alt="' . $row['title'] . '">';
        echo '<h3>' . $row['title'] . '</h3>';
        echo '<p>Author: ' . $row['authorid'] . '</p>';
        echo '<p>' . $row['description'] . '</p>';
       echo '<br>';
       echo '<a href="viewBookmark_pdf.php?pdf=' . urlencode($row['bookfile']) .'&page=' . urlencode($row['page_no']) . '&id=' . urlencode($row['bookid']) . '" class="btn">View page</a>';
        echo '</div>';
    }
} else {
    echo "No books found.";
}
?>
    </div>

</section>
<!-- PDF Modal -->


<!-- home section ense  -->

<!-- icons section starts  -->


<!-- feedback section ends -->

<!-- footer section starts  -->

<!-- <section class="footer">

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
        </div> -->

        <!-- <div class="box">
            <h3>contact info</h3>
            <a href="#"> <i class="fas fa-phone"></i> 9167X XXXXX </a>
            <a href="#"> <i class="fas fa-phone"></i> 77388 XXXXX </a>
            <a href="#"> <i class="fas fa-envelope"></i> kordepriyanka1118@gmail.com </a>
            <a href="#"> <i class="fas fa-envelope"></i> rohitmishra.rm2106@gmail.com </a>
            <img src="mainstyle/image/worldmap.png" class="map" alt="">
        </div> -->
        
    </div>

    <!-- <div class="share">
        <a href="#" class="fab fa-facebook-f"></a>
        <a href="https://twitter.com/priyankakorde" class="fab fa-twitter"></a>
        <a href="X" class="fab fa-instagram"></a>
        <a href="https://www.linkedin.com/in/priyanka-korde-2029521a1/" class="fab fa-linkedin"></a>
        <a href="https://www.linkedin.com/in/rohit-m-3494521a2/" class="fab fa-linkedin"></a>
    </div> -->

    <!-- <div class="credit"> created by <span>Priyanka Korde & Rohit Mishra </span>copyright &copy;2022 all rights reserved! </div> -->

</section>

<!-- footer section ends -->

<!-- loader  -->




<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

<!-- custom js file link  -->

<script src="mainstyle/js/script.js"></script>

</body>
</html>