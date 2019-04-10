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
					if($_SESSION['user_level'] == "vartotojas"){
						echo "
						<div class=\"llu\">
							<a href=\"cart.php\"> Krepšelis </a>
							<a href=\"profile.php\"> $username </a>
							<a href=\"logout.php\"> Logout </a>
						</div>
						";
					}
					$db = mysqli_connect("localhost", "tadlau", "veel0bo6shiuJ3Ch", "tadlau") or die("Unable to connect to db");
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
			$sql = "SELECT * FROM krepselio_preke WHERE vartotojo_id = ".$user_id."";
			$result = mysqli_query($db, $sql);
			echo "
			<h3> Prekių krepšelis </h3>
			<table>
			<tr>
			<th>Nuotrauka</th>
			<th>Pavadinimas</th>
			<th>Fasuotė</th>
			<th>Kaina(€)</th>
			<th>Svoris(g)</th>
			<th>Kiekis(vnt.)</th>
			<th>		</th>
			</tr>
						
			";
			while($row = mysqli_fetch_assoc($result)){
				$prekesId = $row['prekes_id'];
				$sqlPreke = "SELECT * FROM preke WHERE id = ".$prekesId."";
				$resultPreke = mysqli_query($db, $sqlPreke);
				$rowPreke = mysqli_fetch_assoc($resultPreke);

				echo "
				<tr>
				<form action=\"cart_edit_remove.php\" method='POST'> 
				<td><img src=".$rowPreke['nuotrauka']."></td>
				<td>".$rowPreke['pavadinimas']."</td>
				<input type=\"hidden\" name=\"prekes_id\" value=".$prekesId.">
				<td>".$rowPreke['fasuote']."</td>
				<input type=\"hidden\" name=\"vartotojo_id\" value=".$user_id.">
				<td>".$rowPreke['kaina']." Eur. </td>
				<td>".$rowPreke['svoris']." g. </td>
				<td>".$row['kiekis']." vnt. </td>
				<td>
				<input style=\"color: white; background-color: #ff6d6d;\" type='submit' id='remove' name='remove' value='Pašalinti'>
				<input type='submit' id='update' name='update' value='Redaguoti'>
				</td>
				</form>
				</tr>
				";
			}
			echo "</table>";
			echo "
			<form action=\"dummy_payment.php\" method='POST'>
			<input type='submit' id='order' name='order' value='Užsakyti'>
			</form> ";
		?>
	</div>
	</body>
</html>