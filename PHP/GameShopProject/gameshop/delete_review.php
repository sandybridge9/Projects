<!DOCTYPE html>
<?php session_start(); ?>
<html>
	<body>
		
		<?php
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
			if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($db)); }
		}

		if(isset($_POST['delete'])){
			$game_id = $_POST['id'];
			$vartotojo_id = $_SESSION['user_id'];
			$sql = "DELETE FROM atsiliepimas WHERE fk_vartotojas = ".$vartotojo_id." AND fk_zaidimas = ".$game_id."";
			mysqli_query($db, $sql);
			$_POST = null;
			header("Location:reviews.php");
		}
		?>
	</body>
</html>