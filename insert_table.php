<?php
include 'conn/connect/php';

if(isset($_POST['add_table'])){
  echo "<script> alert('MASUK'); </script>";
  $sql = "DROP TABLE if EXISTS premise";
  if ($db_connect->query($sql) === TRUE) {
  } else {
    echo "Error Deleting Table: " . $db_connect->error;
  }

  $sql = "CREATE TABLE premise(id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, ";
  for($i=0; $i < $_SESSION['jumlah_kolom']-1; $i++){
    $temp = $i+1;
    $var = $_SESSION['attr'.$temp];
    if($i==$_SESSION['jumlah_kolom']-2){
      $sql = $sql.$var.' VARCHAR(30)';
    }
    else{
      $sql = $sql.$var.' VARCHAR(30), ';
    }
  }
  $sql = $sql. ");";
  if ($db_connect->query($sql) === TRUE) {
    echo "<script> alert('Table Successfully Added'); </script>";
    echo "<script> location='blank3.php'; </script>";
  } else {
    echo "Error creating table: " . $db_connect->error;
  }
}

?>