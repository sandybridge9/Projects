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
			
			echo"<h3><a href = 'profile.php'> Atgal </a></h3>";
			echo"
			<div class=\"header\">
				<h2>Transporto priemonė</h2>
			</div>
			<div class=\"login_form\">
			<form method=\"POST\" enctype=\"multipart/form-data\">		
			<div class=\"input-group\">
			<label>Maksimalus vežamas svoris(gramais):</label>
			<input type=\"text\" id=\"talpa\" name=\"talpa\" />
			</div>	
			<div class=\"input-group\">
			<input type=\"submit\" id=\"update_button\" name=\"update_button\" value=\"Atnaujinti\" />
			</div>
			</form>
			</div>
			";
		}
		
		if(isset($_POST['update_button'])){
				$talpa = $_POST['talpa'];
				$vartotojoId = $_SESSION['user_id'];

				$sql = "UPDATE transportas SET talpa='".$talpa."' WHERE vairuotojo_id=".$vartotojoId."";
				$result = mysqli_query($db, $sql);
				$_POST = null;
				echo "
				<script type='text/javascript'>
				var answer = confirm (\"Sėkmingai atnaujinote transporto priemonės maksimalų krūvį\")
				if (answer)
				window.location = '/profile.php';
				else
				window.location = '/index.php';
				</script>";
		}	
	?>	
	</body>
</html>