<!DOCTYPE html>
<?php session_start(); ?>
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
					$username = $_SESSION['username'];
					if($_SESSION['user_level'] == "isveziotojas"){
						echo "
						<div class=\"llu\">
							<a href=\"cart.php\"> Prekių bagažas </a>
							<a href=\"profile.php\"> $username </a>
							<a href=\"logout.php\"> Logout </a>
						</div>
						";
					}
					$db = mysqli_connect("localhost", "root", "", "it") or die("Unable to connect to db");
					if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($db)); }
				}else{
					echo "
						<div class=\"llu\">
							<a href=\"login.php\"> Login </a>
							<a href=\"register.php\"> Register </a>
						</div>
					";
				}
			?>	
		</div>
		
		<?php
		if(isset($_POST['transport'])){
			$userId = $_SESSION['user_id'];
			$uzsakymoId = $_POST['uzsakymo_id'];
			$prekesId = $_POST['prekes_id'];

			$sql1 = "SELECT * FROM uzsakyta_preke WHERE uzsakymo_id = ".$uzsakymoId." AND prekes_id = ".$prekesId."";
			$result1 = mysqli_query($db, $sql1);
			$uzsakytaPreke = mysqli_fetch_assoc($result1);
			$kiekis = $uzsakytaPreke['kiekis'];

			$sql2 = "SELECT * FROM transportas WHERE vairuotojo_id = ".$userId."";
			$result2 = mysqli_query($db, $sql2);
			$transportas = mysqli_fetch_assoc($result2);
			$transportoId = $transportas['id'];

			$sql = "INSERT INTO transportuojama_preke (prekes_id, kiekis, uzsakymo_id, transporto_id) VALUES ('$prekesId', '$kiekis', '$uzsakymoId', '$transportoId')";
			$result = mysqli_query($db, $sql);

			$_POST = null;
			echo "
			<script type='text/javascript'>
			var answer = confirm (\"Sėkmingai pridėjote prekę į bagažą\")
			if (answer)
			window.location = 'http://localhost/projektas/index.php';
			else
			window.location = 'http://localhost/projektas/index.php';
			</script>";
			}else if(isset($_POST['transport_all'])){
				$userId = $_SESSION['user_id'];
				$uzsakymoId = $_POST['uzsakymo_id'];
				$prekesId = $_POST['prekes_id'];

				$sql1 = "SELECT * FROM uzsakymas WHERE uzsakymo_id = ".$uzsakymoId."";
				$result1 = mysqli_query($db, $sql1);
				$uzsakymas = mysqli_fetch_assoc($result1);
				$vartotojoId = $uzsakymas['vartotojo_id'];

				$sql2 = "SELECT * FROM transportas WHERE vairuotojo_id = ".$userId."";
				$result2 = mysqli_query($db, $sql2);
				$transportas = mysqli_fetch_assoc($result2);
				$transportoId = $transportas['id'];
				echo"$vartotojoId";
				$sql = "SELECT * FROM uzsakyta_preke WHERE vartotojo_id = ".$vartotojoId."";
				$result = mysqli_query($db, $sql);

				while($row = mysqli_fetch_assoc($result)){
					$prekes_id = $row['prekes_id'];
					$uzsakymo_id = $row['uzsakymo_id'];
					$kiekis = $row['kiekis'];

					$sql3 = "INSERT INTO transportuojama_preke (prekes_id, kiekis, uzsakymo_id, transporto_id) VALUES ('$prekes_id', '$kiekis', '$uzsakymo_id', '$transportoId')";
					$result3 = mysqli_query($db, $sql3);
				}
			$_POST = null;/*
			echo "
			<script type='text/javascript'>
			var answer = confirm (\"Sėkmingai pridėjote prekę į krepšelį\")
			if (answer)
			window.location = 'http://localhost/projektas/index.php';
			else
			window.location = 'http://localhost/projektas/index.php';
			</script>
			";*/
			}
		?>
	</body>
</html>