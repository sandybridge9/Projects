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
		$sql = "SELECT * FROM naujienlaiskis WHERE id = ".$id."";
		$result = mysqli_query($db, $sql);	
		$item = mysqli_fetch_assoc($result);
		
		$sqlZaidimas = "SELECT * FROM zaidimas";
		$zaidimasResult = mysqli_query($db, $sqlZaidimas);
		
		
		
		if(isset($_POST['remove'])){
			$id = $_POST['id'];
			$resutl = mysqli_query($db, "DELETE from naujienlaiskis WHERE id = ".$id." ");
			echo "
			<script type='text/javascript'>
			var answer = confirm (\"Sėkmingai pašalinote naujienlaiškį\")
			if (answer)
			window.location = 'http://localhost/gameshop/newspapers.php';
			else
			window.location = 'http://localhost/gameshop/newspapers.php';
			</script>";
		}
		elseif(isset($_POST['update'])){

			$sql = "SELECT * FROM naujienlaiskis WHERE id = ".$id."";
			$result = mysqli_query($db, $sql);
			$item = mysqli_fetch_assoc($result);
			echo " <h3> ".$item['pavadinimas']." </h3> ";
			
			echo"<h3><a href = 'newspapers.php'> Atgal </a></h3>";
			echo"
			<div class=\"header\">
				<h2>Naujienlaiškis</h2>
			</div>
			<div class=\"login_form\">
			<form method=\"POST\" enctype=\"multipart/form-data\">
			
				<div class=\"input-group\">
					<label>Pavadinimas:</label>
					<input type=\"text\" id=\"pavadinimas\" name=\"pavadinimas\" value = '".$item['pavadinimas']."' required/>
				</div>
				
				<div class=\"input-group\">
					<label>Pranešimas:</label>
					<input type=\"text\" id=\"pavadinimas\" name=\"pavadinimas\" value = '".$item['pranesimas']."' required/>
				</div>
				
				<div class=\"input-group\">
					<label>Data:</label>
					<input type=\"date\" id=\"data\" name=\"data\" value=".$item['data']." required/>
				</div>
				
				<div>
					<label>Žaidimas:</label>
					<select name=\"fk_zaidimas\" required>
					<option selected disabled>Žaidimas</option>";					
					while($rowZaidimas = mysqli_fetch_assoc($zaidimasResult))
					{
						echo"<option value=".$rowZaidimas['id'].">".$rowZaidimas['pavadinimas']."</option>";
					}
					echo"
					</select>
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
				$pranesimas = $_POST['pranesimas'];
				$data = $_POST['data'];
				$fk_zaidimas = $_POST['fk_zaidimas'];
				$id = $_POST['id'];
				
				$sql = "UPDATE naujienlaiskis SET pavadinimas='".$pavadinimas."', pranesimas='".$pranesimas."', data='".$data."', fk_zaidimas='".$fk_zaidimas."' WHERE id=".$id."";
				echo $sql;
				$result = mysqli_query($db, $sql);
				$_POST = null;
				echo "
				<script type='text/javascript'>
				var answer = confirm (\"Sėkmingai atnaujinote naujienlaiškį\")
				if (answer)
				window.location = 'http://localhost/gameshop/newspapers.php';
				else
				window.location = 'http://localhost/gameshop/newspapers.php';
				</script>";
		}
		
		if(isset($_POST['send'])){
			$id = $_POST['id'];	
			$sql = "SELECT * FROM naujienlaiskis WHERE id = ".$id."";
			$result = mysqli_query($db, $sql);	
			$item = mysqli_fetch_assoc($result);
			
			$pavadinimas = $item['pavadinimas'];
			$zaidimas = $item['fk_zaidimas'];
			$pranesimas = $item['pranesimas'];
			 
			$sqlZaidimas = "SELECT * FROM zaidimas WHERE id = ".$zaidimas."";
			$resultZaidimas = mysqli_query($db, $sqlZaidimas);	
			$itemZaidimas = mysqli_fetch_assoc($resultZaidimas);
			 
			$msg = "".$pavadinimas." **".$itemZaidimas['pavadinimas']."** ".$pranesimas."";
			echo $msg;
	
			// DISCORD
			$curl = curl_init("https://discordapp.com/api/webhooks/489411996090105866/6slpJgdl8WJZ2hR28OIUbQlvPc5rlT7SYQ7RyiGTigsikBJvw-2-9EilUCp4cF9G2hb7");
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("content" => $msg)));    
			curl_exec($curl);
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("content" => "@everyone")));
			curl_exec($curl);
			// DISCORD
			echo"
			<script type='text/javascript'>
			var answer = confirm (\"Sėkmingai išsiuntėte naujienlaiškį\")
			if (answer)
			window.location = 'http://localhost/gameshop/newspapers.php';				
			else
			window.location = 'http://localhost/gameshop/newspapers.php';
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