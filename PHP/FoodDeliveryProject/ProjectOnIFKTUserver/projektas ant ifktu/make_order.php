<!DOCTYPE html>
<?php session_start();
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false){
		die("Negalima");
	}else{
		if($_SESSION['user_level'] != "vartotojas"){
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
			
		if(isset($_POST['order'])){
			$userId = $_SESSION['user_id'];
			$adresas = $_POST['adresas'];
			$miestas = $_POST['miestas'];
			$data = "2018-12-19";
			$busena = "Laukiama";

			$sql = "INSERT INTO uzsakymas (vartotojo_id, data, miestas, adresas, busena) VALUES ('$userId', '$data', '$miestas', '$adresas', '$busena')";
			$result = mysqli_query($db, $sql);

			$sql1 = "SELECT * FROM krepselio_preke WHERE vartotojo_id = ".$userId."";
			$result1 = mysqli_query($db, $sql1);

			while($krepselioPreke = mysqli_fetch_assoc($result1))
			{
				$prekesId = $krepselioPreke['prekes_id'];
				$kiekis = $krepselioPreke['kiekis'];
				$sql2 = "SELECT * FROM uzsakymas WHERE vartotojo_id = ".$userId."";
				$result2 = mysqli_query($db, $sql2);
				$uzsakymas = mysqli_fetch_assoc($result2);
				$uzsakymoId = $uzsakymas['id'];
				
				$sql3 = "INSERT INTO uzsakyta_preke (uzsakymo_id, vartotojo_id, prekes_id, kiekis) VALUES ('$uzsakymoId', '$userId', '$prekesId', '$kiekis')";
				$result2 = mysqli_query($db, $sql3);
				$result3 = mysqli_query($db, "DELETE from krepselio_preke WHERE prekes_id = ".$prekesId." AND vartotojo_id = ".$userId."");
			}
			echo "
			<script type='text/javascript'>
			var answer = confirm (\"Sėkmingai sukūrėte užsakymą\")
			if (answer)
			window.location = '/order_list.php';
			else
			window.location = '/index.php';
			</script>";
		}
	}	
	?>	
	</body>
</html>