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
            $id = $_POST['id'];
            $userId = $_SESSION['user_id'];
			$sql = "DELETE FROM draugai WHERE (fk_vartotojas1 = ".$id." AND fk_vartotojas = ".$userId.") OR (fk_vartotojas1 = ".$userId." AND fk_vartotojas = ".$id.")";
			mysqli_query($db, $sql);
			header("Location:friendlist.php");
		}
		?>
	</body>
</html>