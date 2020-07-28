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
        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Select Chaining:</h6>
            <a class="collapse-item" href="backward.php">Backward Chaining</a>
            <a class="collapse-item active" href="forward.php">Forward Chaining</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <div class="sidebar-heading">
        Rule
      </div>

      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          <i class="fas fa-fw fa-cog"></i>
          <span>Rule / Question</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Option:</h6>
            <a class="collapse-item" href="blank.php">Rule Table</a>
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
                  <h1 style="text-align: center;" class="m-0 font-weight-bold text-primary">Forward Chaning</h1>
                </div>
                <div class="card-body">
                  <?php
                  include "conn/connect2.php";
                  $ketemu = false;
                  if(isset($_POST['choice'])){
                    $epoch = $_POST['epoch']-1;
                    $input=array($_POST['attr']=>array($_POST['choice']));
                    $res=$db_connect->query("INSERT INTO working_memory_table (id, attr_name, attr_value) VALUES (null, '$_POST[attr]', '$_POST[choice]')");
                    $ketemu = forward($input, $epoch);
                  }
                  if(isset($_POST['reload'])){
                    $result=$db_connect->query("TRUNCATE TABLE `working_memory_table`");
                    $result=$db_connect->query("TRUNCATE TABLE `attr_table`");
                  }
                  //#################################### GENERATE RULE TABLE FROM PREMISE TABLE ####################################

                  function generate_rule_table(){
                    include "conn/connect2.php";
                    $result=$db_connect->query("TRUNCATE TABLE `working_memory_table`");
                    $result=$db_connect->query("TRUNCATE TABLE `attr_table`");
                    //mengambil kolom apa saja yang ada di premise dan jumlahnya
                    $result=$db_connect->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'premise' AND TABLE_SCHEMA = 'coba_asp'");
                    $c = 0;
                    while($row=$result->fetch_assoc()) {
                      $attribute[$c] = $row['COLUMN_NAME'];
                      $c++;
                    }
                    //ambil jumlah baris yang ada di tabel
                    $result=$db_connect->query("SELECT count(*) FROM `premise`");
                    while($row=$result->fetch_assoc()) {
                      $baris = $row['count(*)'];
                    }

                    //counter untuk jumlah premis
                    //dikurangi 2 karena ada ID dan Result
                    for ($i=1; $i <= $baris ; $i++) { 
                      $jumlah_premis[$i] = -2;
                    }

                    //asumsi tabel premis harus mempunyai kolom dengan nama id
                    for ($i=1; $i <= $baris ; $i++) { 
                      $result=$db_connect->query("SELECT * FROM `premise` where id='$i'");
                      while($row=$result->fetch_assoc()) {
                        for ($j=0; $j<$c ; $j++) { 
                          if($row[$attribute[$j]] != ''){
                            $jumlah_premis[$i]+=1;
                          }
                        }
                      }
                    }

                    $result=$db_connect->query("TRUNCATE TABLE `rule_table`");

                    for ($i=1; $i <= $baris ; $i++) { 
                      for ($j=1; $j <= $jumlah_premis[$i] ; $j++) { 
                        $premnum = $i."-".$j;
                        $result=$db_connect->query("INSERT INTO `rule_table`(`rule_number`, `rule_status`, `prem_clause_num`, `prem_clause_stat`) VALUES ('$i','A,U','$premnum','FR')");
                      }
                    }


                    $result=$db_connect->query("TRUNCATE TABLE `rule_status`");

                    //Generate Rule Status

                    for ($i=1; $i <= $baris ; $i++) { 
                      $result=$db_connect->query("INSERT INTO `rule_status`(`rule_status`, `rule_number`) VALUES ('A,U','$i')");
                    }

                  }
                  //################################################ END #############################################################

                  function write_table()
                  {
                    include "conn/connect2.php";
                    echo '
                    <form method="POST" action="index3.php">
                    <table class=" table table-bordered table-dark text-center" id="datatables">
                    <thead>
                    <h4 class="m-0 font-weight-bold text-primary">Rule Table</h4>
                    <tr>';

                    $result=$db_connect->query("SELECT * FROM `rule_table`");
                    $hitung=0;

                    while($row=$result->fetch_assoc()) {
                      $rule_id[$hitung] = $row['rule_id'];
                      $rule_number[$hitung] = $row['rule_number'];
                      $prem_clause_num[$hitung] = $row['prem_clause_num'];
                      $prem_clause_stat[$hitung] = $row['prem_clause_stat'];
                      $hitung++;
                    }

                    $result=$db_connect->query("SELECT * FROM `rule_status`");
                    $hit = 1;
                    while($row=$result->fetch_assoc()) {
                      $rule_status[$hit] = $row['rule_status'];
                      $hit++;
                    }


                    echo '  <th>rule_id</th>
                    <th>rule_number</th>
                    <th>rule_status</th>
                    <th>prem_clause_num</th>
                    <th>prem_clause_stat</th>
                    </tr></thead>';


                    $result=$db_connect->query("SELECT count(*) FROM `rule_table`");
                    while($row=$result->fetch_assoc()) {
                      $baris_rule = $row['count(*)'];
                    }

                    for ($i=0; $i < $baris_rule; $i++) { 
                      echo "<tr>";
                      echo "<td>".$rule_id[$i]."</td>";
                      echo "<td>".$rule_number[$i]."</td>";
                      echo "<td>".$rule_status[$rule_number[$i]]."</td>";
                      echo "<td>".$prem_clause_num[$i]."</td>";
                      echo "<td>".$prem_clause_stat[$i]."</td>";
                      echo "</tr>";
                    }
                  }
                  //################################################ Forward Start #############################################################

                  function forward($input, $i)
                  {
                    include "conn/connect2.php";
                    $len = count($input);

                    $prem_stat_arr = array();
                    $c=0;
                    $row_cek_stat_arr = array();
                    $c1=0;

                    $attribute = array();
                    $res_column=$db_connect->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'premise' AND TABLE_SCHEMA = 'coba_asp'");
                    $counter = 0;
                    while($row_res_column=$res_column->fetch_assoc()) {
                      $attribute[$counter] = $row_res_column['COLUMN_NAME'];
                      $counter++;
                    }

                    $result=$db_connect->query("TRUNCATE TABLE `attr_table`");

                    // $pointer = $counter - 1;
                    // $cursor = $db_connect->query("INSERT INTO `attr_table`(`attr_name`) VALUES ('$attribute[$pointer]')");

                    $cursor = $db_connect->query("INSERT INTO `attr_table`(`attr_name`) VALUES ('$attribute[$i]')");

                    //Step 2: Memulai proses pengambilan keputusan. Sebuah value dari sebuah atribut premis diambil. Di mana atribut tersebut tidak boleh ada pada klausa kesimpulan. Atribut ini disimpan pada bagian teratas tabel Attribute Queue. 
                    // for ($i=1; $i < $counter; $i++){
                    // $cursor = $db_connect->query("INSERT INTO `attr_table`(`attr_name`) VALUES ('$attribute[$i]')"); 

                    //Step 3: Penelitian satu persatu rule yang ada untuk memeriksa ada tidaknya kesamaan. Periksa tabel Rule/Premis Status, jika tidak ada rule yang statusnya ‘Active’, pencarian dihentikan. Bila ada, dilakukan penelitian bagian klausa premis rule yang statusnya ‘Active’ untuk mencocokkan klausa premis yang sesuai dengan value dari atribut pada bagian teratas tabel Attribute Queue. 

                    $result = $db_connect->query("SELECT * from rule_table");
                    while($row = $result->fetch_assoc()){
                      //cari status yang aktif ("A")
                      $result_status = $db_connect->query("SELECT * from rule_status where id = $row[rule_number]");
                      $row_result_status = $result_status->fetch_assoc();

                      $rule_status = $row_result_status['rule_status'];
                      $status = preg_split("/[\s,]+/", $rule_status);

                      if($status[0] == "A"){
                        //1-1 -- prem num, attr
                        $prem_clause_num = $row['prem_clause_num'];
                        $prem_num = preg_split("/[\s-]+/", $prem_clause_num);
                        //print_r($prem_num);

                        $res = $db_connect->query("SELECT * from premise where id = $prem_num[0]");
                        $row_res = $res->fetch_assoc();

                        if($prem_num[1] == $i){
                          if($row_res[$attribute[$i]] == $input[$attribute[$i]][0]){
                            $r = $db_connect->query("UPDATE rule_table SET prem_clause_stat = 'TU' where rule_id = $row[rule_id] ");
                          }
                          else{
                            //Step 3A: Bila ada premis dari sebuah rule yang bernilai salah, maka diberi tanda D (Discarded) pada rule tersebut untuk menunjukkan bahwa rule tersebut bernilai salah dan tidak dipakai lagi. 
                            $r = $db_connect->query("UPDATE rule_table SET prem_clause_stat = 'FA' where rule_id = $row[rule_id] ");

                            $r = $db_connect->query("UPDATE rule_status SET rule_status = 'U' where id = $row[rule_number] ");

                            $r = $db_connect->query("UPDATE rule_status SET rule_status = CONCAT(rule_status, ',D') where id = $row[rule_number] ");
                          }
                        }
                        $new_result = $db_connect->query("SELECT * from rule_status");
                        while($new_row = $new_result->fetch_assoc()){
                          $c=0;
                          $cek = $db_connect->query("SELECT * from rule_table where rule_number = $new_row[id]");
                          while($row_cek = $cek->fetch_assoc()){
                            $prem_stat_arr[$c++] = $row_cek['prem_clause_stat'];
                          }
                          $tu=0;
                          for($j=0; $j<$c; $j++){
                            if($prem_stat_arr[$j] == "TU"){
                              $tu++;
                            }
                          }

                          //Step 3B
                          if($tu == $c){
                            $r = $db_connect->query("UPDATE rule_status SET rule_status = CONCAT(rule_status, ',TD') where id = $new_row[id] ");
                            $r = $db_connect->query("UPDATE rule_status SET rule_status = 'U,FD' where id = $new_row[id] ");
                            $rule_benar = $new_row['id'];
                            $check = true;
                            $tempco = $counter-1;
                            $result=$db_connect->query("SELECT $attribute[$tempco] FROM `premise` where `id`=$rule_benar ");
                            while($row=$result->fetch_assoc()) {
                              $hasil = $row[$attribute[$tempco]];
                            }
                            // echo $attribute[$tempco]." = ".$hasil."<br><br>";
                            echo "<h3 class='m-0 font-weight-bold'>" .$attribute[$tempco]. ": ".$hasil."</h3><br><br>";
                            echo "<form method='post' action='forward.php'>";
                            echo "<input type='submit' name='reload' value='Try Again' class='btn btn-primary'><br><br>";
                            echo "</form";
                            return true;

                          }
                          elseif ($tu == 0) {
                            //Step 3C: Bila tidak ada rule yang statusnya TD (Triggered),  dilanjutkan ke langkah ke 5
                            $cek_status = $db_connect->query("SELECT * from rule_status where rule_status = 'A,U' ");
                            while($row_cek_status = $cek_status->fetch_assoc()){
                              $row_cek_stat_arr[$c1++] = $row_cek_status['rule_number'];
                            }
                            //Step 6
                            // $r = $db_connect->query("UPDATE rule_status SET rule_status = 'A,M' where id = $row_cek_stat_arr[0] ");
                          }
                        }
                      }
                    }

                    $cek_status = $db_connect->query("SELECT COUNT(*) FROM `rule_status` WHERE `rule_status` = 'U,D'");
                    while($row = $cek_status->fetch_assoc()){
                      $jum_cek = $row["COUNT(*)"];
                    }

                    $cek_status = $db_connect->query("SELECT COUNT(*) FROM `rule_status`");
                    while($row = $cek_status->fetch_assoc()){
                      $jum_cek2 = $row["COUNT(*)"];
                    }
                    if($jum_cek == $jum_cek2){
                      echo "Answer Not Found ! <br><br>";
                      return true;
                    }

                  }

                  $input=array();
                  $result=$db_connect->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'premise' AND TABLE_SCHEMA = 'coba_asp'");
                  $c = 0;
                  while($row=$result->fetch_assoc()) {
                    $attribute[$c] = $row['COLUMN_NAME'];
                    $c++;
                  }

                  if(!isset($_POST['epoch'])) { 
                    generate_rule_table();
                    //echo "Question 1 : ".$attribute[1]."<br><br>";
                    $res = $db_connect->query("SELECT * from question where attribute = '$attribute[1]'");
                    while($row_quiz=$res->fetch_assoc()){
                      $quiz = $row_quiz['quiz'];
                    }
                    echo "<h3 class='m-0 font-weight-bold'>".$quiz." : (".$attribute[1].")</h3><br><br>";
                    $_POST['epoch'] = 1;
                    $result=$db_connect->query("SELECT DISTINCT `$attribute[1]` FROM `premise`");
                    $hitung_choice=0;
                    while($row=$result->fetch_assoc()) {
                      $choice[$hitung_choice] = $row[$attribute[1]];
                      $hitung_choice++;
                    }
                    echo "<form action='forward.php' method='POST'><div class='form-group'><select class='form-control' name='choice'>";

                    for ($i=0; $i < $hitung_choice; $i++) { 
                      if($choice[$i]!=""){
                        echo '<option value="'.$choice[$i].'">'.$choice[$i].'</option>';
                      }
                      echo '</div>';
                    }
                    $epoch = $_POST['epoch']+1;

                    echo '</select><br><br><input type="text" name="attr" value="'.$attribute[1].'" hidden="true"><input type="text" name="epoch" value="'.$epoch.'" hidden="true"><input type="submit" name="submit" class="btn btn-primary"><br><br></form>';

                    write_table();

                  }else{
                    if(!$ketemu){
                      $p = $_POST['epoch'];
                      //echo "Question ".$p." : ".$attribute[$p]."<br><br>";
                      $res_temp = $db_connect->query("SELECT * from question where attribute = '$attribute[$p]'");
                      while($row_quiz=$res_temp->fetch_assoc()){
                        $quiz = $row_quiz['quiz'];
                      }
                      echo "<h3 class='m-0 font-weight-bold'>".$quiz." : (".$attribute[$p].")</h3><br><br>";
                      $result=$db_connect->query("SELECT DISTINCT `$attribute[$p]` FROM `premise`");
                      $hitung_choice=0;
                      while($row=$result->fetch_assoc()) {
                        $choice[$hitung_choice] = $row[$attribute[$p]];
                        $hitung_choice++;
                      }
                      echo "<form action='forward.php' method='POST'><div class='form-group'><select class='form-control' name='choice'>";

                      for ($i=0; $i < $hitung_choice; $i++) { 
                        if($choice[$i]!=""){
                          echo '<option value="'.$choice[$i].'">'.$choice[$i].'</option>';
                        }
                        echo '</div>';
                      }

                      $epoch = $_POST['epoch']+1;
                      echo '</select><br><br><input type="text" name="attr" value="'.$attribute[$p].'" hidden="true"><input type="text" name="epoch" value="'.$epoch.'" hidden="true"><input type="submit" name="submit" class="btn btn-primary"><br><br></form>';
                      write_table();
                    }
                    else{
                      write_table();
                    }

                  }
                  ?>
                </div>
              </div>
            </div>
          </div>

          <table class=" table table-bordered table-dark text-center">
            <thead>
              <h4 class="m-0 font-weight-bold text-primary">Attribute Table</h4>
              <tr>
                <th>ID</th>
                <th>Attribute Name</th>
              </tr>
            </thead>
            <tbody>
              <?php $res = $db_connect->query("SELECT * FROM attr_table;"); ?>
              <?php while($row = $res->fetch_assoc()) { ?>
                <tr>
                  <?php
                  echo '<td>'.$row['id'].'</td>';
                  echo '<td>'.$row['attr_name'].'</td>';
                  ?>
                </tr>
              </tbody>
            <?php } ?>
          </table>

          <table class=" table table-bordered table-dark text-center">
            <thead>
              <h4 class="m-0 font-weight-bold text-primary">Working Memory Table</h4>
              <tr>
                <th>ID</th>
                <th>Attribute Name</th>
                <th>Attribute Value</th>
              </tr>
            </thead>
            <tbody>
              <?php $res = $db_connect->query("SELECT * FROM working_memory_table;"); ?>
              <?php while($row = $res->fetch_assoc()) { ?>
                <tr>
                  <?php
                  echo '<td>'.$row['id'].'</td>';
                  echo '<td>'.$row['attr_name'].'</td>';
                  echo '<td>'.$row['attr_value'].'</td>';
                  ?>
                </tr>
              </tbody>
            <?php } ?>
          </table>

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

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
