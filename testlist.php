<?php include "header.php" ?> <!--- header -->
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">All TEST LIST</h2>
            </div>
            <div class="offset-md-7 col-md-2">
                <a class="add-new" href="new_test.php">Add Test</a>

            </div>
        </div>

        <div class="row">
          <?php
          $data = mysqli_query($conn,"SELECT * FROM `test_name`");
          
             while ($row = mysqli_fetch_array($data)) {
                 ?>
<div style="margin-top:10px;" class="col-md-3"><a class="add-new" href="add-test.php?testname=<?php echo $row['testname']; ?>"><?php echo $row['testname']; ?></a></div>
                 <?php
             }
          ?>
        </div>



<?php include "footer.php" ?> <!--- footer -->
