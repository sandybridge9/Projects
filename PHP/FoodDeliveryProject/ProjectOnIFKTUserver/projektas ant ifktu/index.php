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
			width: 100px;
			height: 100px;
		}
		
		</style>
		<link rel="stylesheet" type="text/css" href="tableStyle.css">
		
	<head>
	
	<body>
		<div class= "title">
			<a href ="index.php">Maisto užsakymų svetainė</a>
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
						echo"
						<div class=\"front-page-games\">
						";
							$sql = "SELECT DISTINCT preke.* FROM preke";
							$result = mysqli_query($db, $sql);	
						echo"
							<table>
							<tr>
							<th>Nuotrauka</th>
							<th>Pavadinimas</th>
							<th>Fasuotė</th>
							<th>Kaina(€)</th>
							<th>Svoris(g.)</th>
							<th>		</th>
							</tr>
							";
							//$rowCount = 1;
							while($row = mysqli_fetch_assoc($result))
							{
								$id = $row['id'];
								//echo"$id";
								echo"
								<tr>
								<td><img src=".$row['nuotrauka']."></td>
								<td>".$row['pavadinimas']."</td>
								<td>".$row['fasuote']."</td>
								<td>".$row['kaina']." Eur. </td>
								<td>".$row['svoris']." g. </td>
								<td>
								<form action='cart_add.php' method='POST'> 
								<input type=\"hidden\" name=\"id\" value=".$row['id'].">
								<input type='submit' id='add' name='add' value='Pridėti prie krepšelio'>
								</form>
								</td>
								</tr>
								";
							} 
								
							echo"
							
							</table>
						</div>
						";
					}
					elseif($_SESSION['user_level'] == "administratorius"){
						echo "
						<div class=\"llu\">
							<a href=\"admin.php\"> Admin </a>
							<a href=\"logout.php\"> Logout </a>
						</div>
						";
						echo"
						<div class=\"front-page-games\">
						";
							$sql = "SELECT DISTINCT preke.* FROM preke";
							$result = mysqli_query($db, $sql);	
						echo"
							<table>
							<tr>
							<th>Nuotrauka</th>
							<th>Pavadinimas</th>
							<th>Fasuotė</th>
							<th>Kaina(€)</th>
							<th>Svoris(g)</th>
							<th>		</th>
							</tr>
							";
							//$rowCount = 1;
							while($row = mysqli_fetch_assoc($result))
							{
								$id = $row['id'];
								//echo"$id";
								echo"
								<tr>
								<td><img src=".$row['nuotrauka']."></td>
								<td>".$row['pavadinimas']."</td>
								<td>".$row['fasuote']."</td>
								<td>".$row['kaina']." Eur. </td>
								<td>".$row['svoris']." g. </td>
								<td>
								<form action='product_edit_remove.php' method='POST'> 
								<input type=\"hidden\" name=\"prekes_id\" value=".$row['id'].">
								<input type='submit' style=\"background-color: red;\" id='remove' name='remove' value='Šalinti'>
								<input type='submit' id='edit' name='edit' value='Redaguoti'>
								</form>
								</td>
								</tr>
								";
							} 
								
							echo"
							</table>
							</div>
							";
					}
					elseif($_SESSION['user_level'] == "isveziotojas"){
						echo "
						<div class=\"llu\">
							<a href=\"transporting_list.php\"> Išvežiotojo bagažas </a>
							<a href=\"profile.php\"> $username </a>
							<a href=\"logout.php\"> Logout </a>
						</div>
						";
						echo"
						<div class=\"front-page-games\">
						";
							$sql = "SELECT * FROM uzsakyta_preke";
							$result = mysqli_query($db, $sql);	
						echo"
							<table>
							<tr>
							<th>Nuotrauka</th>
							<th>Pavadinimas</th>
							<th>Miestas</th>
							<th>Adresas</th>
							<th>Užsakytas kiekis(vnt.)</th>
							<th>Svoris(g.)</th>
							<th>		</th>
							</tr>
						";
						while($row = mysqli_fetch_assoc($result))
						{
							$prekesId = $row['prekes_id'];
							$sql1 = "SELECT * FROM preke WHERE id = ".$prekesId."";
							$result1 = mysqli_query($db, $sql1);
							$preke = mysqli_fetch_assoc($result1);
							$uzsakymoId = $row['uzsakymo_id'];
							$sql2 = "SELECT * FROM uzsakymas WHERE id = ".$uzsakymoId."";
							$result2 = mysqli_query($db, $sql2);
							$uzsakymas = mysqli_fetch_assoc($result2);
							echo"
							<tr>
							<td><img src=".$preke['nuotrauka']."></td>
							<td>".$preke['pavadinimas']."</td>
							<td>".$uzsakymas['miestas']."</td>
							<td>".$uzsakymas['adresas']."</td>
							<td>".$row['kiekis']." vnt. </td>
							<td>".$preke['svoris']." g. </td>
							<td>
							<form action='transporting_add.php' method='POST'> 
							<input type=\"hidden\" name=\"uzsakymo_id\" value=".$row['uzsakymo_id'].">
							<input type=\"hidden\" name=\"prekes_id\" value=".$row['prekes_id'].">
							<input type='submit' style=\"background-color: green;\" id='transport' name='transport' value='Vežti prekę'>
							<input type='submit' style=\"background-color: blue;\"  id='transport_all' name='transport_all' value='Vežti visas vartotojo prekes'>
							</td>
							</form>
							</tr>
							";
						} 				
						echo"				
							</table>
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
		<?php /*
		
			$sql = "SELECT DISTINCT preke.* FROM preke";
			$result = mysqli_query($db, $sql);	
		echo"
			<table>
			<tr>
			<th>Nuotrauka</th>
			<th>Pavadinimas</th>
			<th>Fasuotė</th>
			<th>Kaina(€)</th>
			<th>Svoris(g)</th>
			<th>		</th>
			</tr>
			";
			//$rowCount = 1;
			while($row = mysqli_fetch_assoc($result))
			{
				$id = $row['id'];
				//echo"$id";
				echo"
				<tr>
				<td><img src=".$row['nuotrauka']."></td>
				<td>".$row['pavadinimas']."</td>
				<td>".$row['fasuote']."</td>
				<td>".$row['kaina']." Eur. </td>
				<td>".$row['svoris']." g. </td>
				<td>
				<form action='cart_add.php' method='POST'> 
				<input type=\"hidden\" name=\"id\" value=".$row['id'].">
				<input type='submit' id='add' name='add' value='Pridėti prie krepšelio'>
				</form>
				</td>
				</tr>
				";
			} 
				
			echo"
			
			</table>
			";*/ 
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