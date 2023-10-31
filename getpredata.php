<?php
// Include your database connection code, e.g., connection to the $conn variable
include "config.php"; // Replace with the actual path to your database connection code


// Check if the 'id' parameter has been sent via POST
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Perform your database query with the received 'id'
    $query = "SELECT * FROM test_name
              INNER JOIN test_items ON test_name.id = test_items.id
              WHERE test_items.id = '$id'";
    
    $result = mysqli_query($conn, $query);

    if ($result) {
         $rowCounter = 0;
        // Process the query result here, e.g., fetch and display data
        while ($row = mysqli_fetch_assoc($result)) {
            // Do something with the data, e.g., echo it
            $rowCounter++;
            ?>
                        <div class="form-row" id="row_<?php echo $rowCounter; ?>">
                            <div class="form-group col-md-2">
                                <label for="testType1">Test Name</label>
                                <input type="text" readonly value="<?php echo $row['Test_Type'] ?>" name="testType[]" class="form-control">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="result1">Result</label>
                                <input type="text" name="result[]" value="" class="form-control">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="unit">Unit</label>
                                <input type="text" readonly value="<?php echo $row['Unit'] ?>" class="form-control" name="unit[]">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="reference">Reference Range</label>
                                <input type="text" readonly value="<?php echo $row['Reference_Range'] ?>" name="reference[]" class="form-control">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="reference">Amount</label>
                                <input class="form-control" value="<?php echo $row['bill']?>" type="test" name="bill[]">
                            </div>
                            <div hidden class="form-group col-md-2">
                                <input class="form-control" value="<?php echo $row['id']?>" type="test" name="heading[]">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="reference">Delete Row</label>
                                <button type="button" class="form-control btn btn-danger delete-button">Delete</button>
                            </div>
                        </div>
                        
                
                        <script>
                        $(document).ready(function() {
                        $(".delete-button").click(function() {
                        $(this).closest(".form-row").remove();
                        });
                        });
                        </script>

            <?php
            // You can display other fields as needed
        }
    } else {
        // Handle any database query errors here
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Handle the case where 'id' was not received
    echo "No 'id' parameter received.";
}
?>
