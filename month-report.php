<?php include "header.php" ?> <!-- header -->
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <h2 class="admin-heading text-center">Monthwise Report</h2>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-4 col-md-4">
                <form class="yourform mb-5" action="" method="post">
                    <div class="form-group">
                        <input type="date" name="start" class="form-control" value="<?php echo date('Y-m-d') ?>">
                        <input type="date" name="End" class="form-control" value="<?php echo date('Y-m-d') ?>">
                    </div>
                    <input type="submit" class="btn btn-danger" name="search_month" value="Search">
                </form>
            </div>
        </div>

          <?php //select author count
          if (isset($_REQUEST['search_month'])) {
              $start = $_REQUEST['start'];
              $end = $_REQUEST['End'];
          $start = date("Y-m-d");
          $week=0;
          for ($i=0; $i <= 30; $i++) {
            $sixDaysAgo = $end;
         
          $sql = "SELECT SUM(bill) AS distinct_patient_count FROM test_data WHERE test_date='$sixDaysAgo'";
           $result = mysqli_query($conn, $sql) or die("SQL query failed.");
          $row = mysqli_fetch_array($result);
            $week = $week + $row['distinct_patient_count'];
         }
         
          if(mysqli_num_rows($result) > 0){
           
            
              ?>
            <div class="card" style="width: 14rem; margin: 0 auto;">
              <div class="card-body text-center">
                <p class="card-text"><?php   echo $week; ?>₹</p>
                <h5 class="card-title mb-0">Total Earn</h5>
               <a href="reports.php">More</a>
              </div>
            </div>
          <?php }
          }
          ?>
      

        
    </div>
</div>
<?php include "footer.php" ?> <!-- footer -->
