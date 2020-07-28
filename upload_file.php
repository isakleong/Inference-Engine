<?php

    if ( 0 < $_FILES['file']['error'] ) {
        echo 'a';
    }
    else {
        move_uploaded_file($_FILES['file']['tmp_name'], 'upload/' . $_FILES['file']['name']);
        echo 'upload/' . $_FILES['file']['name'];

        $row = 1;
        $path = $_FILES['file']['name'];
        if (($handle = fopen("upload/Book1.csv", "r")) !== FALSE) {
        	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        		$num = count($data);
        		echo "<p> $num fields in line $row: <br /></p>\n";
        		$row++;
        		for ($c=0; $c < $num; $c++) {
        			echo $data[$c] . "<br />\n";
        		}
        	}
        	fclose($handle);
        }
    }
?>