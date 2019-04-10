<!DOCTYPE html>
<?php session_start(); ?>
<html>
	<head>
		<title>Game shop</title>
		<link rel="stylesheet" type="text/css" href="style.css">
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
					$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
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
	<div class="items-position">
			<div class="shop-items">
				<?php
					$sql = "SELECT * FROM uzsakymas_zaidimas";
					$result = mysqli_query($db, $sql);
					echo "
						<h3> Žaidimų krepšelis </h3>
						<table>
						<tr>
						<th>Uzsakymas</th>
						<th>Zaidimas</th>
						<th>		</th>
						</tr>
						
					";
					while($row = mysqli_fetch_assoc($result))
					{
						$sqlUzsakymas = "SELECT * FROM uzsakymas WHERE id = ".$row['fk_uzsakymas']."";
						$resultUzsakymas = mysqli_query($db, $sqlUzsakymas);
						$rowUzsakymas = mysqli_fetch_assoc($resultUzsakymas);

						$sqlZaidimas = "SELECT * FROM zaidimas WHERE id = ".$row['fk_zaidimas']."";
						$resultZaidimas = mysqli_query($db, $sqlZaidimas);
						$rowZaidimas = mysqli_fetch_assoc($resultZaidimas);

						echo " 
						<tr>
						<form action=\"cart_edit_remove.php\" method='POST'> 

						<td>
						<label>".$rowUzsakymas['uzsakymo_data']."</label>
						<input type=\"hidden\" name=\"fk_uzsakymas\" value=".$row['fk_uzsakymas'].">
						</td>
						
						<td>
						<label>".$rowZaidimas['pavadinimas']."</label>
						<input type=\"hidden\" name=\"fk_zaidimas\" value=".$row['fk_zaidimas'].">
						</td>
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
					<form action=\"cart_buy.php\" method='POST'>
					<input type='submit' id='buy' name='buy' value='Pirkti'>
					</form> ";
				?>
			</div>
	</div>
	</body>
</html>