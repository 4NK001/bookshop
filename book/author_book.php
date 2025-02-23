<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Author-book</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">    
</head>
  <body>
    <h3>Add Book</h3>
  <form action="" method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" id="title" name="title" placeholder="title">
  </div>
  
  <div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" id="description" rows="3" name="description"></textarea>
  </div>
  <div class="form-group">
                  <label for="category">Category</label>
                  <select class="form-select" id="category" name="category">
                     <option value="" selected disabled>Select category</option> <!-- This will be the default option -->
                     <?php
                     include('connection.php');
                     
                        // category
                           $sql = "SELECT * FROM tbl_category";
                           $result=mysqli_query($conn,$sql);

                           if($result){
                              while($row=mysqli_fetch_array($result)) {
                                 echo '<option value="'.$row['categoryid'].'">'. $row['categoryname'] . '</option>';
                              }
                           } else {
                              // If query fails, display an error message
                              echo '<option>Error fetching categories: ' . mysqli_error($connection) . '</option>';
                           }
                     ?>

                  </select>
               </div>
               <div class="form-group">
            <label for="image">choose cover:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
        </div>
        <div class="form-group">
    <label for="book">Upload the Book (PDF only)</label>
    <input type="file" id="book" name="book" accept="application/pdf" required>
</div>

               <button type="submit" class="btn btn-primary" name="submit">Submit</button>
</form>
<?php
                     include('connection.php');
                    
                     if (isset($_POST["submit"])){
                        $title = $_POST['title'];
                        $description = $_POST['description'];
                        $categoryid = $_POST['category'];
                        $image = $_FILES['image']['name'];
                        $authorid=$_SESSION['authorid'];
                        $bookfile=$_FILES['book']['name'];
                            // cover
                            move_uploaded_file($_FILES['image']['tmp_name'],'uploads/'.$image);
                            move_uploaded_file($_FILES['book']['tmp_name'],'uploads/'.$bookfile);
                              $sql = "INSERT INTO tbl_book (title,description,categoryid,image,authorid,bookfile) VALUES 
                              ('$title','$description','$categoryid','$image','$authorid','$bookfile')";
                            mysqli_query($conn, $sql);
                              echo '<script>alert("This Book added successfully.");</script>';
                          }
                          ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>