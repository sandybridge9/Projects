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

		</script>";
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
	<head>
	
	<body>
		<div class="middle-element">
		<a href ="index.php"> Maisto užsakymų svetainė </a>
		</div>	
			
			<div class="items-position">
			<div class="shop-items">
				<?php
					$sql = "SELECT * FROM vartotojas WHERE id != ".$_SESSION['user_id']."";
					$result = mysqli_query($db, $sql);	
					echo "
						<h3> Vartotojai </h3>
						<table>
						<tr>
						<th>Vardas</th>
						<th>Pavarde</th>
						<th>Prisijungimo Vardas</th>
						<th>Vartotojo lygis</th>
						<th>		</th>
						</tr>
						
					";
					while($row = mysqli_fetch_assoc($result))
					{
						echo " 
						<tr>
						<form action='admin_users_edit.php' method='POST'> 
						<td>
						<label>".$row['vardas']."</label>
						<input type=\"hidden\" name=\"vardas\" value=".$row['vardas'].">
						</td>
						<td>
						<label>".$row['pavarde']."</label>
						<input type=\"hidden\" name=\"pavarde\" value=".$row['pavarde'].">
						</td>
						<td>
						<label>".$row['prisijungimo_vardas']."</label>
						<input type=\"hidden\" name=\"prisijungimo_vardas\" value=".$row['prisijungimo_vardas'].">
						</td>
						<td>
						<label>".$row['vartotojo_lygis']."</label>
						<input type=\"hidden\" name=\"vartotojo_lygis\" value=".$row['vartotojo_lygis'].">
						<input type=\"hidden\" name=\"slaptazodis\" value=".$row['slaptazodis'].">
						<input type=\"hidden\" name=\"id\" value=".$row['id'].">
						</td>
						<td>
						<input style=\"color: white; background-color: red;\" type='submit' id='remove' name='remove' value='Pašalinti'>
						<input style=\"color: white; background-color: grey;\" type='submit' id='update' name='update' value='Atnaujinti'>
						</td>
						</form>
						</tr>
						";
					}
					/*  
					echo "</table>";
					if(isset($_POST['remove'])){
						$id = $_POST['id'];
						$resutl = mysqli_query($db, "DELETE from vartotojas WHERE id = ".$id." ");
						$_POST = null;
						echo "
						<script type='text/javascript'>
						var answer = confirm (\"Sėkmingai pašalinote Vartotoj1\")
						if (answer)
						window.location = 'http://localhost/projektas/index.php';
						else
						window.location = 'http://localhost/projektas/index.php';
						</script>";
					}*/
				?>
			</div>
			</div>
				

	</body>
</html>