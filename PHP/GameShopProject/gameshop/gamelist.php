<!DOCTYPE html>
<?php session_start(); 
$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
		if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($db)); }
?>
<html>
	<head>
		<title>Game shop</title>
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
			GAMES LIST
		</div>

		<br>
		
		<div class="user-games">
		<?php
			$userId = $_SESSION['user_id'];
			$sql = "SELECT * FROM zaidimas_vartotojas WHERE fk_vartotojas = ".$userId."";
			$result = mysqli_query($db, $sql);	
			echo"
			<table>
			";
			$rowCount = 1;
			while($row = mysqli_fetch_assoc($result))
			{
				$gameId = $row['fk_zaidimas'];
				$sql2 = "SELECT * FROM zaidimas WHERE id = ".$gameId."";
				$result2 = mysqli_query($db, $sql2);
				$game = mysqli_fetch_assoc($result2);

				$sql3 = "SELECT * FROM megstamiausiu_zaidimu_sarasas_zaidimas INNER JOIN megstamiausiu_zaidimu_sarasas ON fk_megstamiausiu_zaidimu_sarasas = id WHERE fk_vartotojo_profilis = ".$userId." AND fk_zaidimas = ".$gameId."";
				$result3 = mysqli_query($db, $sql3);
				$game2 = mysqli_fetch_assoc($result2);

				$sql4 = "SELECT * FROM atsiliepimas WHERE fk_vartotojo_profilis = ".$userId." AND fk_zaidimas = ".$gameId."";
				$result4 = mysqli_query($db, $sql4);
				$game3 = mysqli_fetch_assoc($result2);				

				if($rowCount % 8 == 0){
					echo"<tr> </tr>";
				}
				echo"
				<th>
					<div class=\"game\">
						<p> ".$game['pavadinimas']." </p>
						<img src=".$game['virselio_nuoroda'].">";
						if ($game3['fk_zaidimas'] != $game['id']){
						echo"
						<form action='write_review.php' method='POST'> 
						<input type=\"hidden\" name=\"id\" value=".$game['id'].">
						<input type='submit' id='write' name='write' value='Write review'>
						</form>";
						}
						if ($game2['fk_zaidimas'] != $game['id']){
						echo"
						<form action='add_to_favourites.php' method='POST'> 
						<input type=\"hidden\" name=\"id\" value=".$game['id'].">
						<input type='submit' id='add' name='add' value='Add to favourites'>
						</form>";
						}
					echo"
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