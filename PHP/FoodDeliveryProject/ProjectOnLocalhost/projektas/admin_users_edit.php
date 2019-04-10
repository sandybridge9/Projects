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
				window.location = 'http://localhost/projektas/index.php';
				else
				window.location = 'http://localhost/projektas/index.php';

			</script>
			";
		}
		$db = mysqli_connect("localhost", "root", "", "it") or die("Unable to connect to db");
		if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($db)); }
	}
	
?>
<html>
	<head>
		<title>Maisto užsakymų svetainė</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<style>
		img {
			width: 20%;
			height: 20%;
		}
		img:hover {
		width: 50%;
		height: 50%;
		}
		</style>
		<link rel="stylesheet" type="text/css" href="tableStyle.css">
	</head>
	
	<body>
		<div class="middle-element">
		<a href ="index.php"> Maisto užsakymų svetainė </a>
		</div>		
		<div class="items-position">
			<div class="shop-items">
				<?php
					if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			
					if(isset($_POST['remove'])){
						$vartotojoId = $_POST['id'];
						echo "$vartotojoId";
						$result = mysqli_query($db, "DELETE from vartotojas WHERE id = ".$vartotojoId."");
						echo "
						<script type='text/javascript'>
						var answer = confirm (\"Sėkmingai pašalinote prekę iš krepšelio\")
						if (answer)
						window.location = 'http://localhost/projektas/admin_users.php';
						else
						window.location = 'http://localhost/projektas/index.php';
						</script>
						";
					}
					elseif(isset($_POST['update'])){
						$vartotojoId = $_POST['id'];
						$slaptazodis = $_POST['slaptazodis'];
						echo "$vartotojoId";
						echo"<h3><a href = 'cart.php'> Atgal </a></h3>";
						echo"
						<div class=\"header\">
						<h2>Vartotojas</h2>
						</div>
						<div class=\"login_form\">
						<form method=\"POST\" enctype=\"multipart/form-data\">		
						<div class=\"input-group\">
						<label>Vardas:</label>
						<input type=\"text\" id=\"vardas\" name=\"vardas\" />
						<input type=\"hidden\" name=\"vartotojo_id\" value=".$vartotojoId.">
						</div>
						<div class=\"input-group\">
						<label>Pavardė:</label>
						<input type=\"text\" id=\"pavarde\" name=\"pavarde\" />
						</div>	
						<div class=\"input-group\">
						<label>Prisijungimo vardas:</label>
						<input type=\"text\" id=\"prisijungimo_vardas\" name=\"prisijungimo_vardas\" />
						</div>	
						<div class=\"input-group\">
						<label>Vartotojo lygis:</label>
						<input type=\"text\" id=\"vartotojo_lygis\" name=\"vartotojo_lygis\" />
						</div>		
						<div class=\"input-group\">
						<input type=\"submit\" id=\"update_button\" name=\"update_button\" value=\"Atnaujinti\" />
						</div>
						</form>
						</div>
						";
					}
			
					if(isset($_POST['update_button'])){
						$vartotojoId = $_POST['vartotojo_id'];
						$vardas = $_POST['vardas'];
						$pavarde = $_POST['pavarde'];
						$prisijungimo_vardas = $_POST['prisijungimo_vardas'];
						$vartotojo_lygis = $_POST['vartotojo_lygis'];
						$sql = "UPDATE vartotojas SET vardas='".$vardas."', pavarde='".$pavarde."', prisijungimo_vardas='".$prisijungimo_vardas."', vartotojo_lygis='".$vartotojo_lygis."' WHERE id=".$vartotojoId."";
						echo $sql;
						$result = mysqli_query($db, $sql);
						$_POST = null;
						echo "
						<script type='text/javascript'>
						var answer = confirm (\"Sėkmingai atnaujinote vartotoją \")
						if (answer)
						window.location = 'http://localhost/projektas/admin_users.php';
						else
						window.location = 'http://localhost/projektas/index.php';
						</script>
						";
					}
				}
				?>
			</div>
		</div>
	</body>
</html>