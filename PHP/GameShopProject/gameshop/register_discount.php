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

	<div class="header">
		<h2>Nuolaidos kodo registracija</h2>
	</div>
	
	<?php
		echo"
		<div class=\"login_form\">
			<form action=\"process_dicount_register.php\" method=\"POST\">
			<div class=\"input-group\">
					<label>Pavadinimas:</label>
					<input type=\"text\" id=\"pavadinimas\" name=\"pavadinimas\" />
				</div>
				<div class=\"input-group\">
					<label>Kodas:</label>
					<input type=\"text\" id=\"kodas\" name=\"kodas\" />
				</div>
				<div class=\"input-group\">
					<label>Procentai:</label>
					<input type=\"number\" step = \"0.01\" id=\"kiekis\" name=\"kiekis\" />
				</div>
				<div class=\"input-group\">
					<input type=\"submit\" id=\"login_button\" name=\"login_button\" value=\"Register\" />
				</div>
			</form>
		</div>";
		
		?>
		
	</body>
</html>