<?php
include 'conn/connect.php';

$result=$db_connect->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'premise' AND TABLE_SCHEMA = 'asp'");
$value = [];
$c=0;
while($row=$result->fetch_assoc()) {
	$attribute[$c] = $row['COLUMN_NAME'];
	$c++;
}

$res = "INSERT INTO premise (id, ";
$res2=") VALUES (null, ";
$res3="";
for($m=1; $m < $c; $m++){
	if($m==$c-1){
		$res.=$attribute[$m];
	}
	else{
		$res.=$attribute[$m].', ';
	}
}
$res.=$res2;
for ($n=1; $n < $c; $n++){
	if($n==$c-1){
		$res3.="'".$_POST[$attribute[$n]]."'";
	}
	else{
		$res3.="'".$_POST[$attribute[$n]]."', ";
	}
}
$res.=$res3.')';

if ($db_connect->query($res) === TRUE) {
	echo "<script> alert('Rule Successfully Added'); </script>";
	echo "<script> location='blank.php'; </script>";
}
else {
	echo "Error adding rule: " . $db_connect->error;
}

?>