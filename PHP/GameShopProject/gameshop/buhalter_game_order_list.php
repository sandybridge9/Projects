<!DOCTYPE html>
<?php 
	session_start(); 
	
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false){
		header('Location: index.php');
		die("Negalima");
	}else{
		if($_SESSION['user_level'] != "buhalteris"){
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
		<div class="middle-element">
		<a href ="index.php"> Game Shop </a>
		</div>	
			
			<div class="items-position">
			<div class="shop-items">
				<?php
					$sql = "SELECT * FROM uzsakymas";
					$result = mysqli_query($db, $sql);	
					
					
					echo "
						<h3> Užsakymas </h3>
						<table>
						<tr>
						<th>Id</th>
						<th>Uzsakymo_data</th>
						<th>Kaina</th>
						<th>Apmoketa</th>
						<th>Pirkejas</th>
						<th>Mokejimas</th>
						<th>		</th>
						</tr>
						
					";
					/*
					
										<td>
						<label>".$row['email']."</label>
						<input type=\"hidden\" name=\"email\" value=".$row['email'].">
						</td>
						<td>
						<p style=\"font-size:10px;\">1-pirkėjas, 2-admin, 3-darbuotojas</p>
						<input type=\"text\" name=\"user_level\" value=".$row['user_level'].">
						<input type=\"hidden\" name=\"id\" value=".$row['id'].">
						</td>
					
					
					*/
					while($row = mysqli_fetch_assoc($result))
					{
						$sqlPirkejas = "SELECT * FROM vartotojas WHERE id = ".$row['fk_vartotojas']."";
						$resultPirkejas = mysqli_query($db, $sqlPirkejas);
						$rowPirkejas = mysqli_fetch_assoc($resultPirkejas);
						
						
						
						if($row['apmoketa'] == 0){
							$apmoketa = "Neapmokėta";
						}else{
							$apmoketa = "Apmokėta";
						}
						
						//echo $rowPirkejas['vardas'];
						echo " 
						<tr>
						<form action=\"\" method='POST'> 
						
						<td>
						<label>".$row['id']."</label>
						<input type=\"hidden\" name=\"id\" value=".$row['id'].">
						</td>
						
						<td>
						<label>".$row['uzsakymo_data']."</label>
						<input type=\"hidden\" name=\"uzsakymo_data\" value=".$row['uzsakymo_data'].">
						</td>
						
						<td>
						<label>".$row['kaina']."</label>
						<input type=\"hidden\" name=\"kaina\" value=".$row['kaina'].">
						</td>
						
						<td>
						<label>".$apmoketa."</label>
						<input type=\"hidden\" name=\"apmoketa\" value=".$row['apmoketa'].">
						</td>
						
						<td>
						<label>".$rowPirkejas['vardas']."</label>
						<input type=\"hidden\" name=\"fk_kurejas\" value=".$row['fk_vartotojas'].">
						<input type=\"hidden\" name=\"id\" value=".$row['id'].">
						</td>
						
						<td>
						<label>".$row['fk_mokejimas']."</label>
						<input type=\"hidden\" name=\"fk_mokejimas\" value=".$row['fk_mokejimas'].">
						</td>
						</form>
						</tr>
						";
					}  
					//						<label>".$row['user_level']."</label>
					//	<input type=\"hidden\" name=\"user_level\" value=".$row['user_level'].">
					echo "</table>";
					
				?>
			</div>
			</div>		
	</body>
</html>

			