<?php
// Start the session
session_start();

// Include your database connection file
include 'connection.php'; // Ensure this file contains your DB connection setup

// Retrieve the parameters from the URL
$bookId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$pdfFile = isset($_GET['pdf']) ? $_GET['pdf'] : '';

// Ensure that the user is logged in and user ID is available in the session
if (!isset($_SESSION['userid'])) {
    echo '<script>window.location.href="login.php";</script>';
    exit;
}

$userId = $_SESSION['userid']; // Assuming user ID is stored in the session

// Initialize page number
$pageNum = 1; // Default to page 1

// Check if the record already exists in the history table
if ($bookId && $userId) {
    // Prepare a SQL query to check for existing record
    $checkSql = "SELECT COUNT(*) AS count FROM tbl_history WHERE userid = '$userId' AND bookid = '$bookId'";
    $result = $conn->query($checkSql);

    if ($result) {
        $row = $result->fetch_assoc();
        
        if ($row['count'] > 0) {
            // Record already exists
            echo "Record already exists.";
            

        } else {
            // Insert the new record
            $insertSql = "INSERT INTO tbl_history (userid, bookid, page_no) VALUES ('$userId', '$bookId', 1)";
            
            if ($conn->query($insertSql) === TRUE) {
                echo "History record saved.";
            } else {
                echo "Error: " . $insertSql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Error checking record existence: " . $conn->error;
    }
} else {
    echo "Invalid parameters.";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View PDF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="mainstyle/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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
            max-width: 90%;
            max-height: 90%;
            overflow: auto;
        }
        #pdf-canvas {
            width: 100%;
            height: auto;
        }
        .controls {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .pdf-btn {
            padding: 10px;
            background-color: #27ae60;
            color: #fff;
            border: none;
            cursor: pointer;
            margin: 0 5px;
            border-radius: 5px;
        }
        #close-modal {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #dc3545;
            color: #fff;
            border-radius: 50%;
        }
        #review-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

    </style>
</head>
<body>
    <div id="pdf-modal" class="pdf-modal">
        <div id="pdf-container">
            <canvas id="pdf-canvas"></canvas>
            <div class="controls">
                <img id="prev-page" src="https://img.icons8.com/ios-filled/50/40C057/circled-chevron-left.png" alt="Previous page" title="Previous page"/>
                <img id="next-page" src="https://img.icons8.com/ios-filled/50/40C057/circled-chevron-right.png" alt="Next page" title="Next page"/>
                <img src="https://img.icons8.com/external-tanah-basah-glyph-tanah-basah/48/40C057/external-bookmark-library-tanah-basah-glyph-tanah-basah.png"
                alt="Bookmark"
                title="Bookmark this page"
                width="48"
                height="48"/>
                <button id="review-btn" class="pdf-btn">Review</button>
                <span id="page-info"></span>
                <span id="close-modal" class="pdf-btn">Close</span>
            </div>
        </div>
    </div>

<!-- Review Modal -->
<div id="review-modal" style="display: none;">
    <div style="
        background: #fff;
        padding: 20px;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        width: 400px;
        max-width: 90%;
    ">
        <h3>Submit Your Review</h3>
        <textarea id="review-comments" rows="5" style="width: 100%;"></textarea>
        <br><br>
        <button id="submit-review" class="pdf-btn">Submit</button>
        <button id="close-review-modal" class="pdf-btn" style="background-color: #dc3545;">Close</button>
    </div>
</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const pdfUrl = urlParams.get('pdf');
            const bookId = urlParams.get('id');
            const pdfModal = document.getElementById('pdf-modal');
            const pdfCanvas = document.getElementById('pdf-canvas');
            const ctx = pdfCanvas.getContext('2d');
            let pdfDoc = null;
            let pageNum = 1;
            const scale = 1.5;

            function openPdfModal() {
                pdfModal.style.display = 'flex';
                loadPdf(pdfUrl);
            }

            function closePdfModal() {
                pdfModal.style.display = 'none';
            }

            function loadPdf(pdfUrl) {
                const url = '/uploads/' + encodeURIComponent(pdfUrl);
                pdfjsLib.getDocument(url).promise.then(pdf => {
                    pdfDoc = pdf;
                    renderPage(pageNum);
                }).catch(error => {
                    console.error('Error loading PDF:', error);
                });
            }

            function renderPage(num) {
                if (!pdfDoc) {
                    console.error('PDF document is not loaded.');
                    return;
                }

                pdfDoc.getPage(num).then(page => {
                    const viewport = page.getViewport({ scale });
                    pdfCanvas.height = viewport.height;
                    pdfCanvas.width = viewport.width;

                    const renderContext = {
                        canvasContext: ctx,
                        viewport: viewport
                    };
                    const renderTask = page.render(renderContext);

                    renderTask.promise.then(() => {
                        document.getElementById('prev-page').style.display = (num > 1) ? 'inline' : 'none';
                        document.getElementById('next-page').disabled = num >= pdfDoc.numPages;
                        document.getElementById('page-info').textContent = `Page ${num} of ${pdfDoc.numPages}`;
                    }).catch(error => {
                        console.error('Error rendering page:', error);
                    });
                }).catch(error => {
                    console.error('Error getting page:', error);
                });
            }

            document.getElementById('prev-page').addEventListener('click', () => {
                if (pageNum > 1) {
                    pageNum--;
                    renderPage(pageNum);
                }
            });
            function updatePageNumberInHistory(pageNumber) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'update_page.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send(`page_no=${pageNumber}&book_id=${encodeURIComponent(bookId)}`);
            }

            document.getElementById('next-page').addEventListener('click', () => {
                if (pdfDoc && pageNum < pdfDoc.numPages) {
                    pageNum++;
                    renderPage(pageNum);
                    updatePageNumberInHistory(pageNum);
                }
            });

            document.getElementById('close-modal').addEventListener('click', closePdfModal);



            // Bookmark functionality
            document.querySelector('#pdf-container img[alt="Bookmark"]').addEventListener('click', () => {
                const bookmarkTitle = prompt("Enter a title for this bookmark:");
                if (bookmarkTitle) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'bookmark.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.send(`book_id=${encodeURIComponent(bookId)}&page_no=${pageNum}&title=${encodeURIComponent(bookmarkTitle)}`);

                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            alert(xhr.responseText);
                        } else {
                            alert('An error occurred while saving the bookmark.');
                        }
                    };
                }
            });

            openPdfModal(); // Open PDF when the page is loaded
        });

        //review
