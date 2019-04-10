<!DOCTYPE html>
<?php session_start(); ?>
<html>
	<body>
		
		<?php
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			$db = mysqli_connect("localhost", "root", "", "is") or die("Unable to connect to db");
			if(!$db){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($db)); }
		}

		if(isset($_POST['remove'])){
			$game_id = $_POST['id'];
			$vartotojo_id = $_SESSION['user_id'];
			$sql = "DELETE m.* FROM megstamiausiu_zaidimu_sarasas_zaidimas m INNER JOIN megstamiausiu_zaidimu_sarasas ON fk_megstamiausiu_zaidimu_sarasas = id WHERE fk_vartotojo_profilis = ".$vartotojo_id." AND fk_zaidimas = ".$game_id."";
			mysqli_query($db, $sql);
			$_POST = null;
			header("Location:favoritegames.php");
		}
		?>
	</body>
</html>