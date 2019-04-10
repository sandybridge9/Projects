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
		<title>Game Shop</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="tableStyle.css">
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
		<h4>Redagavimas</h4>
			
		
			<div>
				<?php
					$sql1 = "SELECT * FROM zaidimu_rinkinys";
					$result1 = mysqli_query($db, $sql1);
					echo "
						<h3> Žaidimų rinkiniai </h3>
						<table>
						<tr>
						<th>Pavadinimas</th>
						<th>Kaina</th>
						<th>Turimas kiekis</th>
						<th>Parduotas kiekis</th>
						<th>Nuolaida</th>
						</tr>
						
					";
					while($row = mysqli_fetch_assoc($result1))
					{						
						echo " 
						<tr>
						<form action='edit_remove_bundle.php' method='POST'> 
						<td>
						<label>".$row['pavadinimas']."</label>
						<input type=\"hidden\" name=\"pavadinimas\" value=".$row['pavadinimas'].">
						<input type=\"hidden\" name=\"id\" value=".$row['id'].">
						</td>
						<td>
						<label>".$row['kaina']."</label>
						<input type=\"hidden\" name=\"kaina\" value=".$row['kaina'].">
						</td>
						<td>
						<label>".$row['turimas_kiekis']."</label>
						<input type=\"hidden\" name=\"turimasKiekis\" value=".$row['turimas_kiekis'].">
						</td>
						<td>
						<label>".$row['parduotas_kiekis']."</label>
						<input type=\"hidden\" name=\"parduotasKiekis\" value=".$row['parduotas_kiekis'].">
						</td>";

						$sql2 = "SELECT * FROM nuolaida";
						$result2 = mysqli_query($db, $sql2);
						while($row2 = mysqli_fetch_assoc($result2))
						{
							if($row2['id'] == $row['fk_nuolaida']){
								echo "
								<td>
								<label>".$row2['pavadinimas']." - ".$row2['kiekis']."%</label>
								<input type=\"hidden\" name=\"nuolaida\" value=".$row['fk_nuolaida'].">
								</td> ";
							}
						}
						echo "
						<td>
						<input style=\"color: white; background-color: #ff6d6d;\" type='submit' id='remove' name='remove' value='Pašalinti'>
						<input type='submit' id='update' name='update' value='Redaguoti'>
						</td>
						</form>
						</tr>
						";
					} 
					echo "</table>";
					
					
				?>
			</div>
				

	</body>
</html>

			<form action='register_bundle.php' method="POST">
				<div class="input-group">
					<input type="submit" id="add" name="add" value="Pridėti naują nuolaidos kodą" />
				</div>
			</form>
			<form action='buhalter.php' method="POST">
				<div class="input-group">
					<input type="submit" value="Grizti" />
				</div>
			</form>