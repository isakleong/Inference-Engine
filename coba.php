<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script>
		$(function () {
			$('form').on('submit', function (e) {
				e.preventDefault();
				$.ajax({
					type: 'post',
					url: 'insert_column.php',
					data: $('form').serialize(),
					success: function () {
						for ($i=0; $i < $_POST['jumlah_kolom']; $i++) { 
							$k = $i+1;
							echo "Kolom ".$k."<br>";
							if($k == 1){
								echo '<input type="text" name="attr'.$k.'" placeholder="id"><br><br>';
							}
							else if($k == $jumlah_kolom){
								echo '<input type="text" name="attr'.$k.'" placeholder="result"><br><br>';
							}
							else{
								echo '<input type="text" name="attr'.$k.'"><br><br>';
							}
						}
						alert('form was submitted');
					}
				});

			});

		});
	</script>
</head>
<body>
	<form method="POST">
		Input Kolom : <br><input type="number" name="jumlah_kolom" min="2">
		<br>
		<br>
		<input type="submit">

	</form>

	<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>