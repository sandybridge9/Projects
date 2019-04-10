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
							<a href=\"cart.php\"> KrepÅ¡elis </a>
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
			FRIEND REVIEWS
		</div>

		<br>
		
		<div class="user-games">
		<?php
			if(isset($_POST['review'])){
			$userId = $_POST['id'];
			$sql = "SELECT * FROM atsiliepimas WHERE fk_vartotojas = ".$userId."";
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
				if($rowCount % 8 == 0){
					echo"<tr> </tr>";
				}
				echo"
				<th>
					<div class=\"game\">
						<p> ".$game['pavadinimas']." </p>
						<img src=".$game['virselio_nuoroda'].">
						<p> ".$row['tekstas']." </p>
						<p> Ivertinimas: ".$row['ivertinimas']."/10 </p>
					</div>
				</th>
				";
				$rowCount = $rowCount + 1;
			} 	
			echo"
			</table>
			";
			}
			?>
		</div>	
	</body>
</html>