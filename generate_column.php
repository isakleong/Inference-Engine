<?php
$inputan = json_decode($_POST['resume'], true);
echo $inputan->inputan[0]->attr1;

?>