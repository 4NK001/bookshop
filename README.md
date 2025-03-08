Bookshop Project Documentation

Introduction

The Bookshop Project is a web-based platform designed to empower authors while providing readers with a seamless book-reading experience. It includes features for managing books, authors, and readers, along with authentication, book reviews, and reading history.

Features

Admin Features

Add and remove book categories.

Manage authors and readers (approve, remove).

Remove books from the platform.

Author Features

Register and log in.

Add books with details such as title, description, and category.

View their published books.

Reader Features

Register and log in.

Read books online.

Bookmark books for later.

Save reading history.

Review and rate books.

Technology Stack

Frontend

HTML, CSS, JavaScript, Bootstrap

Backend

PHP (Core PHP)

MySQL (Database)

Additional Tools

Composer (for managing dependencies like PHPMailer)

Git (for version control)

Installation & Setup

Prerequisites

PHP (>=7.4)

MySQL

Apache or XAMPP Server

Composer (for dependency management)

Git (for version control)

Step-by-Step Setup

Clone the repository

git clone https://github.com/your-username/bookshop.git
cd bookshop

Install dependencies

composer install

Set up the database

Create a MySQL database.

Import the database.sql file located in the project.

Update the database credentials in config.php:

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'your_password');
define('DB_NAME', 'bookshop');

Run the project

Start Apache and MySQL in XAMPP.

Access the project via http://localhost/bookshop/.

Folder Structure

bookshop/
│── assets/          # CSS, JavaScript, images
│── config/          # Configuration files
│── database/        # SQL scripts
│── includes/        # Common PHP includes
│── pages/           # Main pages (home, books, etc.)
│── vendor/          # Composer dependencies
│── index.php        # Entry point
│── .gitignore       # Ignored files
│── README.md        # Project documentation

Common Issues & Fixes

1. PHPMailer Not Sending Emails

Ensure vendor/ is installed using composer install.

Update SMTP settings in mail_config.php.

2. Database Connection Errors

Verify config.php credentials.

Ensure MySQL is running.

3. CSS or JavaScript Not Loading

Check file paths in HTML.

Clear browser cache.



License

This project is licensed under the MIT License.
