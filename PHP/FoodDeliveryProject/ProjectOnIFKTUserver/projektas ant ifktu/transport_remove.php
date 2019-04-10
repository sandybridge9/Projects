<!DOCTYPE html>
<?php session_start();
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false){
		die("Negalima");
	}else{
		if($_SESSION['user_level'] != "isveziotojas"){
			echo "<script type='text/javascript'>
				var answer = confirm (\"Neturite teisių šiai funkcijai\")
				if (answer)
				window.location = '/index.php';
				else
				window.location = '/index.php';

		</script>";
		}else{
		$db=mysqli_connect("localhost", "tadlau", "veel0bo6shiuJ3Ch", "tadlau");
		if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($dbc)); }
		}
	} ?>
<html>
	<head>
		<title>Maisto užsakymų svetainė</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	<head>
	
	<body>
	<div class= "title">
			<a href ="index.php"> Maisto užsakymų svetainė </a>
		</div>
		<div>		
		<?php
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			
		if(isset($_POST['remove'])){
			$prekesId = $_POST['prekes_id'];
			echo"$prekesId";
			$uzsakymoId = $_POST['uzsakymo_id'];
			echo"$uzsakymoId";
			$result = mysqli_query($db, "DELETE from transportuojama_preke WHERE prekes_id = ".$prekesId." AND uzsakymo_id = ".$uzsakymoId."");
			echo "
			<script type='text/javascript'>
			var answer = confirm (\"Sėkmingai pašalinote prekę iš transporto bagažo\")
			if (answer)
			window.location = '/transporting_list.php';
			else
			window.location = '/index.php';
			</script>";
		}
	}	
	?>	
	</body>
</html>