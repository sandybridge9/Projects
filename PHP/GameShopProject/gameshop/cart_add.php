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
		
		<?php
		if(isset($_POST['add'])){
			$id = $_POST['id'];
			//echo "$id";
			$sql = "SELECT * FROM zaidimas WHERE id = ".$id."";
			$result = mysqli_query($db, $sql);
			$rowZaidimas = mysqli_fetch_assoc($result);
			
			$orderId = $rowZaidimas['id'];
			echo "$orderId";
			$userId = $_SESSION['user_id'];
			echo "$userId";
			$uzsakymoData = "2018-12-09";
			$uzsakymoData=date("Y-m-d",strtotime($uzsakymoData));
			echo "$uzsakymoData";
			$kaina = $rowZaidimas['kaina'];
			echo "$kaina";
			$apmoketa = 0;
			echo "$apmoketa";
			$sql1 = "INSERT INTO uzsakymas (id, uzsakymo_data, kaina, apmoketa, fk_vartotojas, fk_mokejimas) VALUES ('$orderId', '$uzsakymoData', '$kaina', '$apmoketa', '$userId', null)";
			$result1 = mysqli_query($db, $sql1);
			
			$sql = "INSERT INTO uzsakymas_zaidimas (fk_uzsakymas, fk_zaidimas) VALUES ('$orderId', '$id')";
			$resutl = mysqli_query($db, $sql);
			$_POST = null;
				echo "
				<script type='text/javascript'>
				var answer = confirm (\"Sėkmingai užregistravote užsakymą\")
				if (answer)
				window.location = 'http://localhost/gameshop/index.php';
				else
				window.location = 'http://localhost/gameshop/index.php';
				</script>";
		}
		?>
	</body>
</html>