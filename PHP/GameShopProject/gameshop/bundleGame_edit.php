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
					$sql1 = "SELECT * FROM zaidimu_rinkinys";
					$result1 = mysqli_query($db, $sql1);
					// $item = $result['id'];
					// $sql2 = "SELECT * FROM nuolaidos_kuponas";
					// $result2 = mysqli_query($db, $sql2);
					echo "
						<h3> Žaidimų rinkiniai </h3>
						<table>
						<tr>
						<th>Kolekcija</th>
						<th>Pavadinimas</th>
						<th>Aprasymas</th>	
						</tr>
						
					";
					while($row = mysqli_fetch_assoc($result1))
					{
						$item = $row['id'];
						echo"<tr><td><label>".$row['pavadinimas']."</label></td></tr>";
						$sql2 = "SELECT * FROM zaidimu_rinkinys_zaidimas WHERE zaidimu_rinkinys_zaidimas.fk_zaidimu_rinkinys = $item";
						$result2 = mysqli_query($db, $sql2);
						while($row2 = mysqli_fetch_assoc($result2))
						{
							$sql3 = "SELECT * FROM zaidimas";
							$result3 = mysqli_query($db, $sql3);
						while($row3 = mysqli_fetch_assoc($result3))
						{
							if($row3['id'] == $row2['fk_zaidimas']){
								echo "
								<tr>
								<form action='edit_remove_bundleGame.php' method='POST'>
								<td></td>
								<td>
								<label>".$row3['pavadinimas']."</label>
								<input type=\"hidden\" name=\"zaidimas\" value=".$row3['id'].">
								<input type=\"hidden\" name=\"kolekcija\" value=".$row2['fk_zaidimu_rinkinys'].">
								</td>
								<td>
								<label>".$row3['aprasymas']."</label>
								</td>
								<td>
								<input style=\"color: white; background-color: #ff6d6d;\" type='submit' id='remove' name='remove' value='Pašalinti'>
								<input type='submit' id='update' name='update' value='Redaguoti'>
								</td>
								</form>
								</tr>";
							}
						}
						}
					} 
					echo "</table>";
					
					
				?>
			</div>
				

	</body>
</html>

			<form action='register_bundleGame.php' method="POST">
				<div class="input-group">
					<input type="submit" id="add" name="add" value="Pridėti žaidimą į kolekciją" />
				</div>
			</form>
			<form action='buhalter.php' method="POST">
				<div class="input-group">
					<input type="submit" value="Grizti" />
				</div>
			</form>