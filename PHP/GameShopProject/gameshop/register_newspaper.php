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
		<title>Game shop</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	<head>
	
	<body>
	<div class="header">
		<h2>Naujienlaiškio registracija</h2>
	</div>
	
	<?php
		$sql = "SELECT * FROM naujienaliskis";
		$result = mysqli_query($db, $sql);
		
		$sqlZaidimas = "SELECT * FROM zaidimas";
		$resultZaidimas = mysqli_query($db, $sqlZaidimas);
		
		echo"
		<div class=\"login_form\">
			<form  method=\"POST\">
			
				<div class=\"input-group\">
					<label>Pavadinimas:</label>
					<input type=\"text\" id=\"pavadinimas\" name=\"pavadinimas\" />
				</div>
				
				<div class=\"input-group\">
					<label>Pranešimas:</label>
					<input type=\"text\" id=\"pranesimas\" name=\"pranesimas\" />
				</div>
				
				<div class=\"input-group\">
					<label>Data:</label>
					<input type=\"date\" id=\"data\" name=\"data\" />
				</div>
				
				
				<div class=\"input-group\">
					<label>Žadimas:</label>
					<select name=\"fk_zaidimas\">
					<option selected disabled>Žaidimas</option>";					
					while($rowZaidimas = mysqli_fetch_assoc($resultZaidimas))
					{
						echo"<option value=".$rowZaidimas['id'].">".$rowZaidimas['pavadinimas']."</option>";
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
			$pavadinimas = $_POST['pavadinimas'];
			$pranesimas = $_POST['pranesimas'];
			$data = $_POST['data'];
			$fk_zaidimas = $_POST['fk_zaidimas'];

				
			$id = $_POST['id'];
			
			$sql = "INSERT INTO naujienlaiskis (pavadinimas, pranesimas, data, fk_zaidimas) VALUES ('$pavadinimas', '$pranesimas', '$data', '$fk_zaidimas')";
			$result = mysqli_query($db, $sql);
			$_POST = null;				
			echo "
			<script type='text/javascript'>
			var answer = confirm (\"Sėkmingai pridėjote naujienlaiškį\")
			if (answer)
			window.location = 'http://localhost/gameshop/newspapers.php';
			else
			window.location = 'http://localhost/gameshop/newspapers.php';
			</script>";
		}
		
		?>
		
	</body>
</html>