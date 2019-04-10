<!DOCTYPE html>
<?php session_start(); ?>
<html>
	<head>
		<title>Maisto užsakymų svetainė</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	<head>
	
	<body>
	<div class= "title">
			<a href ="index.php"> Maisto užsakymų svetainė </a>
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
					}
					$db = mysqli_connect("localhost", "root", "", "it") or die("Unable to connect to db");
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
			$userId = $_SESSION['user_id'];
			$id = $_POST['id'];
			$exists = false;
			$count = 0;
			//checking if item already exists in cart
			$check = "SELECT * FROM krepselio_preke WHERE vartotojo_id = ".$userId."";
			$checkcheck = mysqli_query($db, $check);
			while($checkRow = mysqli_fetch_assoc($checkcheck)){
				$prekesIddd = $checkRow['prekes_id'];
				if($prekesIddd == $id){
					$prekesCount = $checkRow['kiekis'];
					$count = $prekesCount + 1;
					$exists = true;
				}
			}
			echo"$count";
			if($exists == false){
				$sql = "INSERT INTO krepselio_preke (prekes_id, vartotojo_id, kiekis) VALUES ('$id', '$userId', '1')";
				$result = mysqli_query($db, $sql);
			}else{
				$sql = "UPDATE krepselio_preke SET kiekis ='".$count."' WHERE prekes_id=".$id." AND vartotojo_id=".$userId."";
				$result = mysqli_query($db, $sql);
			}
			$_POST = null;
			echo "
			<script type='text/javascript'>
			var answer = confirm (\"Sėkmingai pridėjote prekę į krepšelį\")
			if (answer)
			window.location = 'http://localhost/projektas/index.php';
			else
			window.location = 'http://localhost/projektas/index.php';
			</script>";
		}

		?>
	</body>
</html>