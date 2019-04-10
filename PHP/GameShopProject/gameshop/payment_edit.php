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
		<link rel="stylesheet" type="text/css" href="tableStyle.css">
	<head>
	
	<body>
	<div class= "title">
			<a href ="index.php"> GAME SHOP </a>
	</div>
		<div>		
			<?php
			$username = $_SESSION['username'];
			echo "
			<div class=\"llu\">
				<a href=\"buhalter.php\"> Buhalter stuff </a>
				<a href=\"profile.php\"> $username </a>
				<a href=\"logout.php\"> Logout </a>
			</div>
			";
				
			?>
		</div>
		<h4>Redagavimas</h4>
			
		
			<div>
				<?php	
					$sql1 = "SELECT * FROM mokejimo_budas";
					$result1 = mysqli_query($db, $sql1);
					echo "
						<h3> Mokėjimo budai </h3>
						<table>
						<tr>
						<th> Nr. </th>
						<th> Pavadinimas </th>
						<th>		</th>
						</tr>
						
					";
					$index = 1;
					while($row = mysqli_fetch_assoc($result1))
					{
						echo " 
						<tr>
						<form action='edit_remove_payment.php' method='POST'> 
						<td>
						<label>".$index."</label>
						</td>
						<td>
						<label>".$row['pavadinimas']."</label>
						<input type=\"hidden\" name=\"pavadinimas\" value=".$row['pavadinimas'].">
						<input type=\"hidden\" name=\"id\" value=".$row['id'].">
						</td>
						<td>
						<input style=\"color: white; background-color: #ff6d6d;\" type='submit' id='remove' name='remove' value='Pašalinti'>
						<input type='submit' id='update' name='update' value='Redaguoti'>
						</td>
						</form>
						</tr>
						";
						$index = $index + 1;
					} 
					echo "</table>";
					
					
				?>
			</div>
				

	</body>
</html>

			<form action='register_payment.php' method="POST">
				<div class="input-group">
					<input type="submit" id="add" name="add" value="Pridėti naują mokėjimo būdą" />
				</div>
			</form>
			<form action='buhalter.php' method="POST">
				<div class="input-group">
					<input type="submit" value="Grizti" />
				</div>
			</form>