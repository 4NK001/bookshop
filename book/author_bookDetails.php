<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books4MU</title>
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

        /* Comment Section Styling */
        .comment-section {
            margin-top: 20px;
            max-width: 800px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 20px;
        }

        .comment {
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
</head>
<body>

<section class="book-container">

    <?php
    include('connection.php');

    // Retrieve the parameters from the URL
    $bookId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $sql = "SELECT tbl_book.bookid, tbl_book.title, tbl_book.authorid, tbl_book.description, tbl_book.categoryid, tbl_book.image, tbl_book.bookfile, tbl_author.name 
    FROM tbl_book 
    INNER JOIN tbl_author ON tbl_book.authorid=tbl_author.authorid 
    WHERE tbl_book.bookid=$bookId";
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
            
            // Container for the button
            echo '<div class="btn-container">';
            echo '<a href="view_pdf.php?id=' . urlencode($row["bookid"]) . '&pdf=' . urlencode($row["bookfile"]) . '" class="btn">Read</a>';
            echo '</div>'; // End of button container

            echo '</div>'; // End of book-details
            echo '</div>'; // End of book-card
        }
    } else {
        echo "<p>No books found.</p>";
    }
    ?>

</section>

<section class="comment-section">
    <h2>Reviews</h2>
    <?php
    // Fetch comments for the specific book
    $sql = "SELECT tbl_comment.user_id, tbl_comment.comments, tbl_comment.date, tbl_reader.name 
    FROM tbl_comment 
    INNER JOIN tbl_reader ON tbl_comment.user_id = tbl_reader.userid 
    WHERE tbl_comment.book_id = '$bookId'";
    $result = mysqli_query($conn, $sql);

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
</section>

<script src="mainstyle/js/script.js"></script>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
