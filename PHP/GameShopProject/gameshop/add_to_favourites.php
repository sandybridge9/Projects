<!DOCTYPE html>
<?php session_start(); ?>
<html>
	<body>
		
		<?php
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
			if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($db)); }
		}

		if(isset($_POST['add'])){
			
			$sqlv = "SELECT * FROM vartotojo_profilis WHERE fk_vartotojas = ".$_SESSION['user_id']."";
			$resultv = mysqli_query($db, $sqlv);
			$profile = mysqli_fetch_assoc($resultv);
			$profileId = $profile['id'];

			$userId = $_SESSION['user_id'];
			$sqla = "INSERT INTO pasiekimas_vartotojo_profilis (fk_pasiekimas, fk_vartotojo_profilis) VALUES ( 1, '$profileId')";	
			mysqli_query($db, $sqla);

			$sql = "SELECT * FROM vartotojo_profilis WHERE fk_vartotojas = ".$_SESSION['user_id']."";
			$result = mysqli_query($db, $sql);

			$profileU = mysqli_fetch_assoc($result);

			$profID = $profileU['id'];

			$game_id = $_POST['id'];
			$date = date('Y-m-d H:i:s');
			$vartotojo_id = $_SESSION['user_id'];
			$sql = "INSERT INTO megstamiausiu_zaidimu_sarasas (data, fk_vartotojo_profilis) VALUES ('$date', '$profID')";
			$result = mysqli_query($db, $sql);
			if ($result){
				$sql11 = "SELECT * FROM megstamiausiu_zaidimu_sarasas WHERE fk_vartotojo_profilis =" .$profID."";
				$result11 = mysqli_query($db, $sql11);
				$row11 = mysqli_fetch_assoc($result11);
				$favorite_id = row11['id'];
			}else {
				$sql1 = "SELECT * FROM megstamiausiu_zaidimu_sarasas WHERE fk_vartotojo_profilis =" .$profID."";
				$result1 = mysqli_query($db, $sql1);
				$row = mysqli_fetch_assoc($result1);
				$favorite_id = $row['id'];
				//echo $favorite_id;
			}
			
			$sql1 = "INSERT INTO megstamiausiu_zaidimu_sarasas_zaidimas (fk_megstamiausiu_zaidimu_sarasas, fk_zaidimas) VALUES ('$favorite_id', '$game_id')";
			//echo $sql;
			mysqli_query($db, $sql1);
			$_POST = null;
			header("Location:gamelist.php");
		}
		?>
	</body>
</html>