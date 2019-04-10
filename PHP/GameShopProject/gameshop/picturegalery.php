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
			PICTURE GALLERIES
		</div>

		<br>
		
		<div class="galleries">
		<?php
			$userId = $_SESSION['user_id'];
			$sql = "SELECT * FROM vartotojo_profilis WHERE fk_vartotojas = ".$_SESSION['user_id']."";
			$result = mysqli_query($db, $sql);

			$row = mysqli_fetch_assoc($result);

			$sql = "SELECT * FROM nuotrauku_galerija WHERE fk_vartotojo_profilis = ".$row['id']."";
			$result = mysqli_query($db, $sql);
			if ($result){
			echo"
			<table>
			";
			$rowCount = 1;
			while($row = mysqli_fetch_assoc($result))
			{
				echo"
				<tr>
					<div class=\"game\">
						<p> ".$row['pavadinimas']." </p>
						<form action='pictures.php' method='POST'> 
						<input type=\"hidden\" name=\"id\" value=".$row['id'].">
						<input type='submit' id='open' name='open' value='Open'>
						<form action='remove_gallery.php' method='POST'> 
						<input type=\"hidden\" name=\"id\" value=".$row['id'].">
						<input type='submit' id='remove' name='remove' value='Remove'>
						</form>
					</div>
				</tr>
				";
			}
			}	 	
			echo"
			</table>
			";
			?>
		</div>	

		<br>

		<div class="add-gallery">
			<?php
			echo"
			<form action='add_gallery.php' method='POST'> 
			New gallery name: <input type='text' name='gname'>
			<input type='submit' name='add' value='Add'>
			</form>";
			?>
		</div>
		
	</body>
</html>