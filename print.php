<?php
// Include the header
include "config.php";// Adjust the path to the autoload file

?>

<link rel="stylesheet" href="css/bootstrap.css"> <!-- Bootstrap -->
    <link rel="stylesheet" href="css/style.css"> <!-- Custom stlylesheet -->
    <style>
@media print {
  @page {
         <?php
                $sql1 = "SELECT * FROM pdfsetting";
                $result1 = mysqli_query($conn, $sql1);
                $row1 = mysqli_fetch_assoc($result1);

               ?>
    margin-left: <?php echo $row1['left'] ?>; /* Left margin */
    margin-right: <?php echo $row1['right'] ?>; /* Right margin */
    margin-bottom: <?php echo $row1['bottom'] ?>; /* Bottom margin */
    margin-top: <?php echo $row1['top'] ?>; /* Top margin */
  }
}
</style>

 <div 
   class="container">
    <!-- <img
    class="demo-bg"
    src="http://localhost/library-system/images/logo.jpg"
    alt=""
  > -->
<?php

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_REQUEST['id'])) {
    $patient_id = mysqli_real_escape_string($conn, $_REQUEST['id']);
}

$patient_query = "SELECT
  *
FROM patient_data
JOIN test_data
  ON patient_data.patient_id = test_data.patient_id
JOIN test_name
  ON test_name.id = test_data.heading
WHERE patient_data.patient_id = '$patient_id'
  ";

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
   <div class="col-md-5"><image width="100" src="http://localhost/library-system/images/barcode.gif"></div>
   <div class="col-md-6"><h4> TEST REPORT</h4></div>
</div>
    
<hr>
    <div  class="row">
        <div class="col-md-8">PATIENT NAME  <b>: <?php echo $patient_data['full_name']  ?></b></div>
       
            <div class="col-md-4">REG. NO <b>: <?php echo $patient_data['patient_id'] ?></b></div>
            
        </div>
        <div class="row">
             <div class="col-md-8">AGE <b>: <?php echo $age  ?></b></div>
            <div class="col-md-4">Reg. DATE <b>: <?php echo $patient_data['test_date']  ?></b></div>
            
        </div>
        <div class="row">
            <div class="col-md-8">REF. DOCTOR <b>: <?php echo $patient_data['primary_care_physician']  ?></b></div>
            <div class="col-md-4">Collected on <b>: <?php echo $patient_data['test_date']  ?></b></div>
        </div>
           <div class="row">

            <div class="col-md-8">SAMPLE COLL. AT :<b>APEX PATHOLOGY LABORATORY</b></div>
            <div class="col-md-4">Reported on <b>: <?php echo $patient_data['test_date']  ?></b></div>
          
        </div>
        <hr>

        <div class="well"><center><h5><?php echo $patient_data['insurance_info']  ?></h5></center></div>
       <hr>
   

            <?php

    // SQL query to retrieve test data for the patient
    $test_query = "SELECT
  test_type,
  result,
  unit,
  reference,
  test_name.testname AS testname
FROM patient_data
JOIN test_data
  ON patient_data.patient_id = test_data.patient_id
JOIN test_name
  ON test_name.id = test_data.heading
WHERE patient_data.patient_id = '$patient_id'";

    $test_result = mysqli_query($conn, $test_query);

if ($test_result) {
    $testData = array();
    while ($row = mysqli_fetch_assoc($test_result)) {
        $testData[$row['testname']][] = $row;
    }
        echo '
                    <div class="row">
                        <div class="col-md-3">Test Type</div>
                        <div class="col-md-3">Result</div>
                        <div class="col-md-3">Unit</div>
                        <div class="col-md-3">Reference</div>
                    </div>
                ';
    // Loop through the grouped data and create tables for each unique testname
    foreach ($testData as $testname => $testResults) {
        echo "<h6 style='font-weight:bold; margin:3px;font-family:serif;text-transform: uppercase;'>{$testname}</h6>";


        foreach ($testResults as $row) {
            echo '<div class="row">
                    <div class="col-md-3">' . $row['test_type'] . '</div>
                    <div class="col-md-3">' . $row['result'] . '</div>
                    <div class="col-md-3">' . $row['unit'] . '</div>
                    <div class="col-md-3">' . $row['reference'] . '</div>
                  </div>';
        }

        
    }
}
?>
          <hr>
          <div hidden class="container footer">
        <div class="row">
                 <?php
                $sql1 = "SELECT * FROM settings";
                $result1 = mysqli_query($conn, $sql1);
                $row1 = mysqli_fetch_assoc($result1);

     ?>
            <div class="col-md-9"><img width="150" src="images/<?php echo $row1['leftside'];?>"></div>
           <div class="col-md-2"><img width="150" src="images/<?php echo $row1['rightside'];?>"></div>
        </div>
  <div class="row">
            <div class="col-md-9"><?php echo $patient_data['primary_care_physician']  ?></div>
            <div class="col-md-2">UTTAM CHOUHAN</div> 
        </div>
        <div class="row">
             <div class="col-md-9">M.B.B.S.,D.C.P.<br>Reg:NKH-3094</div>
            <div class="col-md-2">BMLT<br>Reg:DM1102767</div>
        </div>
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
        background-color: #FFFFFF;
        font-family: monospace;
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
            
            bottom: 0;
           
            width: 100%;
        }

        .divcontainer {
   display: flex;
   align-items: center; /* Vertically center content */
}

.div1 {
   flex: 1; /* Takes up remaining space */
}

.div2 {
   text-align: center;
}


</style>


