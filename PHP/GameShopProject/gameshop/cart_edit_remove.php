<!DOCTYPE html>
<?php session_start();
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false){
		die("Negalima");
	}else{
		if($_SESSION['user_level'] != "registruotas_vartotojas"){
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
	} ?>
<html>
	<head>
		<title>Game shop</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	<head>
	
	<body>
	<div class= "title">
			<a href ="index.php"> GAME SHOP </a>
		</div>
		<div>		
		<?php
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
	
		$id = $_POST['fk_uzsakymas'];
		$sql = "SELECT * FROM uzsakymas_zaidimas WHERE fk_uzsakymas = ".$id."";
		$result = mysqli_query($db, $sql);	
		$item = mysqli_fetch_assoc($result);
		
		$sqlUzsakymas = "SELECT * FROM uzsakymas";
		$resultUzsakymas = mysqli_query($db, $sqlUzsakymas);

		$sqlZaidimas = "SELECT * FROM zaidimas";
		$resultZaidimas = mysqli_query($db, $sqlZaidimas);
			
		if(isset($_POST['remove'])){
			$id = $_POST['fk_zaidimas'];
			$result = mysqli_query($db, "DELETE from uzsakymas_zaidimas WHERE fk_zaidimas = ".$id." ");
			echo "
			<script type='text/javascript'>
			var answer = confirm (\"Sėkmingai pašalinote užsakymą\")
			if (answer)
			window.location = 'http://localhost/gameshop/cart.php';
			else
			window.location = 'http://localhost/gameshop/index.php';
			</script>";
		}
		elseif(isset($_POST['update'])){
			echo"<h3><a href = 'cart.php'> Atgal </a></h3>";
			echo"
			<div class=\"header\">
				<h2>Krepšelis</h2>
			</div>
			<div class=\"login_form\">
			<form method=\"POST\" enctype=\"multipart/form-data\">
				<div>
				<label>Uzsakymas:</label>
				<select name=\"fk_uzsakymas\" required>
				<option selected disabled>Zaidimas</option>";					
				while($rowUzsakymas = mysqli_fetch_assoc($resultUzsakymas))
				{
					echo"<option value=".$rowUzsakymas['id'].">".$rowUzsakymas['uzsakymo_data']."</option>";
				}
				echo"
				</select>
				<input type=\"hidden\" name=\"id\" value=".$item2['id'].">
				</div>				
				<div>
				<label>Zaidimas:</label>
				<select name=\"fk_zaidimas\" required>
				<option selected disabled>Zaidimas</option>";					
				while($rowZaidimas = mysqli_fetch_assoc($resultZaidimas))
				{
					echo"<option value=".$rowZaidimas['id'].">".$rowZaidimas['pavadinimas']."</option>";
				}
				echo"
				</select>
				<input type=\"hidden\" name=\"id\" value=".$item2['id'].">
				</div>
				
				<div class=\"input-group\">
				<input type=\"submit\" id=\"update_button\" name=\"update_button\" value=\"Atnaujinti\" />
				</div>
			</form>
			</div>
			";
		}
		
		if(isset($_POST['update_button'])){
				$fk_uzsakymas = $_POST['fk_uzsakymas'];
				$fk_zaidimas = $_POST['fk_zaidimas'];
				$sql = "UPDATE uzsakymas_zaidimas SET fk_zaidimas='".$fk_zaidimas."' WHERE fk_uzsakymas=".$fk_uzsakymas."";
					echo $sql;
				$result = mysqli_query($db, $sql);
				$_POST = null;
				echo "
				<script type='text/javascript'>
				var answer = confirm (\"Sėkmingai atnaujinote užsakymą\")
				if (answer)
				window.location = 'http://localhost/gameshop/cart.php';
				else
				window.location = 'http://localhost/gameshop/cart.php';
				</script>";
		}		
	}	
	?>	
	</body>
</html>