<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>

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
            <a href="./view_category.php">category</a>
            <a href="#">reviews</a>
            <a href="#">feedback</a>
        </nav>
    </div>

</header>