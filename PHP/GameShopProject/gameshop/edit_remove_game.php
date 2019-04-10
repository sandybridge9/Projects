<?php
	session_start();
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false){
		die("Negalima");
	}else{
		if($_SESSION['user_level'] != "administratorius"){
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
	<div>
	</div>
	
	<?php
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
	
		$id = $_POST['id'];
		$sql = "SELECT * FROM zaidimas WHERE id = ".$id."";
		$result = mysqli_query($db, $sql);	
		$item = mysqli_fetch_assoc($result);
		
		$sqlNuolaida = "SELECT * FROM Nuolaida";
		$nuolaidaResult = mysqli_query($db, $sqlNuolaida);
		
		$sqlKurejas = "SELECT * FROM Kurejas";
		$kurejasResult = mysqli_query($db, $sqlKurejas);
		
		
		
		if(isset($_POST['remove'])){
			$resutl = mysqli_query($db, "DELETE from zaidimas WHERE id = ".$id." ");
				echo "<script type='text/javascript'>
				var answer = confirm (\"Sėkmingai pašalinote prekę\")
				if (answer)
				window.location = 'http://localhost/gameshop/admin_games_data_edit.php';
				else
				window.location = 'http://localhost/gameshop/admin_games_data_edit.php';

		</script>";
		}
		elseif(isset($_POST['update'])){
			echo"<h3><a href = 'admin_games_data_edit.php'> Atgal </a></h3>";
			echo"
			<div class=\"header\">
				<h2>Žaidimas</h2>
			</div>
			<div class=\"login_form\">
			<form method=\"POST\" enctype=\"multipart/form-data\">
				<div class=\"input-group\">
					<label>Prekės pavadinimas:</label>
					<input type=\"text\" id=\"pavadinimas\" name=\"pavadinimas\" value = '".$item['pavadinimas']."' required/>
				</div>
				<div class=\"input-group\">
					<label>Data:</label>
					<input type=\"date\" id=\"isleidimo_data\" name=\"isleidimo_data\" value=".$item['isleidimo_data']." required/>
				</div>
				<div class=\"input-group\">
					<label>Žaidimo kaina:</label>
					<input type=\"number\" step = \"0.01\" id=\"kaina\" name=\"kaina\" value = ".$item['kaina']." required/>
				</div>
				<div class=\"input-group\">
					<label>Žaidimo aprašymas:</label>
					<input type=\"text\" id=\"aprasymas\" name=\"aprasymas\" value = '".$item['aprasymas']."' required/>
				</div>
				<div class=\"input-group\">
					<label>Viršelio nuoroda:</label>
					<input type=\"text\" id=\"virselio_nuoroda\" name=\"virselio_nuoroda\" value = '".$item['virselio_nuoroda']."' required/>
				</div>
				<div class=\"input-group\">
					<label>Turimas kiekis:</label>
					<input type=\"number\" step = \"0.01\" id=\"turimas_kiekis\" name=\"turimas_kiekis\" value = ".$item['turimas_kiekis']." required/>
				</div>
				<div class=\"input-group\">
					<label>Parduotas kiekis:</label>
					<input type=\"number\" step = \"0.01\" id=\"parduotas_kiekis\" name=\"parduotas_kiekis\" value = ".$item['parduotas_kiekis']." required/>
					
					<input type=\"hidden\" name=\"id\" value=".$item['id'].">
				</div>
				
				<div>
					<label>fk_kurejas:</label>
					<select name=\"fk_kurejas\" required>
					<option selected disabled>Kurejas</option>";					
					while($rowKurejas = mysqli_fetch_assoc($kurejasResult))
					{
						echo"<option value=".$rowKurejas['id'].">".$rowKurejas['pavadinimas']."</option>";
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
				$isleidimo_data = $_POST['isleidimo_data'];
				$kaina = $_POST['kaina'];
				$aprasymas = $_POST['aprasymas'];
				$virselio_nuoroda = $_POST['virselio_nuoroda'];
				$turimas_kiekis = $_POST['turimas_kiekis'];
				$parduotas_kiekis = $_POST['parduotas_kiekis'];
				$fk_kurejas = $_POST['fk_kurejas'];
				$fk_nuolaida =	null;
				//echo $_POST['fk_nuolaida'];
				//if(isset($_POST['fk_nuolaida'])){
				//	$fk_nuolaida = $_POST['fk_nuolaida'];
				//}else{
				//	$fk_nuolaida =	null;
				//}
				
				$id = $_POST['id'];
				
				if($fk_nuolaida != null){
					$sql = "UPDATE zaidimas SET pavadinimas='".$pavadinimas."', isleidimo_data='".$isleidimo_data."', kaina='".$kaina."', aprasymas='".$aprasymas."', virselio_nuoroda='".$virselio_nuoroda."',
					turimas_kiekis='".$turimas_kiekis."', parduotas_kiekis='".$parduotas_kiekis."', fk_kurejas='".$fk_kurejas."', fk_nuolaida='".$fk_nuolaida."' WHERE id=".$id."";
					echo $sql;
				}else{
					$sql = "UPDATE zaidimas SET pavadinimas='".$pavadinimas."', isleidimo_data='".$isleidimo_data."', kaina='".$kaina."', aprasymas='".$aprasymas."', virselio_nuoroda='".$virselio_nuoroda."',
					turimas_kiekis='".$turimas_kiekis."', parduotas_kiekis='".$parduotas_kiekis."', fk_kurejas='".$fk_kurejas."' WHERE id=".$id."";
					echo $sql;
				}
				$result = mysqli_query($db, $sql);
				$_POST = null;
				echo "
				<script type='text/javascript'>
				var answer = confirm (\"Sėkmingai atnaujinote prekę\")
				if (answer)
				window.location = 'http://localhost/gameshop/admin_games_data_edit.php';
				else
				window.location = 'http://localhost/gameshop/admin_games_data_edit.php';
				</script>";
		}

		
	}	
	?>
		
	</body>
</html>

<!--
	<div>
				<label>fk_nuolaida:</label>
					<select name=\"fk_kurejas\" required>
					<option selected disabled>Nuolaida</option>";	
					while($rowNuolaida = mysqli_fetch_assoc($nuolaidaResult))
					{
						echo"<option value=".$rowNuolaida['id'].">".$rowNuolaida['pavadinimas']."</option>";
					}
					echo"
					</select>
				</div>
-->

<!--
				
				
				<div class=\"input-group\">
					<label>Prekės tipas:</label>
					<input type=\"text\" id=\"type\" name=\"type\" value = '".$item['type']."' required/>
					<input type=\"hidden\" id=\"item_id\" name=\"item_id\" value=".$item['id'].">
				</div>
				
				<div class=\"input-group\">
					<label>Nuotrauka:</label>
					<input type=\"file\" id=\"picture\" name=\"picture\" accept=\"image/png\">
				</div>
		
		
		-->