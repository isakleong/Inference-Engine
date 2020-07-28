<?php
include 'conn/connect.php';
session_start();
$attribute = [];
$c = 0;

if(isset($_POST['add_table'])){
  $sql = "DROP TABLE if EXISTS premise";
  if ($db_connect->query($sql) === TRUE) {
  } else {
    echo "Error Deleting Table: " . $db_connect->error;
  }

  $sql = "CREATE TABLE premise(id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, ";
  for($i=0; $i < $_SESSION['jumlah_kolom']-1; $i++){
    $temp = $i+2;
    $var = $_POST['attr'.$temp];
    $attribute[$i] = $var;
    if($i==$_SESSION['jumlah_kolom']-2){
      $sql = $sql.$var.' VARCHAR(30)';
    }
    else{
      $sql = $sql.$var.' VARCHAR(30), ';
    }
  }
  $sql = $sql. ");";
  // echo $sql;
  if ($db_connect->query($sql) === TRUE) {
    echo "<script> alert('Table Successfully Added'); </script>";
  } else {
    echo "Error creating table: " . $db_connect->error;
  }
}

if(isset($_POST['insert'])){
  for($i=0; $i < $_SESSION['jumlah_row']; $i++){
    $value = [];
    $co=0;
    $j = $i+1;

    for($k=0; $k < $_SESSION['jumlah_kolom']; $k++){
      $l = $k+1;
      if(isset($_POST["row".$j."col".$l])){
        $value[$co++] = $_POST["row".$j."col".$l];
      }
      else{
        $value[$co++] = "";
      }
    }

    $res = "INSERT INTO premise (id, ";
    $res2=") VALUES (null, ";
    $res3="";
    for($m=1; $m < $_SESSION['jumlah_kolom']; $m++){
      if($m==$_SESSION['jumlah_kolom']-1){
        $res.=$_SESSION['attribute'][$m];
      }
      else{
        $res.=$_SESSION['attribute'][$m].', ';
      }
    }
    $res.=$res2;
    for ($n=1; $n < $_SESSION['jumlah_kolom']; $n++){
      if($n==$_SESSION['jumlah_kolom']-1){
        $res3.="'".$value[$n]."'";
      }
      else{
        $res3.="'".$value[$n]."', ";
      }
    }
    $res.=$res3.')';

    if ($db_connect->query($res) === TRUE) {
      // echo "<script> alert('Rule Successfully Added'); </script>";
      // echo "<script> location='blank4.php'; </script>";
    } else {
      echo "Error adding rule: " . $db_connect->error;
    }
  }
}

?>

<?php
include 'conn/connect2.php';
$attribute = [];
$c = 0;

if(isset($_POST['add_table'])){
  $sql = "DROP TABLE if EXISTS premise";
  if ($db_connect->query($sql) === TRUE) {
  } else {
    echo "Error Deleting Table: " . $db_connect->error;
  }

  $sql = "CREATE TABLE premise(id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, ";
  for($i=0; $i < $_SESSION['jumlah_kolom']-1; $i++){
    $temp = $i+2;
    $var = $_POST['attr'.$temp];
    $attribute[$i] = $var;
    if($i==$_SESSION['jumlah_kolom']-2){
      $sql = $sql.$var.' VARCHAR(30)';
    }
    else{
      $sql = $sql.$var.' VARCHAR(30), ';
    }
  }
  $sql = $sql. ");";
  // echo $sql;
  if ($db_connect->query($sql) === TRUE) {
    echo "<script> alert('Table Successfully Added'); </script>";
  } else {
    echo "Error creating table: " . $db_connect->error;
  }
}

