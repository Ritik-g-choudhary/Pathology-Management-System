<?php include "header.php";
$conn = mysqli_connect("localhost","root","","library_system");

 // Include the header ?>
<style type="text/css">
    #customPopup {
  display: none;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: #fff;
  padding: 20px;
  border: 1px solid #ccc;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  z-index: 1000;
}

#customPopup label, #customPopup input, #customPopup button {
  display: block;
  margin-bottom: 10px;
}

</style>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">All Patients</h2>
            </div>
            <div class="offset-md-7 col-md-2">
                <a class="add-new" href="testlist.php">Add Patients</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="message"></div>
                <?php
                // Define the page and limit
 // Define the page and limit
$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? intval($_GET['page']) : 1;
$limit = 100; // Set your limit here

// Calculate the offset
$offset = ($page - 1) * $limit;

// Select query with LIMIT and OFFSET
$sql = "SELECT * FROM patient_data ORDER BY patient_id DESC LIMIT $limit OFFSET $offset";


                $result = mysqli_query($conn, $sql);

                // Display the patient table
                ?>

                <script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<div class="form-row">
<input class="form-group form-control col-md-3" id="myInput" type="text" placeholder="Search..">
<!-- <button class=" form-group form-control btn btn-danger col-md-1">Search</button> -->
</div>
                <table class="content-table">
                    <thead>
                        <th>S.No</th>
                        <th>Patient Name</th>
                        <th>Edit</th>
                        <th>Print</th>
                    </thead>
                    <tbody id="myTable">
                        <?php if (mysqli_num_rows($result) > 0) {
                            $serial = $offset + 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $serial; ?></td>
                                    <td><?php echo $row['full_name']; ?></td>
                                    <td class="edit">
                                        <a href="alltest.php?id=<?php echo $row['patient_id']; ?>"
                                            class="btn btn-success">Edit</a>
                                          
                                    </td>
                                    <td class="delete">
                                         <a href="print.php?id=<?php echo $row['patient_id']; ?>" class="btn btn-danger ">Print</a>
                                          <a href="billprint.php?id=<?php echo $row['patient_id']; ?>" class="btn btn-primary "><i style="margin:5px;" class="fa fa-file-pdf-o"></i> Bill Print</a>
                                           
                                    </td>
                                  
                                </tr>
                                <?php
                                $serial++;
                            }
                        } else { ?>
                            <tr>
                                <td colspan="4">No Patients Found</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php // Pagination
                $sql1 = "SELECT COUNT(*) as count FROM patient_data";
                $result1 = mysqli_query($conn, $sql1);
                $row1 = mysqli_fetch_assoc($result1);
                $total_records = $row1['count'];
                $total_page = ceil($total_records / $limit);

                if ($total_page > 1) {
                    $pagination = "<ul class='pagination admin-pagination'>";
                    if ($page > 1) {
                        $pagination .= '<li class=""><a href="allpatients.php?page=' . ($page - 1) . '">Prev</a></li>';
                    }
                    for ($i = 1; $i <= $total_page; $i++) {
                        $active = ($i == $page) ? "active" : "";
                        $pagination .= '<li class="' . $active . '"><a href="allpatients.php?page=' . $i . '">' . $i . '</a></li>';
                    }
                    if ($total_page > $page) {
                        $pagination .= '<li class=""><a href="allpatients.php?page=' . ($page + 1) . '">Next</a></li>';
                    }
                    $pagination .= "</ul>";
                    echo $pagination;
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script src="js/jquery-3.6.0.min.js" charset="utf-8"></script>
<script type="text/javascript">
    // Delete patient script
    $(".delete-patient").on("click", function () {
        var patient_id = $(this).data("pid");
        $.ajax({
            url: "delete-patient.php",
            type: "POST",
            data: { patient_id: patient_id },
            success: function (data) {
                // Display a message and refresh the page
                $(".message").html(data);
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            }
        });
    });




</script>

<?php include "footer.php"; // Include the footer ?>
