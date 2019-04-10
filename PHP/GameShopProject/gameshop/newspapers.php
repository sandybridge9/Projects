<!DOCTYPE html>
<?php 
	session_start(); 
	
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false){
		header('Location: index.php');
		die("Negalima");
	}else{
		if($_SESSION['user_level'] != "administratorius"){
			echo "<script type='text/javascript'>
				var answer = confirm (\"Neturite teisių šiai funkcijai\")
				if (answer)
				window.location = 'http://localhost/gameshop/index.php';
				else
				window.location = 'http://localhost/gameshop/index.php';

		</script>";
		}
		$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
		if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($db)); }
	}
	
?>
<html>
	<head>
		<title>Game Shop</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<style>
		img {
			width: 20%;
			height: 20%;
		}
		img:hover {
		width: 50%;
		height: 50%;
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
	
			
			<div class="items-position">
			<div class="shop-items">
				<?php
					$sql = "SELECT * FROM naujienlaiskis";
					$result = mysqli_query($db, $sql);	
					
					
					echo "
						<h3> Naujienlaiškiai </h3>
						<table>
						<tr>
						<th>Pavadinimas</th>
						<th>Pranešimas</th>
						<th>Data</th>
						<th>Žaidimas</th>
						<th>		</th>
						</tr>
						
					";
					while($row = mysqli_fetch_assoc($result))
					{
						$sqlZaidimas = "SELECT * FROM zaidimas WHERE id = ".$row['fk_zaidimas']."";
						$resultZaidimas = mysqli_query($db, $sqlZaidimas);
						$rowZaidimas = mysqli_fetch_assoc($resultZaidimas);
						
						//echo $rowPirkejas['vardas'];
						echo " 
						<tr>
						<form action=\"edit_remove_newspaper.php\" method='POST'> 
						
						<td>
						<label>".$row['pavadinimas']."</label>
						<input type=\"hidden\" name=\"pavadinimas\" value=".$row['pavadinimas'].">
						</td>
						
						<td>
						<label>".$row['pranesimas']."</label>
						<input type=\"hidden\" name=\"pranesimas\" value=".$row['pranesimas'].">
						</td>
						
						<td>
						<label>".$row['data']."</label>
						<input type=\"hidden\" name=\"data\" value=".$row['data'].">
						</td>
										
						<td>
						<label>".$rowZaidimas['pavadinimas']."</label>
						<input type=\"hidden\" name=\"fk_zaidimas\" value=".$row['fk_zaidimas'].">
						<input type=\"hidden\" name=\"id\" value=".$row['id'].">
						</td>
						
						<td>
						<input style=\"color: white; background-color: #ff6d6d;\" type='submit' id='remove' name='remove' value='Pašalinti'>
						<input type='submit' id='update' name='update' value='Redaguoti'>
						<input style=\"color: white; background-color: green;\" type='submit' id='send' name='send' value='Siųsti'>
						</td>
						</form>
						</tr>
						";
					}  
					echo "</table>";
					
				?>
			</div>
			</div>
			
			<div>
			<form action='register_newspaper.php' method="POST">
					<div class="input-group">
					<input type="submit" id="add" name="add" value="Pridėti naują naujienlaiškį" />
				</div>
			</form>
			</div>
				

	</body>
</html>

			