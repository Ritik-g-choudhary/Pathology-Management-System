<?php include "header.php"; ?> <!--- header -->
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h2 class="admin-heading"><?php echo $testname = $_REQUEST['testname'];?></h2>
            </div>
            <div class=" col-md-2">
                <a class="add-new" href="allpatients.php">All Patients</a>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <form action="processdata.php" method="post">
                    
                    <!-- first Form Row -->
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="fullName">Full Name</label>
                            <input type="text" class="form-control" id="fullName" name="fullName" >
                        </div>
                        <div class="form-group col-md-3">
                            <label for="dob">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" >
                        </div>
                        <div class="form-group col-md-3">
                            <label for="gender">Gender</label>
                            <select class="form-control" id="gender" name="gender" >
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="address">Address</label>
                            <input type="text" value="PHOPNAR,BURHANPUR" class="form-control" id="address" name="address">
                        </div>
                    </div>
                    
                    <!-- second Form Row  -->
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="phone">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="email">Email Address</label>
                            <input type="email" value="None@mail.com" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group  col-md-3">
                            <label for="emergencyContact">Emergency Contact</label>
                            <input type="text" class="form-control" value="None" id="emergencyContact" name="emergencyContact">
                        </div>
                        <div class="form-group  col-md-3">
                            <label for="medicalHistory">Medical History</label>
                            <textarea class="form-control" value="None" id="medicalHistory" name="medicalHistory" rows="1"></textarea>
                        </div>
                    </div>

                    <!-- third Form Row -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="primaryCarePhysician">Dr. Name</label>
                            <input type="text" class="form-control" id="primaryCarePhysician" name="primaryCarePhysician">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="insuranceInfo">Test Heading</label>
                            <input type="text" class="form-control" value="BIOCHEMISTRY" id="insuranceInfo" name="insuranceInfo">
                        </div>
                    </div>

                    <!-- Fourth Form Row From Data BAse -->
                    <div class="form-row">
<select class="form-control" id="testSelect">
    <option value="" >Select Test Name</option>
    <?php
    $query = "SELECT id, testname FROM test_name";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row['id'] . "'>" . $row['testname'] . "</option>";
    }
    ?>
</select>
<script>
    var rowCount = 0;

    $(document).ready(function () {
        $("#testSelect").change(function () {
            var selectedTestId = $(this).val();
           
            // Send the selectedTestId to your PHP script using an AJAX request
            $.ajax({
                type: "POST",
                url: "getpredata.php",  // Replace with the actual path to your PHP script
                data: { id: selectedTestId },
                success: function (response) {
                 $(".para").append(response);
                 updateRowIds();
                    
                }
            });
        });
    });
    function updateRowIds() {
    rowCount = 0;
    $(".form-row").each(function () {
        rowCount++;
        var rowId = "row_" + rowCount;
        $(this).attr("name", rowId);
    });
}

</script>

                            
                        

      <div class="para">
          
      </div>
                    </div>
                    <div class="form-row">
                    <button style="margin-top:10px;" class="col-md-4 form-control btn btn-success" type="submit" name="save">Submit</button>
                        
                    </div>
                </form>


<script type="text/javascript">
$(document).ready(function() {
  // Attach an onchange event to the select element
  $(".select").on("change", function() {
    var selectedTestId = $(this).val();
    alert(selectedTestId);
 
$.ajax({
  url: 'getpredata.php', // Replace with the actual URL of your PHP script
  data: { id: selectedTestId },
  method: 'POST',
  success: function(response) {
   console.log(response);
  },
  error: function(xhr, status, error) {
    // Handle the error here
    console.log('Error: ' + error);
  }
});
  });
  });
$(document).ready(function () {
    $("#testSelect").change(function () {
        var selectedValue = $(this).val();

        // Remove the selected option
        $(this).find('option[value="' + selectedValue + '"]').remove();
    });
});
</script>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?> <!--- footer -->
<?php
if (isset($_REQUEST['save'])) {
   print_r($_REQUEST);
}

?>