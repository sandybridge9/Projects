<!DOCTYPE html>
<?php session_start(); 
$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
		if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($db)); }
?>
<html>
	<head>
		<title>Game shop</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	<head>
	
	<style>
		h3 {
			text-align: center;
		}
		
	</style>
	
	<body>
		<div class= "title">
			<a href ="index.php"> GAME SHOP </a>
		</div>
		<div>		
			<?php
				if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
					$username = $_SESSION['username'];
					if($_SESSION['user_level'] == "registruotas_vartotojas"){
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
					elseif($_SESSION['user_level'] == "buhalteris"){
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

		<br>
		<br>

		<div class= "title">
			ACHIEVEMENTS
		</div>

		<br>

		<div class="achievements">
		<?php

			$sqlv = "SELECT * FROM vartotojo_profilis WHERE fk_vartotojas = ".$_SESSION['user_id']."";
			$resultv = mysqli_query($db, $sqlv);
			$profile = mysqli_fetch_assoc($resultv);
			$profileId = $profile['id'];

			$userId = $_SESSION['user_id'];
			$sql = "SELECT * FROM pasiekimas_vartotojo_profilis WHERE fk_vartotojo_profilis = ".$profileId."";
			$result = mysqli_query($db, $sql);	
			echo"
			<table>
			";
			$rowCount = 1;
			while($row = mysqli_fetch_assoc($result))
			{
				$achievementId = $row['fk_pasiekimas'];
				$sql2 = "SELECT * FROM pasiekimas WHERE id = ".$achievementId."";
				$result2 = mysqli_query($db, $sql2);
				$achievement = mysqli_fetch_assoc($result2);

				if($rowCount % 8 == 0){
					echo"<tr> </tr>";
				}
				echo"
				<th>
					<div class=\"game\">
						<h1> ".$achievement['pavadinimas']." </h1>
						<p> ".$achievement['aprasymas']." </p>
						<br>
						<p> ".$achievement['isigyjimo_data']." </p>
					</div>
				</th>
				";
				$rowCount = $rowCount + 1;
			} 	
			echo"
			</table>
			";
			?>
		</div>	
	</body>
</html>
</html>