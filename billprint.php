<?php
// Include the header
include "config.php";

?>
<link rel="stylesheet" href="css/bootstrap.css"> <!-- Bootstrap -->
    <link rel="stylesheet" href="css/style.css"> <!-- Custom stlylesheet -->
 <div style="font-weight: bold;
  " class="container">
    
<?php

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_REQUEST['id'])) {
    $patient_id = mysqli_real_escape_string($conn, $_REQUEST['id']);
}

// SQL query to retrieve patient data
$patient_query = "SELECT *
FROM patient_data pd
JOIN test_data td ON pd.patient_id = td.patient_id
WHERE pd.patient_id = '$patient_id'";

$patient_result = mysqli_query($conn, $patient_query);

if ($patient_result) {
    $patient_data = mysqli_fetch_assoc($patient_result);

$dob=$patient_data['dob'];
$currentDate = date('Y-m-d');

// Extract the years, months, and days from the dates
list($dobYear, $dobMonth, $dobDay) = explode('-', $dob);
list($currentYear, $currentMonth, $currentDay) = explode('-', $currentDate);

// Calculate the age
$age = $currentYear - $dobYear;

// Check if the birthday has occurred this year
if ($dobMonth > $currentMonth || ($dobMonth == $currentMonth && $dobDay > $currentDay)) {
    $age--; // The birthday hasn't occurred yet this year
}
?>
<hr>
    <div  class="row">
            <div class="col-md-10">REG. NO : <?php echo $patient_data['patient_id'] ?></div>
            <div class="col-md-2">AGE : <?php echo $age  ?></div>
        </div>
        <div class="row">
            <div class="col-md-10">PATIENT NAME  : <?php echo $patient_data['full_name']  ?></div>
            <div class="col-md-2">GENDER   :  <?php echo $patient_data['gender']  ?></div>
        </div>
        <div class="row">
            <div class="col-md-10">REF. DOCTOR : <?php echo $patient_data['primary_care_physician']  ?></div>
            <div class="col-md-2">DATE : <?php echo $patient_data['test_date']  ?></div>
        </div>
           <div class="row">
            <div class="col-md-6">SAMPLE COLL. AT :APEX PATHOLOGY LABORATORY</div>
          
        </div>
        <hr>
        <div class="well">Basic Well</div>

        <div class="well"><center><h5><?php echo $patient_data['insurance_info']  ?></h5></center></div>
       <hr>
        <table class="table table-striped">
            <thead>
                <th>Test Type</th>
                <th>Result</th>
                <th>Unit</th>
                <th>Reference</th>
                <th>BillIng</th>
            </thead>
            <tbody>

            <?php

    // SQL query to retrieve test data for the patient
    $test_query = "SELECT *
                   FROM test_data td
                   WHERE td.patient_id = '$patient_id'
                   ORDER BY td.test_date";

    $test_result = mysqli_query($conn, $test_query);
$bill=0;
    if ($test_result) {
        while ($row = mysqli_fetch_assoc($test_result)) {
            // Output test data within the loop
            echo '<tr>
                    <td>' . $row['test_type'] . '</td>
                    <td>' . $row['result'] . '</td>
                    <td>' . $row['unit'] . '</td>
                    <td>' . $row['reference'] . '</td>
                   <td>' . $row['bill'] . '₹</td>
                </tr>';
                    $bill = $bill + $row['bill'];

        }
    }
    echo '</tbody>
          </table>


          ';
          ?>
          <hr>
          <h5 style="margin-right: 60px; text-align: right;">Total : <?php echo $bill; ?>₹</h5>
          <div class="container footer">
      
</div>
  </div>
          <?php
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);

// Include the footer
if (isset($_REQUEST['id'])) {
    ?>
    <script>
        window.print();
        setTimeout(function() {
            window.location.href = 'http://localhost/library-system/allpatients.php';
        }, 10000); // 5000 milliseconds (5 seconds)
    </script>
    <?php
}
?>





<style>
    body{
        background-color: white;
    }
    .demo-wrap {
  overflow: hidden;
  position: relative;
}

.demo-bg {
    opacity: 0.2;
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    margin: auto;
    width: 50%;
    height: auto;
}

.demo-content {
  position: relative;
}
        .footer {
            position: fixed;
            bottom: 0;
           
            width: 100%;
        }
</style>