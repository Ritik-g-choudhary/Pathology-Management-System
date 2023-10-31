<?php
// Database connection (You should include your database connection logic here)
include 'config.php';
// Assume you have a database connection object named $conn

// Perform the SQL query to fetch test names
$query = "SELECT id, testname FROM test_name";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$testNames = array();

// Fetch and store test names in an array
while ($row = mysqli_fetch_assoc($result)) {
    $testNames[] = $row;
}

// Close the database connection
mysqli_close($conn);

// Return test names as JSON
header('Content-Type: application/json');
echo json_encode($testNames);
?>
