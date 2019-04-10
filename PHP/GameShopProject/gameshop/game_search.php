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
			width: 120px;
			height: 100px;
		}
		</style>
		<link rel="stylesheet" type="text/css" href="tableStyle.css">
	<head>
	
	<body>
		<div class= "title">
	<a href ="index.php"> GAME SHOP </a>
	</div>
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
			
			<div class="items-position">
			<div class="shop-items">
									<h3> Žaidimaū paieška </h3>
				<form action='' method='POST'> 
				<input type="text" name="searchText"/>
				<input type="checkbox" name="price" value="yes"> Rikuot pagal kainą
				<input type="checkbox" name="count" value="yes"> Rikuot pagal kiekį
				<input type="checkbox" name="countSold" value="yes"> Rikuot pagal parduotų kiekį<br>
				<input type="submit" name="search" value="Filtruoti"/>
				</form>
				
				
				<?php
					if(!isset($_POST['search'])){
	
						$sql = "SELECT DISTINCT zaidimas.*, kurejas.id as kurejo_id, kurejas.pavadinimas as kurejo_avadinimas FROM zaidimas, kurejas GROUP BY zaidimas.id";
						$result = mysqli_query($db, $sql);
					}else{
						if(!empty($_POST['searchText']) || empty($_POST['searchText']) && !isset($_POST['price']) && !isset($_POST['count']) && !isset($_POST['countSold']))
							$sql = "SELECT DISTINCT zaidimas.*, kurejas.id as kurejo_id, kurejas.pavadinimas as kurejo_avadinimas FROM zaidimas, kurejas GROUP BY zaidimas.id";
						elseif(!empty($_POST['searchText']) || empty($_POST['searchText']) && isset($_POST['price']) && !isset($_POST['count']) && !isset($_POST['countSold']))
							$sql = "SELECT DISTINCT zaidimas.*, kurejas.id as kurejo_id, kurejas.pavadinimas as kurejo_avadinimas FROM zaidimas, kurejas GROUP BY zaidimas.id ORDER BY kaina DESC";
						elseif(!empty($_POST['searchText']) || empty($_POST['searchText']) && !isset($_POST['price']) && isset($_POST['count']) && !isset($_POST['countSold']))
							$sql = "SELECT DISTINCT zaidimas.*, kurejas.id as kurejo_id, kurejas.pavadinimas as kurejo_avadinimas FROM zaidimas, kurejas GROUP BY zaidimas.id ORDER BY turimas_kiekis DESC";
						elseif(!empty($_POST['searchText']) || empty($_POST['searchText']) && !isset($_POST['price']) && !isset($_POST['count']) && isset($_POST['countSold']))
							$sql = "SELECT DISTINCT zaidimas.*, kurejas.id as kurejo_id, kurejas.pavadinimas as kurejo_avadinimas FROM zaidimas, kurejas GROUP BY zaidimas.id ORDER BY parduotas_kiekis DESC";
						
							$result = mysqli_query($db, $sql);
					}
					
					
					
					
					
					echo "
						<table>
						<tr>
						<th>pavadinimas</th>
						<th>isleidimo_data</th>
						<th>kaina</th>
						<th>aprasymas</th>
						<th>virselio_nuoroda</th>
						<th>turimas_kiekis</th>
						<th>parduotas_kiekis</th>
						<th>fk_kurejas</th>
						<th>		</th>
						</tr>
						
					";
					if(!isset($_POST['search']) || empty($_POST['searchText'])){
						while($row = mysqli_fetch_assoc($result))
						{
							$sqlKurejas = "SELECT * FROM kurejas WHERE id = ".$row['fk_kurejas']."";
							$resultKurejas = mysqli_query($db, $sqlKurejas);
							$rowKurejas = mysqli_fetch_assoc($resultKurejas);
							echo " 
							<tr>
							<form action='edit_remove_game.php' method='POST'> 
							<td>
							<label>".$row['pavadinimas']."</label>
							<input type=\"hidden\" name=\"pavadinimas\" value=".$row['pavadinimas'].">
							</td>
							<td>
							<label>".$row['isleidimo_data']."</label>
							<input type=\"hidden\" name=\"isleidimo_data\" value=".$row['isleidimo_data'].">
							</td>
							<td>
							<label>".$row['kaina']."</label>
							<input type=\"hidden\" name=\"kaina\" value=".$row['kaina'].">
							</td>
							<td>
							<label>".$row['aprasymas']."</label>
							<input type=\"hidden\" name=\"aprasymas\" value=".$row['aprasymas'].">
							</td>
							<td>
							<img src=".$row['virselio_nuoroda'].">
							<input type=\"hidden\" name=\"virselio_nuoroda\" value=".$row['virselio_nuoroda'].">
							</td>
							<td>
							<label>".$row['turimas_kiekis']."</label>
							<input type=\"hidden\" name=\"turimas_kiekis\" value=".$row['turimas_kiekis'].">
							</td>
							<td>
							<label>".$row['parduotas_kiekis']."</label>
							<input type=\"hidden\" name=\"parduotas_kiekis\" value=".$row['parduotas_kiekis'].">
							</td>
							<td>
							<label>".$rowKurejas['pavadinimas']."</label>
							<input type=\"hidden\" name=\"fk_kurejas\" value=".$row['fk_kurejas'].">
							<input type=\"hidden\" name=\"id\" value=".$row['id'].">
							</td>
							</form>
							</tr>
							";
						}  
						echo "</table>";
					}else{
						while($row = mysqli_fetch_assoc($result))
						{
							$searchWord = $_POST['searchText'];
							$pav = $row['pavadinimas'];
							
							$searchWord = strtolower($searchWord);
							$pav = strtolower($pav);
							
							if(strpos($pav, $searchWord) !== false){
								$sqlKurejas = "SELECT * FROM kurejas WHERE id = ".$row['fk_kurejas']."";
								$resultKurejas = mysqli_query($db, $sqlKurejas);
								$rowKurejas = mysqli_fetch_assoc($resultKurejas);
								echo " 
								<tr>
								<form action='edit_remove_game.php' method='POST'> 
								<td>
								<label>".$row['pavadinimas']."</label>
								<input type=\"hidden\" name=\"pavadinimas\" value=".$row['pavadinimas'].">
								</td>
								<td>
								<label>".$row['isleidimo_data']."</label>
								<input type=\"hidden\" name=\"isleidimo_data\" value=".$row['isleidimo_data'].">
								</td>
								<td>
								<label>".$row['kaina']."</label>
								<input type=\"hidden\" name=\"kaina\" value=".$row['kaina'].">
								</td>
								<td>
								<label>".$row['aprasymas']."</label>
								<input type=\"hidden\" name=\"aprasymas\" value=".$row['aprasymas'].">
								</td>
								<td>
								<img src=".$row['virselio_nuoroda'].">
								<input type=\"hidden\" name=\"virselio_nuoroda\" value=".$row['virselio_nuoroda'].">
								</td>
								<td>
								<label>".$row['turimas_kiekis']."</label>
								<input type=\"hidden\" name=\"turimas_kiekis\" value=".$row['turimas_kiekis'].">
								</td>
								<td>
								<label>".$row['parduotas_kiekis']."</label>
								<input type=\"hidden\" name=\"parduotas_kiekis\" value=".$row['parduotas_kiekis'].">
								</td>
								<td>
								<label>".$rowKurejas['pavadinimas']."</label>
								<input type=\"hidden\" name=\"fk_kurejas\" value=".$row['fk_kurejas'].">
								<input type=\"hidden\" name=\"id\" value=".$row['id'].">
								</td>
								</form>
								</tr>
								";
							}
						}  
						echo "</table>";
					}			
					
				?>
			</div>
			</div>

	</body>
</html>

			