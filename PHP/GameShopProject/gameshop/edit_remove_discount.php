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
		$sql = "SELECT * FROM nuolaida WHERE id = ".$id."";
		$result = mysqli_query($db, $sql);	
		$item = mysqli_fetch_assoc($result);	
		$sql1 = "SELECT * FROM nuolaidos_kuponas WHERE fk_nuolaida = ".$id."";
		$resultup = mysqli_query($db, $sql1);	
		$cupon = mysqli_fetch_assoc($resultup);	
		
		
		if(isset($_POST['remove'])){
			$result2 = mysqli_query($db, "DELETE from nuolaidos_kuponas WHERE fk_nuolaida = $id");
			$result1 = mysqli_query($db, "DELETE FROM nuolaida WHERE nuolaida.id = $id");
				echo "<script type='text/javascript'>
				var answer = confirm (\"Sėkmingai pašalinote nuolaidos kuponą\")
				if (answer)
				window.location = 'http://localhost/gameshop/discount_edit.php';
				else
				window.location = 'http://localhost/gameshop/discount_edit.php';

		</script>";
		}
		elseif(isset($_POST['update'])){
			echo"<h3><a href = 'discount_edit.php'> Atgal </a></h3>";
			echo"
			<div class=\"header\">
				<h2>Nuolaida</h2>
			</div>
			<div class=\"login_form\">
			<form method=\"POST\" enctype=\"multipart/form-data\">
				<div class=\"input-group\">
					<label>Nuolaidos pavadinimas:</label>
					<input type=\"text\" id=\"pavadinimas\" name=\"pavadinimas\" value = '".$item['pavadinimas']."' required/>
					<input type=\"hidden\" name=\"id\" value=".$item['id'].">
				</div>
				<div class=\"input-group\">
					<label>Kodas:</label>
					<input type=\"text\" id=\"kodas\" name=\"kodas\" value=".$cupon['kodas']." required/>
				</div>
				<div class=\"input-group\">
					<label>Procentai:</label>
					<input type=\"number\" step = \"0.01\" id=\"kiekis\" name=\"kiekis\" value = ".$item['kiekis']." required/>
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
				$kodas = $_POST['kodas'];
				$procentai = $_POST['kiekis'];
				$id = $_POST['id'];
				
				$sql1 = "UPDATE nuolaidos_kuponas SET kodas = '".$kodas."' WHERE nuolaidos_kuponas.fk_nuolaida = '".$id."'";
				$sql2 = "UPDATE nuolaida SET pavadinimas = '".$pavadinimas."', kiekis = '".$procentai."' WHERE nuolaida.id = '".$id."'";

				$result1 = mysqli_query($db, $sql1);
				$result2 = mysqli_query($db, $sql2);
				echo "
				<script type='text/javascript'>
				var answer = confirm (\"Sėkmingai atnaujinote prekę\")
				if (answer)
				window.location = 'http://localhost/gameshop/discount_edit.php';
				else
				window.location = 'http://localhost/gameshop/discount_edit.php';
				</script>";
		}

		
	}	
	?>
		
	</body>
</html>

