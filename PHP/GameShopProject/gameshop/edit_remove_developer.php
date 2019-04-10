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
		$sql = "SELECT * FROM kurejas WHERE id = ".$id."";
		$result = mysqli_query($db, $sql);	
		$item = mysqli_fetch_assoc($result);
		
		
		
		if(isset($_POST['remove'])){
			$id = $_POST['id'];
			$resutl = mysqli_query($db, "DELETE from kurejas WHERE id = ".$id." ");
			echo "
			<script type='text/javascript'>
			var answer = confirm (\"Sėkmingai pašalinote Kūrėją\")
			if (answer)
			window.location = 'http://localhost/gameshop/admin_developer_data_edit.php';
			else
			window.location = 'http://localhost/gameshop/admin_developer_data_edit.php';
			</script>";
		}
		elseif(isset($_POST['update'])){
			echo"<h3><a href = 'admin_developer_data_edit.php'> Atgal </a></h3>";
			echo"
			<div class=\"header\">
				<h2>Užsakymas</h2>
			</div>
			<div class=\"login_form\">
			<form method=\"POST\" enctype=\"multipart/form-data\">
			
				<div class=\"input-group\">
					<label>Pavadinimas:</label>
					<input type=\"text\" id=\"pavadinimas\" name=\"pavadinimas\" value=".$item['pavadinimas']." required/>
					<input type=\"hidden\" name=\"id\" value=".$id.">
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
				$sql = "UPDATE kurejas SET pavadinimas='".$pavadinimas."' WHERE id=".$id."";
					echo $sql;
				$result = mysqli_query($db, $sql);
				$_POST = null;
				echo "
				<script type='text/javascript'>
				var answer = confirm (\"Sėkmingai atnaujinote Kūrėją\")
				if (answer)
				window.location = 'http://localhost/gameshop/admin_developer_data_edit.php';
				else
				window.location = 'http://localhost/gameshop/admin_developer_data_edit.php';
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