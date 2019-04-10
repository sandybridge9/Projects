<!DOCTYPE html>
<?php session_start();
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false){
		die("Negalima");
	}else{
		if($_SESSION['user_level'] != "vartotojas"){
			echo "<script type='text/javascript'>
				var answer = confirm (\"Neturite teisių šiai funkcijai\")
				if (answer)
				window.location = 'http://localhost/gameshop/index.php';
				else
				window.location = 'http://localhost/gameshop/index.php';

		</script>";
		}else{
		$db=mysqli_connect("localhost", "root", "", "it");
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
			$vartotojoId = $_SESSION['user_id'];
			$result = mysqli_query($db, "DELETE from krepselio_preke WHERE prekes_id = ".$prekesId." AND vartotojo_id = ".$vartotojoId."");
			echo "
			<script type='text/javascript'>
			var answer = confirm (\"Sėkmingai pašalinote prekę iš krepšelio\")
			if (answer)
			window.location = 'http://localhost/projektas/cart.php';
			else
			window.location = 'http://localhost/projektas/index.php';
			</script>";
		}
		elseif(isset($_POST['update'])){
			$prekesId = $_POST['prekes_id'];
			$vartotojoId = $_SESSION['user_id'];
			echo"<h3><a href = 'cart.php'> Atgal </a></h3>";
			echo"
			<div class=\"header\">
				<h2>Krepšelis</h2>
			</div>
			<div class=\"login_form\">
			<form method=\"POST\" enctype=\"multipart/form-data\">		
			<div class=\"input-group\">
			<label>Kiekis:</label>
			<input type=\"text\" id=\"kiekis\" name=\"kiekis\" />
			<input type=\"hidden\" name=\"prekes_id\" value=".$prekesId.">
			</div>	
			<div class=\"input-group\">
			<input type=\"submit\" id=\"update_button\" name=\"update_button\" value=\"Atnaujinti\" />
			</div>
			</form>
			</div>
			";
		}
		
		if(isset($_POST['update_button'])){
				$prekesId = $_POST['prekes_id'];
				$vartotojoId = $_SESSION['user_id'];
				$kiekis = $_POST['kiekis'];
				$sql = "UPDATE krepselio_preke SET kiekis='".$kiekis."' WHERE prekes_id=".$prekesId." AND vartotojo_id=".$vartotojoId."";
				$result = mysqli_query($db, $sql);
				$_POST = null;
				echo "
				<script type='text/javascript'>
				var answer = confirm (\"Sėkmingai atnaujinote krepšelio prekę\")
				if (answer)
				window.location = 'http://localhost/projektas/cart.php';
				else
				window.location = 'http://localhost/projektas/index.php';
				</script>";
		}		
	}	
	?>	
	</body>
</html>