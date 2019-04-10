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
		$sql = "SELECT * FROM uzsakymas WHERE id = ".$id."";
		$result = mysqli_query($db, $sql);	
		$item = mysqli_fetch_assoc($result);
		
		$sqlNuolaida = "SELECT * FROM Nuolaida";
		$nuolaidaResult = mysqli_query($db, $sqlNuolaida);
		
		$sqlKurejas = "SELECT * FROM vartotojas";
		$kurejasResult = mysqli_query($db, $sqlKurejas);
		
		
		
		if(isset($_POST['remove'])){
			$id = $_POST['id'];
			$resutl = mysqli_query($db, "DELETE from uzsakymas WHERE id = ".$id." ");
			echo "
			<script type='text/javascript'>
			var answer = confirm (\"Sėkmingai pašalinote užsakymą\")
			if (answer)
			window.location = 'http://localhost/gameshop/admin_game_order_data_edit.php';
			else
			window.location = 'http://localhost/gameshop/admin_game_order_data_edit.php';
			</script>";
		}
		elseif(isset($_POST['update'])){
			echo"<h3><a href = 'admin_games_data_edit.php'> Atgal </a></h3>";
			echo"
			<div class=\"header\">
				<h2>Užsakymas</h2>
			</div>
			<div class=\"login_form\">
			<form method=\"POST\" enctype=\"multipart/form-data\">
				<div class=\"input-group\">
					<label>Data:</label>
					<input type=\"date\" id=\"uzsakymo_data\" name=\"uzsakymo_data\" value=".$item['uzsakymo_data']." required/>
				</div>
				
				<div class=\"input-group\">
					<label>Kaina:</label>
					<input type=\"number\" step = \"0.01\" id=\"kaina\" name=\"kaina\" value = ".$item['kaina']." required/>
				</div>
				
				<div class=\"input-group\">
					<label>Apmokėta:</label>
					<select name=\"apmoketa\" required>
					<option selected disabled>Nepasirinkta</option>
					<option value ='0'>Neapmokėta</option>
					<option value='1'>Apmokėta</option>";					
					echo"
					</select>
				</div>
				
				<div>
					<label>Pirkėjas:</label>
					<select name=\"fk_vartotojas\" required>
					<option selected disabled>Vartotojas</option>";					
					while($rowKurejas = mysqli_fetch_assoc($kurejasResult))
					{
						echo"<option value=".$rowKurejas['id'].">".$rowKurejas['vardas']."</option>";
					}
					echo"
					</select>
					<input type=\"hidden\" name=\"id\" value=".$item['id'].">
				</div>
				
				<div class=\"input-group\">
				<input type=\"submit\" id=\"update_button\" name=\"update_button\" value=\"Atnaujinti\" />
				</div>
			</form>
			</div>
			";
		}
		
		if(isset($_POST['update_button'])){
				$uzsakymo_data = $_POST['uzsakymo_data'];
				$kaina = $_POST['kaina'];
				$apmoketa = $_POST['apmoketa'];
				$fk_vartotojas = $_POST['fk_vartotojas'];
				$id = $_POST['id'];
				$sql = "UPDATE uzsakymas SET uzsakymo_data='".$uzsakymo_data."', kaina='".$kaina."', apmoketa='".$apmoketa."', fk_vartotojas='".$fk_vartotojas."' WHERE id=".$id."";
					echo $sql;
				$result = mysqli_query($db, $sql);
				$_POST = null;
				echo "
				<script type='text/javascript'>
				var answer = confirm (\"Sėkmingai atnaujinote užsakymą\")
				if (answer)
				window.location = 'http://localhost/gameshop/admin_game_order_data_edit.php';
				else
				window.location = 'http://localhost/gameshop/admin_game_order_data_edit.php';
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