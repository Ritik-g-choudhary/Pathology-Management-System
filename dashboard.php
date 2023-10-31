<?php include "header.php" ?> <!-- header -->
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">Dashboard</h2>
            </div>
        </div>
        <div class="row">
          <div class="col-md-3 mb-4">
          <?php //select author count
          $todaydate = date("Y-m-d");
          $sql = "SELECT COUNT(*) AS patient_id FROM test_data Where test_date='$todaydate'";
          $result = mysqli_query($conn, $sql) or die("SQL query failed.");
          if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){ 
              ?>
            <div class="card" style="width: 14rem; margin: 0 auto;">
              <div class="card-body text-center">
                <p class="card-text"><?php echo $row['patient_id']; ?></p>
                <h5 class="card-title mb-0">Total Test Today</h5>
              </div>
            </div>
          <?php }
          } ?>
          </div>

          <!-- Second Div -->

           <div class="col-md-3 mb-4">
          <?php //select author count
          $todaydate = date("Y-m-d");
        $sql = "SELECT COUNT(DISTINCT patient_id) AS distinct_patient_count FROM test_data WHERE test_date='$todaydate'";
          $result = mysqli_query($conn, $sql) or die("SQL query failed.");
          if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){ 

              ?>
            <div class="card" style="width: 14rem; margin: 0 auto;">
              <div class="card-body text-center">
                <p class="card-text"><?php echo $row['distinct_patient_count']; ?></p>
                <h5 class="card-title mb-0">Total Patients Today</h5>
              </div>
            </div>
          <?php }
          } ?>
          </div>


          <!--  -->

           <div class="col-md-3 mb-4">
          <?php //select author count
          $today = date("Y-m-d");
          $week=0;
          for ($i=0; $i <= 6; $i++) {
            $sixDaysAgo = date("Y-m-d", strtotime($today . " -$i days"));
         
          $sql = "SELECT COUNT(DISTINCT patient_id) AS distinct_patient_count FROM test_data WHERE test_date='$sixDaysAgo'";
           $result = mysqli_query($conn, $sql) or die("SQL query failed.");
          $row = mysqli_fetch_array($result);
            $week = $week + $row['distinct_patient_count'];
         }
         
          if(mysqli_num_rows($result) > 0){
           
            
              ?>
            <div class="card" style="width: 14rem; margin: 0 auto;">
              <div class="card-body text-center">
                <p class="card-text"><?php   echo $week; ?></p>
                <h5 class="card-title mb-0">Total Patients In Week</h5>
              </div>
            </div>
          <?php }
          ?>
          </div>


           <div class="col-md-3 mb-4">
          <?php //select author count
          $today = date("Y-m-d");
          $week=0;
          for ($i=0; $i <= 30; $i++) {
            $sixDaysAgo = date("Y-m-d", strtotime($today . " -$i days"));
         
          $sql = "SELECT COUNT(DISTINCT patient_id) AS distinct_patient_count FROM test_data WHERE test_date='$sixDaysAgo'";
           $result = mysqli_query($conn, $sql) or die("SQL query failed.");
          $row = mysqli_fetch_array($result);
            $week = $week + $row['distinct_patient_count'];
         }
         
          if(mysqli_num_rows($result) > 0){
           
            
              ?>
            <div class="card" style="width: 14rem; margin: 0 auto;">
              <div class="card-body text-center">
                <p class="card-text"><?php   echo $week; ?></p>
                <h5 class="card-title mb-0">Total Patients In Month</h5>
              </div>
            </div>
          <?php }
          ?>
          </div>

           <div class="col-md-3 mb-4">
          <?php //select author count
          $todaydate = date("Y-m-d");
       $sql = "SELECT SUM(bill) AS distinct_patient_count FROM test_data WHERE test_date='$todaydate'";
          $result = mysqli_query($conn, $sql) or die("SQL query failed.");
          if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){ 

              ?>
            <div class="card" style="width: 14rem; margin: 0 auto;">
              <div class="card-body text-center">
                <p class="card-text"><?php echo $row['distinct_patient_count']; ?>₹</p>
                <h5 class="card-title mb-0">Today Earning</h5>
              </div>
            </div>
          <?php }
          } ?>
          </div>


                     <div class="col-md-3 mb-4">
          <?php //select author count
          $today = date("Y-m-d");
          $week=0;
          for ($i=0; $i <= 6; $i++) {
            $sixDaysAgo = date("Y-m-d", strtotime($today . " -$i days"));
         
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
                <h5 class="card-title mb-0">Total Week Earning</h5>
              </div>
            </div>
          <?php }
          ?>
          </div>

           <div class="col-md-3 mb-4">
          <?php //select author count
          $today = date("Y-m-d");
          $week=0;
          for ($i=0; $i <= 30; $i++) {
            $sixDaysAgo = date("Y-m-d", strtotime($today . " -$i days"));
         
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
                <h5 class="card-title mb-0">Total Earn In Month</h5>
               <a href="reports.php">More</a>
              </div>
            </div>
          <?php }
          ?>
          </div>

           
        </div>
    </div>
</div>
<?php include "footer.php" ?> <!-- footer -->
