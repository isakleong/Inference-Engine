<?php
include 'koneksi.php';

$koneksi->query("INSERT INTO question (id, attribute, question) VALUES (null, '$_POST[attribute]','$fileName','$_POST[question]')");
echo "<script> alert('Question Successfully Added'); </script>";
echo "<script> location='blank.php'; </script>";
}

?>

