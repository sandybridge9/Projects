<!DOCTYPE html>
<?php session_start(); ?>
<html>
	<head>
		<title>Maisto užsakymų svetainė</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="tableStyle.css">

		<style>
		img {
			width: 100px;
			height: 100px;
		}
		</style>

	<head>
	
	<body>
	<div class= "title">
			<a href ="index.php"> Maisto užsakymų svetainė </a>
	</div>
		<div>		
			<?php
				if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
					$username = $_SESSION['username'];
					if($_SESSION['user_level'] == "isveziotojas"){
						echo "
						<div class=\"llu\">
							<a href=\"transporting_list.php\"> Išvežiotojo bagažas </a>
							<a href=\"profile.php\"> $username </a>
							<a href=\"logout.php\"> Logout </a>
						</div>
						";
					}
					$db = mysqli_connect("localhost", "root", "", "it") or die("Unable to connect to db");
					if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($db)); }
				}else{
					echo "
						<div class=\"llu\">
							<a href=\"login.php\"> Login </a>
							<a href=\"register.php\"> Register </a>
						</div>
					";
				}
			?>	
	</div>
	<div class="front-page-games">
		<?php
			$user_id = $_SESSION['user_id'];

			$sql1 = "SELECT * FROM transportas WHERE vairuotojo_id = ".$user_id."";
			$result1 = mysqli_query($db, $sql1);
			$transportas = mysqli_fetch_assoc($result1);
			$transportoId = $transportas['id'];

			$sql = "SELECT * FROM transportuojama_preke WHERE transporto_id = ".$transportoId."";
			$result = mysqli_query($db, $sql);

			echo "
			<h3> Transporto bagažas </h3>
			<table>
			<tr>
			<th>Nuotrauka</th>
			<th>Pavadinimas</th>
			<th>Miestas</th>
			<th>Adresas</th>
			<th>Kiekis(vnt.)</th>
			<th>Bendras svoris (g.) </th>
			<th>		</th>
			</tr>
						
			";
			while($row = mysqli_fetch_assoc($result)){
				$prekesId = $row['prekes_id'];
				$kiekis = $row['kiekis'];
				$sqlPreke = "SELECT * FROM preke WHERE id = ".$prekesId."";
				$resultPreke = mysqli_query($db, $sqlPreke);
				$rowPreke = mysqli_fetch_assoc($resultPreke);
				$svoris = $rowPreke['svoris'];
				$bendrasSvoris = $svoris * $kiekis;
				$uzsakymoId = $row['uzsakymo_id'];

				$sql2 = "SELECT * FROM uzsakymas WHERE id = ".$uzsakymoId."";
				$result2 = mysqli_query($db, $sql2);
				$uzsakymas = mysqli_fetch_assoc($result2);
				$miestas = $uzsakymas['miestas'];
				$adresas = $uzsakymas['adresas'];
				


				echo "
				<tr>
				<form action=\"transport_remove.php\" method='POST'> 
				<td><img src=".$rowPreke['nuotrauka']."></td>
				<td>".$rowPreke['pavadinimas']."</td>
				<input type=\"hidden\" name=\"prekes_id\" value=".$prekesId.">
				<td>".$miestas."</td>
				<input type=\"hidden\" name=\"uzsakymo_id\" value=".$uzsakymoId.">
				<td>".$adresas."</td>
				<td>".$kiekis." vnt. </td>
				<td>".$bendrasSvoris." g. </td>
				<td>
				<input style=\"color: white; background-color: #ff6d6d;\" type='submit' id='remove' name='remove' value='Pašalinti'>
				</td>
				</form>
				</tr>
				";
			}
			echo "</table>";
			echo "
			<form action=\"transport_remove_all.php\" method='POST'>
			<input type='submit' id='begin' name='begin' value='Vežti'>
			</form> ";
		?>
	</div>
	</body>
</html>