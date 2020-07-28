<?php
include "conn/connect2.php";
$ketemu = false;
if(isset($_POST['choice'])){

	$epoch = $_POST['epoch']-1;
	// if($epoch == 1){
	// 	$input=array($_POST['attr']=>array("$_POST['choice']"));
	// }else{
	// 	array_push($input, $_POST['attr']=>array("$_POST['choice']"));
	// }

	$input=array($_POST['attr']=>array($_POST['choice']));
	$ketemu = forward($input, $epoch);
}


//#################################### GENERATE RULE TABLE FROM PREMISE TABLE ####################################

function generate_rule_table(){
	include "conn/connect2.php";
	//mengambil kolom apa saja yang ada di premise dan jumlahnya
	$result=$db_connect->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'premise' AND TABLE_SCHEMA = 'coba_asp'");
	$c = 0;
	while($row=$result->fetch_assoc()) {
		$attribute[$c] = $row['COLUMN_NAME'];
		$c++;
	}

	// array_shift($attribute);
	// $c = count($attribute);


	// for ($i=0; $i <$c ; $i++) { 
	// 	# code...
	// 	echo $attribute[$i]."<br>";
	// }

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

	//jumlah premis per baris rule
	// for ($i=1; $i <= $baris ; $i++) { 
	// 	echo $jumlah_premis[$i];
	// }

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
	echo '<style type="text/css">
	table, th, td{
		border: 1px solid black;
		border-collapse: collapse;
		border-spacing: 5px;
		padding: 5px;
	}
	</style>

	<form method="POST" action="index3.php">
	<table style="width:100%">
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


	echo '	<th>rule_id</th>
	<th>rule_number</th>
	<th>rule_status</th>
	<th>prem_clause_num</th>
	<th>prem_clause_stat</th>
	</tr>';


	$result=$db_connect->query("SELECT count(*) FROM `rule_table`");
	while($row=$result->fetch_assoc()) {
		$baris_rule = $row['count(*)'];
	}

	for ($i=0; $i < $baris_rule; $i++) { 
	# code...
		echo "<tr>";
		echo "<th>".$rule_id[$i]."</th>";
		echo "<th>".$rule_number[$i]."</th>";
		echo "<th>".$rule_status[$rule_number[$i]]."</th>";
		echo "<th>".$prem_clause_num[$i]."</th>";
		echo "<th>".$prem_clause_stat[$i]."</th>";
		echo "</tr>";
	}
}


//################################################ Forward Start #############################################################

//array inputan
// $input=array(
// 	"Layar"=>array("Touch"),
// 	"Proc"=>array("Portable"),
// 	"Battery"=>array("Low"),
// 	"Pen"=>array("Noneee")
// );


function forward($input, $i)
{
	include "conn/connect2.php";
	$len = count($input);
	//print_r($input[0]);

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
						echo $attribute[$tempco]." = ".$hasil."<br><br>";
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


// $input=array(
// 	"engine_type"=>array("jet"),
// 	"wing_position"=>array("high"),
// 	"bulges"=>array("none")
// );



$input=array();
$result=$db_connect->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'premise' AND TABLE_SCHEMA = 'coba_asp'");
$c = 0;
while($row=$result->fetch_assoc()) {
	$attribute[$c] = $row['COLUMN_NAME'];
	$c++;
}



if(!isset($_POST['epoch'])) { 
	generate_rule_table();
	echo "Question 1 : ".$attribute[1]."<br><br>";
	$_POST['epoch'] = 1;
	$result=$db_connect->query("SELECT DISTINCT `$attribute[1]` FROM `premise`");
	$hitung_choice=0;
	while($row=$result->fetch_assoc()) {
		$choice[$hitung_choice] = $row[$attribute[1]];
		$hitung_choice++;
	}
	echo "<form action='home.php' method='POST'><select name='choice'>";

	for ($i=0; $i < $hitung_choice; $i++) { 
		# code...
		if($choice[$i]!=""){
			echo '<option value="'.$choice[$i].'">'.$choice[$i].'</option>';
		}
		

	}
	$epoch = $_POST['epoch']+1;

	echo '</select><br><br><input type="text" name="attr" value="'.$attribute[1].'" hidden="true"><input type="text" name="epoch" value="'.$epoch.'" hidden="true"><input type="submit" name="submit"></form>';

	write_table();
	


}else{
	if(!$ketemu){
		$p = $_POST['epoch'];
		echo "Question ".$p." : ".$attribute[$p]."<br><br>";
		$result=$db_connect->query("SELECT DISTINCT `$attribute[$p]` FROM `premise`");
		$hitung_choice=0;
		while($row=$result->fetch_assoc()) {
			$choice[$hitung_choice] = $row[$attribute[$p]];
			$hitung_choice++;
		}
		echo "<form action='home.php' method='POST'><select name='choice'>";

		for ($i=0; $i < $hitung_choice; $i++) { 
			# code...
			if($choice[$i]!=""){
				echo '<option value="'.$choice[$i].'">'.$choice[$i].'</option>';
			}

		}


		$epoch = $_POST['epoch']+1;
		echo '</select><br><br><input type="text" name="attr" value="'.$attribute[$p].'" hidden="true"><input type="text" name="epoch" value="'.$epoch.'" hidden="true"><input type="submit" name="submit"></form>';

		write_table();
	}
	else{
		write_table();
	}
	
}

//$i = forward($input, 1);


// }

// $hasil_attr = $attribute[$counter-1];
// if(!$check){
// 	echo "Answer Not Found";
// }
// else{
// 	$cursor = $db_connect->query("SELECT `$hasil_attr` FROM `premise` WHERE `id` = '$rule_benar'");
// 	while($row=$cursor->fetch_assoc()) {
// 		$answer = $row['plane'];
// 	}
// 	echo $hasil_attr." : ".$answer;

// }


// $find=0;
// $notfound=false;
// $cek_ada = $db_connect->query("SELECT * from rule_status");
// while($row_cek_ada = $cek_ada->fetch_assoc()){
// 	if(($row_cek_ada['rule_status'] == "A,M") || ($row_cek_ada['rule_status'] == "U,D")){
// 		$find++;
// 	}
// }
// $cek_baris = $db_connect->query("SELECT count(*) from premise");
// while($row_cek_baris = $cek_baris->fetch_assoc()){
// 	$baris = $row_cek_baris['count(*)'];
// }

// if($find == $baris){
// 	$notfound=true;
// }
// if($notfound)
// 	echo "Answer Not Found";


?>