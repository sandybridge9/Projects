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
		<div class="middle-element">
		<a href ="index.php"> Game Shop </a>
		</div>	
			
			<div class="items-position">
			<div class="shop-items">
				<?php
					$sql = "SELECT * FROM vartotojas WHERE id != ".$_SESSION['user_id']."";
					$result = mysqli_query($db, $sql);	
					echo "
						<h3> Vartotojai </h3>
						<table>
						<tr>
						<th>Vardas</th>
						<th>Pavarde</th>
						<th>Gimimo data</th>
						<th>Prisijungimo Vardas</th>
						<th>E. Paštas</th>
						<th>Vartotojo lygis</th>
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
						echo " 
						<tr>
						<form action='' method='POST'> 
						<td>
						<label>".$row['vardas']."</label>
						<input type=\"hidden\" name=\"vardas\" value=".$row['vardas'].">
						</td>
						<td>
						<label>".$row['pavarde']."</label>
						<input type=\"hidden\" name=\"pavarde\" value=".$row['pavarde'].">
						</td>
						<td>
						<label>".$row['gimimo_data']."</label>
						<input type=\"hidden\" name=\"gimimo_data\" value=".$row['gimimo_data'].">
						</td>
						<td>
						<label>".$row['prisijungimo_vardas']."</label>
						<input type=\"hidden\" name=\"prisijungimo_vardas\" value=".$row['prisijungimo_vardas'].">
						</td>
						<td>
						<label>".$row['el_pastas']."</label>
						<input type=\"hidden\" name=\"el_pastas\" value=".$row['el_pastas'].">
						</td>
						<td>
						<label>".$row['vartotojo_lygis']."</label>
						<input type=\"hidden\" name=\"vartotojo_lygis\" value=".$row['vartotojo_lygis'].">
						<input type=\"hidden\" name=\"id\" value=".$row['id'].">
						</td>
						<td>
						<input style=\"color: white; background-color: #ff6d6d;\" type='submit' id='remove' name='remove' value='Pašalinti'>
						</td>
						</form>
						</tr>
						";
					}  
					//						<label>".$row['user_level']."</label>
					//	<input type=\"hidden\" name=\"user_level\" value=".$row['user_level'].">
					echo "</table>";
					if(isset($_POST['remove'])){
						$id = $_POST['id'];
						$resutl = mysqli_query($db, "DELETE from vartotojas WHERE id = ".$id." ");
						$_POST = null;
						echo "
						<script type='text/javascript'>
						var answer = confirm (\"Sėkmingai pašalinote Vartotoj1\")
						if (answer)
						window.location = 'http://localhost/gameshop/admin_users_edit.php';
						else
						window.location = 'http://localhost/gameshop/admin_users_edit.php';
						</script>";
					}
				?>
			</div>
			</div>
				

	</body>
</html>