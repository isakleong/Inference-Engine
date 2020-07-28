<?php
	$hostname = "localhost";
	$username = "root";
	$password = "";
	$database = "coba_asp";

	$db_connect=mysqli_connect($hostname,$username,$password,$database);
	if ($db_connect->connect_error) {
		echo "Connection error:" .$db_connect->connect_error."<br><br>";
	}
?>