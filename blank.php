<?php
include 'conn/connect.php';

session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Proyek ASP</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-plane"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Proyek ASP</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Chaining
      </div>

      <!-- Nav Item - Pages Chaining Menu -->
      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Backward / Forward</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Select Chaining:</h6>
            <a class="collapse-item" href="backward.php">Backward Chaining</a>
            <a class="collapse-item" href="forward.php">Forward Chaining</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <div class="sidebar-heading">
        Rule
      </div>

      <!-- Nav Item - Pages Rule Menu -->
      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          <i class="fas fa-fw fa-cog"></i>
          <span>Rule / Question</span>
        </a>
        <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Option:</h6>
            <a class="collapse-item active" href="blank.php">Rule Table</a>
            <a class="collapse-item" href="quiz.php">Question</a>
          </div>
        </div>
      </li>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content" style="margin-top: 40px;">

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <!-- <h1 class="h3 mb-4 text-gray-800">Blank Page</h1> -->
          <div class="row">
            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h3 class="m-0 font-weight-bold text-primary" style="text-align: center;">Rule Table</h3>
                  <button class="btn btn-primary" id="post-column" data-toggle="modal" data-target="#column"><i class="fa fa-plus-circle" aria-hidden="true"></i> Insert Column Number </button>
                </div>

                <?php 
                $result=$db_connect->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'premise' AND TABLE_SCHEMA = 'asp'");
                $c=0;
                while($row=$result->fetch_assoc()) {
                  $attribute[$c] = $row['COLUMN_NAME'];
                  $c++;
                }
                ?>
                <div class="card-body" id="fill_table">
                  <table class=" table table-bordered table-dark text-center" id="datatables">
                    <thead>
                      <tr>
                        <?php
                        for ($i=0; $i < $c; $i++) { 
                          echo '<th>'.$attribute[$i].'</th>';
                        }
                        ?>
                      </tr>
                    </thead>

                    <tbody>


                      <?php $res = $db_connect->query("SELECT * FROM premise;"); ?>
                      <?php while($row = $res->fetch_assoc()) { ?>
                        <tr>
                          <?php
                          for ($i=0; $i < $c; $i++) { 
                            echo '<td>'.$row[$attribute[$i]].'</td>';
                          }
                          ?>
                        </tr>
                      </tbody>
                    <?php } ?>
                    <tfoot>
                      <tr>
                        <th colspan="8"><button class="btn btn-primary" data-toggle="modal" data-target="#rule"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Row </button> </th>
                      </tr>
                      <tr>
                        <th colspan="8">
                          <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#uploadfile"><i class="fa fa-file" aria-hidden="true"></i> Upload File </button> -->
                          <!-- <button class="btn btn-primary"><input type="file" class="form-control" id="sortpicture" name="sortpic"></button> -->
                        </th>
                      </tr>
                      <tr>
                        <th colspan="8"><a href="delete_rule.php"><button class="btn btn-primary" onClick="return confirm('Are You Sure ?')"><i class="fa fa-trash" aria-hidden="true"></i> Delete Row </button></a> </th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <h6><span>Copyright &copy; Daniel and Isak</span></h6>
          <input type="text" name="pathh" id="pathh">
        </div>
      </div>
    </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL -->

  <div id="uploadfile" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="upload_file.php" method="POST">
          <div class="modal-header">
            <h4 class="modal-title"> Upload File (.csv) </h4>
            <button class="close" data-dismiss="modal"> x </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Select File</label>
              <input type="file" class="form-control" id="sortpicture" name="sortpic">
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-success" id="add_file">Save</button>
            <button class="btn btn-danger"> Reset </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div id="column" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="blank2.php" method="POST">
          <div class="modal-header">
            <h4 class="modal-title"> Insert Column Number </h4>
            <button class="close" data-dismiss="modal"> x </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Jumlah Kolom</label>
              <input class="form-control" type="number" name="jumlah_kolom" id="jumlah_kolom" min="3">
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-success" id="add_clm_btn">Save</button>
            <button class="btn btn-danger"> Reset </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div id="rule" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"> Add New Rule </h4>
          <button class="close" data-dismiss="modal"> x </button>
        </div>
        <form method="post" action="upload_rule.php">
          <div class="modal-body">
            <?php
            for($i=1;$i<$c;$i++){
              echo "<div class=form-group>". "<label>$attribute[$i]</label>" . "<input type=text class=form-control name=$attribute[$i] required" . "</div>";
            }
            ?>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-success" name="save" value="Save">
            <button type="reset" class="btn btn-danger"> Reset </button>
          </div>
        </form>
      </div>
    </div>
  </div>



  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- script add column -->
  <script>
    $(document).ready(function(){
      var pathh;
      $('#add_file').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var file_data = $('#sortpicture').prop('files')[0];  
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        //alert(form_data);                             
        $.ajax({
                url: 'upload_file.php', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(res){
                  if(res == 'a'){
                    alert('gagal');
                  }else{
                    alert("Upload sukses!!"); // display response from the PHP script, if any
                    pathh=res;
                    // $("#uploadfile").hide();
                      alert(document.getElementById('pathh').value + " ");

                  }


              }
          });
      });
    });
  </script>

</body>
</html>
