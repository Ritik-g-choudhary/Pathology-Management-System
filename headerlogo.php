<?php include "header.php" ?> <!--- header -->

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">All Books</h2>
            </div>
            <div class="offset-md-7 col-md-2">
                <a class="add-new" href="add-book.php">Back</a>
            </div>
        </div>
        <div class="row">
        <div class="offset-md-3 col-md-6">
     <?php
                $sql1 = "SELECT * FROM settings";
                $result1 = mysqli_query($conn, $sql1);
                $row1 = mysqli_fetch_assoc($result1);

     ?>
      <form class="yourform" enctype="multipart/form-data" action="" method="post" autocomplete="off">
        <div class="form-group">
            <img width="100" src="images/<?php echo $row1['img'];?>">
        </div>
        <div class="form-group">
            <label>Logo</label>
            <input type="file" name="logo">
        </div>

        <div class="form-group">

            <img width="100" src="images/<?php echo $row1['leftside'];?>">
        </div>
        <div class="form-group">
            <label>Left Side Dr. Sign</label>
            <input type="file" name="leftside">
        </div>


        <div class="form-group">
            <img width="100" src="images/<?php echo $row1['rightside'];?>">
        </div>
        <div class="form-group">
            <label>Right Side Dr. Sign</label>
            <input type="file" name="rightside">
        </div>

        
        <input type="submit" name="save" class="btn btn-danger" value="save" required>
      </form>
    </div>
        </div>
    </div>
</div>
<?php include "footer.php" ?> <!--- footer -->
<?php
if (isset($_POST['save'])) {
    // Database connection

    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Function to handle image upload and update in database
    function uploadAndUpdateImage($fileInputName, $imageColumn) {
        global $conn;

        // Check if a file was selected
        if (isset($_FILES[$fileInputName]['name']) && !empty($_FILES[$fileInputName]['name'])) {
            // File handling
            $targetDirectory = "images/";  // Your target directory
            $targetFile = $targetDirectory . basename($_FILES[$fileInputName]['name']);
           $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if it's a valid image file
            $validExtensions = array("jpg", "jpeg", "png", "gif");
            if (in_array($imageFileType, $validExtensions)) {
                // Move the new image to the target directory
                if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $targetFile)) {
                    // Update the image name in the database
                    $updateSql = "UPDATE settings SET $imageColumn = '" . mysqli_real_escape_string($conn, $_FILES[$fileInputName]['name']) . "'";
                    if (mysqli_query($conn, $updateSql)) {
                        echo "$imageColumn updated successfully.<br>";
                    } else {
                        echo "Error updating $imageColumn in the database: " . mysqli_error($conn) . "<br>";
                    }
                } else {
                    echo "Error uploading the $imageColumn file.<br>";
                }
            } else {
                echo "Invalid file format for $imageColumn. Supported formats are: jpg, jpeg, png, gif.<br>";
            }
        }
    }

    // Update the images one by one
    uploadAndUpdateImage('logo', 'img');
    uploadAndUpdateImage('leftside', 'leftside');
    uploadAndUpdateImage('rightside', 'rightside');

    // Close the database connection
    mysqli_close($conn);
}
?>
