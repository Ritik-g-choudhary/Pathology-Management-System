<?php include "header.php" ?> <!-- header -->
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">Add Publisher</h2>
            </div>
            <div class="offset-md-7 col-md-2">
              <a class="add-new" href="publisher.php">All Publishers</a>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <form class="yourform" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off">
                    <div class="form-group">
                        <label>Test Name</label>
                        
                        <input type="text" class="form-control" placeholder="Suger Test" name="testname" value="" >
                    </div>
                    <input type="submit" name="save" class="btn btn-danger" value="save" >
                </form>
                <?php // if form submit
                if(isset($_POST['save'])){
                 $testname = $_POST['testname'];
                        $sql1 = "INSERT INTO test_name (testname) VALUES ('{$testname}')";
                       $done = mysqli_query($conn, $sql1);
                       if ($done) {
                           echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Test Saved",
                    showConfirmButton: true
                });
              </script>';
                       }
                       
                    }
                  
                 ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php" ?> <!-- footer -->
