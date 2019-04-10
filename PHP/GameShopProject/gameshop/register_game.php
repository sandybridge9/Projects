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
		<h2>Žaidimo registracija</h2>
	</div>
	
	<?php
		$sql = "SELECT * FROM kurejas";
		$result = mysqli_query($db, $sql);
		echo"
		<div class=\"login_form\">
			<form action=\"process_game_register.php\" method=\"POST\">
			<div class=\"input-group\">
					<label>Pavadinimas:</label>
					<input type=\"text\" id=\"pavadinimas\" name=\"pavadinimas\" />
				</div>
				<div class=\"input-group\">
					<label>Išleidimo data:</label>
					<input type=\"date\" id=\"isleidimo_data\" name=\"isleidimo_data\" />
				</div>
				<div class=\"input-group\">
					<label>kaina:</label>
					<input type=\"text\" id=\"kaina\" name=\"kaina\" />
				</div>
				<div class=\"input-group\">
					<label>aprasymas:</label>
					<input type=\"comment\" id=\"aprasymas\" name=\"aprasymas\" />
				</div>
				<div class=\"input-group\">
					<label>virselio_nuoroda:</label>
					<input type=\"text\" id=\"virselio_nuoroda\" name=\"virselio_nuoroda\" />
				</div>
				<div class=\"input-group\">
					<label>turimas_kiekis:</label>
					<input type=\"text\" id=\"turimas_kiekis\" name=\"turimas_kiekis\" />
				</div>
				<div class=\"input-group\">
					<label>parduotas_kiekis:</label>
					<input type=\"text\" id=\"parduotas_kiekis\" name=\"parduotas_kiekis\" />
				</div>
				<div class=\"input-group\">
					<label>fk_kurejas:</label>
					<select name=\"fk_kurejas\">
					<option selected disabled>Kurejas</option>";					
					while($row = mysqli_fetch_assoc($result))
					{
						//<option value="saab">Saab</option>
						echo"<option value=".$row['id'].">".$row['pavadinimas']."</option>";
					}
					echo"
					</select>
				</div>
					<div class=\"input-group\">
					<input type=\"submit\" id=\"login_button\" name=\"login_button\" value=\"Register\" />
				</div>
			</form>
		</div>";
		
		?>
		
	</body>
</html>