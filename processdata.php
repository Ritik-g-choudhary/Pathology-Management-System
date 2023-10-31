<?php
include 'header.php';
if (isset($_POST['save'])) {
    // Include your database connection code or configuration here
    $conn = mysqli_connect("localhost", "root", "", "library_system");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    

    // Collect patient details from the form
    $full_name = $_POST['fullName'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
     $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $emergency_contact = $_POST['emergencyContact'];
    $medical_history = $_POST['medicalHistory'];
    $primary_care_physician = $_POST['primaryCarePhysician'];
    $insurance_info = $_POST['insuranceInfo'];
    
    // Collect other patient details here...

    // Insert patient details into the patient_data table
     $sql = "INSERT INTO patient_data (full_name, dob, gender, address, phone, email, emergency_contact, medical_history, primary_care_physician, insurance_info)
            VALUES ('$full_name', '$dob', '$gender', '$address', '$phone', '$email', '$emergency_contact', '$medical_history', '$primary_care_physician', '$insurance_info')";


    if (mysqli_query($conn, $sql)) {
        $patient_id = mysqli_insert_id($conn); // Get the auto-generated patient ID

        // Collect and insert test data into the test_data table
    $testTypes = $_POST['testType'];
$results = $_POST['result'];
$units = $_POST['unit'];       // Use a different variable name
$references = $_POST['reference']; // Use a different variable name
$bill = $_POST['bill'];
$heading = $_POST['heading'];

// Loop through the test data arrays and insert them into the test_data table
for ($i = 0; $i < count($testTypes); $i++) {
    $testType = $testTypes[$i];
    $result = $results[$i];
    $unit = $units[$i];       // Use the correct variable name
    $reference = $references[$i];
    $bills = $bill[$i];
    $headings = $heading[$i]; // Use the correct variable name
    $test_date = date("Y-m-d");
    $test_sql = "INSERT INTO test_data (patient_id, test_type, result, test_date, unit, reference,bill,heading) VALUES ('$patient_id', '$testType', '$result', '$test_date', '$unit', '$reference','$bills','$headings')";

            if (mysqli_query($conn, $test_sql)) {
               echo '<script>
  Swal.fire({
    title: "Redirect Example",
    text: "Press OK to Go Dashboard page.",
    icon: "success",
    showCancelButton: true,
    confirmButtonText: "OK",
  }).then((result) => {
    if (result.isConfirmed) {
      // Redirect the user to another page
      window.location.href = "dashboard.php"; // Replace with your desired URL
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      // Handle cancellation
    }
  });
</script>';
            } else {
                echo "Error: " . $test_sql . "<br>" . mysqli_error($conn);
            }
        }

        echo '<script>
  Swal.fire({
    title: "Redirect Example",
   text: "Press OK to Go Dashboard page.",
    icon: "success",
    showCancelButton: true,
    confirmButtonText: "OK",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      // Redirect the user to another page
      window.location.href = "dashboard.php"; // Replace with your desired URL
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      // Handle cancellation
    }
  });
</script>';    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    // Handle GET requests or form not submitted
}
?>
