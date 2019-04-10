<!DOCTYPE html>
<?php session_start();
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false){
		die("Negalima");
	}else{
		if($_SESSION['user_level'] != "registruotas_vartotojas"){
			echo "<script type='text/javascript'>
				var answer = confirm (\"Neturite teisių šiai funkcijai\")
				if (answer)
				window.location = 'http://localhost/gameshop/index.php';
				else
				window.location = 'http://localhost/gameshop/index.php';

		</script>";
		}else{
		$db=mysqli_connect("localhost", "root", "", "is");
		if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($dbc)); }
		}
	} ?>
<html>
	<head>
		<title>Game shop</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	<head>
	
	<body>
	<div class= "title">
			<a href ="index.php"> GAME SHOP </a>
		</div>
		<div>		
		<?php
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			
		if(isset($_POST['buy'])){

			$userId = $_SESSION['user_id'];
			$sql = "SELECT * FROM uzsakymas WHERE fk_vartotojas = ".$userId."";
			$result = mysqli_query($db, $sql);
			while($uzsakymai = mysqli_fetch_assoc($result))
			{
				$uzsakymoNr = $uzsakymai['id'];
				$sql1 = "SELECT * FROM uzsakymas_zaidimas WHERE fk_uzsakymas = ".$uzsakymoNr."";
				$result1 = mysqli_query($db, $sql1);
				$uzsakymas_zaidimas = mysqli_fetch_assoc($result1);
				$zaidimoId = $uzsakymas_zaidimas['fk_zaidimas'];
				$sql2 = "INSERT INTO zaidimas_vartotojas (fk_zaidimas, fk_vartotojas) VALUES ('$zaidimoId', '$userId')";
				$result2 = mysqli_query($db, $sql2);
				$result3 = mysqli_query($db, "DELETE from uzsakymas_zaidimas WHERE fk_uzsakymas = ".$uzsakymoNr."");
			}
			$result4 = mysqli_query($db, "DELETE from uzsakymas WHERE fk_vartotojas = ".$userId."");

			echo "
			<script type='text/javascript'>
			var answer = confirm (\"Sėkmingai sumokejote uz užsakymą\")
			if (answer)
			window.location = 'http://localhost/gameshop/cart.php';
			else
			window.location = 'http://localhost/gameshop/index.php';
			</script>";
		}
	}	
	?>	
	</body>
</html>