<?php
include 'conn/connect.php';
session_start();

for($k=0; $k < $_SESSION['upload_kolom']; $k++){

}

for($i=0; $i < $_SESSION['upload_row']; $i++){
 $j = $i+1;
 for($k=0; $k < $_SESSION['upload_kolom']; $k++){
   $l = $k+1;
   echo $_POST["row".$j."col".$l];
 }
}

// $res = $db_connect->query("SELECT COUNT(*) as total FROM 'premise'");
// echo mysql_result($res, 0);


// if ($db_connect->query($sql) === TRUE) {
//     echo "<script> alert('Rule Successfully Added'); </script>";
// } else {
//     echo "Error creating table: " . $db_connect->error;
// }

?>