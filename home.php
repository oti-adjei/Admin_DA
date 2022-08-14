<?php
session_start();
// If the session variable is empty, this
// means the user is yet to login
// User will be sent to 'login.php' page
// to allow the user to login
if (!isset($_SESSION['uname'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: index.php');
}

include "config.php";




// logout
if(isset($_POST['but_logout'])){
    session_destroy();
    header('Location: index.php');
}

?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Portal</title>
    <!--Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/nav.css">
</head>

<body>
    <nav class="navbar navbar-expand-xl navbar-light bg-light">
        <a href="#" class="navbar-brand"><i class="fa fa-cube"></i>Brand<b>Name</b></a>

        <!-- Collection of nav links, forms, and other content for toggling -->
        <div class="navbar-nav ml-auto">

            <div class="nav-item dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action"><img
                        src="/examples/images/avatar/2.jpg" class="avatar" alt="Avatar"> <?php echo $_SESSION['uname']; ?>
                </a>
                <div class="dropdown-menu">
                    <a href="#" class="dropdown-item"><i class="fa fa-user-o"></i> Profile</a></a>
                    <a href="#" class="dropdown-item"><i class="fa fa-calendar-o"></i> Calendar</a></a>
                    <a href="#" class="dropdown-item"><i class="fa fa-sliders"></i> Settings</a></a>
                    <div class="dropdown-divider"></div>
                    <form method='post' action="">
                        <input type="submit" value="Logout" name="but_logout">
                    </form>
                </div>
            </div>
        </div>
        </div>
    </nav>
    <div class="container">
        <div>&nbsp;</div>
        <h3>How to edit Mysql data in modal</h3>
        <div class="row mt-6">

            <table id="" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Product Name</th>
                        <th class="text-center"> Product Category</th>
                        <th class="text-center"> Product Price</th>
                        <th class="text-center">Posting Date</th>
                        <th class=" text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
					$sql="SELECT * from tblproducts ORDER BY id DESC";
					$query = $dbh -> prepare($sql);
					$query->execute();
					$results=$query->fetchAll(PDO::FETCH_OBJ);
					$cnt=1;
					if($query->rowCount() > 0)
					{
						foreach($results as $row)
						{ 
							?>
                    <tr>
                        <td class="text-center"><?php echo htmlentities($cnt);?></td>
                        <td><?php  echo htmlentities($row->ProductName);?></td>
                        <td class="text-center"><?php  echo htmlentities($row->CategoryName);?></td>
                        <td class="text-center"><?php  echo htmlentities($row->ProductPrice);?></td>
                        <td class="text-center"><?php  echo htmlentities(date("d-m-Y", strtotime($row->PostingDate)));?>
                        </td>
                        <td class=" text-center">
                            <a href="#" class=" edit_data4 btn btn-sm btn-primary" id="<?php echo  ($row->id); ?>"
                                title="click to edit">Edit</a>
                        </td>
                    </tr>
                    <?php
							$cnt=$cnt+1;
						}
					} ?>
                </tbody>
            </table>
        </div>
        <!--  start  modal -->
        <div id="editData4" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Product details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="info_update4">
                        <?php @include("edit_product.php");?>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
        <!--   end modal -->
    </div>
    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.edit_data4', function() {
            var edit_id4 = $(this).attr('id');
            $.ajax({
                url: "edit_product.php",
                type: "post",
                data: {
                    edit_id4: edit_id4
                },
                success: function(data) {
                    $("#info_update4").html(data);
                    $("#editData4").modal('show');
                }
            });
        });
    });
    </script>
</body>

</html>