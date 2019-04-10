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
			$profile_id = $_POST['id'];
			$description = $_POST['desc'];
			$sql = "UPDATE vartotojo_profilis SET aprasas = '$description' WHERE fk_vartotojas = '$profile_id'";
			echo $sql;
			mysqli_query($db, $sql);
			$_POST = null;
			header("Location:profile.php");
		}
		?>
	</body>
</html>