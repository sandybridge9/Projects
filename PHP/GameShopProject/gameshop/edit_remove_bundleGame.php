<?php
	session_start();
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false){
		die("Negalima");
	}else{
		if($_SESSION['user_level'] != "buhalteris"){
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
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Game Shop</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	<head>
	
	<body>
	<div class= "title">
			<a href ="index.php"> GAME SHOP </a>
	</div>
		<div>		
			<?php
			$username = $_SESSION['username'];
			echo "
			<div class=\"llu\">
				<a href=\"buhalter.php\"> Buhalter stuff </a>
				<a href=\"profile.php\"> $username </a>
				<a href=\"logout.php\"> Logout </a>
			</div>
			";
				
			?>
		</div>
	
	<?php
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
	
		$zaidimas = $_POST['zaidimas'];
		$kolekcija = $_POST['kolekcija'];
		// echo $zaidimas;
		// echo $kolekcija;
		$sql = "SELECT * FROM zaidimu_rinkinys_zaidimas WHERE zaidimu_rinkinys_zaidimas.fk_zaidimu_rinkinys = ".$kolekcija." AND zaidimu_rinkinys_zaidimas.fk_zaidimas = ".$zaidimas."";
		$result = mysqli_query($db, $sql);	
		$item = mysqli_fetch_assoc($result);	
		$sqlKolekcija = "SELECT * FROM zaidimu_rinkinys";
		$kolekcijaResult = mysqli_query($db, $sqlKolekcija);
		$sqlZaidimas = "SELECT * FROM zaidimas";
		$zaidimasResult = mysqli_query($db, $sqlZaidimas);

		// $sql1 = "SELECT pavadinimas FROM nuolaida WHERE nuolaida.id = ".$nuolaida."";
		// $result1 = mysqli_query($db, $sql1);	
		//$cupon = mysqli_fetch_assoc($result1);	
		// echo $result1;
		
		
		if(isset($_POST['remove'])){
			mysqli_query($db, "DELETE from zaidimu_rinkinys_zaidimas WHERE zaidimu_rinkinys_zaidimas.fk_zaidimu_rinkinys = ".$kolekcija." AND zaidimu_rinkinys_zaidimas.fk_zaidimas = ".$zaidimas."");
				echo "<script type='text/javascript'>
				var answer = confirm (\"Sėkmingai pašalinote nuolaidos kuponą\")
				if (answer)
				window.location = 'http://localhost/gameshop/bundleGame_edit.php';
				else
				window.location = 'http://localhost/gameshop/bundleGame_edit.php';

		</script>";
		}
		elseif(isset($_POST['update'])){
			echo"<h3><a href = 'bundleGame_edit.php'> Atgal </a></h3>";
			echo"
			<div class=\"header\">
				<h2>Nuolaida</h2>
			</div>
			<div class=\"login_form\">
			<form method=\"POST\" enctype=\"multipart/form-data\">
			<div>
			<label>Kolekcija:</label>
			<select name=\"kolekcija\" required>";
			echo"<option selected disabled>Kolekcija</option>";					
			while($rowKolekcija = mysqli_fetch_assoc($kolekcijaResult))
			{
				echo"<option value=".$rowKolekcija['id'].">".$rowKolekcija['pavadinimas']."</option>";
			}
			echo"
			</select>
			</div>
			<div>
			<label>Žaidimas:</label>
			<select name=\"zaidimas\" required>";
			echo"<option selected disabled>Žaidimas</option>";					
			while($rowZaidimas = mysqli_fetch_assoc($zaidimasResult))
			{
				echo"<option value=".$rowZaidimas['id'].">".$rowZaidimas['pavadinimas']."</option>";
			}
			echo"
			</select>
			</div>

				
				<div class=\"input-group\">
					<input type=\"hidden\" name=\"kolid\" value=".$kolekcija.">
					<input type=\"hidden\" name=\"zaiid\" value=".$zaidimas.">
					<input type=\"submit\" id=\"update_button\" name=\"update_button\" value=\"Atnaujinti\" />
				</div>
			</form>
			</div>
			";
		}
		if(isset($_POST['update_button'])){
			$kolekcija2 = $_POST['kolekcija'];
			$zaidimas2 = $_POST['zaidimas'];
			$kolekcija = $_POST['kolid'];
			$zaidimas = $_POST['zaiid'];
				$sql1 = "UPDATE zaidimu_rinkinys_zaidimas SET fk_zaidimu_rinkinys = '".$kolekcija2."', fk_zaidimas = '".$zaidimas2."' WHERE fk_zaidimu_rinkinys = '".$kolekcija."' AND fk_zaidimas = '".$zaidimas."'";

				$result1 = mysqli_query($db, $sql1);
				echo "
				<script type='text/javascript'>
				var answer = confirm (\"Sėkmingai atnaujinote prekę\")
				if (answer)
				window.location = 'http://localhost/gameshop/bundleGame_edit.php';
				else
				window.location = 'http://localhost/gameshop/bundleGame_edit.php';
				</script>";
		}

		
	}	
	?>
		
	</body>
</html>

