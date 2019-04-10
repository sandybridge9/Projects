<!DOCTYPE html>
<?php session_start(); 
$db = mysqli_connect("localhost", "tadlau", "veel0bo6shiuJ3Ch", "tadlau") or die("Unable to connect to db");
		if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($db)); }
?>
<html>
	<head>
		<title>Maisto užsakymų svetainė</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<style>
		img {
			width: 130;
			height: 100px;
		}
		
		</style>
		<link rel="stylesheet" type="text/css" href="tableStyle.css">
		
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
					elseif($_SESSION['user_level'] == "administratorius"){
						echo "
						<div class=\"llu\">
							<a href=\"admin.php\"> Admin </a>
							<a href=\"profile.php\"> $username </a>
							<a href=\"logout.php\"> Logout </a>
						</div>
						";
					}
					elseif($_SESSION['user_level'] == "isveziotojas"){
						echo "
						<div class=\"llu\">
							<a href=\"buhalter.php\"> Buhalter stuff </a>
							<a href=\"profile.php\"> $username </a>
							<a href=\"logout.php\"> Logout </a>
						</div>
						";
					}
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
			$userId = $_SESSION['user_id'];
			$sql = "SELECT * FROM uzsakyta_preke WHERE vartotojo_id = ".$userId."";
			$result = mysqli_query($db, $sql);
			echo"
				<div class=\"front-page-games\">
			";
			echo"
				<table>
				<tr>
				<th>Nuotrauka</th>
				<th>Pavadinimas</th>
				<th>Fasuotė</th>
				<th>Kaina(€)</th>
				<th>Svoris(g.)</th>
				<th>Užsakytas kiekis(vnt.)</th>
				</tr>
			";
			while($row = mysqli_fetch_assoc($result))
			{
				$prekesId = $row['prekes_id'];
				$sql1 = "SELECT * FROM preke WHERE id = ".$prekesId."";
				$result1 = mysqli_query($db, $sql1);
				$preke = mysqli_fetch_assoc($result1);
				echo"
				<tr>
				<td><img src=".$preke['nuotrauka']."></td>
				<td>".$preke['pavadinimas']."</td>
				<td>".$preke['fasuote']."</td>
				<td>".$preke['kaina']." Eur. </td>
				<td>".$preke['svoris']." g. </td>
				<td>".$row['kiekis']." vnt. </td>
				</tr>
				";
			} 				
			echo"				
				</table>
				</div>
			";
		?>
		</div>	
	</body>
</html>