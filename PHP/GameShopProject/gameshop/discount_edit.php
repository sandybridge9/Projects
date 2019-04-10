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
					//$sql = "SELECT DISTINCT nuolaidos_kuponas.kodas as kodas, nuolaida.pavadinimas as pavadinimas, nuolaida.kiekis as procentai FROM nuolaidos_kuponas, nuolaida GROUP BY nuolaida.id";
					//$result = mysqli_query($db, $sql);	
					$sql1 = "SELECT * FROM nuolaida";
					$result1 = mysqli_query($db, $sql1);
					// $sql2 = "SELECT * FROM nuolaidos_kuponas";
					// $result2 = mysqli_query($db, $sql2);
					echo "
						<h3> Nuolaidos </h3>
						<table>
						<tr>
						<th>Pavadinimas</th>
						<th>Kodas</th>
						<th>Procentai</th>
						<th>		</th>
						</tr>
						
					";
					while($row = mysqli_fetch_assoc($result1))
					{
						//"SELECT password FROM users WHERE username = $loggin_user"
						// $sql2 = "SELECT * FROM nuolaidos_kuponas WHERE fk_nuolaida == $row['id']";
						// $result2 = mysqli_query($db, $sql2);
						// while($row2 = mysqli_fetch_assoc($result2))
						// {
						// 	if($row['id'] == $row2['fk_nuolaida']){
						// 		$kodas = $row2['kodas'];
						// 	}
						// }
						
						echo " 
						<tr>
						<form action='edit_remove_discount.php' method='POST'> 
						<td>
						<label>".$row['pavadinimas']."</label>
						<input type=\"hidden\" name=\"pavadinimas\" value=".$row['pavadinimas'].">
						<input type=\"hidden\" name=\"id\" value=".$row['id'].">
						</td>";
						$sql2 = "SELECT * FROM nuolaidos_kuponas";
						$result2 = mysqli_query($db, $sql2);
						while($row2 = mysqli_fetch_assoc($result2))
						{
							if($row['id'] == $row2['fk_nuolaida']){
								echo "
								<td>
								<label>".$row2['kodas']."</label>
								<input type=\"hidden\" name=\"isleidimo_data\" value=".$row2['kodas'].">
								</td> ";
							}
						}
						echo "
						<td>
						<label>".$row['kiekis']."</label>
						<input type=\"hidden\" name=\"kaina\" value=".$row['kiekis'].">
						</td>
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

			<form action='register_discount.php' method="POST">
				<div class="input-group">
					<input type="submit" id="add" name="add" value="Pridėti naują nuolaidos kodą" />
				</div>
			</form>
			<form action='buhalter.php' method="POST">
				<div class="input-group">
					<input type="submit" value="Grizti" />
				</div>
			</form>