<?php include "header.php"; ?> <!--- header -->
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h2 class="admin-heading">Edit Report Data</h2>
            </div>
            <div class=" col-md-2">
                <a class="add-new" href="allpatients.php">All Patients</a>
            </div>
        </div>

        <?php
if (isset($_REQUEST['id'])) {
 $patient_id = mysqli_real_escape_string($conn, $_REQUEST['id']);
}

$data = mysqli_query($conn, "SELECT
  test_type,
  result,
  unit,
  test_data.bill,
  reference,
  test_name.testname AS testname,
  patient_data.full_name AS patient_id
FROM patient_data
JOIN test_data
  ON patient_data.patient_id = test_data.patient_id
JOIN test_name
  ON test_name.id = test_data.heading
WHERE patient_data.patient_id = '$patient_id'");
$row = mysqli_fetch_array($data);
?>
        <div class="row">
            <div class=" col-md-12">
                <form action="" method="post">
               
                    <div class="form-row">
                             <div class="form-group col-md-3 col-sm-6">
                        <label for="fullName">Full Name</label>
                        <input type="text" value="<?php echo $row['patient_id'] ?>" class="form-control" id="fullName" name="fullName" >
                    </div>
                </div>
                    
    <div class="form-row" id="row_">
        <div class="form-group col-xs-2">
            <label for="testType1">Test Name</label>
        </div>
        <div class="form-group col-xs-2">
            <label for="result1">Result</label>
        </div>
        <div class="form-group col-xs-2">
            <label for="unit">Unit</label>
        </div>
        <div class="form-group col-xs-2">
            <label for="reference">Reference Range</label>
        </div>
        <div class="form-group col-xs-2">
            <label for="reference">Amount</label>
        </div>
       
    </div>

<?php

while ($row = mysqli_fetch_array($data)) {

    ?>
<hr>
    <div class="form-row" id="row_">
        <div class="form-group col-xs-1 col-md-2">
            <input type="text" readonly value="<?php echo $row['test_type'] ?>" name="testname[]" class="form-control">
        </div>
        <div class="form-group col-xs-1 col-md-2">
            <input type="text" name="result[]" value="<?php echo $row['result']?>" class="form-control">
        </div>
        <div class="form-group col-xs-1 col-md-2">
            <input type="text" readonly value="<?php echo $row['unit'] ?>" class="form-control" name="unit[]">
        </div>
        <div class="form-group col-xs-1 col-md-2">
            <input type="text" readonly value="<?php echo $row['reference'] ?>" name="reference[]" class="form-control">
        </div>
        <div class="form-group col-xs-1 col-md-2">
            <input class="form-control"  value="<?php echo $row['bill'] ?>" type="test" name="bill[]">
        </div>
       
    </div>

    <?php
}
?>
    <div class="form-row">
        <div class="form-group col-xs-1 col-md-2">
            <button type="submit" name="updateData" class="btn btn-primary">Update Data</button>
        </div>
    </div>
</form>
</div>
</div>


<?php

if (isset($_POST['updateData'])) {
     $testname = $_POST['testname'];
    $result = $_POST['result'];
    $unit = $_POST['unit'];
    $reference = $_POST['reference'];
    $bill = $_POST['bill'];

    // Assuming the form fields are indexed in a way that corresponds to the database rows
    for ($i = 0; $i < count($testname); $i++) {
        $testnameValue = mysqli_real_escape_string($conn, $testname[$i]);
        $resultValue = mysqli_real_escape_string($conn, $result[$i]);
        $unitValue = mysqli_real_escape_string($conn, $unit[$i]);
        $referenceValue = mysqli_real_escape_string($conn, $reference[$i]);
        $billValue = mysqli_real_escape_string($conn, $bill[$i]);

        // Update the database with the new values
        $updateQuery = "UPDATE test_data
                        SET result = '$resultValue', bill = '$billValue'
                        WHERE patient_id = '$patient_id' AND test_type = '$testnameValue'";

        if (mysqli_query($conn, $updateQuery)) {
            
        } else {
            echo "Error updating data: " . mysqli_error($conn);
        }
    }
}

if (isset($_POST['fullName'])) {
    // Handle data update here
    $full_name = mysqli_real_escape_string($conn, $_POST['fullName']);

    // Update the full_name field in the patient_data table
    $updateNameQuery = "UPDATE patient_data
                        SET full_name = '$full_name'
                        WHERE patient_id = '$patient_id'";

    if (mysqli_query($conn, $updateNameQuery)) {
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
    }


// Close the database connection
mysqli_close($conn);
?>


<?php include "footer.php"; ?> <!--- footer -->
