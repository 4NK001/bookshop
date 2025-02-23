
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Admin-category</title>
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

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  + Add category
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="" method="POST">
  <div class="form-group">
    <label for="category">category name</label>
    <input type="text" class="form-control" id="category" name="categoryName" placeholder="Enter category name">
  </div>
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="save">save</button>
      </div>
</form>
      </div>
      
    </div>
  </div>
</div>

  <table class="table table-sm">
  <thead>
    <tr>
      <th scope="col">category id</th>
      <th scope="col">category name</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>


  <!-- php-->

  <?php 

include('connection.php');
if (isset($_POST["save"])){
  $categoryName = $_POST['categoryName'];

$sql="SELECT * FROM tbl_category WHERE categoryname='$categoryName'";

    $result=mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)>0){

        echo '<script>alert("This category already exists.");</script>';
    }
    else{
    
        $sql = "INSERT INTO tbl_category (categoryname) VALUES ('$categoryName')";
        mysqli_query($conn, $sql);
        echo '<script>alert("This category added successfully.");</script>';
    }
  }
  // fetch
    $sql = "SELECT * FROM tbl_category";
    $result = mysqli_query($conn, $sql);
  
    if ($result) {
     
while ($row = mysqli_fetch_array($result)) {
    echo "<tr><td>" . $row["categoryid"] . "</td><td>" . $row["categoryname"] . "</td>";
    echo '<td><a href="deletecategory.php?id=' . $row['categoryid'] . '">Delete</a></td></tr>';
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
