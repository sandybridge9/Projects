<!DOCTYPE html>
<?php 
	session_start(); 
	
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false){
		header('Location: index.php');
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
		}
		$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
		if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($db)); }
	}
	
?>
<html>
	<head>
		<title>Game shop login</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	<head>
	
	<body>
	<div class="header">
		<h2>Užsakymo registracija</h2>
	</div>
	
	<?php
		$sql = "SELECT * FROM vartotojas";
		$result = mysqli_query($db, $sql);
		echo"
		<div class=\"login_form\">
			<form method=\"POST\">
			
				<div class=\"input-group\">
					<label>Uzsakymo data:</label>
					<input type=\"date\" id=\"uzsakymo_data\" name=\"uzsakymo_data\" />
				</div>
				
				<div class=\"input-group\">
					<label>kaina:</label>
					<input type=\"text\" id=\"kaina\" name=\"kaina\" />
				</div>
				
				<div class=\"input-group\">
					<label>Apmokėta:</label>
					<select name=\"apmoketa\">
					<option selected value ='0'>Neapmokįta</option>
					<option value='1'>Apmokėta</option>";					
					echo"
					</select>
				</div>
				<div class=\"input-group\">
					<label>Pirkejas:</label>
					<select name=\"fk_vartotojas\">
					<option selected disabled>Vartotojas</option>";					
					while($row = mysqli_fetch_assoc($result))
					{
						echo"<option value=".$row['id'].">".$row['vardas']."</option>";
					}
					echo"
					</select>
				</div>
					<div class=\"input-group\">
					<input type=\"submit\" id=\"login_button\" name=\"login_button\" value=\"Register\" />
				</div>
			</form>
		</div>";
		
		if(isset($_POST['login_button'])){
			$uzsakymo_data = $_POST['uzsakymo_data'];
			$kaina = $_POST['kaina'];
			$apmoketa = $_POST['apmoketa'];
			$fk_vartotojas = $_POST['fk_vartotojas'];
			
			$sql = "INSERT INTO uzsakymas (uzsakymo_data, kaina, apmoketa, fk_vartotojas) VALUES ('$uzsakymo_data', '$kaina', '$apmoketa', '$fk_vartotojas')";
			$resutl = mysqli_query($db, $sql);
			
			$_POST = null;
				echo "
				<script type='text/javascript'>
				var answer = confirm (\"Sėkmingai užregistravote užsakymą\")
				if (answer)
				window.location = 'http://localhost/gameshop/admin_game_order_data_edit.php';
				else
				window.location = 'http://localhost/gameshop/admin_game_order_data_edit.php';
				</script>";
			
		}
		?>
		
	</body>
</html>