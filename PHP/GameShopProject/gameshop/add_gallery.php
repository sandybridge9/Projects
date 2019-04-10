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
			$sql = "SELECT * FROM vartotojo_profilis WHERE fk_vartotojas = ".$_SESSION['user_id']."";
			$result = mysqli_query($db, $sql);

			$row = mysqli_fetch_assoc($result);

			$gallery_name = $_POST['gname'];
			$date = date('Y-m-d H:i:s');
			$vartotojo_id = $_SESSION['user_id'];
			$sql = "INSERT INTO nuotrauku_galerija (pavadinimas, data, fk_vartotojo_profilis) VALUES ('$gallery_name', '$date', '$row[id]')";
			echo $sql;
			mysqli_query($db, $sql);
			$_POST = null;
			header("Location:picturegalery.php");
		}
		?>
	</body>
</html>