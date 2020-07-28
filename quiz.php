<?php
include 'conn/connect.php';
if(isset($_POST['insert_quiz'])){
  $attr = array();
 $res = $db_connect->query("SELECT * FROM question;"); 
 while($row = $res->fetch_assoc()) { 
  array_push($attr, $row['attribute']);
 }

                     
  $co=0;
  $res = $db_connect->query("SELECT * FROM question;");
  while($row = $res->fetch_assoc()) {
    $co++;
  }
  for($i=0; $i < $co; $i++){
    $a = $_POST[$attr[$i]];
    $db_connect->query("UPDATE question set quiz= '$a' where attribute='$attr[$i]'");
    // $result=$db_connect->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'premise' AND TABLE_SCHEMA = 'asp'");
  }
}
?>

<?php
include 'conn/connect2.php';
if(isset($_POST['insert_quiz'])){
  $attr = array();
 $res = $db_connect->query("SELECT * FROM question;"); 
 while($row = $res->fetch_assoc()) { 
  array_push($attr, $row['attribute']);
 }

                     
  $co=0;
  $res = $db_connect->query("SELECT * FROM question;");
  while($row = $res->fetch_assoc()) {
    $co++;
  }
  for($i=0; $i < $co; $i++){
    $a = $_POST[$attr[$i]];
    $db_connect->query("UPDATE question set quiz= '$a' where attribute='$attr[$i]'");
    // $result=$db_connect->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'premise' AND TABLE_SCHEMA = 'asp'");
  }
}
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
            <a class="collapse-item" href="blank.php">Rule Table</a>
            <a class="collapse-item active" href="quiz.php">Question</a>
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
        <!-- <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <h1 style="text-align: center;" class="h3 text-gray-800">Backward Chaining</h1>
          <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>
          </ul>
        </nav> -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="row">

            <div class="col-lg-12">

              <!-- Circle Buttons -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h1 style="text-align: center;" class="m-0 font-weight-bold text-primary">Question</h1>
                </div>
                <div class="card-body">
                  <table class=" table table-bordered table-dark text-center" id="datatables">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Attribute</th>
                        <th>Question</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php include 'conn/connect.php'; ?>
                      <?php $res = $db_connect->query("SELECT * FROM question;"); ?>
                      <?php while($row = $res->fetch_assoc()) { ?>
                        <tr>
                          <form action="quiz.php" method="post">
                          <?php
                            echo '<td>'.$row['id'].'</td>';
                            echo '<td>'.$row['attribute'].'</td>';  
                            echo '<td> <input type="text" class="form-control" value="'.$row['quiz'].'" name="'.$row['attribute'].'"> </td>';
                          ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="8"><button type="submit" class="btn btn-primary" name="insert_quiz"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Question </button></th></form>
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
      <!-- <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer> -->
      <!-- End of Footer -->
      <footer class="sticky-footer bg-white">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <h6><span>Copyright &copy; Daniel and Isak</span></h6>
        </div>
      </div>
    </footer>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div id="question" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"> Add New Question </h4>
          <button class="close" data-dismiss="modal"> x </button>
        </div>
        <form method="post" action="upload_question.php">
          <div class="modal-body">
            <div class="form-group">
              <label>Attribute</label>
              <input class="form-control" type="text" name="attribute">
            </div>
            <div class="form-group">
              <label>Question</label>
              <input class="form-control" type="text" name="question">
            </div>
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

</body>

</html>
