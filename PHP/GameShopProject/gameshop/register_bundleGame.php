<!DOCTYPE html>
<?php 
	session_start(); 
	
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false){
		header('Location: index.php');
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
		<a href="bundleGame_edit.php"> Atgal </a>

	<div class="header">
		<h2>Žaidimų registracija į kolekciją</h2>
	</div>
	
	<?php
		$sql = "SELECT * FROM zaidimas";
		$result = mysqli_query($db, $sql);
		$sql2 = "SELECT * FROM zaidimu_rinkinys";
		$result2 = mysqli_query($db, $sql2);
		echo"
		<div class=\"login_form\">
			<form action=\"process_bundleGame_register.php\" method=\"POST\">
				<div class=\"input-group\">
				<label>Kolekcija:</label>
				<select name=\"kolekcija\">
				<option selected disabled>Kolekcija</option>";					
				while($row = mysqli_fetch_assoc($result2))
				{
					echo"<option value=".$row['id'].">".$row['pavadinimas']."</option>";
				}
				echo"
				</select>
				</div>
				<div class=\"input-group\">
				<label>Žaidimas:</label>
				<select name=\"zaidimas\">
				<option selected disabled>Žaidimas</option>";					
				while($row = mysqli_fetch_assoc($result))
				{
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