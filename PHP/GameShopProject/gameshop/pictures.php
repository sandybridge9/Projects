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
		display: block;
		max-width:300px;
		max-height:100px;
		}	

		div {
			width: 160px;
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
				}
			?>
			
		</div>

		<br>
		<br>

		<div class= "title">
			GALLERY
		</div>

		<br>
		
		<div class="pictures">
		<?php
		if(isset($_POST['open'])){
			$gallery_id = $_POST['id'];
			$sql = "SELECT * FROM nuotrauka WHERE fk_nuotrauku_galerija = ".$gallery_id."";
			$result = mysqli_query($db, $sql);
			if ($result){
			echo"
			<table>
			";
			$rowCount = 1;
			while($row = mysqli_fetch_assoc($result))
			{
				if($rowCount % 8 == 0){
					echo"<tr> </tr>";
				}
				echo"
				<th>
					<div class=\"game\">
						<p> ".$row['data']." </p>
						<img src=".$row['nuoroda'].">
						<form action='remove_picture.php' method='POST'> 
						<input type=\"hidden\" name=\"id\" value=".$row['id'].">
						<input type='submit' id='remove' name='remove' value='Remove picture'>
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
		}
		?>
		</div>	

		<br>

		<div class="add-picture">
			<?php
			$gallery_id = $_POST['id'];
			echo"
			<form action='add_picture.php' method='POST'> 
			Picture:
			<br>
			<input type='text' name='link'>
			<br>
			<input type=\"hidden\" name=\"id\" value=".$gallery_id.">
			<input type='submit' name='add' value='Add'>
			</form>";
			?>
		</div>
		
	</body>
</html>