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
			$gallery_id = $_POST['id'];
			$sql = "DELETE FROM nuotrauka WHERE fk_nuotrauku_galerija = ".$gallery_id."";
			$sql = "DELETE FROM nuotrauku_galerija WHERE id = ".$gallery_id."";
			mysqli_query($db, $sql);
			$_POST = null;
			header("Location:picturegalery.php");
		}
		?>
	</body>
</html>