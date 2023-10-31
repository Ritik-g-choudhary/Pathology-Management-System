<!DOCTYPE html>
<?php
include 'header.php';
?>
<html>
<head>
    <title>Insert Data</title>
   
</head>
<!DOCTYPE html>
<html>

<head>
</head>

<body>
    <div class="container">
        <div class="form-row">
            <h2>Insert Data</h2>
            <form method="POST" action=""> <!-- Update the form action to your server-side script -->
                <div class="form-row" id="row-0">
                    <div class="form-group col-md-2">
                        <label for="TestName">Test Name:</label>
                        <select class="form-control" name="TestName[0]"></select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="TestType">Test Type:</label>
                        <input type="text" class="form-control" name="TestType[0]">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="Result">Result:</label>
                        <input type="text" class="form-control" name="Result[0]">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="Unit">Unit:</label>
                        <input type="text" class="form-control" name="Unit[0]">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="ReferenceRange">Reference Range:</label>
                        <input type="text" class="form-control" name="ReferenceRange[0]">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="Price">Price:</label>
                        <input type="text" class="form-control" name="bill[0]">
                    </div>
                </div>
                <button type="button" onclick="addRow()">Add Row</button>
                <button type="submit" name="save" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</body>

</html>

<script>
    // Counter for the unique row identifier
    var rowCounter = 1;

    // Function to fetch test names and populate the dropdown options
    function populateTestNames(select) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_test_names.php', true);
        xhr.onload = function() {
            if (xhr.status == 200) {
                var testNames = JSON.parse(xhr.responseText);
                testNames.forEach(function(name) {
                    var option = document.createElement('option');
                    option.value = name.id;
                    option.text = name.testname;
                    select.appendChild(option);
                });
            }
        };
        xhr.send();
    }

    // Call the populateTestNames function for the initial "Test Name" dropdown
    var initialSelect = document.querySelector('select[name="TestName[0]"]');
    populateTestNames(initialSelect);

    // Function to add a new row with the "Test Name" dropdown
    function addRow() {
        var newRow = document.createElement('div');
        newRow.className = 'form-row';
        newRow.id = 'row-' + rowCounter;

        // Create the HTML for the new row
        var html = `
            <div class="form-group col-md-2">
                <label for="TestName">Test Name:</label>
                <select class="form-control" name="TestName[${rowCounter}]"></select>
            </div>
            <div class="form-group col-md-2">
                <label for="TestType">Test Type:</label>
                <input type="text" class="form-control" name="TestType[${rowCounter}]">
            </div>
            <div class="form-group col-md-2">
                <label for="Result">Result:</label>
                <input type="text" class="form-control" name="Result[${rowCounter}]">
            </div>
            <div class="form-group col-md-2">
                <label for="Unit">Unit:</label>
                <input type="text" class="form-control" name="Unit[${rowCounter}]">
            </div>
            <div class="form-group col-md-2">
                <label for="ReferenceRange">Reference Range:</label>
                <input type="text" class="form-control" name="ReferenceRange[${rowCounter}]">
            </div>
            <div class="form-group col-md-2">
                <label for="Price">Price:</label>
                <input type="text" class="form-control" name="bill[${rowCounter}]">
            </div>
        `;

        newRow.innerHTML = html;
        document.querySelector('.container form').appendChild(newRow);

        // Call the function to populate the newly added row's "Test Name" dropdown
        var newSelect = newRow.querySelector(`select[name="TestName[${rowCounter}]`);
        populateTestNames(newSelect);

        rowCounter++; // Increment the row counter for the next row
    }
</script>

<?php
if (isset($_POST['save'])) {
    $TestNames = $_POST['TestName'];
    $TestTypes = $_POST['TestType'];
    $Results = $_POST['Result'];
    $Units = $_POST['Unit'];
    $ReferenceRanges = $_POST['ReferenceRange'];
    $bills = $_POST['bill'];

    // Check connection (Replace with your database connection logic)
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Create an array to hold the values
    $values = array();

    // Loop through the submitted data
    for ($i = 0; $i < count($TestNames); $i++) {
        $TestName = mysqli_real_escape_string($conn, $TestNames[$i]);
        $TestType = mysqli_real_escape_string($conn, $TestTypes[$i]);
        $Result = mysqli_real_escape_string($conn, $Results[$i]);
        $Unit = mysqli_real_escape_string($conn, $Units[$i]);
        $ReferenceRange = mysqli_real_escape_string($conn, $ReferenceRanges[$i]);
        $bill = mysqli_real_escape_string($conn, $bills[$i]);

        // Add the values to the array
        $values[] = "('$TestType', '$Result', '$Unit', '$ReferenceRange', '$TestName', '$TestName', '$bill')";
    }

    // Construct the SQL query to insert multiple rows
    $sql = "INSERT INTO test_items (Test_Type, Result, Unit, Reference_Range, test_name, id, bill) VALUES " . implode(', ', $values);

    if (mysqli_query($conn, $sql)) {
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

    // Close the database connection
    mysqli_close($conn);
}
