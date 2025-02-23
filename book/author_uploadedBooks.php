
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Author-Book</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="../assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    />
<!-- bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Fonts and icons -->
    <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["../assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />

    
  </head>
  <body>



  <table class="table table-sm">
  <thead>
    <tr>
      <th scope="col">Book id</th>
      <th scope="col">Title</th>
      <th scope="col">Delete</th>
      <th scope="col">View_review</th>
      <th scope="col">View_donations</th>
    </tr>
  </thead>


  <!-- php-->

  <?php 

include('connection.php');

  // fetch
  $authorid=$_SESSION['authorid'];
    $sql = "SELECT * FROM tbl_book where authorid = $authorid";
    $result = mysqli_query($conn, $sql);
  
    if ($result) {
     
while ($row = mysqli_fetch_array($result)) {
    echo "<tr><td>" . $row["bookid"] . "</td><td>" . $row["title"] . "</td>";
    echo '<td><a href="author_deleteBook.php?id=' . $row['bookid'] . '">Delete</a></td>';
    echo '<td><a href="author_bookDetails.php?id=' . $row['bookid'] . '">view review</a></td>';
    echo '<td><a href="author_bookDonation.php?id=' . $row['bookid'] . '">view donations</a></td></tr>';
}


    }
    ?>
  </tbody>
</table>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
       </script>
  </body>
</html>