if(isset($_POST['insert'])){
  for($i=0; $i < $_SESSION['jumlah_row']; $i++){
    $value = [];
    $co=0;
    $j = $i+1;

    for($k=0; $k < $_SESSION['jumlah_kolom']; $k++){
      $l = $k+1;
      if(isset($_POST["row".$j."col".$l])){
        $value[$co++] = $_POST["row".$j."col".$l];
      }
      else{
        $value[$co++] = "";
      }
    }

    $res = "INSERT INTO premise (id, ";
    $res2=") VALUES (null, ";
    $res3="";
    for($m=1; $m < $_SESSION['jumlah_kolom']; $m++){
      if($m==$_SESSION['jumlah_kolom']-1){
        $res.=$_SESSION['attribute'][$m];
      }
      else{
        $res.=$_SESSION['attribute'][$m].', ';
      }
    }
    $res.=$res2;
    for ($n=1; $n < $_SESSION['jumlah_kolom']; $n++){
      if($n==$_SESSION['jumlah_kolom']-1){
        $res3.="'".$value[$n]."'";
      }
      else{
        $res3.="'".$value[$n]."', ";
      }
    }
    $res.=$res3.')';

    if ($db_connect->query($res) === TRUE) {
      echo "<script> alert('Rule Successfully Added'); </script>";
      echo "<script> location='blank4.php'; </script>";
    } else {
      echo "Error adding rule: " . $db_connect->error;
    }
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
                </div>
                <?php

                if(isset($_POST['add_row'])){
                  $_SESSION['jumlah_row']+=1;
                }

                if(isset($_POST['delete'])){
                  if($_SESSION['jumlah_row'] > 1){
                    $_SESSION['jumlah_row']-=1;
                  }
                }

                if(isset($_POST['insert'])){

                }

                if(isset($_SESSION['jumlah_row'])){
                  $jumlah_row = $_SESSION['jumlah_row'];
                } else{
                  $jumlah_row = 1;
                  $_SESSION['jumlah_row'] = $jumlah_row;
                }



                $jumlah_kolom = $_SESSION['jumlah_kolom'];
                $attribute = array();

                if(isset($_POST['attr1'])){
                  for ($i=0; $i < $jumlah_kolom; $i++) { 
                    $k = $i+1;
                    array_push($attribute, $_POST['attr'.$k]);
                  }
                  $_SESSION['attribute'] = $attribute;
                } else{
                  $attribute = $_SESSION['attribute'];
                }

                ?>

                <div class="card-body" id="fill_table">
                  <table class=" table table-bordered table-light text-center" id="datatables">
                    <form method="POST" action="blank3.php">
                      <thead>
                        <tr>
                          <?php
                          for ($i=0; $i < $jumlah_kolom; $i++) { 
                            echo '<th>'.$attribute[$i].'</th>';
                          }
                          ?>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        $co_column=0;
                        for ($i=0; $i < $jumlah_row; $i++) { 
                          $j = $i+1;
                          echo '<tr style="text-align: center;" id="baris">';
                          for ($k=0; $k < $jumlah_kolom; $k++) { 
                            $l = $k+1;
                            if($k==0){
                              echo '<td>'.$j.'</td>';
                            }else{
                              if(isset($_POST["row".$j."col".$l])){
                                echo '<td><input class="form-control form_input" type="text" name="row'.$j.'col'.$l.'" value="'.$_POST["row".$j."col".$l].'"></td>';
                                      // $column_name[$co_column++] = $_POST["row".$j."col".$l];
                              }else{
                                echo '<td><input class="form-control form_input" type="text" name="row'.$j.'col'.$l.'"></td>';
                              }
                            }
                          }

                        }
                        $juml = $jumlah_kolom+1;
                        ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <?php
                          echo '<tr style="text-align: center;"> <td colspan="'.$juml.'"> <input class="btn btn-primary" type="submit" name="add_row" value="Add Row"> <input class="btn btn-primary" type="submit" name="delete" value="Delete Row"> <input class="btn btn-primary" type="submit" name="insert" value="Insert rule" onclick="return  confirm(`Are you sure to insert the rule ?`)"> </td>  </tr>';
                          $_SESSION['upload_kolom'] = $jumlah_kolom;
                          $_SESSION['upload_row'] = $jumlah_row;
                          ?>
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

         <!--  <?php 
          
         ?> -->

         <!-- MODAL -->

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
        </script>

      </body>
      </html>
