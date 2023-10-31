<?php include "header.php"; // header
if(isset($_POST['save'])){
  //validate inputs
  $setting_id = mysqli_real_escape_string($conn, $_POST['id']);
  $return_days = mysqli_real_escape_string($conn, $_POST['returndays']);
  $fine = mysqli_real_escape_string($conn, $_POST['fine']);
//update query
  $sql = "UPDATE settings SET return_days = '{$return_days}', fine = '{$fine}' WHERE id = '{$setting_id}'";
  if(mysqli_query($conn, $sql)){
    echo "<div class='alert alert-success'>Updated successfully.</div>";
  }else{
    echo "<div class='alert alert-danger'>Updated not successfully.</div>";
  }
} ?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">Setting</h2>
            </div>
        </div>
        <div class="row">
            <div class="yourform offset-md-3 col-md-6">
               <ul class="list-group">

  <a href="pdfmargin.php"><li class="list-group-item list-group-item-success"><i style="margin:2px;" class="fa fa-file-pdf-o"></i>Pdf Margin Setting</li></a>
  <a href="headerlogo.php"><li class="list-group-item list-group-item-info">Header Logo Setting</li></a>
 <a href="change-password.php"><li class="list-group-item list-group-item-danger">Change Password</li></a> 
                </ul>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php" ?> <!-- footer -->

<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

/* Button used to open the contact form - fixed at the bottom of the page */
.open-button {
  background-color: #555;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
  position: fixed;
  bottom: 23px;
  right: 28px;
  width: 280px;
}

/* The popup form - hidden by default */
.form-popup {
  display: none;
  position: fixed;
  bottom: 0;
  right: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}

/* Add styles to the form container */
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

/* Full-width input fields */
.form-container input[type=text], .form-container input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/login button */
.form-container .btn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
</style>



<script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>

</body>
</html>
