<?php include "header.php" ?> <!--- header -->

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">All Books</h2>
            </div>
            <div class="offset-md-7 col-md-2">
                <a class="add-new" href="add-book.php">Back</a>
            </div>
        </div>
        <div class="row">
        <div class="offset-md-3 col-md-6">
     <?php
                $sql1 = "SELECT * FROM pdfsetting";
                $result1 = mysqli_query($conn, $sql1);
                $row1 = mysqli_fetch_assoc($result1);

     ?>
      <form class="yourform" action="" method="post" autocomplete="off">
        <div class="form-group">
            <label>Top</label>
            <input type="number" class="form-control" name="top" value="<?php echo $row1['top'] ?>" required>
        </div>
        <div class="form-group">
          <label>Left</label>
          <input type="number" class="form-control" name="left" value="<?php echo $row1['left'] ?>" required>
           
          </select>
        </div>
        <div class="form-group">
            <label>Right</label>
            <input type="number" class="form-control" name="right" value="<?php echo $row1['right'] ?>" required>
        </div>
        <div class="form-group">
            <label>Bottom</label>
            <input type="number" class="form-control" name="bottom" value="<?php echo $row1['bottom'] ?>" required>
        </div>
        <input type="submit" name="save" class="btn btn-danger" value="save" required>
      </form>
    </div>
        </div>
    </div>
</div>
<?php include "footer.php" ?> <!--- footer -->
<?php
if(isset($_POST['save'])){
  //validate inputs
  $top = mysqli_real_escape_string($conn, $_POST['top']);
  $left = mysqli_real_escape_string($conn, $_POST['left']);
  $right = mysqli_real_escape_string($conn, $_POST['right']);
  $bottom = mysqli_real_escape_string($conn, $_POST['bottom']);

//update query
  $sql = "UPDATE pdfsetting SET `top` = '$top', `left` = '$left', `right` = '$right', `bottom` = '$bottom'";

  if(mysqli_query($conn, $sql)){
  echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Updated Successfully",
                    showConfirmButton: true,
                   
                });
              </script>';
  }else{
   echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Update Failed",
                    text: "An error occurred while updating the settings.",
                    showConfirmButton: true
                });
              </script>';
  }
} ?>

