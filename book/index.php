<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Shop</title>

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

        <a href="./index.php" class="logo"> <i class="fas fa-book"></i>  Book Shop </a>

        <form action="javascript:void(0);" class="search-form">
    <input type="search" placeholder="Search here..." id="search-box">
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

</nav>


<!-- home section starts  -->

<section class="home" id="home">

    <div class="row">
<?php
include('connection.php');
    
    $sql = "SELECT bookid, title, description, categoryid, image FROM tbl_book";
$rslt = $conn->query($sql);

// Check if any books found
if ($rslt->num_rows > 0) {
    while ($row = $rslt->fetch_assoc()) {
        // Output HTML for each book
        echo '<div class="book-card">';
        echo '<img src="uploads/' . $row['image'] . '" alt="' . $row['title'] . '">';
        echo '<h3>' . $row['title'] . '</h3>';
        // echo '<p>Author: ' . $row['authorid'] . '</p>';
        echo '<p>' . $row['description'] . '</p>';
       echo '<br>';
       

       
       // Ensure you are within a PHP block if this is part of a larger PHP file
       // Example of correctly generating the link
       echo '<a href="book_details.php?id='. urlencode($row["bookid"]) . '" class="btn">Read</a>';
 
        echo '</div>';
    
    }
} else {
    echo "No books found.";
}
?>
    </div>

</section>
<!-- PDF Modal -->



        
    </div>

   
</section>

<!-- footer section ends -->

<!-- loader  -->




<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
<!-- custom js file link  -->

<script src="mainstyle/js/script.js"></script>
<script>
document.getElementById('search-box').addEventListener('input', function () {
    const query = this.value.trim();
    const bookContainer = document.querySelector('.home .row'); // Update this selector based on where the books are displayed

    if (query.length > 0) {
        // Fetch books matching the query
        fetch(`searchbooks.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(books => {
                console.log('Books received:', books); // Debugging: Log the received data
                bookContainer.innerHTML = ''; // Clear existing books

                if (books.length > 0) {
                    books.forEach(book => {
                        const bookCard = document.createElement('div');
                        bookCard.classList.add('book-card');
                        bookCard.innerHTML = `
                            <img src="uploads/${book.image}" alt="${book.title}">
                            <h3>${book.title}</h3>
                            <p>${book.description}</p>
                            <a href="book_details.php?id=${book.bookid}" class="btn">Read</a>
                        `;
                        bookContainer.appendChild(bookCard);
                    });
                } else {
                    bookContainer.innerHTML = '<p>No books found.</p>'; // Show a message if no books match the query
                }
            })
            .catch(error => console.error('Error fetching books:', error));
    } else {
        // Reload all books when the search box is cleared
        fetchAllBooks();
    }
});

function fetchAllBooks() {
    // Fetch all books (similar to your existing code to load books)
    fetch(`load_books.php`)
        .then(response => response.json())
        .then(books => {
            const bookContainer = document.querySelector('.home .row');
            bookContainer.innerHTML = '';

            if (books.length > 0) {
                books.forEach(book => {
                    const bookCard = document.createElement('div');
                    bookCard.classList.add('book-card');
                    bookCard.innerHTML = `
                        <img src="uploads/${book.image}" alt="${book.title}">
                        <h3>${book.title}</h3>
                        <p>${book.description}</p>
                        <a href="book_details.php?id=${book.bookid}" class="btn">Read</a>
                    `;
                    bookContainer.appendChild(bookCard);
                });
            } else {
                bookContainer.innerHTML = '<p>No books found.</p>';
            }
        })
        .catch(error => console.error('Error fetching all books:', error));
}
</script>


</body>
</html>
