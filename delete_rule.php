<?php 
include 'conn/connect.php';
$res = "DELETE FROM premise ORDER BY id DESC LIMIT 1";

if ($db_connect->query($res) === TRUE) {
	echo "<script> alert('Rule Successfully Deleted'); </script>";
	echo "<script> location='blank.php'; </script>";
}
else {
	echo "Error deleting rule: " . $db_connect->error;
}
?>