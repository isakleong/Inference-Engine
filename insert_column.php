<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<?php
$jumlah_kolom = $_POST['jumlah_kolom'];

session_start();

// echo '<form method="POST" name="form_table">';
for ($i=0; $i < $jumlah_kolom; $i++) { 
	# code...
	$k = $i+1;
	echo "<div class='form-group'>";
	echo "Kolom ".$k."<br>";
	if($k == 1){
		echo '<input class="form-control form_input" type="text" id="attr'.$k.'" name="attr'.$k.'" placeholder="id"><br><br>';
	}
	else if($k == $jumlah_kolom){
		echo '<input class="form-control form_input" type="text" id="attr'.$k.'" name="attr'.$k.'" placeholder="result"><br><br>';
	}
	else{
		echo '<input class="form-control form_input" type="text" id="attr'.$k.'" name="attr'.$k.'"><br><br>';
	}
	echo "</div>";
}
echo '<input type="text" name="jumlah_kolom" value="'.$jumlah_kolom.'" hidden="true">';
// echo '<input type="submit" class="btn btn-success" value="Submit" id="add_new_table"></form>';
echo '<button class="btn btn-success" id="add_new_table">Submit</button>';
$_SESSION['jumlah_kolom'] = $jumlah_kolom;

?>

<script>
	$(document).ready(function(){
		$("#add_new_table").click(function(e){
			e.preventDefault();
			var inputan = [];
			var input = {};
			// $(".form_input").each(function() {
			// 	inputan.push($(this).val());
			// });
			$(".form_input").each(function(){
				input[this.name] = this.value;
				inputan.push(input[this.name]);
			});
			// var send_data = {
			// 	'jumlah_kolom' : $("#jumlah_kolom").val(),
			// 	'inputan' : inputan
			// }
			var resume = JSON.stringify({
				jumlah_kolom: $("#jumlah_kolom").val(),
				inputan: inputan
			});
			console.log(resume);

			//var jumlah_kolom = $("#jumlah_kolom").val();
			//var attr = $("#attr").val();
			
			// var i=0;
			// var attr = [];
			// for(i=1; i <= jumlah_kolom; i++){
			// 	var temp = $("#attr" + i).val();
			// 	attr[i] = temp;
			// 	console.log(attr[i]);
			// }

			// var attr = {}
			// $('form :input:text[name^="attr"]').each(function(){
			// 	attr[this.name] = this.value;
			// });
			// console.log(attr[1]);

			$.ajax({
				url:'generate_column.php',
				method : 'POST',
				dataType: "json",
				// data: JSON.stringify(send_data),
				data: {resume:resume},
				// data: {
				// 	jumlah_kolom:jumlah_kolom,
				// 	attr1: attr
				// },
				success : function(data){
					$("#fill_table").html(data);
					// $('#column').modal('hide');
					alert("Column Successfully Added");
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(thrownError);
				}
			});

		});
	});    
</script>

