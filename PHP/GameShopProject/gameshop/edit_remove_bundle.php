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
	
		$id = $_POST['id'];
		$nuolaida = $_POST['nuolaida'];
		$sql = "SELECT * FROM zaidimu_rinkinys WHERE id = ".$id."";
		$result = mysqli_query($db, $sql);	
		$item = mysqli_fetch_assoc($result);	
		$sqlNuolaida = "SELECT * FROM nuolaida";
		$nuolaidaResult = mysqli_query($db, $sqlNuolaida);
		// $sql1 = "SELECT pavadinimas FROM nuolaida WHERE nuolaida.id = ".$nuolaida."";
		// $result1 = mysqli_query($db, $sql1);	
		//$cupon = mysqli_fetch_assoc($result1);	
		// echo $result1;
		
		
		if(isset($_POST['remove'])){
			mysqli_query($db, "DELETE from zaidimu_rinkinys WHERE id = $id");
				echo "<script type='text/javascript'>
				var answer = confirm (\"Sėkmingai pašalinote nuolaidos kuponą\")
				if (answer)
				window.location = 'http://localhost/gameshop/bundle_edit.php';
				else
				window.location = 'http://localhost/gameshop/bundle_edit.php';

		</script>";
		}
		elseif(isset($_POST['update'])){
			echo"<h3><a href = 'bundle_edit.php'> Atgal </a></h3>";
			echo"
			<div class=\"header\">
				<h2>Nuolaida</h2>
			</div>
			<div class=\"login_form\">
			<form method=\"POST\" enctype=\"multipart/form-data\">
				<div class=\"input-group\">
					<label>Rinkinio pavadinimas:</label>
					<input type=\"text\" id=\"pavadinimas\" name=\"pavadinimas\" value = '".$item['pavadinimas']."' required/>
					<input type=\"hidden\" name=\"id\" value=".$item['id'].">
				</div>
				<div class=\"input-group\">
					<label>Kaina:</label>
					<input type=\"number\" step = \"0.01\" id=\"kaina\" name=\"kaina\" value=".$item['kaina']." required/>
				</div>
				<div class=\"input-group\">
					<label>Turimas kiekis:</label>
					<input type=\"text\" id=\"turimasKiekis\" name=\"turimasKiekis\" value=".$item['turimas_kiekis']." required/>
				</div>
				<div class=\"input-group\">
					<label>Parduotas kiekis:</label>
					<input type=\"text\" id=\"parduotasKiekis\" name=\"parduotasKiekis\" value=".$item['parduotas_kiekis']." required/>
				</div>
				<div>
					<label>Nuolaida:</label>
					<select name=\"nuolaida\" required>";
					// <option value=".$result1['id'].">".$result1['pavadinimas']."</option>
					// <option selected disabled>Kurejas</option>
					// <option value=".$rowNuolaida['id'].">".$rowNuolaida['pavadinimas']."</option>
					echo"<option selected disabled>Kurejas</option>";					
					while($rowNuolaida = mysqli_fetch_assoc($nuolaidaResult))
					{
						echo"<option value=".$rowNuolaida['id'].">".$rowNuolaida['pavadinimas']."</option>";
					}
					echo"
					</select>
				</div>
				<div class=\"input-group\">
					<input type=\"submit\" id=\"update_button\" name=\"update_button\" value=\"Atnaujinti\" />
				</div>
			</form>
			</div>
			";
		}
		if(isset($_POST['update_button'])){
			$pavadinimas = $_POST['pavadinimas'];
			$kaina = $_POST['kaina'];
			// $nuoroda = "nuoroda";
			$turimasKiekis = $_POST['turimasKiekis'];
			$parduotasKiekis = $_POST['parduotasKiekis'];
			$nuolaida = $_POST['nuolaida'];
				$id = $_POST['id'];
				
				$sql1 = "UPDATE zaidimu_rinkinys SET pavadinimas = '".$pavadinimas."', kaina = '".$kaina."', turimas_kiekis = '".$turimasKiekis."', parduotas_kiekis = '".$parduotasKiekis."', fk_nuolaida = '".$nuolaida."' WHERE zaidimu_rinkinys.id = '".$id."'";
				// $sql2 = "UPDATE nuolaida SET pavadinimas = '".$pavadinimas."', kiekis = '".$procentai."' WHERE nuolaida.id = '".$id."'";

				$result1 = mysqli_query($db, $sql1);
				// $result2 = mysqli_query($db, $sql2);
				echo "
				<script type='text/javascript'>
				var answer = confirm (\"Sėkmingai atnaujinote prekę\")
				if (answer)
				window.location = 'http://localhost/gameshop/bundle_edit.php';
				else
				window.location = 'http://localhost/gameshop/bundle_edit.php';
				</script>";
		}

		
	}	
	?>
		
	</body>
</html>

