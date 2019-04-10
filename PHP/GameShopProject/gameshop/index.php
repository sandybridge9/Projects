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
		
		<div class="front-page-games">
		<?php
		
			$sql = "SELECT DISTINCT zaidimas.* FROM zaidimas";
			$result = mysqli_query($db, $sql);	
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
						<p> ".$row['pavadinimas']." </p>
						<img src=".$row['virselio_nuoroda'].">
						<p> ".$row['kaina']." Eur. </p>
					</div>
					<form action='cart_add.php' method='POST'> 
					<input type=\"hidden\" name=\"id\" value=".$row['id'].">
					<input type='submit' id='add' name='add' value='Add to cart'>
					</form>
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
<!--
					<tr>
					<th>
						<div class=\"game\">
							<p> GTA 5 </p>
							<img src=\"https://images.g2a.com/newlayout/323x433/1x1x0/387a113709aa/59e5efeb5bafe304c4426c47\">
						</div>
						<a href=\"cart_add.php\">Add to cart</a>
					</th>
					<th>
						<div class=\"game\">
							<p>League of legends</p>
							<img src=\"https://news-a.akamaihd.net/public/images/misc/GameBox.jpg\">
						</div>
						<a href=\"cart_add.php\">Add to cart</a>
					</th>
					<th>
						<div class=\"game\">
							<p>Dishonored </p>
							<img src=\"https://upload.wikimedia.org/wikipedia/en/thumb/6/65/Dishonored_box_art_Bethesda.jpg/220px-Dishonored_box_art_Bethesda.jpg\">
						</div>
						<a href=\"cart_add.php\">Add to cart</a>
					</th>
				</tr>";
				-->