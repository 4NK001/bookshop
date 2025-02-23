<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="mainstyle/css/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="mainstyle/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="mainstyle/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="mainstyle/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="mainstyle/favicon_io/site.webmanifest">
    <style>
        .main-container {
            display: flex;
            gap: 20px;
            padding: 20px;
        }

        .category-list {
            width: 20%;
            background: #f5f5f5;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
        }

        .category-list h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .category-list ul {
            list-style: none;
            padding: 0;
        }

        .category-list ul li {
            margin-bottom: 10px;
        }

        .category-list ul li a {
            text-decoration: none;
            color: #007bff;
            cursor: pointer;
        }

        .category-list ul li a:hover {
            color: #0056b3;
        }

        .book-display {
            flex-grow: 1;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .book-display h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .book {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .book img {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
        }

        .book .info {
            color: #333;
        }

        .book .info h4 {
            margin: 0 0 5px;
        }

        .book .info p {
            margin: 0;
        }
    </style>
</head>
<body>
    
<header class="header">
    <div class="header-1">
        <a href="#" class="logo"> <i class="fas fa-book"></i> Book Shop </a>
        <form action="" class="search-form">
            <input type="search" placeholder="search here..." id="search-box">
            <label for="search-box" class="fas fa-search"></label>
        </form>
        <div class="icons">
            <div id="search-btn" class="fas fa-search"></div>
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

<nav class="bottom-navbar">
   
</nav>

<section class="main-container">
    <div class="category-list">
        <h3>Categories</h3>
        <ul id="categories">
            <!-- Categories will be dynamically loaded here -->
        </ul>
    </div>
    <div class="book-display">
        <h3>Books</h3>
        <div id="books">
            <!-- Books will be dynamically loaded here -->
        </div>
    </div>
</section>

<script>
    // Define `loadBooks` in the global scope
    function loadBooks(categoryId = 0) {
        const booksElement = document.getElementById("books");

        fetch(`load_books.php?categoryid=${categoryId}`)
            .then(response => response.json())
            .then(books => {
                booksElement.innerHTML = ""; // Clear existing books

                if (books.length === 0) {
                    booksElement.innerHTML = "<p>No books found in this category.</p>";
                } else {
                    books.forEach(book => {
                        const bookItem = document.createElement("div");
                        bookItem.classList.add("book");
                        bookItem.innerHTML = `
                            <img src="uploads/${book.image}" alt="${book.title}">
                            <div class="info">
                                <h4>${book.title}</h4>
                                <p>${book.description}</p>
                            </div>
                        `;
                        booksElement.appendChild(bookItem);
                    });
                }
            })
            .catch(error => {
                console.error("Error loading books:", error);
            });
    }

    document.addEventListener("DOMContentLoaded", function () {
        const categoriesElement = document.getElementById("categories");

        // Load categories
        fetch("load_categories.php")
            .then(response => response.json())
            .then(categories => {
                categories.forEach(category => {
                    const categoryItem = document.createElement("li");
                    categoryItem.innerHTML = `<a href="#" onclick="loadBooks(${category.categoryid}); return false;">${category.categoryname}</a>`;
                    categoriesElement.appendChild(categoryItem);
                });
            })
            .catch(error => {
                console.error("Error loading categories:", error);
            });

        // Load all books initially
        loadBooks();
    });
</script>



<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
<script src="mainstyle/js/script.js"></script>

</body>
</html>