document.addEventListener('DOMContentLoaded', () => {
    const reviewModal = document.getElementById('review-modal');
    const reviewBtn = document.getElementById('review-btn');
    const closeReviewModal = document.getElementById('close-review-modal');
    const submitReview = document.getElementById('submit-review');
    const reviewComments = document.getElementById('review-comments');
    
    const bookId = '<?php echo $bookId; ?>'; // Book ID from PHP
    const userId = '<?php echo $userId; ?>'; // User ID from PHP

    // Show the review modal
    reviewBtn.addEventListener('click', () => {
        reviewModal.style.display = 'block';
    });

    // Hide the review modal
    closeReviewModal.addEventListener('click', () => {
        reviewModal.style.display = 'none';
        reviewComments.value = ''; // Clear the textarea
    });

    // Submit the review
    submitReview.addEventListener('click', () => {
        const comments = reviewComments.value.trim();

        if (!comments) {
            alert('Please enter a review.');
            return;
        }

        // Send the review to the server via AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'submit_review.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');

        // Prepare JSON data
        const reviewData = JSON.stringify({
            comments: comments,
            book_id: bookId,
            user_id: userId
        });

        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                alert(response.message); // Show success or error message
                reviewModal.style.display = 'none';
                reviewComments.value = ''; // Clear textarea after submission
            } else {
                alert('An error occurred. Please try again.');
            }
        };

        xhr.send(reviewData);
    });
});


    </script>
</body>
</html>
