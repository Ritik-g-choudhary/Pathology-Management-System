<?php
$conn = mysqli_connect("localhost","root","","library_system");

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the selected test type from the AJAX request
$selectedTestType = $_POST['testType'];

// Query the database to fetch options for the selected test type
$sql = "SELECT reference_range FROM pre_data WHERE test_type = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $selectedTestType);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    
    // Generate HTML options based on the query result
    $options = '<option value="">Select a reference range</option>';
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . $row['reference_range'] . '">' . $row['reference_range'] . '</option>';
    }

    echo $options;
} else {
    echo '<option value="">No reference ranges found</option>';
}

// Close the database connection
$stmt->close();
$conn->close();
?>