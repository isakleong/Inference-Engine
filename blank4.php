<?php
include 'conn/connect.php';
$result=$db_connect->query("TRUNCATE TABLE `question`");
$result=$db_connect->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'premise' AND TABLE_SCHEMA = 'asp'");
  $c=0;
  while($row=$result->fetch_assoc()) {
    $attribute[$c] = $row['COLUMN_NAME'];
    $c++;
  }
  for ($i=1; $i < $c; $i++) { 
            # code...
    $result = "INSERT INTO question (id, attribute, quiz) VALUES (null, '$attribute[$i]', '$attribute[$i]')";

    if ($db_connect->query($result) === TRUE) {
              // echo "<script> alert('Rule Successfully Added'); </script>";
    } else {
      echo $db_connect->error;
    }
  }

  echo "<script> location='blank.php'; </script>";
?>

<?php
include 'conn/connect2.php';
$result=$db_connect->query("TRUNCATE TABLE `question`");
$result=$db_connect->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'premise' AND TABLE_SCHEMA = 'coba_asp'");
  $c=0;
  while($row=$result->fetch_assoc()) {
    $attribute[$c] = $row['COLUMN_NAME'];
    $c++;
  }
  for ($i=1; $i < $c; $i++) { 
            # code...
    $result = "INSERT INTO question (id, attribute, quiz) VALUES (null, '$attribute[$i]', '$attribute[$i]')";

    if ($db_connect->query($result) === TRUE) {
              // echo "<script> alert('Rule Successfully Added'); </script>";
    } else {
      echo $db_connect->error;
    }
  }

  echo "<script> location='blank.php'; </script>";
?>