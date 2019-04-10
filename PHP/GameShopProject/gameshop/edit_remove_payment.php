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
		<a href="payment_edit.php"> Atgal </a>
	
	<?php
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
	
		$id = $_POST['id'];
		$sql = "SELECT * FROM mokejimo_budas WHERE id = ".$id."";
		$result = mysqli_query($db, $sql);	
		$item = mysqli_fetch_assoc($result);	
		// $sql1 = "SELECT * FROM nuolaidos_kuponas WHERE fk_nuolaida = ".$id."";
		// $resultup = mysqli_query($db, $sql1);	
		// $cupon = mysqli_fetch_assoc($resultup);	
		
		
		if(isset($_POST['remove'])){
			$result = mysqli_query($db, "DELETE from mokejimo_budas WHERE id = $id");
				echo "<script type='text/javascript'>
				var answer = confirm (\"Sėkmingai pašalinote nuolaidos kuponą\")
				if (answer)
				window.location = 'http://localhost/gameshop/payment_edit.php';
				else
				window.location = 'http://localhost/gameshop/payment_edit.php';

		</script>";
		}
		elseif(isset($_POST['update'])){
			// echo"<h3><a href = 'payment_edit.php'> Atgal </a></h3>";
			echo"
			<div class=\"header\">
				<h2>Mokėjimo būdai</h2>
			</div>
			<div class=\"login_form\">
			<form method=\"POST\" enctype=\"multipart/form-data\">
				<div class=\"input-group\">
					<label>Mokėjimo būdo pavadinimas:</label>
					<input type=\"text\" id=\"pavadinimas\" name=\"pavadinimas\" value = '".$item['pavadinimas']."' required/>
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
				$pavadinimas = $_POST['pavadinimas'];
				$id = $_POST['id'];
				
				$sql2 = "UPDATE mokejimo_budas SET pavadinimas = '".$pavadinimas."' WHERE mokejimo_budas.id = '".$id."'";

				$result2 = mysqli_query($db, $sql2);
				echo "
				<script type='text/javascript'>
				var answer = confirm (\"Sėkmingai atnaujinote prekę\")
				if (answer)
				window.location = 'http://localhost/gameshop/payment_edit.php';
				else
				window.location = 'http://localhost/gameshop/payment_edit.php';
				</script>";
		}

		
	}	
	?>
		
	</body>
</html>

