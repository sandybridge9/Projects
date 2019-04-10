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
				}
			?>
			
		</div>

		<br>
		<br>

		<div class= "title">
			FAVORITE GAMES
		</div>

		<br>
		
		<div class="user-games">
		<?php
			$sql = "SELECT * FROM vartotojo_profilis WHERE fk_vartotojas = ".$_SESSION['user_id']."";
			$result = mysqli_query($db, $sql);

			$row = mysqli_fetch_assoc($result);

			$userId = $row['id'];//$_SESSION['user_id'];
			$sql = "SELECT * FROM megstamiausiu_zaidimu_sarasas_zaidimas INNER JOIN megstamiausiu_zaidimu_sarasas ON fk_megstamiausiu_zaidimu_sarasas = id WHERE fk_vartotojo_profilis = ".$userId."";
			$result = mysqli_query($db, $sql);
			if ($result){
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
				if($rowCount % 8 == 0){
					echo"<tr> </tr>";
				}
				echo"
				<th>
					<div class=\"game\">
						<p> ".$game['pavadinimas']." </p>
						<img src=".$game['virselio_nuoroda'].">
						<form action='write_review.php' method='POST'> 
						<input type=\"hidden\" name=\"id\" value=".$game['id'].">
						<input type='submit' id='write' name='write' value='Write review'>
						</form>
						<form action='remove_from_favourites.php' method='POST'> 
						<input type=\"hidden\" name=\"id\" value=".$game['id'].">
						<input type='submit' id='remove' name='remove' value='Remove from favourites'>
						</form>
					</div>
				</th>
				";
				$rowCount = $rowCount + 1;
			}
			}	 	
			echo"
			</table>
			";
			?>
		</div>	
		
	</body>
</html>