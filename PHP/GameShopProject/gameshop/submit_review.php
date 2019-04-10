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
			$sqla = "INSERT INTO pasiekimas_vartotojo_profilis (fk_pasiekimas, fk_vartotojo_profilis) VALUES ( 4, '$profileId')";	
			mysqli_query($db, $sqla);

			$review = $_POST['review'];
			$ivertinimas = $_POST['ivertinimas'];
			echo $ivertinimas;
			$date = date('Y-m-d H:i:s');
			$game_id = $_POST['id'];
			$vartotojo_id = $_SESSION['user_id'];	
			$sql = "INSERT INTO atsiliepimas (tekstas, ivertinimas, fk_vartotojas, fk_zaidimas) VALUES ('$review', '$ivertinimas', '$vartotojo_id', '$game_id')";
			echo $sql;
			mysqli_query($db, $sql);
			$_POST = null;
			header("Location:reviews.php");
		}
		?>
	</body>
</html>