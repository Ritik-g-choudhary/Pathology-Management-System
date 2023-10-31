<?php
session_start();
include 'config.php'; //db configuration
if(!isset($_SESSION['username'])){ //check session is exists
  header("$base_url");
} ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Library System</title>
    <link rel="stylesheet" href="css/bootstrap.css"> <!-- Bootstrap -->
    <link rel="stylesheet" href="css/style.css"> <!-- Custom stlylesheet -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


  </head>
  <body>
    <div id="header"> <!-- HEADER -->
      <div class="container">
          <div class="row">
              <div class="offset-md-4 col-md-4">
                <div class="logo">
                      <?php
                $sql1 = "SELECT * FROM settings";
                $result1 = mysqli_query($conn, $sql1);
                $row1 = mysqli_fetch_assoc($result1);

     ?>
                  <a href="#"><img src="images/<?php echo $row1['img'];?>"></a>
                </div>
              </div>
              <div class="offset-md-2 col-md-2">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Hi Admin
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="change-password.php">Change Password</a>
                      <a class="dropdown-item" href="logout.php">Log Out</a>
                    </div>
                    </div>
              </div>
          </div>
      </div>
    </div> <!-- /HEADER -->
    <div id="menubar"> <!-- Menu Bar -->
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <ul class="menu">         
                    <li><a href="dashboard.php"><i style="color: white; font-size: 18px; margin: 5px;" class="fa fa-home"></i>Dashboard</a></li>
                     <li><a href="allpatients.php"><i style="color: white; font-size: 18px; margin: 5px;" class="fa fa-list-alt"></i>All Patients</a></li>
                    <li><a href="testlist.php"><i style="color: white; font-size: 18px; margin: 5px;" class="fa fa-list"></i>Test List</a></li>
                     <li><a href="add-testtype.php"><i style="color: white; font-size: 18px; margin: 5px;" class="fa fa-plus"></i>Add Test</a></li>
                     <li><a href="new_test.php"><i style="color: white; font-size: 18px; margin: 5px;" class="fa fa-plus-square-o"></i>Add Test Items</a></li>
                    <li><a href="setting.php"><i style="color: white; font-size: 18px; margin: 5px;" class="fa fa-cog"></i>Settings</a></li>
                  </ul>
              </div>
          </div>
      </div>
    </div> <!-- /Menu Bar -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style type="text/css">
  


.menu li a:hover{
    background: red !important;
    color: white;
    font-weight: bold;
}



</style>